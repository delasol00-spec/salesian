<?php
/**
 * フォールバックテンプレート
 * このファイルは直接使われることを想定していない。
 * 適切なテンプレートが存在しない場合のフォールバック。
 *
 * @package salesian
 */

get_header(); ?>

<main>
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>">
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
        </article>
    <?php endwhile; endif; ?>
</main>

<?php get_footer();
