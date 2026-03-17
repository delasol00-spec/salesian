<?php
/**
 * 年間行事 アーカイブ（一覧）テンプレート
 * URL: /life/year/
 * カスタム投稿タイプ: year
 * ギャラリー形式（アイキャッチ画像のみ）
 *
 * @package seibi
 */

get_header(); ?>

<div class="container-fluid p-0">
  <main class="sub-page-view">
    <div class="sub-hero">
      <img src="<?php echo get_template_directory_uri(); ?>/img/school-life-bg.webp" alt="" class="sub-hero-img" />
    </div>
    <section class="page-title">
      <h1>年間行事</h1>
      <div class="inner-border"></div>
    </section>
  </main>
</div>

<section class="p-70-70">
  <div class="container">
    <div class="row">
      <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
        <div class="col-md-4 col-6 mb-4">
          <a href="<?php the_permalink(); ?>" class="year-gallery-item d-block">
            <div class="year-gallery-img">
              <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'medium_large', [ 'alt' => get_the_title(), 'class' => 'img-fluid w-100' ] ); ?>
              <?php else : ?>
                <img src="<?php echo get_template_directory_uri(); ?>/img/news_title.svg" alt="<?php the_title_attribute(); ?>" class="img-fluid w-100" />
              <?php endif; ?>
            </div>
            <p class="year-gallery-title text-center mt-2"><?php the_title(); ?></p>
          </a>
        </div>
        <?php endwhile; ?>
      <?php else : ?>
        <div class="col-12">
          <p>現在、年間行事のギャラリーはありません。</p>
        </div>
      <?php endif; ?>
    </div>

    <?php if ( $GLOBALS['wp_query']->max_num_pages > 1 ) : ?>
    <div class="row mt-4">
      <div class="col-12 text-center">
        <?php
        the_posts_pagination( [
            'mid_size'  => 2,
            'prev_text' => '<span class="material-symbols-outlined">chevron_left</span>',
            'next_text' => '<span class="material-symbols-outlined">chevron_right</span>',
        ] );
        ?>
      </div>
    </div>
    <?php endif; ?>
  </div>
</section>

<?php get_footer();
