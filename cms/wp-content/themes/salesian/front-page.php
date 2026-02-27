<?php
/**
 * トップページテンプレート
 * URL: /
 *
 * 静的HTML受領後に html/index.html の内容を移植する。
 *
 * @package salesian
 */

get_header(); ?>

<!-- =======================================
     MAIN: トップページ
     html/index.html を参照して移植する
     ======================================= -->
<main id="main-top">
    <?php if ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
    <?php endif; ?>
</main>
<!-- /MAIN -->

<?php get_footer();
