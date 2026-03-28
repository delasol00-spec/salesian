<?php
/**
 * パンフレットダウンロード
 * URL: /about/download/
 *
 * @package seibi
 */

get_header(); ?>

<?php get_template_part( 'template-parts/page-hero', null, [ 'hero_img' => 'img/about/about-bg.webp' ] ); ?>

<section class="p-70-70">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 col-12 mb-3 text-center">
        <img src="<?php echo get_template_directory_uri(); ?>/img/about/download-img/panph.webp" class="img-fluid mb-2" loading="lazy" alt="サレジアン国際学園小学校整備クラスパンフレット" />
        <p>サレジアン国際学園小学校 パンフレット（PDFファイル4.7MB）</p>
      </div>
      <div class="col-12 mb-lg-5 text-center">
        <a class="btn-slide btn-m btn-pink mb-3" href="<?php echo get_template_directory_uri(); ?>/img/about/download-img/panph2027.pdf" target="_blank">
          <span class="text">パンフレットをダウンロードする<span class="material-symbols-outlined">open_in_new</span></span>
        </a><br />
        <small>リンクをクリックするとお使いのブラウザにカタログが表示されます。<br />
          パンフレットを保存するにはお使いのブラウザから保存してください。</small>
      </div>
    </div>
  </div>
</section>

<?php get_footer();
