<?php
/**
 * テーマセットアップ・パーマリンク設定
 *
 * @package seibi
 */

// -----------------------------------------------
// WordPress 技術情報の隠蔽
// -----------------------------------------------
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
remove_action( 'template_redirect', 'rest_output_link_header', 11 );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

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
// パーマリンク構造の自動設定
// -----------------------------------------------
function seibi_set_permalink_structure() {
    $structure = '/%category%/%post_id%/';
    if ( get_option( 'permalink_structure' ) !== $structure ) {
        global $wp_rewrite;
        $wp_rewrite->set_permalink_structure( $structure );
        flush_rewrite_rules();
    }
}
add_action( 'after_setup_theme', 'seibi_set_permalink_structure' );
