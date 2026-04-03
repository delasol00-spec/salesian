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
// 卒業生 アクセス制限
//
// seibi_graduate_access = 1 のユーザー：卒業生ページのみ編集可
//   → 他のメニューはすべて非表示、卒業生以外のURLへの直接アクセスもブロック
// 管理者（administrator）：制限なし（すべて表示）
// それ以外のユーザー：卒業生メニューを非表示
// -----------------------------------------------

/**
 * graduate 限定ユーザーか判定する。
 */
function seibi_is_graduate_only_user() {
    if ( current_user_can( 'administrator' ) ) {
        return false;
    }
    return get_user_meta( get_current_user_id(), 'seibi_graduate_access', true ) === '1';
}

/**
 * 管理画面メニューの表示制御。
 * - graduate 限定ユーザー：卒業生以外をすべて非表示
 * - それ以外の非管理者：卒業生メニューを非表示
 */
function seibi_graduate_control_menu() {
    if ( current_user_can( 'administrator' ) ) {
        return;
    }

    if ( seibi_is_graduate_only_user() ) {
        // 卒業生関連以外をすべて除去
        global $menu, $submenu;
        foreach ( $menu as $item ) {
            $slug = $item[2] ?? '';
            if ( $slug === 'edit.php?post_type=graduate' ) {
                continue;
            }
            remove_menu_page( $slug );
        }
        // ダッシュボードのサブメニューも除去
        remove_submenu_page( 'index.php', 'index.php' );
        return;
    }

    // 通常ユーザー：卒業生メニューを非表示
    remove_menu_page( 'edit.php?post_type=graduate' );
}
add_action( 'admin_menu', 'seibi_graduate_control_menu', 999 );

/**
 * graduate 限定ユーザーが卒業生以外のURLへ直接アクセスした場合にブロックする。
 */
function seibi_graduate_block_other_screens() {
    if ( ! is_admin() || ! seibi_is_graduate_only_user() ) {
        return;
    }
    $screen = get_current_screen();
    if ( ! $screen ) {
        return;
    }
    // 卒業生投稿・カテゴリー画面は通過
    if ( $screen->post_type === 'graduate' || $screen->taxonomy === 'graduate-category' ) {
        return;
    }
    // プロフィール画面は通過（パスワード変更等）
    if ( $screen->base === 'profile' ) {
        return;
    }
    wp_safe_redirect( admin_url( 'edit.php?post_type=graduate' ) );
    exit;
}
add_action( 'current_screen', 'seibi_graduate_block_other_screens' );

/**
 * graduate 限定ユーザーがダッシュボード（/wp-admin/）にアクセスしたとき
 * 卒業生一覧へリダイレクトする（current_screen より前に発火）。
 */
function seibi_graduate_redirect_dashboard() {
    if ( ! is_admin() || ! seibi_is_graduate_only_user() ) {
        return;
    }
    global $pagenow;
    if ( $pagenow === 'index.php' ) {
        wp_safe_redirect( admin_url( 'edit.php?post_type=graduate' ) );
        exit;
    }
}
add_action( 'admin_init', 'seibi_graduate_redirect_dashboard' );

/**
 * ユーザープロフィール画面に「卒業生ページ管理」チェックボックスを追加。
 * 管理者のみ表示・操作可。
 */
function seibi_graduate_access_profile_field( WP_User $user ) {
    if ( ! current_user_can( 'administrator' ) ) {
        return;
    }
    // 管理者自身には不要（常に全権限）
    if ( in_array( 'administrator', $user->roles, true ) ) {
        return;
    }
    $has_access = get_user_meta( $user->ID, 'seibi_graduate_access', true ) === '1';
    ?>
    <h2>卒業生ページ管理</h2>
    <table class="form-table">
        <tr>
            <th><label for="seibi_graduate_access">アクセス権限</label></th>
            <td>
                <input type="checkbox"
                       name="seibi_graduate_access"
                       id="seibi_graduate_access"
                       value="1"
                       <?php checked( $has_access ); ?> />
                <label for="seibi_graduate_access">卒業生ページの管理のみを許可する</label>
                <p class="description">チェックを入れると、このユーザーは卒業生ページの編集のみ行えます。</p>
            </td>
        </tr>
    </table>
    <?php
}
add_action( 'show_user_profile', 'seibi_graduate_access_profile_field' );
add_action( 'edit_user_profile', 'seibi_graduate_access_profile_field' );

/**
 * チェックボックスの値を保存する。管理者のみ操作可。
 */
function seibi_graduate_access_profile_save( $user_id ) {
    if ( ! current_user_can( 'administrator' ) ) {
        return;
    }
    // 管理者自身は変更しない
    $target = new WP_User( $user_id );
    if ( in_array( 'administrator', $target->roles, true ) ) {
        return;
    }
    if ( isset( $_POST['seibi_graduate_access'] ) && $_POST['seibi_graduate_access'] === '1' ) {
        update_user_meta( $user_id, 'seibi_graduate_access', '1' );
    } else {
        delete_user_meta( $user_id, 'seibi_graduate_access' );
    }
}
add_action( 'personal_options_update', 'seibi_graduate_access_profile_save' );
add_action( 'edit_user_profile_update', 'seibi_graduate_access_profile_save' );

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
