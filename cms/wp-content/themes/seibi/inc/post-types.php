<?php
/**
 * カスタム投稿タイプ・タクソノミー
 *
 * @package seibi
 */

// -----------------------------------------------
// カスタム投稿タイプ
// -----------------------------------------------
function seibi_register_post_types() {

    // お知らせ（NEWS & TOPICS）
    register_post_type( 'information', [
        'labels'       => [
            'name'          => 'お知らせ',
            'singular_name' => 'お知らせ',
            'add_new_item'  => 'お知らせを追加',
            'edit_item'     => 'お知らせを編集',
        ],
        'public'       => true,
        'has_archive'  => true,
        'rewrite'      => [ 'slug' => 'information' ],
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-megaphone',
        'supports'     => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
    ] );

    // 学校説明会
    register_post_type( 'briefing', [
        'labels'       => [
            'name'          => '学校説明会',
            'singular_name' => '学校説明会',
            'add_new_item'  => '学校説明会を追加',
            'edit_item'     => '学校説明会を編集',
        ],
        'public'       => true,
        'has_archive'  => true,
        'rewrite'      => [ 'slug' => 'admission/briefing' ],
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-calendar-alt',
        'supports'     => [ 'title' ],
    ] );

    // 公開行事
    register_post_type( 'event', [
        'labels'       => [
            'name'          => '公開行事',
            'singular_name' => '公開行事',
            'add_new_item'  => '公開行事を追加',
            'edit_item'     => '公開行事を編集',
        ],
        'public'       => true,
        'has_archive'  => true,
        'rewrite'      => [ 'slug' => 'admission/event' ],
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-calendar',
        'supports'     => [ 'title', 'editor' ],
    ] );

    // 年間行事（ギャラリー形式）
    register_post_type( 'year', [
        'labels'       => [
            'name'          => '年間行事',
            'singular_name' => '年間行事',
            'add_new_item'  => '年間行事を追加',
            'edit_item'     => '年間行事を編集',
        ],
        'public'       => true,
        'has_archive'  => true,
        'rewrite'      => [ 'slug' => 'life/year' ],
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-images-alt2',
        'supports'     => [ 'title', 'thumbnail' ],
    ] );
}
add_action( 'init', 'seibi_register_post_types' );

// -----------------------------------------------
// カスタムタクソノミー
// -----------------------------------------------
function seibi_register_taxonomies() {

    // お知らせカテゴリー
    register_taxonomy( 'information-category', 'information', [
        'labels'       => [
            'name'          => 'カテゴリー',
            'singular_name' => 'カテゴリー',
            'add_new_item'  => 'カテゴリーを追加',
            'edit_item'     => 'カテゴリーを編集',
        ],
        'hierarchical' => true,
        'public'       => true,
        'rewrite'      => [ 'slug' => 'information-category' ],
        'show_in_rest' => true,
    ] );
}
add_action( 'init', 'seibi_register_taxonomies' );

// -----------------------------------------------
// briefing 表示設定タクソノミー
// 「トップページ」タームにチェックした投稿のみトップに表示
// -----------------------------------------------
function seibi_register_briefing_flag() {
    register_taxonomy( 'briefing-flag', 'briefing', [
        'labels'       => [
            'name'          => '表示設定',
            'singular_name' => '表示設定',
            'add_new_item'  => '表示設定を追加',
            'edit_item'     => '表示設定を編集',
        ],
        'hierarchical' => true,
        'public'       => false,
        'show_ui'      => true,
        'show_in_rest' => false,
        'rewrite'      => false,
    ] );
}
add_action( 'init', 'seibi_register_briefing_flag' );
