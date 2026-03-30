<?php
/**
 * 児童募集要項
 * URL: /admission/requirements/
 *
 * カスタムフィールド一覧:
 *   req_fiscal_year          : 年度表示
 *   req_seibi_count          : 星美 募集人数（全日程共通）
 *   req_seibi_app_a/b/c      : 星美 出願期間 A/B/C日程
 *   req_seibi_int_a/b/c      : 星美 面接期間 A/B/C日程
 *   req_seibi_exam_a/b/c     : 星美 入学試験 A/B/C日程
 *   req_seibi_result_a/b/c   : 星美 合格発表 A/B/C日程
 *   req_seibi_exam_fee       : 星美 受験料（全日程共通）
 *   req_seibi_entry_fee      : 星美 入学金（全日程共通）
 *   req_seibi_pdf_text       : 星美 募集要項ボタンテキスト
 *   req_seibi_pdf_url        : 星美 募集要項 PDF URL
 *   req_seibi_selection      : 星美 選考内容の概要（textarea）
 *   req_seibi_interview      : 星美 面接の説明（textarea）
 *   req_seibi_belongings     : 星美 持ち物・服装（textarea）
 *   req_seibi_enroll_note    : 星美 入学手続と納付金 注記（textarea）
 *   req_seibi_tuition        : 星美 授業料（年額）
 *   req_seibi_edu_fee        : 星美 教育充実費（年額）
 *   req_seibi_facility_fee   : 星美 施設設備費（年額）
 *   req_seibi_pta_fee        : 星美 父母の会入会金
 *   req_seibi_misc_fee       : 星美 諸経費（年額）
 *   req_seibi_tuition_note   : 星美 学費その他経費・注記（textarea）
 *   req_inter_detail_url     : インターナショナルクラス 詳細ページURL
 *   req_returnee_detail_url  : 帰国生入試 詳細ページURL
 *
 * @package seibi
 */

get_header();

$id = get_the_ID();

// ── カスタムフィールド読み込み ───────────────────────────────────────
$fiscal_year = get_post_meta( $id, 'req_fiscal_year', true );

// 星美クラス 日程別
$schedules = [
    'A' => [
        'show'      => get_post_meta( $id, 'req_seibi_show_a',      true ),
        'count'     => get_post_meta( $id, 'req_seibi_count_a',     true ),
        'app'       => get_post_meta( $id, 'req_seibi_app_a',       true ),
        'int'       => get_post_meta( $id, 'req_seibi_int_a',       true ),
        'exam'      => get_post_meta( $id, 'req_seibi_exam_a',      true ),
        'result'    => get_post_meta( $id, 'req_seibi_result_a',    true ),
        'exam_fee'  => get_post_meta( $id, 'req_seibi_exam_fee_a',  true ),
        'entry_fee' => get_post_meta( $id, 'req_seibi_entry_fee_a', true ),
        'pdf_id'    => (int) get_post_meta( $id, 'req_seibi_pdf_id_a', true ),
    ],
    'B' => [
        'show'      => get_post_meta( $id, 'req_seibi_show_b',      true ),
        'count'     => get_post_meta( $id, 'req_seibi_count_b',     true ),
        'app'       => get_post_meta( $id, 'req_seibi_app_b',       true ),
        'int'       => get_post_meta( $id, 'req_seibi_int_b',       true ),
        'exam'      => get_post_meta( $id, 'req_seibi_exam_b',      true ),
        'result'    => get_post_meta( $id, 'req_seibi_result_b',    true ),
        'exam_fee'  => get_post_meta( $id, 'req_seibi_exam_fee_b',  true ),
        'entry_fee' => get_post_meta( $id, 'req_seibi_entry_fee_b', true ),
        'pdf_id'    => (int) get_post_meta( $id, 'req_seibi_pdf_id_b', true ),
    ],
    'C' => [
        'show'      => get_post_meta( $id, 'req_seibi_show_c',      true ),
        'count'     => get_post_meta( $id, 'req_seibi_count_c',     true ),
        'app'       => get_post_meta( $id, 'req_seibi_app_c',       true ),
        'int'       => get_post_meta( $id, 'req_seibi_int_c',       true ),
        'exam'      => get_post_meta( $id, 'req_seibi_exam_c',      true ),
        'result'    => get_post_meta( $id, 'req_seibi_result_c',    true ),
        'exam_fee'  => get_post_meta( $id, 'req_seibi_exam_fee_c',  true ),
        'entry_fee' => get_post_meta( $id, 'req_seibi_entry_fee_c', true ),
        'pdf_id'    => (int) get_post_meta( $id, 'req_seibi_pdf_id_c', true ),
    ],
];

