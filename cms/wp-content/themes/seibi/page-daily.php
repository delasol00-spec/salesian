<?php
/**
 * 星美クラスの一日
 * URL: /life/daily/
 *
 * @package salesian
 */

get_header(); ?>

<!-- =======================================
     MAIN: 星美クラスの一日
     html/life/daily/index.html を参照して移植する
     ======================================= -->
<main id="main-daily">
    <?php get_template_part( 'template-parts/breadcrumb' ); ?>

    <?php if ( have_posts() ) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>">
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
        </article>
    <?php endif; ?>
</main>
<!-- /MAIN -->

<?php get_footer();
