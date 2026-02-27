<?php
/**
 * 学校紹介 セクショントップテンプレート
 * URL: /about/
 * Slug: about
 *
 * 静的HTML受領後に html/about/index.html の内容を移植する。
 *
 * @package salesian
 */

get_header(); ?>

<!-- =======================================
     MAIN: 学校紹介
     html/about/index.html を参照して移植する
     ======================================= -->
<main id="main-about">
    <?php get_template_part( 'template-parts/breadcrumb' ); ?>

    <?php if ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
    <?php endif; ?>
</main>
<!-- /MAIN -->

<?php get_footer();
