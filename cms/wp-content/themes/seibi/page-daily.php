<?php
/**
 * 星美クラスの一日
 * URL: /life/daily/
 *
 * @package seibi
 */

get_header(); ?>

<?php get_template_part( 'template-parts/page-hero', null, [ 'hero_img' => 'img/igakunen.webp' ] ); ?>

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
