<?php
/**
 * 年間行事 アーカイブ（一覧）テンプレート
 * URL: /life/year/
 * カスタム投稿タイプ: year
 *
 * ギャラリー形式（写真のみ）。
 * 静的HTML受領後に html/life/year/index.html の内容を移植する。
 *
 * @package salesian
 */

get_header(); ?>

<!-- =======================================
     MAIN: 年間行事 一覧（ギャラリー形式）
     html/life/year/index.html を参照して移植する
     ======================================= -->
<main id="main-year">
    <?php get_template_part( 'template-parts/breadcrumb' ); ?>

    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <?php get_template_part( 'template-parts/content' ); ?>
        <?php endwhile; ?>
    <?php endif; ?>
</main>
<!-- /MAIN -->

<?php get_footer();
