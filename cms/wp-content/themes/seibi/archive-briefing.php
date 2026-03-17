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
      <h1>学校説明会・公開行事</h1>
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
                  'briefing_datetime'          => '日時',
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
                  $val = get_post_meta( $id, $key, true );
                  if ( $val !== '' ) : ?>
                <span><?php echo esc_html( $label ); ?>：</span><?php echo esc_html( $val ); ?><br />
              <?php endif; endforeach; ?>
              </p>
              <?php
              $btn_text = get_post_meta( $id, 'briefing_button_text', true );
              $btn_url  = get_post_meta( $id, 'briefing_button_url', true );
              if ( $btn_text && $btn_url ) : ?>
              <a class="btn-slide btn-m btn-pink" href="<?php echo esc_url( $btn_url ); ?>" target="_blank" rel="noopener noreferrer"><span class="text"><?php echo esc_html( $btn_text ); ?><span class="material-symbols-outlined">open_in_new</span></span></a>
              <?php endif; ?>
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
                  'outside_datetime'    => '日時',
                  'outside_venue'       => '会場',
                  'outside_time'        => '時間',
                  'outside_description' => false,
              ];
          ?>
          <div class="event-col-pink">
            <h3><?php the_title(); ?></h3>
            <div class="event-spec">
              <p>
              <?php foreach ( $outside_fields as $key => $label ) :
                  $val = get_post_meta( $id, $key, true );
                  if ( $val !== '' ) :
                      if ( $label ) : ?>
                <span><?php echo esc_html( $label ); ?>：</span><?php echo esc_html( $val ); ?><br />
              <?php else : ?>
                <?php echo esc_html( $val ); ?><br />
              <?php endif; endif; endforeach; ?>
              </p>
              <?php
              $btn_text = get_post_meta( $id, 'outside_button_text', true );
              $btn_url  = get_post_meta( $id, 'outside_button_url', true );
              if ( $btn_text && $btn_url ) : ?>
              <a class="btn-slide btn-m btn-pink" href="<?php echo esc_url( $btn_url ); ?>" target="_blank" rel="noopener noreferrer"><span class="text"><?php echo esc_html( $btn_text ); ?><span class="material-symbols-outlined">open_in_new</span></span></a>
              <?php endif; ?>
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
