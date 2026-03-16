<?php
/**
 * 特別音楽クラブ
 * URL: /life/music-club/
 *
 * @package salesian
 */

get_header(); ?>

<!-- =======================================
     MAIN: 特別音楽クラブ
     html/life/music-club/index.html を参照して移植する
     ======================================= -->
<main id="main-music-club">
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
