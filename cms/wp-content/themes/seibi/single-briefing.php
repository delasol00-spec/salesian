<?php
/**
 * 学校説明会 詳細テンプレート
 * カスタム投稿タイプ: briefing
 *
 * @package seibi
 */

get_header();

if ( have_posts() ) :
    the_post();
    $id = get_the_ID();

    $detail_fields = [
        'briefing_date'              => '日時',
        'briefing_venue'             => '場所',
        'briefing_reception'         => '受付',
        'briefing_session'           => '説明会',
        'briefing_target'            => '対象',
        'briefing_method'            => '参加方法',
        'briefing_web_cancel_period' => '予約期間',
        'briefing_notes'             => '注意事項',
    ];

    $capacity_note = get_post_meta( $id, 'briefing_capacity_note', true );
endif;
?>

<div class="container-fluid p-0">
  <main class="sub-page-view">
    <div class="sub-hero">
      <img src="<?php echo get_template_directory_uri(); ?>/img/event-img/gakkou.webp" alt="" class="sub-hero-img" />
    </div>
    <section class="page-title">
      <h1><?php the_title(); ?></h1>
      <div class="inner-border"></div>
    </section>
  </main>
</div>

<section class="p-70-70">
  <div class="container">
    <div class="row justify-content-center">

      <div class="col-lg-8">
        <div class="event-detail-box">
          <h3 class="mb-3"><?php the_title(); ?></h3>
          <dl class="event-detail">
            <?php foreach ( $detail_fields as $key => $label ) :
                if ( $key === 'briefing_date' ) :
                    $date_val = get_post_meta( $id, 'briefing_date', true );
                    $time_val = get_post_meta( $id, 'briefing_time', true );
                    $display  = trim( seibi_format_datetime( $date_val ) . ( $time_val ? '　' . $time_val : '' ) );
                    if ( $display !== '' ) : ?>
              <dd><?php echo esc_html( $label ); ?></dd>
              <dt><?php echo nl2br( esc_html( $display ) ); ?></dt>
                    <?php endif;
                    continue;
                endif;
                $val = get_post_meta( $id, $key, true );
                if ( $val !== '' ) : ?>
              <dd><?php echo esc_html( $label ); ?></dd>
              <dt><?php echo nl2br( esc_html( seibi_format_datetime( $val ) ) ); ?></dt>
            <?php endif; endforeach; ?>
          </dl>

          <?php if ( $capacity_note ) : ?>
          <?php echo wp_kses_post( wpautop( $capacity_note ) ); ?>
          <?php endif; ?>
          <div class="text-center">
            <p class="pink"><small>定員に達し次第、受付を終了させていただきますので、あらかじめご了承ください。</small></p>
            <a class="btn-slide btn-m btn-pink" href="https://mirai-compass.net/usr/seibie/event/evtIndex.jsf" target="_blank" rel="noopener noreferrer">
              <span class="text">参加予約･キャンセルはこちらから<span class="material-symbols-outlined">open_in_new</span></span>
            </a>
          </div>
        </div>
      </div>

      <div class="col-lg-8">
        <div class="event-detail-box">
          <h3>ご来校されるみなさまへ</h3>
          <p>
            ● 本校へのお車でのご来校はお控えください。<br>
            ● また、自転車でのご来校もお控えください。
          </p>
          <img src="<?php echo get_template_directory_uri(); ?>/img/event-img/annaizu.png" class="img-fluid" alt="案内図">
          <p class="mb-0">
            <strong>お問い合わせ：TEL 03-3906-0053</strong><br />
            受付時間月〜金：9:00〜16:30／土：9:00〜14:00<br>
            （※日曜・祝日を除く。土曜日は児童登校日のみ受付。）
          </p>
        </div>
      </div>

    </div>

    <div class="mt-5 text-center">
      <a class="btn-slide btn-l btn-pink" href="<?php echo esc_url( get_post_type_archive_link( 'briefing' ) ); ?>">
        <span class="text">学校説明会・公開行事一覧へ戻る</span>
      </a>
    </div>

  </div>
</section>

<?php get_footer();
