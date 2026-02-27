<?php
/**
 * 404 エラーページ
 *
 * @package salesian
 */

get_header(); ?>

<main id="main-404">
    <h1>404 - ページが見つかりません</h1>
    <p>お探しのページは存在しないか、移動した可能性があります。</p>
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">トップページへ戻る</a>
</main>

<?php get_footer();
