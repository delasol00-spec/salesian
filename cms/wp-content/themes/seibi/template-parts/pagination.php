<?php
/**
 * ページネーション（共通）
 * .news-page-num / .news-page-arrow クラスで出力
 *
 * @package seibi
 */

global $wp_query;

$links = [];
if ( $wp_query->max_num_pages > 1 ) {
    $current = max( 1, get_query_var( 'paged' ) );
    $raw     = paginate_links( [
        'base'      => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
        'format'    => '?paged=%#%',
        'current'   => $current,
        'total'     => $wp_query->max_num_pages,
        'prev_text' => '←',
        'next_text' => '→',
        'type'      => 'array',
        'end_size'  => 1,
        'mid_size'  => 2,
    ] );
    if ( $raw ) {
        $links = $raw;
    }
}
?>
<section class="pagenation">
  <?php if ( $links ) : ?>
  <nav class="news-pagination" aria-label="ページネーション">
    <?php foreach ( $links as $link ) :
        $link = str_replace( 'class="prev page-numbers"', 'class="news-page-arrow" aria-label="前のページ"', $link );
        $link = str_replace( 'class="next page-numbers"', 'class="news-page-arrow" aria-label="次のページ"', $link );
        $link = str_replace( 'class="page-numbers current"', 'class="news-page-num is-current" aria-current="page"', $link );
        $link = str_replace( 'class="page-numbers"', 'class="news-page-num"', $link );
        echo $link;
    endforeach; ?>
  </nav>
  <?php endif; ?>
</section>
