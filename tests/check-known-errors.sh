#!/bin/bash
# =============================================================================
# check-known-errors.sh
#
# CLAUDE.md「静的HTMLの既知の誤り」が WP テーマに混入していないか確認する。
# トラ・トラ・トラ（CSS/JS 全上書き・テンプレート移植）後に実行する。
#
# 使い方:
#   bash tests/check-known-errors.sh
#
# 終了コード:
#   0 = 全チェック PASS
#   1 = 1件以上 FAIL
# =============================================================================

THEME_DIR="cms/wp-content/themes/seibi"
CSS_FILE="$THEME_DIR/css/pages.css"

# ---- カラー定義 ----
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
RESET='\033[0m'

pass_count=0
fail_count=0

# ---- ヘルパー関数 ----

# 指定パターンが grep で見つかれば FAIL（= 誤りが混入している）
check_absent() {
  local label="$1"
  local pattern="$2"
  local target="$3"

  if grep -qr "$pattern" $target 2>/dev/null; then
    echo -e "  ${RED}FAIL${RESET}  $label"
    echo -e "        パターン: ${YELLOW}$pattern${RESET}"
    grep -rn "$pattern" $target 2>/dev/null | sed 's/^/        /'
    (( fail_count++ ))
  else
    echo -e "  ${GREEN}PASS${RESET}  $label"
    (( pass_count++ ))
  fi
}

# 指定パターンが grep で見つからなければ FAIL（= 正しい修正が失われている）
check_present() {
  local label="$1"
  local pattern="$2"
  local target="$3"

  if grep -qr "$pattern" $target 2>/dev/null; then
    echo -e "  ${GREEN}PASS${RESET}  $label"
    (( pass_count++ ))
  else
    echo -e "  ${RED}FAIL${RESET}  $label"
    echo -e "        パターン: ${YELLOW}$pattern${RESET} が見つかりません"
    (( fail_count++ ))
  fi
}

# =============================================================================
# チェック開始
# =============================================================================

echo ""
echo "========================================"
echo " Salesian WP 既知エラー チェック"
echo "========================================"
echo ""

# --- [1] pages.css: 誤った background URL ---
echo "[1] pages.css — background URL の誤りパターン"
check_absent \
  "religion-para-img に ../feature/religion-img が混入していない" \
  "\.\./feature/religion-img" \
  "$CSS_FILE"

check_absent \
  "english-para-img に ../feature/english-img が混入していない" \
  "\.\./feature/english-img" \
  "$CSS_FILE"

check_absent \
  "general-para-img に ../feature/general-img が混入していない" \
  "\.\./feature/general-img" \
  "$CSS_FILE"

check_absent \
  "assistenza-para-img に ../feature/assistenza-img が混入していない" \
  "\.\./feature/assistenza-img" \
  "$CSS_FILE"

echo ""

# --- [2] pages.css: .blog-header .news-category の固定色 ---
# .blog-header .news-category ブロック直後5行以内に background が現れたら誤り
echo "[2] pages.css — .blog-header .news-category の固定 background 色"
label=".blog-header .news-category に background 固定色が混入していない"
if grep -A 5 "\.blog-header \.news-category" "$CSS_FILE" 2>/dev/null | grep -q "background:"; then
  echo -e "  ${RED}FAIL${RESET}  $label"
  echo -e "        .blog-header .news-category ブロック内に background: が見つかりました"
  grep -A 5 "\.blog-header \.news-category" "$CSS_FILE" | sed 's/^/        /'
  (( fail_count++ ))
else
  echo -e "  ${GREEN}PASS${RESET}  $label"
  (( pass_count++ ))
fi

echo ""

# --- [3] pages.css: 正しい URL が存在するか（修正が保たれているか）---
echo "[3] pages.css — 修正済み background URL が維持されている"
check_present \
  "religion-para-img が ../img/religion-img を使用している" \
  "\.\./img/religion-img" \
  "$CSS_FILE"

check_present \
  "english-para-img が ../img/english-img を使用している" \
  "\.\./img/english-img" \
  "$CSS_FILE"

check_present \
  "general-para-img が ../img/general-img を使用している" \
  "\.\./img/general-img" \
  "$CSS_FILE"

check_present \
  "assistenza-para-img が ../img/assistenza-img を使用している" \
  "\.\./img/assistenza-img" \
  "$CSS_FILE"

echo ""

# --- [4] PHPテンプレート: 誤ったリンク ---
echo "[4] PHPテンプレート — 誤ったリンクが混入していない"
check_absent \
  "page-flow.php に 'admission/event.html' リンクが混入していない（正: /admission/briefing/）" \
  "admission/event\.html" \
  "$THEME_DIR"

check_absent \
  "page-examinee.php に '../about/download.html' リンクが混入していない（正: /admission/flow/ または /admission/transfer/）" \
  "\.\./about/download\.html" \
  "$THEME_DIR"

echo ""

# =============================================================================
# 結果サマリー
# =============================================================================

echo "========================================"
total=$(( pass_count + fail_count ))
echo " 結果: $pass_count / $total PASS"

if [ "$fail_count" -eq 0 ]; then
  echo -e " ${GREEN}すべてのチェックが通過しました。${RESET}"
  echo "========================================"
  echo ""
  exit 0
else
  echo -e " ${RED}${fail_count} 件の問題が見つかりました。上記を修正してください。${RESET}"
  echo "========================================"
  echo ""
  exit 1
fi
