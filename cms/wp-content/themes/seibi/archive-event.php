<?php
/**
 * 公開行事 アーカイブ（一覧）テンプレート
 * URL: /admission/event/
 * カスタム投稿タイプ: event
 *
 * 静的HTML受領後に html/admission/event/index.html の内容を移植する。
 *
 * @package salesian
 */

get_header(); ?>

<!-- =======================================
     MAIN: 公開行事 一覧
     html/admission/event/index.html を参照して移植する
     ======================================= -->
<main id="main-event">
    <?php get_template_part( 'template-parts/breadcrumb' ); ?>

    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <?php get_template_part( 'template-parts/content' ); ?>
        <?php endwhile; ?>
    <?php endif; ?>
</main>
<!-- /MAIN -->

<?php get_footer();
