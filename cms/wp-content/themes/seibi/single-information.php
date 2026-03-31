<?php
/**
 * お知らせ 詳細テンプレート
 * カスタム投稿タイプ: information
 *
 * @package seibi
 */

get_header(); ?>

<?php if ( have_posts() ) : the_post(); ?>

<div class="container-fluid p-0">
  <main class="sub-page-view">
    <div class="sub-hero">
      <div class="sub-hero blog-main-img">
        <?php if ( has_post_thumbnail() ) : ?>
          <?php the_post_thumbnail( 'full', [ 'alt' => '', 'class' => 'sub-hero-img' ] ); ?>
        <?php else : ?>
          <img src="<?php echo get_template_directory_uri(); ?>/img/news-title.webp" alt="" class="sub-hero-img" />
        <?php endif; ?>
      </div>
    </div>
    <section class="page-title blog-title">
      <h1>NEWS &amp; TOPICS</h1>
      <div class="inner-border"></div>
    </section>
  </main>
</div>

<section class="p-70-70">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8 col-12">
        <?php
        $terms     = get_the_terms( get_the_ID(), 'information-category' );
        $term      = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0] : null;
        $cat_label = $term ? esc_html( $term->name ) : '';
        $cat_slug  = $term ? $term->slug : '';
        $bg_map    = [
            'school-life' => 'bg-blue',
            'admission'   => 'bg-green',
            'event'       => 'bg-orange',
            'news'        => 'bg-purple',
        ];
        $cat_class = isset( $bg_map[ $cat_slug ] ) ? $bg_map[ $cat_slug ] : 'bg-blue';
        ?>
        <div class="blog-header">
          <span class="news-date"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></span>
          <?php if ( $cat_label ) : ?>
          <span class="news-category <?php echo esc_attr( $cat_class ); ?>"><?php echo $cat_label; ?></span>
          <?php endif; ?>
        </div>
        <h2 class="blog-title"><?php the_title(); ?></h2>

        <div class="single-news-content">
          <?php the_content(); ?>
        </div>

        <div class="page-direction mt-5">
          <div class="text-center d-flex justify-content-between">
            <?php $prev = get_adjacent_post( false, '', true ); ?>
            <?php if ( $prev ) : ?>
            <a href="<?php echo esc_url( get_permalink( $prev->ID ) ); ?>" class="btn-slide btn-s btn-pink">
              <span class="text">前の記事</span>
            </a>
            <?php else : ?>
            <span class="btn-slide btn-s btn-pink disabled" aria-disabled="true">
              <span class="text">前の記事</span>
            </span>
            <?php endif; ?>

            <?php $next = get_adjacent_post( false, '', false ); ?>
            <?php if ( $next ) : ?>
            <a href="<?php echo esc_url( get_permalink( $next->ID ) ); ?>" class="btn-slide btn-s btn-pink">
              <span class="text">次の記事</span>
            </a>
            <?php else : ?>
            <span class="btn-slide btn-s btn-pink disabled" aria-disabled="true">
              <span class="text">次の記事</span>
            </span>
            <?php endif; ?>
          </div>
          <div class="mt-5 text-center">
            <a class="btn-slide btn-l btn-pink" href="<?php echo esc_url( get_post_type_archive_link( 'information' ) ); ?>">NEWS &amp; TOPICS一覧へ戻る</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php endif; ?>

<?php get_footer();
