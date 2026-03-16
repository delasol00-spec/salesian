<?php
/**
 * 学校説明会・公開行事 アーカイブ（一覧）テンプレート
 * URL: /admission/briefing/
 * カスタム投稿タイプ: briefing
 *
 * 静的HTML受領後に html/admission/briefing/index.html の内容を移植する。
 *
 * @package salesian
 */

get_header(); ?>

<!-- =======================================
     MAIN: 学校説明会・公開行事 一覧
     html/admission/briefing/index.html を参照して移植する
     ======================================= -->
<main id="main-briefing">
    <?php get_template_part( 'template-parts/breadcrumb' ); ?>

    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <?php get_template_part( 'template-parts/content' ); ?>
        <?php endwhile; ?>
    <?php endif; ?>
</main>
<!-- /MAIN -->

<?php get_footer();
