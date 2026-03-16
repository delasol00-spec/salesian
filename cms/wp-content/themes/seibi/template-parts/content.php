<?php
/**
 * 投稿コンテンツパーツ
 * ループ内で get_template_part( 'template-parts/content' ) として呼び出す。
 *
 * @package salesian
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
    </header>

    <div class="entry-content">
        <?php the_content(); ?>
    </div>
</article>
