<?php
/**
 * 公開行事 アーカイブ（一覧）テンプレート
 * URL: /admission/event/
 * カスタム投稿タイプ: event
 *
 * @package seibi
 */

get_header(); ?>

<div class="container-fluid p-0">
  <main class="sub-page-view">
    <div class="sub-hero">
      <img src="<?php echo get_template_directory_uri(); ?>/img/admission/admission-bg.webp" alt="" class="sub-hero-img" />
    </div>
    <section class="page-title">
      <h1>公開行事</h1>
      <div class="inner-border"></div>
    </section>
  </main>
</div>

<section class="p-70-70">
  <div class="container">
    <div class="row justify-content-center">
      <?php
      $event_query = new WP_Query( [
          'post_type'      => 'event',
          'posts_per_page' => -1,
          'orderby'        => 'date',
          'order'          => 'ASC',
      ] );

      if ( $event_query->have_posts() ) : ?>
      <div class="col-lg-8">
        <div class="sec-title-pink pink">公開行事</div>
        <?php while ( $event_query->have_posts() ) : $event_query->the_post(); ?>
        <div class="event-col-pink">
          <h3><?php the_title(); ?></h3>
          <div class="event-spec">
            <?php the_content(); ?>
          </div>
        </div>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
      </div>
      <?php else : ?>
      <div class="col-lg-8">
        <div class="sec-title-pink pink">公開行事</div>
        <div class="event-col-pink">
          <p>現在、公開行事の予定はありません。</p>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php get_footer();
