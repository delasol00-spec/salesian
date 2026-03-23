<?php
/**
 * CSS / JS エンキュー
 *
 * @package seibi
 */

// -----------------------------------------------
// CSS / JS エンキュー
// -----------------------------------------------
function seibi_enqueue_scripts() {
    $theme_uri = get_template_directory_uri();
    $ver       = wp_get_theme()->get( 'Version' );

    // --- 外部CDN CSS ---
    wp_enqueue_style( 'bootstrap',        'https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css', [], null );
    wp_enqueue_style( 'noto-serif-jp',    'https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@700;900&display=swap', [], null );
    wp_enqueue_style( 'material-symbols', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..25', [], null );

    // --- ローカル CSS（読み込み順厳守）---
    wp_enqueue_style( 'seibi-style',   $theme_uri . '/css/style.css',   [ 'bootstrap', 'noto-serif-jp', 'material-symbols' ], $ver );
    wp_enqueue_style( 'seibi-menu',    $theme_uri . '/css/menu.css',    [ 'seibi-style' ], $ver );
    wp_enqueue_style( 'seibi-loading', $theme_uri . '/css/loading.css', [ 'seibi-menu' ],  $ver );

    // 下層ページ（トップページ以外）に pages.css を追加
    if ( ! is_front_page() ) {
        wp_enqueue_style( 'seibi-pages', $theme_uri . '/css/pages.css', [ 'seibi-menu' ], $ver );
    }

    // --- 外部CDN JS（フッターに出力）---
    // Bootstrap 4.6（jQuery 依存 → WordPress 同梱 jquery を使用）
    wp_enqueue_script( 'bootstrap',          'https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js', [ 'jquery' ], null, true );
    wp_enqueue_script( 'gsap',               'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js',              [], null, true );
    wp_enqueue_script( 'gsap-scrolltrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js',    [ 'gsap' ], null, true );

    // --- ローカル JS ---
    wp_enqueue_script( 'seibi-gtag',    $theme_uri . '/js/gtag.js',    [], $ver, true );
    wp_enqueue_script( 'seibi-script',  $theme_uri . '/js/script.js',  [ 'jquery', 'gsap-scrolltrigger' ], $ver, true );
    wp_enqueue_script( 'seibi-loading', $theme_uri . '/js/loading.js', [ 'seibi-script' ], $ver, true );
}
add_action( 'wp_enqueue_scripts', 'seibi_enqueue_scripts' );
