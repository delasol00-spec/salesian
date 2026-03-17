<?php
/**
 * 児童募集要項
 * URL: /admission/requirements/
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
      <h1><?php the_title(); ?></h1>
      <div class="inner-border"></div>
    </section>
  </main>
</div>

<section class="p-70-70">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="sec-title-blue blue">令和9年度（2027年度） 児童募集要項</div>
        <div class="mini-nav">
          <a href="#seibi" class="btn-slide-r btn-ss btn-pink-r">星美クラス</a>
          <a href="#inter" class="btn-slide-r btn-ss btn-pink-r ml-md-3">インターナショナルクラス</a>
          <a href="#returnee" class="btn-slide-r btn-ss btn-pink-r ml-md-3">帰国生入試</a>
        </div>
        <div class="table-responsive" id="seibi">
          <table class="table table-bordered table-striped admission" style="min-width: 800px">
            <tr>
              <th colspan="3" class="bg-pink text-white">星美クラス</th>
            </tr>
            <tr>
              <th></th>
              <th>A日程</th>
              <th>B日程</th>
            </tr>
            <tr>
              <th>募集人数</th>
              <td colspan="2">第１学年(男、女)「星美クラス」「インターナショナルクラス」合わせて120名</td>
            </tr>
            <tr>
              <th>出願期間（Web出願）</th>
              <td>10月1日(木)〜10月4日（日）</td>
              <td>11月10日(火)〜11月14日（土）</td>
            </tr>
            <tr>
              <th>面接期間</th>
              <td>10月8日（木）〜10月20日（火）</td>
              <td>11月16日（月）〜 11月19日（木）</td>
            </tr>
            <tr>
              <th>入学試験</th>
              <td>11月1日（日）8:50開始</td>
              <td>11月20日（金）8:50開始</td>
            </tr>
            <tr>
              <th>合格発表（Web発表）</th>
              <td>11月2日（月）</td>
              <td>11月21日（土）</td>
            </tr>
            <tr>
              <th>出願費用</th>
              <td colspan="2">受験料　25,000円</td>
            </tr>
            <tr>
              <th>入学手続き</th>
              <td colspan="2">入学金　250,000円</td>
            </tr>
            <tr>
              <th>児童募集要項</th>
              <td colspan="2"><a href="#seibi" class="btn-slide-r btn-ss btn-pink-r">こちらからダウンロードいただけます (PDF 0.0MB)</a></td>
            </tr>
          </table>
        </div>

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

        <div class="event-col-white">
          <h3><strong>【星美クラス】</strong>持ち物／服装について</h3>
          <div class="event-spec">
            <p>
              鉛筆3本、体育着、上履き（保護者の方もお持ちください）<br />
              のり（スティックタイプ）、はさみ、クレヨン（12~16色）、水筒：任意（お茶かお水）
            </p>
          </div>
        </div>

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

<section class="p-70-70" id="inter">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="table-responsive">
          <table class="table table-bordered table-striped inter" style="min-width: 800px">
            <tr>
              <th colspan="4" class="bg-blue text-white">インターナショナルクラス</th>
            </tr>
            <tr>
              <th></th>
              <th>A日程</th>
              <th>B日程</th>
              <th>C日程</th>
            </tr>
            <tr>
              <th>募集人数</th>
              <td colspan="3">第１学年(男、女)「星美クラス」「インターナショナルクラス」合わせて120名</td>
            </tr>
            <tr>
              <th>出願期間（Web出願）</th>
              <td>10月1日（木）〜<br />10月12日（月）</td>
              <td>11月5日（木）〜<br />11月15日（日）</td>
              <td>12月14日（月）〜<br />12月27日（日）</td>
            </tr>
            <tr>
              <th>面接期間</th>
              <td>10月18日（日）まで</td>
              <td>11月16日（日）まで</td>
              <td>2027年1月4日（月）まで</td>
            </tr>
            <tr>
              <th>入学試験</th>
              <td>11月2日（月）未定</td>
              <td>11月20日（金）未定</td>
              <td>2027年1月6日（水）未定</td>
            </tr>
            <tr>
              <th>合格発表（Web発表）</th>
              <td>11月5日（木）17:00</td>
              <td>11月24日（火）17:00</td>
              <td>2027年1月8日（金）17:00</td>
            </tr>
            <tr>
              <th>出願費用</th>
              <td colspan="3">受験料　25,000円</td>
            </tr>
          </table>
        </div>
        <div class="event-col-white inter-title">
          <h3><strong>【インターナショナルクラス】</strong>選考内容他</h3>
          <div class="event-spec">
            <p>
              <a href="https://www.el.seibi.ac.jp/international/enrolment/application_guidelines/">詳細はインターナショナルクラスHPでご確認ください。<span class="material-symbols-outlined">open_in_new</span></a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="p-70-70" id="returnee">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="table-responsive">
          <table class="table table-bordered table-striped inter" style="min-width: 800px">
            <tr>
              <th colspan="3" class="bg-blue text-white">帰国生入試</th>
            </tr>
            <tr>
              <th></th>
              <th>第1回</th>
              <th>第2回</th>
            </tr>
            <tr>
              <th>募集人数</th>
              <td colspan="2">若干名</td>
            </tr>
            <tr>
              <th>出願期間（Web出願）</th>
              <td>2025年10/1(水)～10/5(日)</td>
              <td>2025年12/15(月)～2026年1/4(日)</td>
            </tr>
            <tr>
              <th>親子面接</th>
              <td>2025年10/20(月)～10/23(木)</td>
              <td>2026年1/7(水)</td>
            </tr>
            <tr>
              <th>入学試験</th>
              <td>2025年10/25(土)午後</td>
              <td>2026年1/7(水)</td>
            </tr>
            <tr>
              <th>合格発表（Web発表）</th>
              <td>2025年10/26(日)17:00</td>
              <td>2026年1/8(木)17:00</td>
            </tr>
            <tr>
              <th>入学金振込期間</th>
              <td>2025年10/26(日)17:00～10/29(水)23:59</td>
              <td>2026年1/8(木)17:00～1/11(日)23:59</td>
            </tr>
          </table>
        </div>
        <div class="event-col-white inter-title">
          <h3><strong>【帰国生入試】</strong>選考内容他</h3>
          <div class="event-spec">
            <p>
              <a href="https://www.el.seibi.ac.jp/international/enrolment/application_guidelines/">詳細はインターナショナルクラスHPでご確認ください。<span class="material-symbols-outlined">open_in_new</span></a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php get_footer();
