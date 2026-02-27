<?php
/**
 * 入試について セクショントップテンプレート
 * URL: /admission/
 * Slug: admission
 *
 * 静的HTML受領後に html/admission/index.html の内容を移植する。
 *
 * @package salesian
 */

get_header(); ?>

<!-- =======================================
     MAIN: 入試について
     html/admission/index.html を参照して移植する
     ======================================= -->
<main id="main-admission">
    <?php get_template_part( 'template-parts/breadcrumb' ); ?>

    <?php if ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
    <?php endif; ?>
</main>
<!-- /MAIN -->

<?php get_footer();
