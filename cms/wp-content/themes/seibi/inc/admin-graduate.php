<?php
/**
 * 卒業生アクセス制限
 *
 * seibi_graduate_access = 1 のユーザー：卒業生ページのみ編集可
 *   → 他のメニューはすべて非表示、卒業生以外のURLへの直接アクセスもブロック
 * 管理者（administrator）：制限なし（すべて表示）
 * それ以外のユーザー：卒業生メニューを非表示
 *
 * @package seibi
 */

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
            if ( in_array( $slug, [ 'index.php', 'edit.php?post_type=graduate', 'profile.php' ], true ) ) {
                continue;
            }
            remove_menu_page( $slug );
        }
        // ダッシュボードのサブメニュー（ホーム・更新）を除去
        remove_submenu_page( 'index.php', 'update-core.php' );
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
    // プロフィール画面は通過（$pagenow で先に判定）
    global $pagenow;
    if ( in_array( $pagenow, [ 'profile.php', 'user-edit.php' ], true ) ) {
        return;
    }
    $screen = get_current_screen();
    if ( ! $screen ) {
        return;
    }
    // ダッシュボード・卒業生投稿・カテゴリー画面は通過
    if ( $screen->base === 'dashboard' || $screen->post_type === 'graduate' || $screen->taxonomy === 'graduate-category' ) {
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
    // プロフィール画面は通過
    if ( in_array( $pagenow, [ 'profile.php', 'user-edit.php' ], true ) ) {
        return;
    }
    // ダッシュボードはそのまま通過
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
