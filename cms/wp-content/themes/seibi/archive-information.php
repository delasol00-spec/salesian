<?php
/**
 * お知らせ（NEWS & TOPICS）アーカイブ（一覧）テンプレート
 * URL: /information/
 * カスタム投稿タイプ: information
 *
 * @package seibi
 */

get_header(); ?>

<div class="container-fluid p-0">
  <main class="sub-page-view">
    <div class="sub-hero">
      <picture>
        <source media="(max-width: 991px)" srcset="<?php echo get_template_directory_uri(); ?>/img/news-title-sp.webp" />
        <img src="<?php echo get_template_directory_uri(); ?>/img/news-title.webp" alt="" class="sub-hero-img" />
      </picture>
    </div>
    <section class="page-title">
      <h1>NEWS &amp; TOPICS</h1>
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
                'school-life' => 'bg-blue',
                'admission'   => 'bg-green',
                'event'       => 'bg-orange',
                'news'        => 'bg-purple',
            ];

            if ( have_posts() ) :
                while ( have_posts() ) : the_post();
                    $terms     = get_the_terms( get_the_ID(), 'information-category' );
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
                            <img src="<?php echo get_template_directory_uri(); ?>/img/news-title.webp" alt="<?php the_title_attribute(); ?>" class="img-fluid" />
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
                <p>現在、お知らせはありません。</p>
            <?php endif; ?>
          </div>

          <div class="col-md-4 col-12">
            <div class="row">
              <div class="col-12 blog-cate-title">カテゴリー</div>
              <div class="blog-cate-container">
                <?php $current_cat = isset( $_GET['info_cat'] ) ? sanitize_key( $_GET['info_cat'] ) : ''; ?>
                <a href="<?php echo esc_url( get_post_type_archive_link( 'information' ) ); ?>" class="btn-slide btn-ss btn-pink<?php echo $current_cat === '' ? ' is-current' : ''; ?>">全て</a><br />
                <a href="<?php echo esc_url( add_query_arg( 'info_cat', 'school-life', get_post_type_archive_link( 'information' ) ) ); ?>" class="btn-slide btn-ss btn-blue<?php echo $current_cat === 'school-life' ? ' is-current' : ''; ?>">学校生活</a><br />
                <a href="<?php echo esc_url( add_query_arg( 'info_cat', 'admission', get_post_type_archive_link( 'information' ) ) ); ?>" class="btn-slide btn-ss btn-green<?php echo $current_cat === 'admission' ? ' is-current' : ''; ?>">入試関連</a><br />
                <a href="<?php echo esc_url( add_query_arg( 'info_cat', 'event', get_post_type_archive_link( 'information' ) ) ); ?>" class="btn-slide btn-ss btn-orange<?php echo $current_cat === 'event' ? ' is-current' : ''; ?>">イベント</a><br />
                <a href="<?php echo esc_url( add_query_arg( 'info_cat', 'news', get_post_type_archive_link( 'information' ) ) ); ?>" class="btn-slide btn-ss btn-purple<?php echo $current_cat === 'news' ? ' is-current' : ''; ?>">お知らせ</a><br />
                <a href="http://el-seibi.tokyo/blog/" class="btn-slide btn-ss btn-gray" target="_blank" rel="noopener noreferrer">去年以前の記事</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php if ( $GLOBALS['wp_query']->max_num_pages > 1 ) : ?>
<section class="pagenation">
  <nav class="news-pagination" aria-label="ページネーション">
    <?php
    the_posts_pagination( [
        'mid_size'  => 2,
        'prev_text' => '←',
        'next_text' => '→',
        'before_page_number' => '<span class="news-page-num">',
        'after_page_number'  => '</span>',
    ] );
    ?>
  </nav>
</section>
<?php endif; ?>

<?php get_footer();
