<?php
/**
 * 学校説明会 詳細テンプレート
 * カスタム投稿タイプ: briefing
 *
 * @package seibi
 */

get_header(); ?>

<div class="container-fluid p-0">
  <main class="sub-page-view">
    <div class="sub-hero">
      <img src="<?php echo get_template_directory_uri(); ?>/img/briefing_title.svg" alt="" class="sub-hero-img" style="object-fit:contain; background:#f8f4f1;" />
    </div>
    <section class="page-title">
      <h1>学校説明会・公開行事</h1>
      <div class="inner-border"></div>
    </section>
  </main>
</div>

<section class="p-70-70">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <?php if ( have_posts() ) : the_post(); ?>
        <article>
          <h1><?php the_title(); ?></h1>
          <?php the_content(); ?>
        </article>

        <div class="mt-5 text-center">
          <a class="btn-slide btn-l btn-pink" href="<?php echo esc_url( get_post_type_archive_link( 'briefing' ) ); ?>">
            <span class="text">学校説明会・公開行事一覧へ戻る</span>
          </a>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<?php get_footer();
