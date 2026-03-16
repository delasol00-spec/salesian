<?php
/**
 * Salesian International Theme Functions
 *
 * @package seibi
 */

// -----------------------------------------------
// テーマセットアップ
// -----------------------------------------------
function seibi_setup() {
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
add_action( 'after_setup_theme', 'seibi_setup' );

// -----------------------------------------------
// CSS / JS エンキュー
// （静的HTML受領後、実際のファイル名に合わせて更新する）
// -----------------------------------------------
function seibi_enqueue_scripts() {
    $theme_uri = get_template_directory_uri();
    $version   = wp_get_theme()->get( 'Version' );

    // メインCSS（静的HTMLから移植後に追加）
    // wp_enqueue_style( 'seibi-style', $theme_uri . '/css/style.css', [], $version );

    // メインJS（静的HTMLから移植後に追加）
    // wp_enqueue_script( 'seibi-script', $theme_uri . '/js/main.js', [ 'jquery' ], $version, true );
}
add_action( 'wp_enqueue_scripts', 'seibi_enqueue_scripts' );

// -----------------------------------------------
// カスタム投稿タイプ
// （静的HTML受領後、必要に応じて追加する）
// -----------------------------------------------

// -----------------------------------------------
// 詳細ページを持たないカスタム投稿タイプのリダイレクト
// briefing（学校説明会・公開行事）と event（公開行事）は
// 一覧ページのみ。詳細URLへのアクセスはアーカイブへリダイレクト。
// -----------------------------------------------
function seibi_redirect_no_single() {
    $no_single_types = [ 'briefing', 'event' ];

    if ( is_singular( $no_single_types ) ) {
        $post_type  = get_post_type();
        $archive_url = get_post_type_archive_link( $post_type );
        if ( $archive_url ) {
            wp_redirect( $archive_url, 301 );
            exit;
        }
        wp_redirect( home_url( '/' ), 301 );
        exit;
    }
}
add_action( 'template_redirect', 'seibi_redirect_no_single' );
