<?php
/**
 * 404 エラーページ
 *
 * @package salesian
 */

get_header(); ?>

<div class="container-fluid p-0">
  <main class="sub-page-view">
    <div class="sub-hero">
      <picture>
        <source media="(max-width: 991px)" srcset="<?php echo get_template_directory_uri(); ?>/img/404-sp.webp" />
        <img src="<?php echo get_template_directory_uri(); ?>/img/404.webp" alt="" class="sub-hero-img" />
      </picture>
    </div>

    <section class="page-title">
      <h1>ページが見つかりませんでした</h1>
      <div class="inner-border"></div>
    </section>
  </main>
</div>

<section class="page404">
  <p>申し訳ありません、お探しのページが見つかりませんでした。<br>
  メニューを開いてページをお探しいただくか、<br>
  下のページ一覧でご希望のページをお探しください。</p>
</section>

<?php get_footer();
