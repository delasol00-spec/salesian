<?php
/**
 * 卒業後の進路
 * URL: /feature/career/
 *
 * @package salesian
 */

get_header(); ?>

<!-- =======================================
     MAIN: 卒業後の進路
     html/feature/career/index.html を参照して移植する
     ======================================= -->
<main id="main-career">
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
