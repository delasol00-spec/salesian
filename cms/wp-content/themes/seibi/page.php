<?php
/**
 * 固定ページ 汎用テンプレート
 * 個別テンプレート（page-{slug}.php）がない場合に使用される。
 *
 * 静的HTML受領後に各ページの内容を移植する。
 *
 * @package salesian
 */

get_header(); ?>

<!-- =======================================
     MAIN: 固定ページ（汎用）
     ======================================= -->
<main id="main-page">
    <?php if ( have_posts() ) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>">
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
        </article>
    <?php endif; ?>
</main>
<!-- /MAIN -->

<?php get_footer();
