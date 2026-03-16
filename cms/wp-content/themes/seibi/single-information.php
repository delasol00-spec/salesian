<?php
/**
 * お知らせ 詳細テンプレート
 * カスタム投稿タイプ: information
 *
 * 静的HTML受領後に詳細ページのデザインを移植する。
 *
 * @package salesian
 */

get_header(); ?>

<main id="main-information-single">
    <?php get_template_part( 'template-parts/breadcrumb' ); ?>

    <?php if ( have_posts() ) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>">
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
        </article>
    <?php endif; ?>
</main>

<?php get_footer();
