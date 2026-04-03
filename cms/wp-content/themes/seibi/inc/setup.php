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

// -----------------------------------------------
// セクション親ページ: 最初の子ページへリダイレクト
// -----------------------------------------------
/**
 * 現在のページの最初の子ページへ 301 リダイレクトする。
 * 子ページが存在しない場合はトップページへ。
 * page-about.php / page-admission.php / page-life.php から呼び出す。
 */
// -----------------------------------------------
// お知らせアーカイブ: ?information-category=slug でカテゴリー絞り込み
// -----------------------------------------------
add_action( 'pre_get_posts', function ( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }
    if ( ! $query->is_post_type_archive( 'information' ) ) {
        return;
    }
    $per_page = (int) get_option( 'seibi_information_per_page', 10 );
    $query->set( 'posts_per_page', $per_page );

    $cat = isset( $_GET['info_cat'] ) ? sanitize_key( $_GET['info_cat'] ) : '';
    if ( $cat ) {
        $query->set( 'tax_query', [ [
            'taxonomy' => 'information-category',
            'field'    => 'slug',
            'terms'    => $cat,
        ] ] );
    }
} );

// 卒業生アーカイブ: ?grad_cat=slug でカテゴリー絞り込み・表示件数設定
add_action( 'pre_get_posts', function ( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }
    if ( ! $query->is_post_type_archive( 'graduate' ) ) {
        return;
    }
    $per_page = (int) get_option( 'seibi_graduate_per_page', 10 );
    $query->set( 'posts_per_page', $per_page );

    $cat = isset( $_GET['grad_cat'] ) ? sanitize_key( $_GET['grad_cat'] ) : '';
    if ( $cat ) {
        $query->set( 'tax_query', [ [
            'taxonomy' => 'graduate-category',
            'field'    => 'slug',
            'terms'    => $cat,
        ] ] );
    }
} );
