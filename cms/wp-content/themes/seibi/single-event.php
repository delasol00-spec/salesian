<?php
/**
 * 公開行事 詳細テンプレート
 * カスタム投稿タイプ: event
 *
 * @package seibi
 */

get_header();

if ( have_posts() ) :
    the_post();
    $id = get_the_ID();

    $detail_fields = [
        'event_date'   => '日時',
        'event_place'  => '場所',
        'event_target' => '参加対象',
        'event_method' => '参加方法',
        'event_period' => '予約期間',
    ];

    $capacity_note = get_post_meta( $id, 'event_capacity_note', true );
    $thumbnail_url = get_the_post_thumbnail_url( $id, 'full' );
endif;
?>

<div class="container-fluid p-0">
  <main class="sub-page-view">
    <div class="sub-hero">
      <?php if ( $thumbnail_url ) : ?>
      <img src="<?php echo esc_url( $thumbnail_url ); ?>" alt="" class="sub-hero-img" />
      <?php else : ?>
      <img src="<?php echo get_template_directory_uri(); ?>/img/admission/admission-bg.webp" alt="" class="sub-hero-img" />
      <?php endif; ?>
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
                $val = get_post_meta( $id, $key, true );
                if ( $val !== '' ) : ?>
              <dd><?php echo esc_html( $label ); ?></dd>
              <dt><?php echo nl2br( esc_html( $val ) ); ?></dt>
            <?php endif; endforeach; ?>
          </dl>

          <?php the_content(); ?>

          <?php if ( $capacity_note ) : ?>
          <?php echo wp_kses_post( wpautop( $capacity_note ) ); ?>
          <?php endif; ?>
          <div class="text-center">
            <p class="pink"><small>定員に達し次第、受付を終了させていただきますので、あらかじめご了承ください。</small></p>
            <a class="btn-slide btn-s btn-pink" href="https://mirai-compass.net/usr/seibie/event/evtIndex.jsf" target="_blank" rel="noopener noreferrer">
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
      <a class="btn-slide btn-l btn-pink" href="<?php echo esc_url( get_post_type_archive_link( 'event' ) ); ?>">
        <span class="text">公開行事一覧へ戻る</span>
      </a>
    </div>

  </div>
</section>

<?php get_footer();
