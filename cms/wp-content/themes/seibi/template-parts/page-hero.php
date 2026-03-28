<?php
/**
 * サブページ共通ヒーロー
 *
 * @package seibi
 * @param array $args {
 *   @type string $hero_img ヒーロー画像パス（テーマディレクトリからの相対パス、例: img/about/about-bg.webp）
 *   @type string $hero_alt ヒーロー画像の alt 属性（省略可、デフォルト空文字）
 * }
 */

$hero_img = $args['hero_img'] ?? '';
$hero_alt = $args['hero_alt'] ?? '';
?>
<div class="container-fluid p-0">
  <main class="sub-page-view">
    <div class="sub-hero">
      <img src="<?php echo esc_url( get_template_directory_uri() . '/' . $hero_img ); ?>" alt="<?php echo esc_attr( $hero_alt ); ?>" class="sub-hero-img" />
    </div>
    <section class="page-title">
      <h1><?php the_title(); ?></h1>
      <div class="inner-border"></div>
    </section>
  </main>
</div>
