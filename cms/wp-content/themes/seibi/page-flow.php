<?php
/**
 * 入学までの流れ
 * URL: /admission/flow/
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
        <div class="sec-title-blue blue">入学までの流れ</div>

        <div class="event-col-white">
          <h3 class="r-top-10">学校説明会</h3>
          <div class="event-spec">
            <p>４月から９月の３回実施される学校説明会にご参加ください。
              学校説明会では、入試に関する説明の他、星美学園小学校の特徴や取り組みなどを紹介いたします。</p>
            <div class="btn-group d-flex justify-content-end w-100">
              <a href="<?php echo esc_url( home_url( '/admission/event/' ) ); ?>" class="btn-slide btn-mini btn-pink btn-right">学校説明会 <span class="material-symbols-outlined"> keyboard_double_arrow_right </span></a>
            </div>
          </div>
        </div>

        <div class="event-col-white">
          <h3 class="r-top-10">出願（Web出願）</h3>
          <div class="event-spec">
            <p>
              <strong>A日程：</strong>10月1日(木)〜10月4日(日)<br>
              <strong>B日程：</strong>11月10日(火)〜11月14日(土)<br>
              詳細は児童受験要項でご確認ください。
            </p>
            <div class="btn-group d-flex justify-content-end w-100">
              <a href="<?php echo esc_url( home_url( '/admission/requirements/' ) ); ?>" class="btn-slide btn-mini btn-pink btn-right">児童募集要項 <span class="material-symbols-outlined"> keyboard_double_arrow_right </span></a>
            </div>
          </div>
        </div>

        <div class="event-col-white">
          <h3 class="r-top-10">合格発表（Web合格発表）</h3>
          <div class="event-spec">
            <p>
              試験日の翌日にWebにて発表いたします。
            </p>
          </div>
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
