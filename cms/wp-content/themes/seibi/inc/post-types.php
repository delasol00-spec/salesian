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
        'has_archive'  => 'admission/briefing',
        'rewrite'      => [ 'slug' => 'briefing' ],
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
        'has_archive'  => 'admission/event',
        'rewrite'      => [ 'slug' => 'event' ],
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-calendar',
        'supports'     => [ 'title', 'thumbnail' ],
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

// -----------------------------------------------
// event 表示設定タクソノミー
// 「トップページ」タームにチェックした投稿のみトップに表示
// -----------------------------------------------
function seibi_register_event_flag() {
    register_taxonomy( 'event-flag', 'event', [
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
add_action( 'init', 'seibi_register_event_flag' );

// -----------------------------------------------
// カスタム投稿タイプ パーマリンク（/{slug}/{post_id}/ 形式）
// -----------------------------------------------
function seibi_custom_post_type_rewrite_rules() {
    $post_types = [
        'information' => 'information',
        'year'        => 'life/year',
        'event'       => 'event',
        'briefing'    => 'briefing',
    ];

    foreach ( $post_types as $post_type => $slug ) {
        add_rewrite_rule(
            '^' . $slug . '/(\d+)/?$',
            'index.php?post_type=' . $post_type . '&p=$matches[1]',
            'top'
        );
    }
}
add_action( 'init', 'seibi_custom_post_type_rewrite_rules' );

function seibi_post_type_link( $post_link, $post ) {
    $slugs = [
        'information' => 'information',
        'year'        => 'life/year',
        'event'       => 'event',
        'briefing'    => 'briefing',
    ];

    if ( ! isset( $slugs[ $post->post_type ] ) ) {
        return $post_link;
    }

    return home_url( '/' . $slugs[ $post->post_type ] . '/' . $post->ID . '/' );
}
add_filter( 'post_type_link', 'seibi_post_type_link', 10, 2 );

// -----------------------------------------------
// information-category タクソノミーページをアーカイブへ 301 リダイレクト
// テンプレートが存在しないため 500 エラー防止
// -----------------------------------------------
add_action( 'template_redirect', function () {
	if ( is_tax( 'information-category' ) ) {
		wp_redirect( get_post_type_archive_link( 'information' ), 301 );
		exit;
	}
} );

function seibi_flush_post_type_rewrite_once() {
    if ( get_option( 'seibi_post_id_rewrite_v3' ) !== '1' ) {
        flush_rewrite_rules();
        update_option( 'seibi_post_id_rewrite_v3', '1' );
    }
}
add_action( 'wp_loaded', 'seibi_flush_post_type_rewrite_once' );
