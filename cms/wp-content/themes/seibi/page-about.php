<?php
/**
 * 学校紹介 セクション親ページ
 * URL: /about/
 * Slug: about
 *
 * このページ単独のコンテンツは存在しない。
 * 校長メッセージへリダイレクトする。
 *
 * @package salesian
 */

$redirect_page = get_page_by_path( 'about/principal' );
if ( $redirect_page ) {
    wp_redirect( get_permalink( $redirect_page->ID ), 301 );
    exit;
}
wp_redirect( home_url( '/' ), 301 );
exit;
