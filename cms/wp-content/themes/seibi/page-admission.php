<?php
/**
 * 入試について セクション親ページ
 * URL: /admission/
 * Slug: admission
 *
 * このページ単独のコンテンツは存在しない。
 * 児童募集要項へリダイレクトする。
 *
 * @package salesian
 */

$redirect_page = get_page_by_path( 'admission/requirements' );
if ( $redirect_page ) {
    wp_redirect( get_permalink( $redirect_page->ID ), 301 );
    exit;
}
wp_redirect( home_url( '/' ), 301 );
exit;
