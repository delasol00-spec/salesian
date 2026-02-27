<?php
/**
 * 学校生活 セクショントップテンプレート
 * URL: /school-life/
 * Slug: school-life
 *
 * 静的HTML受領後に html/school-life/index.html の内容を移植する。
 *
 * @package salesian
 */

get_header(); ?>

<!-- =======================================
     MAIN: 学校生活
     html/school-life/index.html を参照して移植する
     ======================================= -->
<main id="main-school-life">
    <?php get_template_part( 'template-parts/breadcrumb' ); ?>

    <?php if ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
    <?php endif; ?>
</main>
<!-- /MAIN -->

<?php get_footer();
