<?php
/**
 * 学校生活 セクション親ページ
 * URL: /life/
 * Slug: life
 *
 * このページ単独のコンテンツは存在しない。
 * 最初の子ページ（星美クラスの一日）へリダイレクトする。
 *
 * @package salesian
 */

$children = get_pages( [
    'parent'      => get_the_ID(),
    'sort_order'  => 'ASC',
    'sort_column' => 'menu_order',
    'number'      => 1,
] );

if ( $children ) {
    wp_redirect( get_permalink( $children[0]->ID ), 301 );
    exit;
}

// 子ページが見つからない場合はトップへ
wp_redirect( home_url( '/' ), 301 );
exit;
