<?php
/**
 * 管理画面カスタマイズ・リダイレクト
 *
 * @package seibi
 */

// -----------------------------------------------
// 編集者のプロフィール画面：不要項目を非表示
// -----------------------------------------------
function seibi_hide_editor_profile_fields() {
    $user = wp_get_current_user();
    if ( ! in_array( 'editor', (array) $user->roles, true ) ) {
        return;
    }
    $screen = get_current_screen();
    if ( ! $screen || $screen->base !== 'profile' ) {
        return;
    }
    ?>
    <style>
        /* キーボードショートカット */
        .user-comment-shortcuts-wrap,
        /* 名・姓 */
        .user-first-name-wrap,
        .user-last-name-wrap,
        /* サイト */
        .user-url-wrap,
        /* プロフィール写真・あなたについて・プロフィール情報 */
        .user-profile-picture,
        .user-description-wrap,
        #profile-page .form-table + h2,
        /* アプリケーションパスワード */
        #application-passwords-section { display: none !important; }
    </style>
    <?php
}
add_action( 'admin_head', 'seibi_hide_editor_profile_fields' );

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
    // 編集者はツールメニューも非表示
    $user = wp_get_current_user();
    if ( in_array( 'editor', (array) $user->roles, true ) ) {
        remove_menu_page( 'tools.php' );
    }
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

// -----------------------------------------------
// 年間行事 一覧：月（year_month）絞り込みフィルター
// -----------------------------------------------

/**
 * 「月」ドロップダウンを投稿一覧のフィルターバーに追加
 */
function seibi_year_month_filter_dropdown() {
    $screen = get_current_screen();
    if ( ! $screen || $screen->post_type !== 'year' ) {
        return;
    }

    $selected = isset( $_GET['year_month_filter'] ) ? sanitize_text_field( $_GET['year_month_filter'] ) : '';

    $terms = get_terms( [
        'taxonomy'   => 'year_month',
        'hide_empty' => false,
    ] );

    if ( is_wp_error( $terms ) || empty( $terms ) ) {
        return;
    }

    echo '<select name="year_month_filter">';
    echo '<option value="">すべての月</option>';
    foreach ( $terms as $term ) {
        printf(
            '<option value="%s"%s>%s</option>',
            esc_attr( $term->slug ),
            selected( $selected, $term->slug, false ),
            esc_html( $term->name )
        );
    }
    echo '</select>';
}
add_action( 'restrict_manage_posts', 'seibi_year_month_filter_dropdown' );

/**
 * ドロップダウン選択値を WP_Query に反映
 */
function seibi_year_month_filter_query( $query ) {
    if ( ! is_admin() || ! $query->is_main_query() ) {
        return;
    }
    if ( $query->get( 'post_type' ) !== 'year' ) {
        return;
    }
    $filter = isset( $_GET['year_month_filter'] ) ? sanitize_text_field( $_GET['year_month_filter'] ) : '';
    if ( $filter === '' ) {
        return;
    }

    $tax_query = [
        [
            'taxonomy' => 'year_month',
            'field'    => 'slug',
            'terms'    => $filter,
        ],
    ];
    $query->set( 'tax_query', $tax_query );
}
add_action( 'pre_get_posts', 'seibi_year_month_filter_query' );

// -----------------------------------------------
// お知らせ・卒業生 一覧：カテゴリー絞り込みフィルター
// -----------------------------------------------

/**
 * カテゴリードロップダウンを投稿一覧のフィルターバーに追加（汎用）
 *
 * @param string $post_type   対象投稿タイプ
 * @param string $taxonomy    タクソノミースラッグ
 * @param string $param_name  GETパラメーター名
 * @param string $all_label   「すべて」の選択肢ラベル
 */
function seibi_category_filter_dropdown( $post_type, $taxonomy, $param_name, $all_label ) {
    $screen = get_current_screen();
    if ( ! $screen || $screen->post_type !== $post_type ) {
        return;
    }

    $selected = isset( $_GET[ $param_name ] ) ? sanitize_text_field( $_GET[ $param_name ] ) : '';

    $terms = get_terms( [
        'taxonomy'   => $taxonomy,
        'hide_empty' => false,
    ] );

    if ( is_wp_error( $terms ) || empty( $terms ) ) {
        return;
    }

    echo '<select name="' . esc_attr( $param_name ) . '">';
    echo '<option value="">' . esc_html( $all_label ) . '</option>';
    foreach ( $terms as $term ) {
        printf(
            '<option value="%s"%s>%s</option>',
            esc_attr( $term->slug ),
            selected( $selected, $term->slug, false ),
            esc_html( $term->name )
        );
    }
    echo '</select>';
}

