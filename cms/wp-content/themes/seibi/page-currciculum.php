<?php
/**
 * 教科教育
 * URL: /feature/currciculum/
 *
 * @package salesian
 */

get_header(); ?>

<!-- =======================================
     MAIN: 教科教育
     html/feature/currciculum/index.html を参照して移植する
     ======================================= -->
<main id="main-currciculum">
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
