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
      <div class="col-12">
        <p class="text-center mb-5 text-m">
          <strong>以下の行事は<span class="pink">星美クラス</span>の公開行事です。</strong>
        </p>

        <?php
        $event_query = new WP_Query( [
            'post_type'      => 'event',
            'posts_per_page' => -1,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
        ] );

        if ( $event_query->have_posts() ) : ?>
        <div class="row">
          <?php while ( $event_query->have_posts() ) : $event_query->the_post();
            $event_date     = get_post_meta( get_the_ID(), 'event_date', true );
            $event_place    = get_post_meta( get_the_ID(), 'event_place', true );
            $event_target   = get_post_meta( get_the_ID(), 'event_target', true );
            $event_method   = get_post_meta( get_the_ID(), 'event_method', true );
            $event_period   = get_post_meta( get_the_ID(), 'event_period', true );
            $event_link_label = get_post_meta( get_the_ID(), 'event_link_label', true );
          ?>
          <div class="col-lg-6">
            <div class="event-box">
              <h2><?php the_title(); ?></h2>
              <?php if ( has_post_thumbnail() ) : ?>
              <img src="<?php the_post_thumbnail_url( 'large' ); ?>" alt="<?php the_title_attribute(); ?>" class="img-fluid" />
              <?php endif; ?>
              <dl class="event-detail">
                <?php if ( $event_date ) : ?>
                <dd>日時</dd>
                <dt><?php echo esc_html( $event_date ); ?></dt>
                <?php endif; ?>
                <?php if ( $event_place ) : ?>
                <dd>場所</dd>
                <dt><?php echo esc_html( $event_place ); ?></dt>
                <?php endif; ?>
                <?php if ( $event_target ) : ?>
                <dd>参加対象</dd>
                <dt><?php echo esc_html( $event_target ); ?></dt>
                <?php endif; ?>
                <?php if ( $event_method ) : ?>
                <dd>参加方法</dd>
                <dt><?php echo esc_html( $event_method ); ?></dt>
                <?php endif; ?>
                <?php if ( $event_period ) : ?>
                <dd>予約期間</dd>
                <dt><?php echo esc_html( $event_period ); ?></dt>
                <?php endif; ?>
              </dl>
              <?php if ( get_the_content() ) : ?>
              <div class="text-center mb-4">
                <a class="btn-slide btn-s btn-pink" href="<?php the_permalink(); ?>">
                  <span class="text"><?php echo $event_link_label ? esc_html( $event_link_label ) : '詳細・参加予約はこちらから'; ?><span class="material-symbols-outlined">open_in_new</span></span>
                </a>
              </div>
              <?php endif; ?>
            </div>
          </div>
          <?php endwhile; ?>
          <?php wp_reset_postdata(); ?>
        </div>
        <?php else : ?>
        <p class="text-center">現在、公開行事の予定はありません。</p>
        <?php endif; ?>

      </div>
    </div>
  </div>
</section>

<?php get_footer();
