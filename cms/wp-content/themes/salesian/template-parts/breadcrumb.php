<?php
/**
 * パンくずリスト
 *
 * 静的HTML受領後にデザインに合わせて更新する。
 * プラグイン（Yoast SEO 等）を使う場合はそちらに差し替える。
 *
 * @package salesian
 */

// ルートページ（トップ）では表示しない
if ( is_front_page() ) {
    return;
}
?>

<nav class="breadcrumb" aria-label="パンくずリスト">
    <ol>
        <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">ホーム</a></li>

        <?php
        // 親ページがある場合は親ページのリンクを出力する
        $post    = get_post();
        $ancestors = array_reverse( get_post_ancestors( $post ) );
        foreach ( $ancestors as $ancestor_id ) :
        ?>
            <li>
                <a href="<?php echo esc_url( get_permalink( $ancestor_id ) ); ?>">
                    <?php echo esc_html( get_the_title( $ancestor_id ) ); ?>
                </a>
            </li>
        <?php endforeach; ?>

        <li aria-current="page"><?php the_title(); ?></li>
    </ol>
</nav>
