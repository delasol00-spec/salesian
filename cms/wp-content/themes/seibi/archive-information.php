<?php
/**
 * お知らせ（NEWS & TOPICS）アーカイブ（一覧）テンプレート
 * URL: /information/
 * カスタム投稿タイプ: information
 *
 * 静的HTML受領後に html/information/index.html の内容を移植する。
 * カテゴリーあり。
 *
 * @package salesian
 */

get_header(); ?>

<!-- =======================================
     MAIN: お知らせ（NEWS & TOPICS）一覧
     html/information/index.html を参照して移植する
     ======================================= -->
<main id="main-information">
    <?php get_template_part( 'template-parts/breadcrumb' ); ?>

    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <?php get_template_part( 'template-parts/content' ); ?>
        <?php endwhile; ?>
    <?php endif; ?>
</main>
<!-- /MAIN -->

<?php get_footer();
