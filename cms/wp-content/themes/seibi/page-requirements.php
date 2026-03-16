<?php
/**
 * 児童募集要項
 * URL: /admission/requirements/
 *
 * @package salesian
 */

get_header(); ?>

<!-- =======================================
     MAIN: 児童募集要項
     html/admission/requirements/index.html を参照して移植する
     ======================================= -->
<main id="main-requirements">
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
