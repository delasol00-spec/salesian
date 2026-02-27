<?php
/**
 * 星美クラスの教育 セクショントップテンプレート
 * URL: /seibi/
 * Slug: seibi
 *
 * 静的HTML受領後に html/seibi/index.html の内容を移植する。
 *
 * @package salesian
 */

get_header(); ?>

<!-- =======================================
     MAIN: 星美クラスの教育
     html/seibi/index.html を参照して移植する
     ======================================= -->
<main id="main-seibi">
    <?php get_template_part( 'template-parts/breadcrumb' ); ?>

    <?php if ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
    <?php endif; ?>
</main>
<!-- /MAIN -->

<?php get_footer();
