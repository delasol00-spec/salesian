<?php
/**
 * 年間行事 詳細テンプレート
 * カスタム投稿タイプ: year
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
      <h1><?php the_title(); ?></h1>
      <div class="inner-border"></div>
    </section>
  </main>
</div>

<section class="p-70-70">
  <div class="container">
    <?php if ( have_posts() ) : the_post(); ?>
    <div class="row justify-content-center">
      <?php if ( has_post_thumbnail() ) : ?>
      <div class="col-lg-8 mb-4">
        <?php the_post_thumbnail( 'full', [ 'alt' => get_the_title(), 'class' => 'img-fluid w-100' ] ); ?>
      </div>
      <?php endif; ?>

      <div class="col-lg-8">
        <div class="single-year-content">
          <?php the_content(); ?>
        </div>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-12 text-center">
        <a class="btn-slide btn-l btn-pink" href="<?php echo esc_url( get_post_type_archive_link( 'year' ) ); ?>">
          <span class="text">年間行事一覧へ戻る</span>
        </a>
      </div>
    </div>
    <?php endif; ?>
  </div>
</section>

<?php get_footer();
