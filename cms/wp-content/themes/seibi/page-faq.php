<?php
/**
 * よくある質問
 * URL: /about/faq/
 *
 * @package salesian
 */

get_header(); ?>

<!-- =======================================
     MAIN: よくある質問
     html/about/faq/index.html を参照して移植する
     ======================================= -->
<main id="main-faq">
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
