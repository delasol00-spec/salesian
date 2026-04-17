<?php
/**
 * ページ別 Basic 認証
 *
 * @package seibi
 */

/**
 * 「保護者の方」ページ（スラッグ: guardians）にのみ Basic 認証をかける。
 * template_redirect は出力前に実行されるため、ヘッダー送信が可能。
 */
function seibi_basic_auth_parents() {
    if ( ! is_page( 'guardians' ) ) {
        return;
    }

    // .htpasswd ファイルからユーザー一覧を読み込む
    $htpasswd_file = get_template_directory() . '/inc/.htpasswd';
    $valid_users   = array();
    if ( file_exists( $htpasswd_file ) ) {
        $lines = file( $htpasswd_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );
        foreach ( $lines as $line ) {
            $line = trim( $line );
            if ( empty( $line ) || strpos( $line, ':' ) === false ) {
                continue;
            }
            list( $u, $h ) = explode( ':', $line, 2 );
            $valid_users[ trim( $u ) ] = trim( $h );
        }
    }

    // FastCGI 環境（エックスサーバー等）では PHP_AUTH_USER が自動設定されないため、
    // 複数の方法で Authorization ヘッダーを取得してフォールバックする。
    if ( ! isset( $_SERVER['PHP_AUTH_USER'] ) ) {
        $authorization = '';

        // 方法1: $_SERVER から直接取得
        if ( ! empty( $_SERVER['HTTP_AUTHORIZATION'] ) ) {
            $authorization = $_SERVER['HTTP_AUTHORIZATION'];
        } elseif ( ! empty( $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ) ) {
            $authorization = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
        }

        // 方法2: getallheaders()（FastCGI でも動作する場合がある）
        if ( ! $authorization && function_exists( 'getallheaders' ) ) {
            $all_headers = getallheaders();
            foreach ( $all_headers as $key => $value ) {
                if ( strtolower( $key ) === 'authorization' ) {
                    $authorization = $value;
                    break;
                }
            }
        }

        if ( substr( $authorization, 0, 6 ) === 'Basic ' ) {
            $decoded = base64_decode( substr( $authorization, 6 ) );
            if ( strpos( $decoded, ':' ) !== false ) {
                list( $_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'] ) = explode( ':', $decoded, 2 );
            }
        }
    }

    $auth_user = isset( $_SERVER['PHP_AUTH_USER'] ) ? $_SERVER['PHP_AUTH_USER'] : '';
    $auth_pass = isset( $_SERVER['PHP_AUTH_PW'] )   ? $_SERVER['PHP_AUTH_PW']   : '';

    // .htpasswd の DES crypt ハッシュで検証
    $authenticated = false;
    if ( isset( $valid_users[ $auth_user ] ) ) {
        $hash = $valid_users[ $auth_user ];
        if ( crypt( $auth_pass, $hash ) === $hash ) {
            $authenticated = true;
        }
    }

    if ( ! $authenticated ) {
        header( 'WWW-Authenticate: Basic realm="保護者専用ページ"' );
        status_header( 401 );
        echo '認証が必要です。正しいユーザー名とパスワードを入力してください。';
        exit;
    }
}
add_action( 'template_redirect', 'seibi_basic_auth_parents' );
