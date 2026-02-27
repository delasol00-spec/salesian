<?php
/**
 * WordPress Docker 設定ファイル
 */

if (!function_exists('getenv_docker')) {
	function getenv_docker($env, $default) {
		if ($fileEnv = getenv($env . '_FILE')) {
			return rtrim(file_get_contents($fileEnv), "\r\n");
		} elseif (($val = getenv($env)) !== false) {
			return $val;
		} else {
			return $default;
		}
	}
}

// ** データベース設定 ** //
define( 'DB_NAME',     getenv_docker('WORDPRESS_DB_NAME',     'wordpress') );
define( 'DB_USER',     getenv_docker('WORDPRESS_DB_USER',     'wordpress') );
define( 'DB_PASSWORD', getenv_docker('WORDPRESS_DB_PASSWORD', 'wordpress_password') );
define( 'DB_HOST',     getenv_docker('WORDPRESS_DB_HOST',     'mysql') );
define( 'DB_CHARSET',  'utf8mb4' );
define( 'DB_COLLATE',  '' );

// ** 認証キー・ソルト ** //
define( 'AUTH_KEY',         getenv_docker('WORDPRESS_AUTH_KEY',         'fe0402fbfbdd3ed110c11310150b448f34a94630') );
define( 'SECURE_AUTH_KEY',  getenv_docker('WORDPRESS_SECURE_AUTH_KEY',  'a56b151f395f47212bf686b0782a67d4519d4e37') );
define( 'LOGGED_IN_KEY',    getenv_docker('WORDPRESS_LOGGED_IN_KEY',    '31fa4b0516114efcdbb38ddea82943600af48971') );
define( 'NONCE_KEY',        getenv_docker('WORDPRESS_NONCE_KEY',        'ff449b858f896c9bb3f56b0839831ef289ee1c80') );
define( 'AUTH_SALT',        getenv_docker('WORDPRESS_AUTH_SALT',        '6d30150425b636c87f884faa045fc00b844a334c') );
define( 'SECURE_AUTH_SALT', getenv_docker('WORDPRESS_SECURE_AUTH_SALT', '68cdd3203e0160f81620ae26045802dd98f8fe44') );
define( 'LOGGED_IN_SALT',   getenv_docker('WORDPRESS_LOGGED_IN_SALT',   'ecb6244c9d1cd6a51b193ad6ec8c7898bf138a80') );
define( 'NONCE_SALT',       getenv_docker('WORDPRESS_NONCE_SALT',       '89db50d238fa709f40c43aba05a55e9245932d23') );

// ** テーブルプレフィックス ** //
$table_prefix = getenv_docker('WORDPRESS_TABLE_PREFIX', 'wp_');

// ** サイトURL設定 ** //
// WP_HOME  : ブラウザでアクセスするURL（フロントエンドのURL）
// WP_SITEURL: WordPressコアが設置されているURL（管理画面のベースURL）
define( 'WP_HOME',    'http://localhost:8110/seibi' );
define( 'WP_SITEURL', 'http://localhost:8110/seibi/cms' );

// ** デバッグ設定 ** //
define( 'WP_DEBUG', false );

/* リバースプロキシ対応 */
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false) {
	$_SERVER['HTTPS'] = 'on';
}

if ($configExtra = getenv_docker('WORDPRESS_CONFIG_EXTRA', '')) {
	eval($configExtra);
}

/* 編集はここまで */

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

require_once ABSPATH . 'wp-settings.php';
