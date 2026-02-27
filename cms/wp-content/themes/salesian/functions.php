<?php
/**
 * Salesian International Theme Functions
 *
 * @package salesian
 */

// -----------------------------------------------
// テーマセットアップ
// -----------------------------------------------
function salesian_setup() {
    // アイキャッチ画像
    add_theme_support( 'post-thumbnails' );

    // タイトルタグをWordPressに管理させる
    add_theme_support( 'title-tag' );

    // HTML5マークアップ
    add_theme_support( 'html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ] );

    // ナビゲーションメニューの登録
    register_nav_menus( [
        'primary' => 'グローバルナビゲーション',
        'footer'  => 'フッターナビゲーション',
    ] );
}
add_action( 'after_setup_theme', 'salesian_setup' );

// -----------------------------------------------
// CSS / JS エンキュー
// （静的HTML受領後、実際のファイル名に合わせて更新する）
// -----------------------------------------------
function salesian_enqueue_scripts() {
    $theme_uri = get_template_directory_uri();
    $version   = wp_get_theme()->get( 'Version' );

    // メインCSS（静的HTMLから移植後に追加）
    // wp_enqueue_style( 'salesian-style', $theme_uri . '/assets/css/style.css', [], $version );

    // メインJS（静的HTMLから移植後に追加）
    // wp_enqueue_script( 'salesian-script', $theme_uri . '/assets/js/main.js', [ 'jquery' ], $version, true );
}
add_action( 'wp_enqueue_scripts', 'salesian_enqueue_scripts' );

// -----------------------------------------------
// カスタム投稿タイプ
// （静的HTML受領後、必要に応じて追加する）
// -----------------------------------------------

// -----------------------------------------------
// カスタムフィールド（ACF等）
// （静的HTML受領後、必要に応じて追加する）
// -----------------------------------------------