?>

<?php get_template_part( 'template-parts/page-hero', null, [ 'hero_img' => 'img/admission/admission-bg.webp' ] ); ?>

<section class="p-70-70">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">

        <?php if ( $fiscal_year ) : ?>
        <div class="sec-title-blue blue"><?php echo esc_html( $fiscal_year ); ?></div>
        <?php endif; ?>

        <!-- ▼ 星美クラス A/B/C日程 テーブル（縦積み） -->
        <?php
        $schedule_labels = array_keys( $schedules );
        $last_label      = end( $schedule_labels );
        foreach ( $schedules as $label => $s ) :
            if ( '1' !== $s['show'] ) continue;
            $mb_class = ( $label === $last_label ) ? 'mb-5' : 'mb-3';
        ?>
        <div class="table <?php echo esc_attr( $mb_class ); ?>">
          <table class="table table-bordered table-striped admission">
            <tr>
              <th colspan="2" class="bg-pink text-white">星美クラス <?php echo esc_html( $label ); ?>日程</th>
            </tr>
            <tr>
              <th>募集人数</th>
              <td><?php echo esc_html( $s['count'] ); ?></td>
            </tr>
            <tr>
              <th>出願期間（Web出願）</th>
              <td><?php echo esc_html( $s['app'] ); ?></td>
            </tr>
            <tr>
              <th>面接期間</th>
              <td><?php echo esc_html( $s['int'] ); ?></td>
            </tr>
            <tr>
              <th>入学試験</th>
              <td><?php echo esc_html( $s['exam'] ); ?></td>
            </tr>
            <tr>
              <th>合格発表（Web発表）</th>
              <td><?php echo esc_html( $s['result'] ); ?></td>
            </tr>
            <tr>
              <th>出願費用</th>
              <td>受験料　<?php echo esc_html( $s['exam_fee'] ); ?></td>
            </tr>
            <tr>
              <th>入学手続き</th>
              <td>入学金　<?php echo esc_html( $s['entry_fee'] ); ?></td>
            </tr>
            <?php if ( $s['pdf_id'] ) :
                $pdf_url  = wp_get_attachment_url( $s['pdf_id'] );
                $pdf_file = get_attached_file( $s['pdf_id'] );
                $pdf_size = '';
                if ( $pdf_file && file_exists( $pdf_file ) ) {
                    $pdf_size = number_format( filesize( $pdf_file ) / 1048576, 1 ) . 'MB';
                }
            ?>
            <tr>
              <th>児童募集要項</th>
              <td>
                <a href="<?php echo esc_url( $pdf_url ); ?>" class="btn-slide-r btn-ss btn-pink-r" target="_blank" rel="noopener noreferrer">
                  こちらからダウンロードいただけます<?php echo $pdf_size ? ' (PDF ' . esc_html( $pdf_size ) . ')' : ''; ?><span class="material-symbols-outlined">open_in_new</span>
                </a>
              </td>
            </tr>
            <?php endif; ?>
          </table>
        </div>
        <?php endforeach; ?>

        <!-- ▼ 選考内容 -->
        <div class="event-col-white">
          <h3><strong>【星美クラス】</strong> 選考内容</h3>
          <div class="event-spec">
            <p>選考は面接とペーパーテスト、社会性のテストの結果をもとに合否を判断いたします。</p>
            <p class="sub-title">面接</p>
            <p class="pl-3 mb-3">
              面接時間：<strong>15分程度</strong>　(面接は保護者同伴の親子面接)<br />
              次の事がわかるような質問をさせていただいております。<br />
              ・家庭と学校との連携<br />
              ・保護者の協力体制<br />
              ・ご家庭でのお子様の教育についての考え方など<br />
              お子様には、自分の言葉で表現できるように、毎日の会話を大切にされてください。
            </p>
            <p class="sub-title">ペーパーテスト</p>
            <p class="pl-3">
              <strong>知能・言語と２つの領域でテストを実施予定</strong><br />
              こんな力をつけましょう。
            </p>
            <div class="col-md-10 mx-auto mt-3 mb-3">
              <div class="d-flex border-bottom align-items-center pl-md-3">
                <div class="p-2 font-weight-bold" style="width: 40%">よく見る力</div>
                <div class="p-2 flex-grow-1" style="width: 60%">物事をじっくり観察させましょう。</div>
              </div>
              <div class="d-flex border-bottom align-items-center pl-md-3">
                <div class="p-2 font-weight-bold" style="width: 40%">しっかり聞く力</div>
                <div class="p-2 flex-grow-1" style="width: 60%">話を最後まで聞かせましょう。</div>
              </div>
              <div class="d-flex border-bottom align-items-center pl-md-3">
                <div class="p-2 font-weight-bold" style="width: 40%">よく考える力</div>
                <div class="p-2 flex-grow-1" style="width: 60%">「なぜ」の疑問を大切にしましょう。</div>
              </div>
              <div class="d-flex border-bottom align-items-center pl-md-3">
                <div class="p-2 font-weight-bold" style="width: 40%">分かりやすく話す力</div>
                <div class="p-2 flex-grow-1" style="width: 60%">相手に伝わるように表現させましょう。</div>
              </div>
              <div class="d-flex border-bottom align-items-center pl-md-3">
                <div class="p-2 font-weight-bold" style="width: 40%">集中して物事に取り組む力</div>
                <div class="p-2 flex-grow-1" style="width: 60%">途中で投げ出さず、最後まで取り組ませましょう。興味を持ったことを大切にしましょう。</div>
              </div>
            </div>
            <p class="sub-title">社会性のテスト</p>
            <p class="pl-3">
              <strong>集団の中で関わる力があるかどうかを見ます。</strong><br />
              日頃の生活から、こんなことを意識するといいでしょう。
            </p>
            <div class="col-md-10 mx-auto mt-3 pb-3">
              <div class="d-flex border-bottom align-items-center pl-md-3">
                <div class="p-2 font-weight-bold" style="width: 15%">挨拶</div>
                <div class="p-2 flex-grow-1" style="width: 85%">明るく元気よく挨拶をする。</div>
              </div>
              <div class="d-flex border-bottom align-items-center pl-md-3">
                <div class="p-2 font-weight-bold" style="width: 15%">返事</div>
                <div class="p-2 flex-grow-1" style="width: 85%">呼ばれたら、すぐに「はい」と返事をする。</div>
              </div>
              <div class="d-flex border-bottom align-items-center pl-md-3">
                <div class="p-2 font-weight-bold" style="width: 15%">関わり</div>
                <div class="p-2 flex-grow-1" style="width: 85%">誰とでも仲良く遊べる／ 目を見て、話が聞ける／ 言われたことができる</div>
              </div>
            </div>
          </div>
        </div>

        <!-- ▼ 持ち物・服装 -->
        <div class="event-col-white">
          <h3><strong>【星美クラス】</strong>持ち物／服装について</h3>
          <div class="event-spec">
            <p>
              鉛筆3本、体育着、上履き（保護者の方もお持ちください）<br />
              のり（スティックタイプ）、はさみ、クレヨン（12~16色）、水筒：任意（お茶かお水）
            </p>
          </div>
        </div>

        <!-- ▼ 入学手続と納付金 -->
        <div class="event-col-white">
          <h3><strong>【星美クラス】</strong>入学手続と納付金</h3>
          <div class="event-spec">
            <p>所定日時に手続を完了しない場合は、合格は取消となります。</p>
            <div class="col-md-6 mx-auto mt-3 pb-3">
              <div class="d-flex border-bottom align-items-center pl-md-3">
                <div class="p-2 font-weight-bold" style="width: 40%">入学金</div>
                <div class="p-2 flex-grow-1" style="width: 60%">250,000円</div>
              </div>
            </div>
            <p class="small">
              ※一旦納入した入学金は、返金はいたしません。<br />
              ※納付金は変更する場合がございます。予めご了承ください。
            </p>
          </div>
        </div>

        <!-- ▼ 学費・その他 -->
        <div class="event-col-white">
          <h3><strong>【星美クラス】</strong>学費・その他</h3>
          <div class="event-spec">
            <div class="col-md-6 mx-auto mt-3 pb-3">
              <div class="d-flex border-bottom align-items-center pl-md-3">
                <div class="p-2 font-weight-bold" style="width: 60%"></div>
                <div class="p-2 flex-grow-1 text-right" style="width: 40%"><small>年額</small></div>
              </div>
              <div class="d-flex border-bottom align-items-center pl-md-3">
                <div class="p-2 font-weight-bold" style="width: 60%">１. 授業料</div>
                <div class="p-2 flex-grow-1 text-right" style="width: 40%">420,000円</div>
              </div>
              <div class="d-flex border-bottom align-items-center pl-md-3">
                <div class="p-2 font-weight-bold" style="width: 60%">２. 教育充実費</div>
                <div class="p-2 flex-grow-1 text-right" style="width: 40%">96,000円</div>
              </div>
              <div class="d-flex border-bottom align-items-center pl-md-3">
                <div class="p-2 font-weight-bold" style="width: 60%">３. 施設設備費</div>
                <div class="p-2 flex-grow-1 text-right" style="width: 40%">80,000円</div>
              </div>
              <div class="d-flex border-bottom align-items-center pl-md-3">
                <div class="p-2 font-weight-bold" style="width: 60%">４. 父母の会入会金</div>
                <div class="p-2 flex-grow-1 text-right" style="width: 40%">5,000円</div>
              </div>
              <div class="d-flex border-bottom align-items-center pl-md-3">
                <div class="p-2 font-weight-bold" style="width: 60%">５. 諸経費</div>
                <div class="p-2 flex-grow-1 text-right" style="width: 40%">44,000円</div>
              </div>
            </div>
            <p>
              その他副教材、iPad積立金、給食費、牛乳費等の年間の経費が必要となります。<br />
              <small>※学費・その他は変更する場合がございます。予めご了承ください。</small>
            </p>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<!-- ================================================================ -->
<!-- インターナショナルクラス・帰国生入試 -->
<!-- ================================================================ -->
<section class="p-70-70" id="inter">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">

        <div class="event-col-white inter-title">
          <h3><strong>【インターナショナルクラス】</strong>選考内容他</h3>
          <div class="event-spec">
            <p>
              <a href="https://www.el.seibi.ac.jp/international/enrolment/application_guidelines/" target="_blank" rel="noopener noreferrer">詳細はインターナショナルクラスHPでご確認ください。<span class="material-symbols-outlined">open_in_new</span></a>
            </p>
          </div>
        </div>

        <div class="event-col-white inter-title">
          <h3><strong>【帰国生入試】</strong>選考内容他</h3>
          <div class="event-spec">
            <p>
              <a href="https://www.el.seibi.ac.jp/international/enrolment/application_guidelines/" target="_blank" rel="noopener noreferrer">詳細はインターナショナルクラスHPでご確認ください。<span class="material-symbols-outlined">open_in_new</span></a>
            </p>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<?php get_footer();
