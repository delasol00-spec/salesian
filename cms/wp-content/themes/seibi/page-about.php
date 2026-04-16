<?php
/**
 * 学校紹介 セクション親ページ
 * URL: /about/
 * Slug: about
 *
 * このページ単独のコンテンツは存在しない。
 * 建学の精神・教育理念へリダイレクトする。
 *
 * @package salesian
 */

$redirect_page = get_page_by_path( 'about/method' );
if ( $redirect_page ) {
    wp_redirect( get_permalink( $redirect_page->ID ), 301 );
    exit;
}
wp_redirect( home_url( '/' ), 301 );
exit;
