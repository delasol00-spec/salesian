<?php
/**
 * 管理画面カスタマイズ・リダイレクト
 *
 * @package seibi
 */

// -----------------------------------------------
// 年間行事 編集画面でメディアアップローダーを有効化
// -----------------------------------------------
function seibi_enqueue_media_for_year( $hook ) {
    $screen = get_current_screen();
    if ( $screen && $screen->post_type === 'year' && in_array( $hook, [ 'post.php', 'post-new.php' ], true ) ) {
        wp_enqueue_media();
    }
}
add_action( 'admin_enqueue_scripts', 'seibi_enqueue_media_for_year' );

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

// -----------------------------------------------
// 編集者の固定ページアクセス制限（児童募集要項のみ許可）
// -----------------------------------------------

/**
 * 固定ページ一覧を「児童募集要項」のみに絞り込む
 */
function seibi_editor_filter_pages( $query ) {
    if ( ! is_admin() || ! $query->is_main_query() ) {
        return;
    }
    if ( $query->get( 'post_type' ) !== 'page' ) {
        return;
    }
    $user = wp_get_current_user();
    if ( ! in_array( 'editor', (array) $user->roles, true ) ) {
        return;
    }

    $allowed = get_page_by_path( 'admission/requirements' );
    $query->set( 'post__in', $allowed ? [ $allowed->ID ] : [ 0 ] );
}
add_action( 'pre_get_posts', 'seibi_editor_filter_pages' );

/**
 * 許可ページ以外の編集画面・新規作成画面へのアクセスをブロック
 */
function seibi_editor_restrict_page_edit() {
    if ( ! is_admin() ) {
        return;
    }
    $user = wp_get_current_user();
    if ( ! in_array( 'editor', (array) $user->roles, true ) ) {
        return;
    }

    $screen = get_current_screen();
    if ( ! $screen ) {
        return;
    }

    // 固定ページの新規作成を禁止
    if ( $screen->base === 'post-new' && $screen->post_type === 'page' ) {
        wp_safe_redirect( admin_url( 'edit.php?post_type=page' ) );
        exit;
    }

    // 固定ページの編集画面：許可ページ以外を禁止
    if ( $screen->base === 'post' && $screen->post_type === 'page' ) {
        $post_id = isset( $_GET['post'] ) ? (int) $_GET['post'] : 0;
        $allowed  = get_page_by_path( 'admission/requirements' );
        if ( ! $allowed || $post_id !== $allowed->ID ) {
            wp_safe_redirect( admin_url( 'edit.php?post_type=page' ) );
            exit;
        }
    }
}
add_action( 'current_screen', 'seibi_editor_restrict_page_edit' );

// -----------------------------------------------
// 児童募集要項の本文入力エリアを非表示
// -----------------------------------------------

/**
 * add_meta_boxes より前に発火する admin_init で editor サポートを外す。
 * ブロックエディター・クラシックエディター双方に効く。
 */
function seibi_remove_editor_for_requirements() {
    $post_id = isset( $_GET['post'] ) ? (int) $_GET['post'] : 0;
    if ( ! $post_id ) {
        return;
    }
    $page = get_page_by_path( 'admission/requirements' );
    if ( $page && $post_id === $page->ID ) {
        remove_post_type_support( 'page', 'editor' );
    }
}
add_action( 'admin_init', 'seibi_remove_editor_for_requirements' );
