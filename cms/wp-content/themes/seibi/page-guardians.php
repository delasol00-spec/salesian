<?php
/**
 * 保護者の方
 * URL: /guardians/
 * ※ Basic 認証あり（inc/auth.php で制御）
 *
 * @package seibi
 */

get_header(); ?>

<?php get_template_part( 'template-parts/page-hero', null, [ 'hero_img' => 'img/about/about-bg.webp', 'hero_sp_img' => 'img/about/hero-about-bg.webp' ] ); ?>

<section class="p-70-70">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <?php
        while ( have_posts() ) :
            the_post();
            ?>
            <h2 class="sec-title pink"><?php the_title(); ?></h2>
            <?php the_content(); ?>
        <?php endwhile; ?>
      </div>
    </div>
  </div>
</section>

<?php get_footer();
