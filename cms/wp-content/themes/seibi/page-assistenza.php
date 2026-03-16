<?php
/**
 * アシステンツァ・異学年交流
 * URL: /feature/assistenza/
 *
 * @package salesian
 */

get_header(); ?>

<!-- =======================================
     MAIN: アシステンツァ・異学年交流
     html/feature/assistenza/index.html を参照して移植する
     ======================================= -->
<main id="main-assistenza">
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
