<?php
/**
 * 制服
 * URL: /about/uniform/
 *
 * @package salesian
 */

get_header(); ?>

<?php get_template_part( 'template-parts/page-hero', null, [ 'hero_img' => 'img/about/about-bg.webp' ] ); ?>

<section class="p-70-70">
  <div class="container">
    <div class="row uniform">
      <div class="col-md-6 col-12 mb-3">
        <img src="<?php echo get_template_directory_uri(); ?>/img/uniform-img/uni-winter.webp" class="img-fluid r-top-10" loading="lazy" alt="冬服" />
        <p class="img-title r-bottom-10">冬服<br><span>期間：10月〜5月中旬</span></p>
      </div>
      <div class="col-md-6 col-12">
        <img src="<?php echo get_template_directory_uri(); ?>/img/uniform-img/uni-summer.webp" class="img-fluid r-top-10" loading="lazy" alt="夏服" />
        <p class="img-title r-bottom-10">夏服<br><span>期間：5月下旬〜9月</span></p>
      </div>
    </div>
  </div>
</section>

<?php get_footer();
