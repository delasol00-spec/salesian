<?php
/**
 * 家庭との連携・協力
 * URL: /life/cooperation/
 *
 * @package salesian
 */

get_header(); ?>

<!-- =======================================
     MAIN: 家庭との連携・協力
     html/life/cooperation/index.html を参照して移植する
     ======================================= -->
<main id="main-cooperation">
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
