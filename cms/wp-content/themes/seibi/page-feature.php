<?php
/**
 * 星美クラスの教育（リダイレクト）
 * URL: /feature/
 *
 * @package seibi
 */

$redirect_page = get_page_by_path( 'feature/religion' );
if ( $redirect_page ) {
    wp_redirect( get_permalink( $redirect_page->ID ), 301 );
    exit;
}
wp_redirect( home_url( '/' ), 301 );
exit;
