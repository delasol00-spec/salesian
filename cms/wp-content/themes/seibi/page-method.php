<?php
/**
 * 建学の精神・教育理念
 * URL: /about/method/
 *
 * @package salesian
 */

get_header(); ?>

<!-- =======================================
     MAIN: 建学の精神・教育理念
     html/about/method/index.html を参照して移植する
     ======================================= -->
<main id="main-method">
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
