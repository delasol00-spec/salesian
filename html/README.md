# 静的HTML 設置ディレクトリ

制作会社から受け取った静的HTML/CSS/JS/画像ファイルをここに設置します。

---

## 設置方法

制作会社から受け取ったファイルをそのままこのディレクトリに展開してください。

```
html/
├── README.md
├── index.html          # トップページ
├── about.html          # 会社概要ページ（例）
├── news.html           # ニュース一覧ページ（例）
├── css/
│   └── style.css
├── js/
│   └── main.js
└── images/
    └── ...
```

---

## このディレクトリの目的

- 制作会社から受け取ったオリジナルファイルを**そのまま保存・参照**するための場所
- WordPressへの組み込み作業時に**元のHTMLを確認**するために使う
- Gitで管理することで、**変更履歴を追跡**できる

> ⚠️ このディレクトリのファイルは直接編集しないこと。
> WordPressテーマへの組み込みは `cms/wp-content/themes/salesian/` で行う。

---

## ブラウザでの確認方法

静的HTMLをブラウザで直接開いて確認できます。

```bash
# macOSの場合
open html/index.html
```

または VS Code の Live Server 拡張機能を使うと便利です。
