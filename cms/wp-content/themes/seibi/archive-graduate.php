<?php
/**
 * 卒業生の方へ アーカイブ（一覧）テンプレート
 * URL: /graduate/
 * カスタム投稿タイプ: graduate
 *
 * @package seibi
 */

get_header(); ?>

<div class="container-fluid p-0">
  <main class="sub-page-view">
    <div class="sub-hero">
      <img src="<?php echo get_template_directory_uri(); ?>/img/graduate/main.webp" alt="" class="sub-hero-img" />
    </div>
    <section class="page-title">
      <h1>卒業生の方へ</h1>
      <div class="inner-border"></div>
    </section>
  </main>
</div>

<section class="p-70-0">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="row">
          <div class="col-md-8 col-12">
            <?php
            $bg_map = [
                'news'          => 'bg-purple',
                'alumni-report' => 'bg-blue',
            ];

            if ( have_posts() ) :
                while ( have_posts() ) : the_post();
                    $terms     = get_the_terms( get_the_ID(), 'graduate-category' );
                    $term      = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0] : null;
                    $cat_label = $term ? esc_html( $term->name ) : '';
                    $cat_slug  = $term ? $term->slug : '';
                    $cat_class = isset( $bg_map[ $cat_slug ] ) ? $bg_map[ $cat_slug ] : 'bg-blue';
                    $excerpt   = get_the_excerpt();
                    if ( mb_strlen( $excerpt ) > 75 ) {
                        $excerpt = mb_substr( $excerpt, 0, 75 ) . '…';
                    }
                    ?>
                    <div class="news-list">
                      <article class="news-card">
                        <a href="<?php the_permalink(); ?>" class="news-card-link">
                          <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'medium', [ 'alt' => get_the_title(), 'class' => 'img-fluid' ] ); ?>
                          <?php else : ?>
                            <img src="<?php echo get_template_directory_uri(); ?>/img/graduate/main.webp" alt="<?php the_title_attribute(); ?>" class="img-fluid" />
                          <?php endif; ?>
                          <div class="news-card-body">
                            <div class="blog-header">
                              <span class="news-date"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></span>
                              <?php if ( $cat_label ) : ?>
                              <span class="news-category <?php echo esc_attr( $cat_class ); ?>"><?php echo $cat_label; ?></span>
                              <?php endif; ?>
                            </div>
                            <h2 class="news-card-title"><?php the_title(); ?></h2>
                            <?php if ( $excerpt ) : ?>
                            <p class="news-card-excerpt"><?php echo esc_html( $excerpt ); ?></p>
                            <?php endif; ?>
                          </div>
                        </a>
                      </article>
                    </div>
                    <?php
                endwhile;
            else : ?>
                <p>現在、記事はありません。</p>
            <?php endif; ?>
          </div>

          <div class="col-md-4 col-12">
            <div class="row">
              <div class="col-12 blog-cate-title">カテゴリー</div>
              <div class="blog-cate-container">
                <?php $current_cat = isset( $_GET['grad_cat'] ) ? sanitize_key( $_GET['grad_cat'] ) : ''; ?>
                <a href="<?php echo esc_url( get_post_type_archive_link( 'graduate' ) ); ?>" class="gra-cate<?php echo $current_cat === '' ? ' is-current' : ''; ?>">全て</a><br />
                <a href="<?php echo esc_url( add_query_arg( 'grad_cat', 'news', get_post_type_archive_link( 'graduate' ) ) ); ?>" class="gra-cate<?php echo $current_cat === 'news' ? ' is-current' : ''; ?>">お知らせ</a><br />
                <a href="<?php echo esc_url( add_query_arg( 'grad_cat', 'alumni-report', get_post_type_archive_link( 'graduate' ) ) ); ?>" class="gra-cate<?php echo $current_cat === 'alumni-report' ? ' is-current' : ''; ?>">同窓会報告</a><br />
                <a href="http://el-seibi.tokyo/blog/" class="gra-cate" target="_blank" rel="noopener noreferrer">去年以前の記事</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
global $wp_query;
if ( $wp_query->max_num_pages > 1 ) :
    $current = max( 1, get_query_var( 'paged' ) );
    $links   = paginate_links( [
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
?>
<section class="pagenation">
  <nav class="news-pagination" aria-label="ページネーション">
    <?php foreach ( $links as $link ) :
        $link = str_replace( 'class="prev page-numbers"', 'class="news-page-arrow" aria-label="前のページ"', $link );
        $link = str_replace( 'class="next page-numbers"', 'class="news-page-arrow" aria-label="次のページ"', $link );
        $link = str_replace( 'class="page-numbers current"', 'class="news-page-num is-current" aria-current="page"', $link );
        $link = str_replace( 'class="page-numbers"', 'class="news-page-num"', $link );
        echo $link;
    endforeach; ?>
  </nav>
</section>
<?php endif; ?>

<?php get_footer();
