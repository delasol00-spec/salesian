<?php
/**
 * お知らせ 詳細テンプレート
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

<section class="p-70-70">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <?php if ( have_posts() ) : the_post(); ?>
        <article class="single-news-article">
          <div class="single-news-header mb-4">
            <?php
            $terms     = get_the_terms( get_the_ID(), 'information-category' );
            $term      = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0] : null;
            $cat_label = $term ? esc_html( $term->name ) : '';
            $cat_slug  = $term ? $term->slug : '';
            $bg_map    = [
                'school-life' => 'bg-blue',
                'admission'   => 'bg-green',
                'event'       => 'bg-orange',
                'notice'      => 'bg-purple',
            ];
            $cat_class = isset( $bg_map[ $cat_slug ] ) ? $bg_map[ $cat_slug ] : 'bg-blue';
            ?>
            <div class="d-flex align-items-center mb-2">
              <span class="news-date mr-3"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></span>
              <?php if ( $cat_label ) : ?>
              <span class="news-category <?php echo esc_attr( $cat_class ); ?>"><?php echo $cat_label; ?></span>
              <?php endif; ?>
            </div>
            <h1 class="single-news-title"><?php the_title(); ?></h1>
          </div>

          <?php if ( has_post_thumbnail() ) : ?>
          <div class="single-news-thumbnail mb-4">
            <?php the_post_thumbnail( 'large', [ 'alt' => get_the_title(), 'class' => 'img-fluid' ] ); ?>
          </div>
          <?php endif; ?>

          <div class="single-news-content">
            <?php the_content(); ?>
          </div>
        </article>

        <div class="mt-5 text-center">
          <a class="btn-slide btn-l btn-pink" href="<?php echo esc_url( get_post_type_archive_link( 'information' ) ); ?>">
            <span class="text">NEWS &amp; TOPICS一覧へ戻る</span>
          </a>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<?php get_footer();
