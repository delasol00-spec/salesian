#!/usr/bin/env python3
"""
リンクチェッカー — Salesian International WordPress サイト
使い方: python3 check_links.py [BASE_URL]
デフォルト: http://localhost:8110/seibi/
"""

import sys
import urllib.request
import urllib.parse
import urllib.error
import re
import time
from collections import deque

BASE_URL = sys.argv[1] if len(sys.argv) > 1 else "http://localhost:8110/seibi/"
TIMEOUT = 10
DELAY = 0.1  # サーバー負荷軽減のため各リクエスト間に入れる待機時間（秒）

visited = set()
queue = deque([BASE_URL])
broken = []     # [(url, status_or_error, found_on)]
redirects = []  # [(url, location, found_on)]
ok = []         # [(url, status)]

LINK_RE = re.compile(r'href=["\']([^"\'#\s]+)["\']', re.IGNORECASE)


def normalize(url, base):
    """相対URLを絶対URLに変換し、フラグメントを除去する"""
    url = url.split('#')[0].strip()
    if not url:
        return None
    abs_url = urllib.parse.urljoin(base, url)
    # クエリ文字列は保持、末尾スラッシュを統一
    parsed = urllib.parse.urlparse(abs_url)
    path = parsed.path
    if not path.endswith('/') and '.' not in path.split('/')[-1]:
        path += '/'
    normalized = parsed._replace(path=path, fragment='').geturl()
    return normalized


def is_internal(url):
    base_parsed = urllib.parse.urlparse(BASE_URL)
    url_parsed = urllib.parse.urlparse(url)
    return (url_parsed.scheme in ('http', 'https')
            and url_parsed.netloc == base_parsed.netloc
            and url_parsed.path.startswith(base_parsed.path.rstrip('/') or '/'))


def fetch(url):
    """URLをfetchしてステータスコードとHTMLを返す（リダイレクトは手動追跡）"""
    req = urllib.request.Request(url, headers={'User-Agent': 'LinkChecker/1.0'})
    try:
        with urllib.request.urlopen(req, timeout=TIMEOUT) as resp:
            status = resp.status
            content_type = resp.headers.get('Content-Type', '')
            html = ''
            if 'text/html' in content_type:
                html = resp.read().decode('utf-8', errors='ignore')
            return status, html, None
    except urllib.error.HTTPError as e:
        return e.code, '', None
    except urllib.error.URLError as e:
        return None, '', str(e.reason)
    except Exception as e:
        return None, '', str(e)


def extract_links(html, page_url):
    links = set()
    for href in LINK_RE.findall(html):
        # mailto: tel: javascript: は除外
        if re.match(r'^(mailto:|tel:|javascript:|data:)', href, re.I):
            continue
        norm = normalize(href, page_url)
        if norm:
            links.add(norm)
    return links


def check_external(url, found_on):
    """外部リンクはHEADリクエストだけでステータス確認"""
    req = urllib.request.Request(url, method='HEAD',
                                 headers={'User-Agent': 'LinkChecker/1.0'})
    try:
        with urllib.request.urlopen(req, timeout=TIMEOUT) as resp:
            return resp.status
    except urllib.error.HTTPError as e:
        return e.code
    except Exception:
        return None


# ── メインループ ──────────────────────────────────────────

print(f"🔍 リンクチェック開始: {BASE_URL}\n")

external_links = {}  # url -> found_on（後でまとめてチェック）

while queue:
    url = queue.popleft()
    if url in visited:
        continue
    visited.add(url)

    internal = is_internal(url)

    if not internal:
        # 外部リンクはキューに積まず後でまとめてチェック
        if url not in external_links:
            external_links[url] = url
        continue

    status, html, error = fetch(url)
    time.sleep(DELAY)

    if error:
        print(f"  ❌ ERROR  {url}  ({error})")
        broken.append((url, f"ERROR: {error}", "—"))
    elif status is None:
        print(f"  ❌ ERROR  {url}")
        broken.append((url, "ERROR: unknown", "—"))
    elif status >= 400:
        print(f"  ❌ {status}    {url}")
        broken.append((url, status, "—"))
    elif status in (301, 302, 303, 307, 308):
        print(f"  ➡️  {status}    {url}")
        redirects.append((url, status, "—"))
        ok.append((url, status))
    else:
        short = url.replace(BASE_URL, '/')
        print(f"  ✅ {status}    {short}")
        ok.append((url, status))

    # 内部リンクを抽出してキューに追加
    for link in extract_links(html, url):
        if link not in visited:
            queue.append(link)

# ── 外部リンクチェック ────────────────────────────────────

if external_links:
    print(f"\n🌐 外部リンク確認中 ({len(external_links)} 件)...")
    for ext_url, found_on in external_links.items():
        status = check_external(ext_url, found_on)
        time.sleep(DELAY)
        if status is None or status >= 400:
            mark = f"❌ {status}" if status else "❌ ERROR"
            print(f"  {mark}  {ext_url}")
            broken.append((ext_url, status or 'ERROR', found_on))
        else:
            print(f"  ✅ {status}  {ext_url}")

# ── 結果サマリー ─────────────────────────────────────────

print("\n" + "=" * 60)
print(f"📊 チェック結果サマリー")
print("=" * 60)
print(f"  チェックURL総数 : {len(visited) + len(external_links)}")
print(f"  ✅ 正常         : {len(ok)}")
print(f"  ➡️  リダイレクト  : {len(redirects)}")
print(f"  ❌ エラー・404  : {len(broken)}")

if redirects:
    print("\n── リダイレクト一覧 ────────────────────────────────────")
    for url, status, found_on in redirects:
        print(f"  [{status}] {url}")

if broken:
    print("\n── ❌ エラー・リンク切れ一覧 ───────────────────────────")
    for url, status, found_on in broken:
        print(f"  [{status}] {url}")
    print()
    sys.exit(1)
else:
    print("\n✅ リンク切れなし！")
    sys.exit(0)
