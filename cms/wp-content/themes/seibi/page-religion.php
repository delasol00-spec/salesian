<?php
/**
 * 宗教教育
 * URL: /feature/religion/
 *
 * @package salesian
 */

get_header(); ?>

<!-- =======================================
     MAIN: 宗教教育
     html/feature/religion/index.html を参照して移植する
     ======================================= -->
<main id="main-religion">
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
