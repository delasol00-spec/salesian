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
      <img src="<?php echo get_template_directory_uri(); ?>/img/news_title.svg" alt="" class="sub-hero-img" style="object-fit:contain; background:#f8f4f1;" />
    </div>
    <section class="page-title">
      <h1>NEWS &amp; TOPICS</h1>
      <div class="inner-border"></div>
    </section>
  </main>
</div>

<section class="news news-bg p-70-70">
  <div class="container">
    <div class="row">
      <div class="news-cate-container">
        <a href="<?php echo esc_url( get_post_type_archive_link( 'information' ) ); ?>" class="btn-slide btn-s btn-pink">全て</a>
        <a href="<?php echo esc_url( add_query_arg( 'info_cat','school-life', get_post_type_archive_link( 'information' ) ) ); ?>" class="btn-slide btn-s btn-blue">学校生活</a>
        <a href="<?php echo esc_url( add_query_arg( 'info_cat','admission', get_post_type_archive_link( 'information' ) ) ); ?>" class="btn-slide btn-s btn-green">入試関連</a>
        <a href="<?php echo esc_url( add_query_arg( 'info_cat','event', get_post_type_archive_link( 'information' ) ) ); ?>" class="btn-slide btn-s btn-orange">イベント</a>
        <a href="<?php echo esc_url( add_query_arg( 'info_cat','news', get_post_type_archive_link( 'information' ) ) ); ?>" class="btn-slide btn-s btn-purple">お知らせ</a>
      </div>
    </div>
  </div>

  <div class="news-card-grid">
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
            ?>
            <article class="news-card">
              <a href="<?php the_permalink(); ?>" class="news-card-link">
                <div class="news-card-header">
                  <span class="news-date"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></span>
                  <?php if ( $cat_label ) : ?>
                  <span class="news-category <?php echo esc_attr( $cat_class ); ?>"><?php echo $cat_label; ?></span>
                  <?php endif; ?>
                </div>

                <div class="news-card-image">
                  <?php if ( has_post_thumbnail() ) : ?>
                    <?php the_post_thumbnail( 'medium', [ 'alt' => get_the_title() ] ); ?>
                  <?php else : ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/img/news_title.svg" alt="<?php the_title_attribute(); ?>" />
                  <?php endif; ?>
                </div>

                <div class="news-card-body">
                  <h3 class="news-card-title"><?php the_title(); ?></h3>
                </div>
              </a>
            </article>
            <?php
        endwhile;
    else : ?>
        <div class="container">
          <p>現在、お知らせはありません。</p>
        </div>
    <?php endif; ?>
  </div>

  <?php if ( $GLOBALS['wp_query']->max_num_pages > 1 ) : ?>
  <div class="col-12 mb-lg-5 mt-lg-5 text-center">
    <?php
    the_posts_pagination( [
        'mid_size'  => 2,
        'prev_text' => '<span class="material-symbols-outlined">chevron_left</span>',
        'next_text' => '<span class="material-symbols-outlined">chevron_right</span>',
    ] );
    ?>
  </div>
  <?php endif; ?>
</section>

<?php get_footer();
