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

    // 学校説明会･学外説明会
    register_post_type( 'briefing', [
        'labels'       => [
            'name'          => '学校説明会･学外説明会',
            'singular_name' => '学校説明会･学外説明会',
            'add_new_item'  => '学校説明会･学外説明会を追加',
            'edit_item'     => '学校説明会･学外説明会を編集',
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
        'supports'     => [ 'title', 'page-attributes' ],
    ] );
}
add_action( 'init', 'seibi_register_post_types' );

// -----------------------------------------------
// カスタムタクソノミー
// -----------------------------------------------
function seibi_register_taxonomies() {

    // 年間行事 月カテゴリー
    register_taxonomy( 'year_month', 'year', [
        'labels'       => [
            'name'          => '月',
            'singular_name' => '月',
            'add_new_item'  => '月を追加',
            'edit_item'     => '月を編集',
        ],
        'hierarchical' => true,
        'public'       => false,
        'show_ui'      => true,
        'show_in_rest' => true,
        'rewrite'      => false,
    ] );

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
// 「表示設定」タクソノミー共通登録ヘルパー
// 「トップページ」タームにチェックした投稿のみトップに表示
// -----------------------------------------------
/**
 * 非公開の「表示設定」タクソノミーを登録する。
 *
 * @param string $taxonomy  タクソノミースラッグ（例: 'briefing-flag'）
 * @param string $post_type 対象投稿タイプ（例: 'briefing'）
 */
function seibi_register_flag_taxonomy( $taxonomy, $post_type ) {
    register_taxonomy( $taxonomy, $post_type, [
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

function seibi_register_flag_taxonomies() {
    seibi_register_flag_taxonomy( 'briefing-flag', 'briefing' );
    seibi_register_flag_taxonomy( 'event-flag', 'event' );
}
add_action( 'init', 'seibi_register_flag_taxonomies' );

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

// -----------------------------------------------
// year_month デフォルトターム（4月〜3月）自動作成
// -----------------------------------------------
function seibi_create_year_month_defaults() {
    if ( get_option( 'seibi_year_month_terms_created' ) === '1' ) {
        return;
    }
    $months = [ '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月', '1月', '2月', '3月' ];
    foreach ( $months as $month ) {
        if ( ! term_exists( $month, 'year_month' ) ) {
            wp_insert_term( $month, 'year_month' );
        }
    }
    update_option( 'seibi_year_month_terms_created', '1' );
}
add_action( 'init', 'seibi_create_year_month_defaults', 20 );
