<?php
/**
 * 星美クラスの特色
 * URL: /feature/characteristics/
 *
 * @package seibi
 */

get_header(); ?>

<div class="container-fluid p-0">
  <main class="sub-page-view">
    <div class="sub-hero">
      <img src="<?php echo get_template_directory_uri(); ?>/img/edu01.webp" alt="" class="sub-hero-img" />
    </div>
    <section class="page-title">
      <h1><?php the_title(); ?></h1>
      <div class="inner-border"></div>
    </section>
  </main>
</div>

<section class="p-70-70">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <?php if ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<?php get_footer();
