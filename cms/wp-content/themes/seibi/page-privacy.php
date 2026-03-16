<?php
/**
 * 個人情報保護方針
 * URL: /about/privacy/
 *
 * @package salesian
 */

get_header(); ?>

<!-- =======================================
     MAIN: 個人情報保護方針
     html/about/privacy/index.html を参照して移植する
     ======================================= -->
<main id="main-privacy">
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
