<?php
/**
 * 管理画面カスタマイズ・リダイレクト
 *
 * @package seibi
 */

// -----------------------------------------------
// デフォルト「投稿」「コメント」を無効化
// -----------------------------------------------
function seibi_remove_post_menu() {
    remove_menu_page( 'edit.php' );
    remove_menu_page( 'edit-comments.php' );
}
add_action( 'admin_menu', 'seibi_remove_post_menu' );

function seibi_unregister_post_type() {
    unregister_post_type( 'post' );
}
add_action( 'init', 'seibi_unregister_post_type', 99 );

// コメント機能を完全に無効化
function seibi_disable_comments() {
    // 新規コメントを受け付けない
    add_filter( 'comments_open', '__return_false', 99 );
    add_filter( 'pings_open',    '__return_false', 99 );
    // コメント一覧を空にする
    add_filter( 'comments_array', '__return_empty_array', 99 );
}
add_action( 'init', 'seibi_disable_comments' );

// 管理バーのコメントアイコンを非表示
function seibi_remove_admin_bar_comments( $wp_admin_bar ) {
    $wp_admin_bar->remove_node( 'comments' );
}
add_action( 'admin_bar_menu', 'seibi_remove_admin_bar_comments', 999 );

// 投稿・固定ページのコメントサポートを削除
function seibi_remove_comment_support() {
    remove_post_type_support( 'post', 'comments' );
    remove_post_type_support( 'post', 'trackbacks' );
    remove_post_type_support( 'page', 'comments' );
    remove_post_type_support( 'page', 'trackbacks' );
}
add_action( 'init', 'seibi_remove_comment_support', 99 );

// -----------------------------------------------
// 詳細ページを持たないカスタム投稿タイプのリダイレクト
// briefing（学校説明会）と event（公開行事）は
// 一覧ページのみ。詳細URLへのアクセスはアーカイブへリダイレクト。
// -----------------------------------------------
function seibi_redirect_no_single() {
    $no_single_types = [ 'briefing', 'event' ];

    if ( is_singular( $no_single_types ) ) {
        $post_type   = get_post_type();
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
