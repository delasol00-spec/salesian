<?php
/**
 * 学校説明会・公開行事 アーカイブ（一覧）テンプレート
 * URL: /admission/briefing/
 * カスタム投稿タイプ: briefing
 * カテゴリー（briefing-category）で学校説明会／学外説明会を出し分け
 *   学校説明会 → スラッグ: school-briefing
 *   学外説明会 → スラッグ: outside-briefing
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
      <h1>学校説明会･学外説明会</h1>
      <div class="inner-border"></div>
    </section>
  </main>
</div>

<section class="p-70-70">
  <div class="container">
    <div class="row justify-content-center">

      <?php
      // --- 学校説明会（briefing_type = school）---
      $school_query = new WP_Query( [
          'post_type'      => 'briefing',
          'posts_per_page' => -1,
          'orderby'        => 'menu_order',
          'order'          => 'ASC',
          'meta_query'     => [
              [
                  'key'     => 'briefing_type',
                  'value'   => 'school',
                  'compare' => '=',
              ],
          ],
      ] );
      ?>
      <div class="col-lg-8">
        <div class="sec-title-blue blue">学校説明会</div>
        <?php if ( $school_query->have_posts() ) : ?>
          <?php while ( $school_query->have_posts() ) : $school_query->the_post();
              $id = get_the_ID();
              $school_fields = [
                  'briefing_date'              => '日時',
                  'briefing_target'            => '対象',
                  'briefing_reception'         => '受付',
                  'briefing_session'           => '説明会',
                  'briefing_web_cancel_period' => 'WEB予約・キャンセル受付期間',
              ];
          ?>
          <div class="event-col-blue">
            <h3><?php the_title(); ?></h3>
            <div class="event-spec">
              <p>
              <?php foreach ( $school_fields as $key => $label ) :
                  if ( $key === 'briefing_date' ) :
                      $date_val = get_post_meta( $id, 'briefing_date', true );
                      $time_val = get_post_meta( $id, 'briefing_time', true );
                      $display  = trim( seibi_format_datetime( $date_val ) . ( $time_val ? '　' . $time_val : '' ) );
                      if ( $display !== '' ) : ?>
                <span><?php echo esc_html( $label ); ?>：</span><?php echo esc_html( $display ); ?><br />
                      <?php endif;
                      continue;
                  endif;
                  $val = get_post_meta( $id, $key, true );
                  if ( $val !== '' ) : ?>
                <span><?php echo esc_html( $label ); ?>：</span><?php echo esc_html( seibi_format_datetime( $val ) ); ?><br />
              <?php endif; endforeach; ?>
              </p>
              <?php
              $link_type = get_post_meta( $id, 'briefing_link_type', true ) ?: 'none';
              if ( $link_type === 'detail' ) : ?>
              <a class="btn-slide btn-m btn-pink" href="<?php echo esc_url( get_permalink() ); ?>"><span class="text">詳細・参加予約はこちらから<span class="material-symbols-outlined">open_in_new</span></span></a>
              <?php elseif ( $link_type === 'external' ) :
                  $btn_label = get_post_meta( $id, 'briefing_link_label', true );
                  $btn_url   = get_post_meta( $id, 'briefing_link_url', true );
                  if ( $btn_label && $btn_url ) : ?>
              <a class="btn-slide btn-m btn-pink" href="<?php echo esc_url( $btn_url ); ?>" target="_blank" rel="noopener noreferrer"><span class="text"><?php echo esc_html( $btn_label ); ?><span class="material-symbols-outlined">open_in_new</span></span></a>
              <?php endif; endif; ?>
            </div>
          </div>
          <?php endwhile; ?>
          <?php wp_reset_postdata(); ?>
        <?php else : ?>
          <div class="event-col-blue">
            <p>現在、学校説明会の情報はありません。</p>
          </div>
        <?php endif; ?>
      </div>

      <?php
      // --- 学外説明会（briefing_type = outside）---
      $outside_query = new WP_Query( [
          'post_type'      => 'briefing',
          'posts_per_page' => -1,
          'orderby'        => 'menu_order',
          'order'          => 'ASC',
          'meta_query'     => [
              [
                  'key'     => 'briefing_type',
                  'value'   => 'outside',
                  'compare' => '=',
              ],
          ],
      ] );
      ?>
      <div class="col-lg-8">
        <div class="sec-title-pink pink">学外説明会</div>
        <?php if ( $outside_query->have_posts() ) : ?>
          <?php while ( $outside_query->have_posts() ) : $outside_query->the_post();
              $id = get_the_ID();
              $outside_fields = [
                  'outside_date'        => '日時',
                  'outside_venue'       => '会場',
                  'outside_description' => false,
              ];
          ?>
          <div class="event-col-pink">
            <h3><?php the_title(); ?></h3>
            <div class="event-spec">
              <p>
              <?php foreach ( $outside_fields as $key => $label ) :
                  if ( $key === 'outside_date' ) :
                      $date_val = get_post_meta( $id, 'outside_date', true );
                      $time_val = get_post_meta( $id, 'outside_time', true );
                      $display  = trim( seibi_format_datetime( $date_val ) . ( $time_val ? '　' . $time_val : '' ) );
                      if ( $display !== '' ) : ?>
                <span><?php echo esc_html( $label ); ?>：</span><?php echo esc_html( $display ); ?><br />
                      <?php endif;
                      continue;
                  endif;
                  $val = get_post_meta( $id, $key, true );
                  if ( $val !== '' ) :
                      if ( $label ) : ?>
                <span><?php echo esc_html( $label ); ?>：</span><?php echo esc_html( seibi_format_datetime( $val ) ); ?><br />
              <?php else : ?>
                <?php echo esc_html( seibi_format_datetime( $val ) ); ?><br />
              <?php endif; endif; endforeach; ?>
              </p>
              <?php
              $link_type = get_post_meta( $id, 'outside_link_type', true ) ?: 'none';
              if ( $link_type === 'external' ) :
                  $btn_label = get_post_meta( $id, 'outside_link_label', true );
                  $btn_url   = get_post_meta( $id, 'outside_link_url', true );
                  if ( $btn_label && $btn_url ) : ?>
              <a class="btn-slide btn-m btn-pink" href="<?php echo esc_url( $btn_url ); ?>" target="_blank" rel="noopener noreferrer"><span class="text"><?php echo esc_html( $btn_label ); ?><span class="material-symbols-outlined">open_in_new</span></span></a>
              <?php endif; endif; ?>
            </div>
          </div>
          <?php endwhile; ?>
          <?php wp_reset_postdata(); ?>
        <?php else : ?>
          <div class="event-col-pink">
            <p>現在、学外説明会の情報はありません。</p>
          </div>
        <?php endif; ?>
      </div>

    </div>
  </div>
</section>

<?php get_footer();
