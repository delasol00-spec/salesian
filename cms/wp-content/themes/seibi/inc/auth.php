<?php
/**
 * ページ別 Basic 認証
 *
 * @package seibi
 */

/**
 * 「保護者の方」ページ（スラッグ: parents）にのみ Basic 認証をかける。
 * template_redirect は出力前に実行されるため、ヘッダー送信が可能。
 */
function seibi_basic_auth_parents() {
    if ( ! is_page( 'guardians' ) ) {
        return;
    }

    $valid_user = 'admin';
    $valid_pass = 'pass';

    $auth_user = isset( $_SERVER['PHP_AUTH_USER'] ) ? $_SERVER['PHP_AUTH_USER'] : '';
    $auth_pass = isset( $_SERVER['PHP_AUTH_PW'] )   ? $_SERVER['PHP_AUTH_PW']   : '';

    if ( $auth_user !== $valid_user || $auth_pass !== $valid_pass ) {
        header( 'WWW-Authenticate: Basic realm="保護者専用ページ"' );
        status_header( 401 );
        echo '認証が必要です。正しいユーザー名とパスワードを入力してください。';
        exit;
    }
}
add_action( 'template_redirect', 'seibi_basic_auth_parents' );
