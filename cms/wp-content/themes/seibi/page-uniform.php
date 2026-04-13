<?php
/**
 * 制服
 * URL: /about/uniform/
 *
 * @package seibi
 */

get_header(); ?>

<div class="container-fluid p-0">
  <main class="sub-page-view">
    <div class="sub-hero">
      <picture>
        <source media="(max-width: 991px)" srcset="<?php echo get_template_directory_uri(); ?>/img/about/hero-about-bg.webp" />
        <img src="<?php echo get_template_directory_uri(); ?>/img/about/about-bg.webp" alt="" class="sub-hero-img" />
      </picture>
    </div>

    <section class="page-title">
      <h1><?php the_title(); ?></h1>
      <div class="inner-border"></div>
    </section>
  </main>
</div>

<section class="p-70-70">
  <div class="container">
    <div class="row uniform">
      <div class="col-md-6 col-12 mb-3">
        <img src="<?php echo get_template_directory_uri(); ?>/img/uniform-img/uni-winter.webp" class="img-fluid r-top-10" loading="lazy" alt="冬服" />
        <p class="img-title r-bottom-10 bg-pink">冬服</p>
      </div>
      <div class="col-md-6 col-12">
        <img src="<?php echo get_template_directory_uri(); ?>/img/uniform-img/uni-summer.webp" class="img-fluid r-top-10" loading="lazy" alt="夏服" />
        <p class="img-title r-bottom-10 bg-blue">夏服</p>
      </div>
    </div>
  </div>
</section>

<?php get_footer();
