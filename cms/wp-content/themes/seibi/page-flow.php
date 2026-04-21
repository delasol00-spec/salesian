<?php
/**
 * 入学までの流れ
 * URL: /admission/flow/
 *
 * @package seibi
 */

get_header(); ?>

<?php get_template_part( 'template-parts/page-hero', null, [ 'hero_img' => 'img/admission/admission-bg.webp' ] ); ?>

<section class="p-70-70">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="sec-title-blue blue">入学までの流れ</div>

        <div class="event-col-white">
          <h3 class="r-top-10">学校説明会</h3>
          <div class="event-spec">
            <p>４月から９月の３回実施される学校説明会にご参加ください。
              学校説明会では、入試に関する説明の他、サレジアン国際学園小学校の特徴や取り組みなどを紹介いたします。</p>
            <div class="btn-group d-flex justify-content-end w-100">
              <a href="<?php echo esc_url( home_url( '/admission/briefing/' ) ); ?>" class="btn-slide btn-mini btn-pink btn-right">学校説明会 <span class="material-symbols-outlined"> keyboard_double_arrow_right </span></a>
            </div>
          </div>
        </div>
        <div class="col-12 text-center">
          <span class="material-symbols-outlined after-flow-arrow" aria-hidden="true">arrow_circle_down</span>
        </div>

        <?php
        // 児童募集要項（requirementsページ）から表示中の各日程データをまとめて取得
        // $req_schedules = [ 'A日程' => [ 'app' => '...', 'int' => '...', 'exam' => '...', 'result' => '...' ], ... ]
        $req_pages = get_posts( [
            'name'        => 'requirements',
            'post_type'   => 'page',
            'post_status' => 'publish',
            'numberposts' => 1,
        ] );
        $req_schedules = [];
        if ( $req_pages ) {
            $req_id = $req_pages[0]->ID;
            foreach ( [ 'a', 'b', 'c' ] as $s ) {
                if ( '1' === get_post_meta( $req_id, "req_seibi_show_{$s}", true ) ) {
                    $req_schedules[ strtoupper( $s ) . '日程' ] = [
                        'app'    => get_post_meta( $req_id, "req_seibi_app_{$s}",    true ),
                        'int'    => get_post_meta( $req_id, "req_seibi_int_{$s}",    true ),
                        'exam'   => get_post_meta( $req_id, "req_seibi_exam_{$s}",   true ),
                        'result' => get_post_meta( $req_id, "req_seibi_result_{$s}", true ),
                    ];
                }
            }
        }
        ?>
        <div class="event-col-white">
          <h3 class="r-top-10">出願（Web出願）</h3>
          <div class="event-spec">
            <p>
              <?php foreach ( $req_schedules as $label => $d ) : if ( ! $d['app'] ) continue; ?>
                <strong><?php echo esc_html( $label ); ?>：</strong><?php echo esc_html( $d['app'] ); ?><br>
              <?php endforeach; ?>
              詳細は児童募集要項でご確認ください。
            </p>
            <div class="btn-group d-flex justify-content-end w-100">
              <a href="<?php echo esc_url( home_url( '/admission/requirements/' ) ); ?>" class="btn-slide btn-mini btn-pink btn-right">児童募集要項 <span class="material-symbols-outlined"> keyboard_double_arrow_right </span></a>
            </div>
          </div>
        </div>
        <div class="col-12 text-center">
          <span class="material-symbols-outlined after-flow-arrow" aria-hidden="true">arrow_circle_down</span>
        </div>

        <div class="event-col-white">
          <h3 class="r-top-10">選考</h3>
          <div class="event-spec">
            <p>面接＋ペーパーテスト＋社会性のテスト<br>
              選考は面接とペーパーテスト、社会性のテストの結果をもとに合否を判断いたします。</p>
            <p>
              <strong class="pink">面接期間</strong><br>
              <?php foreach ( $req_schedules as $label => $d ) : if ( ! $d['int'] ) continue; ?>
                <strong><?php echo esc_html( $label ); ?>：</strong><?php echo esc_html( $d['int'] ); ?><br>
              <?php endforeach; ?>
            </p>
            <p>
              <strong class="pink">入学試験</strong><br>
              <?php foreach ( $req_schedules as $label => $d ) : if ( ! $d['exam'] ) continue; ?>
                <strong><?php echo esc_html( $label ); ?>：</strong><?php echo esc_html( $d['exam'] ); ?><br>
              <?php endforeach; ?>
            </p>
            <div class="btn-group d-flex justify-content-end w-100">
              <a href="<?php echo esc_url( home_url( '/admission/requirements/' ) ); ?>" class="btn-slide btn-mini btn-pink btn-right">児童募集要項 <span class="material-symbols-outlined"> keyboard_double_arrow_right </span></a>
            </div>
          </div>
        </div>
        <div class="col-12 text-center">
          <span class="material-symbols-outlined after-flow-arrow" aria-hidden="true">arrow_circle_down</span>
        </div>

        <div class="event-col-white">
          <h3 class="r-top-10">合格発表（Web合格発表）</h3>
          <div class="event-spec">
            <p>
              <?php foreach ( $req_schedules as $label => $d ) : if ( ! $d['result'] ) continue; ?>
                <strong><?php echo esc_html( $label ); ?>：</strong><?php echo esc_html( $d['result'] ); ?><br>
              <?php endforeach; ?>
              試験日の翌日にWebにて発表いたします。
            </p>
          </div>
        </div>
        <div class="col-12 text-center">
          <span class="material-symbols-outlined after-flow-arrow" aria-hidden="true">arrow_circle_down</span>
        </div>

        <div class="event-col-white">
          <h3 class="r-top-10">入学手続</h3>
          <div class="event-spec">
            <p>合格された方は、入学金250,000円をWebにてお支払いいただきます。<br>
              入学手続き書類を郵送いたしますので案内をお読みいただいて、入学手続きを行ってください。</p>
            <div class="col-md-6 mx-auto mt-3 pb-3">
              <div class="d-flex border-bottom align-items-center pl-md-3">
                <div class="p-2 font-weight-bold" style="width: 40%">入学金</div>
                <div class="p-2 flex-grow-1" style="width: 60%">250,000円</div>
              </div>
            </div>
            <p class="small">
              手続きが行われない場合は、辞退とみなして合格は取り消しとなります。<br>
              一度提出された書類及び、納入された入学金については、理由の如何に関わらずご返還いたしませんので、予めご了承ください。
            </p>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<?php get_footer();