function seibi_information_category_dropdown() {
    seibi_category_filter_dropdown( 'information', 'information-category', 'information_category_filter', 'すべてのカテゴリー' );
}
add_action( 'restrict_manage_posts', 'seibi_information_category_dropdown' );

function seibi_graduate_category_dropdown() {
    seibi_category_filter_dropdown( 'graduate', 'graduate-category', 'graduate_category_filter', 'すべてのカテゴリー' );
}
add_action( 'restrict_manage_posts', 'seibi_graduate_category_dropdown' );

/**
 * ドロップダウン選択値を WP_Query に反映（汎用）
 */
function seibi_category_filter_query( $query ) {
    if ( ! is_admin() || ! $query->is_main_query() ) {
        return;
    }

    $map = [
        'information' => [ 'param' => 'information_category_filter', 'taxonomy' => 'information-category' ],
        'graduate'    => [ 'param' => 'graduate_category_filter',    'taxonomy' => 'graduate-category' ],
    ];

    $post_type = $query->get( 'post_type' );
    if ( ! isset( $map[ $post_type ] ) ) {
        return;
    }

    $filter = isset( $_GET[ $map[ $post_type ]['param'] ] ) ? sanitize_text_field( $_GET[ $map[ $post_type ]['param'] ] ) : '';
    if ( $filter === '' ) {
        return;
    }

    $query->set( 'tax_query', [ [
        'taxonomy' => $map[ $post_type ]['taxonomy'],
        'field'    => 'slug',
        'terms'    => $filter,
    ] ] );
}
add_action( 'pre_get_posts', 'seibi_category_filter_query' );

// -----------------------------------------------
// カスタム投稿タイプ一覧：タクソノミーカラムを追加
// -----------------------------------------------

/**
 * 投稿タイプ一覧にタクソノミーカラムを追加する汎用ヘルパー
 *
 * @param string $post_type   投稿タイプスラッグ
 * @param string $taxonomy    タクソノミースラッグ
 * @param string $column_key  カラムキー
 * @param string $label       カラムヘッダーラベル
 */
function seibi_add_taxonomy_column( $post_type, $taxonomy, $column_key, $label ) {
    // カラムをタイトルの直後に追加
    add_filter( "manage_{$post_type}_posts_columns", function( $columns ) use ( $column_key, $label ) {
        $new = [];
        foreach ( $columns as $key => $value ) {
            $new[ $key ] = $value;
            if ( $key === 'title' ) {
                $new[ $column_key ] = $label;
            }
        }
        return $new;
    } );

    // カラムの中身を出力
    add_action( "manage_{$post_type}_posts_custom_column", function( $column, $post_id ) use ( $column_key, $taxonomy ) {
        if ( $column !== $column_key ) {
            return;
        }
        $terms = get_the_terms( $post_id, $taxonomy );
        if ( $terms && ! is_wp_error( $terms ) ) {
            $names = wp_list_pluck( $terms, 'name' );
            echo esc_html( implode( ', ', $names ) );
        } else {
            echo '<span style="color:#aaa">—</span>';
        }
    }, 10, 2 );

    // カラムをソート可能にする
    add_filter( "manage_edit-{$post_type}_sortable_columns", function( $columns ) use ( $column_key ) {
        $columns[ $column_key ] = $column_key;
        return $columns;
    } );
}

// お知らせ → カテゴリー
seibi_add_taxonomy_column( 'information', 'information-category', 'info_category', 'カテゴリー' );

// 卒業生 → カテゴリー
seibi_add_taxonomy_column( 'graduate', 'graduate-category', 'grad_category', 'カテゴリー' );

// 年間行事 → 月
seibi_add_taxonomy_column( 'year', 'year_month', 'year_month_col', '月' );

// 学校説明会 → 表示設定
seibi_add_taxonomy_column( 'briefing', 'briefing-flag', 'briefing_flag_col', '表示設定' );

// 公開行事 → 表示設定
seibi_add_taxonomy_column( 'event', 'event-flag', 'event_flag_col', '表示設定' );

// -----------------------------------------------
// ダッシュボード：不要なウィジェットを非表示
// -----------------------------------------------
function seibi_remove_dashboard_widgets() {
    // WordPress ニュース
    remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
    // クイック下書き
    remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
    // 概要（At a Glance）
    remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
    // アクティビティ
    remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
    // サイトヘルスステータス
    remove_meta_box( 'dashboard_site_health', 'dashboard', 'normal' );
}
add_action( 'wp_dashboard_setup', 'seibi_remove_dashboard_widgets' );

// ようこそパネルを非表示
remove_action( 'welcome_panel', 'wp_welcome_panel' );
