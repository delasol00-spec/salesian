<?php
/**
 * 星美クラスの教育（リダイレクト）
 * URL: /feature/
 *
 * @package seibi
 */

$first_child = get_page_by_path( 'feature/integrated-studies' );
if ( $first_child ) {
    wp_redirect( get_permalink( $first_child->ID ), 301 );
    exit;
}
