<?php
/**
 * WordPress サブディレクトリインストール用エントリポイント
 *
 * URL:             http://localhost:8110/seibi/
 * FPMコンテナ内:   /var/www/html/seibi/index.php
 * WordPressコア:   /var/www/html/  （一階層上）
 *
 * @package WordPress
 */

define( 'WP_USE_THEMES', true );
require( dirname( __FILE__ ) . '/../wp-blog-header.php' );
