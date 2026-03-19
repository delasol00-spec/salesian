# 静的HTML 設置ディレクトリ

制作会社から受け取った静的HTML/CSS/JS/画像ファイルを設置するディレクトリ。

> **参照専用。このディレクトリのファイルは直接編集しない。**
> WordPressテーマへの組み込みは `cms/wp-content/themes/seibi/` で行う。

---

## 納品状況（2026-03-17時点）

| セクション | 状況 |
|---|---|
| `index.html`（トップ） | 納品済み |
| `about/`（学校紹介） | 納品済み |
| `admission/`（入試） | 一部納品済み（briefing.html のみ） |
| `feature/`（星美クラスの教育） | **未納品** |
| `life/`（学校生活） | **未納品** |

---

## ディレクトリ構成

```
html-ここにアップ/
├── README.md
├── favicon.svg
├── index.html              # トップページ
├── css/
│   ├── style.css           # メインスタイルシート（全体）
│   ├── menu.css            # サイドバー・ナビゲーション
│   ├── pages.css           # 下層ページ専用スタイル
│   ├── loading.css         # ローディングアニメーション
│   └── loading-screen.css  # 空ファイル（未使用）
├── js/
│   ├── script.js           # メインスクリプト（GSAP、メニュー制御）
│   ├── loading.js          # ローディング画面の段階的非表示
│   └── gtag.js             # Google Analytics
├── img/                    # 共通画像（ロゴ、フッター装飾等）
│   ├── top-logo.svg / top-logo.png / top-logo-sm.svg
│   ├── menu-logo.webp / menu-icon.svg
│   ├── 01〜05.webp          # スライドショー画像
│   ├── movie.mp4 / movie2.mp4
│   ├── footer-bg.webp / footer-maria.webp
│   ├── splash.svg / splash.png / loading.webp
│   └── ...（その他共通画像）
├── about/                  # 学校紹介セクション（納品済み）
│   ├── index.html          # 校長メッセージ
│   ├── method.html         # 建学の精神・教育理念
│   ├── history.html        # 星美の歩み
│   ├── uniform.html        # 制服
│   ├── access.html         # アクセス
│   ├── area.html           # 通学地域
│   ├── facility.html       # 施設・設備・環境
│   ├── security.html       # 災害・セキュリティ対策
│   ├── faq.html            # よくある質問
│   ├── side-menu.html      # （参考コンポーネント・WP組み込み対象外）
│   ├── img/                # aboutセクション共通画像
│   ├── facility-img/       # 施設紹介用画像
│   ├── history-img/        # 沿革用画像
│   ├── uniform-img/        # 制服用画像
│   └── security-img/       # 災害対策用画像
└── admission/              # 入試セクション（一部納品済み）
    ├── index.html          # 児童募集要項
    ├── briefing.html       # 学校説明会・公開行事
    └── img/                # admissionセクション共通画像
```

---

## HTMLファイルとWordPressテンプレートの対応

| HTMLファイル | ページ名 | WordPressテンプレート |
|---|---|---|
| `index.html` | トップページ | `index.php` |
| `about/index.html` | 校長メッセージ | `page-principal.php` |
| `about/method.html` | 建学の精神・教育理念 | `page-method.php` |
| `about/history.html` | 星美の歩み | `page-history.php` |
| `about/uniform.html` | 制服 | `page-uniform.php` |
| `about/access.html` | アクセス | `page-access.php` |
| `about/area.html` | 通学地域 | `page-area.php` |
| `about/facility.html` | 施設・設備・環境 | `page-facility.php` |
| `about/security.html` | 災害・セキュリティ対策 | `page-security.php` |
| `about/faq.html` | よくある質問 | `page-faq.php` |
| `admission/index.html` | 児童募集要項 | `page-requirements.php` |
| `admission/briefing.html` | 学校説明会・公開行事 | `archive-briefing.php` |

---

## 使用ライブラリ

### 外部CDN

| ライブラリ | バージョン | 種別 |
|---|---|---|
| Bootstrap | 4.6.2 | CSS + JS |
| jQuery | 3.6.0 | JS（WP移植時はWP同梱版に置き換え） |
| GSAP | 3.12.2 | JS |
| GSAP ScrollTrigger | 3.12.2 | JS |
| Noto Serif JP | - | Google Fonts（700, 900） |
| Material Symbols Outlined | - | Google Fonts（アイコン） |

> **WP移植時**: jQuery は CDN 版を削除し `wp_enqueue_script('jquery')` の依存指定に変更する。

### ローカルファイル

CSSは `style.css → menu.css → [pages.css] → loading.css` の順に読み込む。
`pages.css` は下層ページのみ。

---

## ブラウザでの確認方法

```bash
open html-ここにアップ/index.html
```

または VS Code の Live Server 拡張機能を使う。

---

## 注意事項

- **Bootstrap 4**: `data-toggle` 属性等、BS4 記法を使用（BS5 とは非互換）
- **`<main>` の外にコンテンツ**: 下層ページのメインコンテンツは `<main>` タグの外の `<section>` 内にある。WP移植時は構造に注意
- **`about/side-menu.html`**: 参考コンポーネント。WP組み込み対象外
- **`css/loading-screen.css`**: 空ファイル。使用不要
- 詳細な仕様は [`docs/design/notes.md`](../docs/design/notes.md) を参照
