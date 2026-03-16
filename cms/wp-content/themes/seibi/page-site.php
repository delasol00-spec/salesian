<?php
/**
 * このサイトについて
 * URL: /about/site/
 *
 * @package salesian
 */

get_header(); ?>

<!-- =======================================
     MAIN: このサイトについて
     html/about/site/index.html を参照して移植する
     ======================================= -->
<main id="main-site">
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
