<?php
/**
 * 災害・セキュリティ対策
 * URL: /about/security/
 *
 * @package salesian
 */

get_header(); ?>

<!-- =======================================
     MAIN: 災害・セキュリティ対策
     html/about/security/index.html を参照して移植する
     ======================================= -->
<main id="main-security">
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
