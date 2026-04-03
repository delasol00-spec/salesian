<?php
/**
 * 学校生活 セクション親ページ
 * URL: /life/
 * Slug: life
 *
 * このページ単独のコンテンツは存在しない。
 * 星美クラスの一日へリダイレクトする。
 *
 * @package salesian
 */

$redirect_page = get_page_by_path( 'life/daily' );
if ( $redirect_page ) {
    wp_redirect( get_permalink( $redirect_page->ID ), 301 );
    exit;
}
wp_redirect( home_url( '/' ), 301 );
exit;
