<?php
/**
 * 星美クラスの一日
 * URL: /life/daily/
 *
 * @package seibi
 */

get_header(); ?>

<main class="sub-page-view">
  <div class="sub-hero">
    <picture>
      <source media="(max-width: 991px)" srcset="<?php echo get_template_directory_uri(); ?>/img/day-img/main-sp.webp" />
      <img src="<?php echo get_template_directory_uri(); ?>/img/day-img/main.webp" alt="" class="sub-hero-img" />
    </picture>
  </div>

  <section class="page-title">
    <h1><?php the_title(); ?></h1>
    <div class="inner-border"></div>
  </section>
</main>

<section class="p-70-70 bg-white">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 title-box-s">
        <h2 class="col-12 sec-title-pink pink">各学年の週の授業時間数</h2>
      </div>
      <div class="col-lg-10 col-12 mb-5">
        <img src="<?php echo get_template_directory_uri(); ?>/img/day-img/curriculum.webp" class="img-fluid js-image-zoom" loading="lazy" alt="各学年の週の授業時間数" style="cursor: zoom-in" role="button" tabindex="0" aria-label="画像を拡大表示" />
      </div>
    </div>
    <!-- //row -->
  </div>
  <!-- //container -->
</section>

<section class="p-70-70">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8 col-12 mb-5">
        <p>
          星美クラスの教育は、朝や放課後も大切にしています。<br />
          朝は一日のスタートを切るための準備として、放課後は学習やクラブ練習、 子どもと教員が信頼関係を深めるための時間として、さまざまな取り組みをしています。
        </p>
      </div>
      <div class="sec-title-pink pink"><h3>星美クラスの朝</h3></div>

      <div class="col-12 general-box">
        <div class="row">
          <div class="col-lg-8 col-12">
            <h3 class="title-s">チャレンジタイム</h3>
            <p>
              朝会の前、「チャレンジタイム」という学習時間を設けています。<br>
              この「チャレンジタイム」は、漢字や計算、読書といった学習を短時間で集中して行う取り組みです。<br>
              日々の鍛錬を目的としており、繰り返し行うことによる基礎学力の向上だけでなく、脳の準備運動としても効果を期待しています。
            </p>
          </div>
          <div class="col-lg-4 col-12">
            <img src="<?php echo get_template_directory_uri(); ?>/img/day-img/01.webp" class="img-fluid" loading="lazy" alt="朝会／朝の会" />
          </div>
        </div>
      </div>

      <div class="col-12 general-box">
        <div class="row">
          <div class="col-lg-8 col-12 order-md-2">
            <h3 class="title-s">朝会／朝の会</h3>
            <p>
              星美クラスでは、授業前に必ず朝会があり、曜日ごとに全校、児童会、宗教、体育朝会などがあります。<br />
              各朝会のテーマごとに心の糧になる講話があったり、児童会からのイベントの紹介があったり、運動をしたりします。<br />
              テレビ放送を通して行う朝会のときには、放送委員が放送機器を使って、全校に放送を流します。<br />
              その後、行われる各クラスの朝の会では、担任が朝会の内容を受けて指導し、その日の連絡事項を確認します。
            </p>
          </div>
          <div class="col-lg-4 col-12 order-md-1">
            <img src="<?php echo get_template_directory_uri(); ?>/img/day-img/02.webp" class="img-fluid" loading="lazy" alt="朝会／朝の会" />
          </div>
        </div>
      </div>

      <div class="col-12 general-box">
        <div class="row">
          <div class="col-lg-8 col-12">
            <h3 class="title-s">早朝練習</h3>
            <p>
              特別音楽クラブ（聖歌隊・金管バンド）週に2回と、試合前には運動系クラブ（バスケットボール・野球・サッカー）が練習しています。<br>
              特別音楽クラブ、運動系クラブともに高学年の子どもたちが、早朝から活動しています。
            </p>
          </div>
          <div class="col-lg-4 col-12">
            <img src="<?php echo get_template_directory_uri(); ?>/img/day-img/03.webp" class="img-fluid" loading="lazy" alt="早朝練習" />
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<section class="p-70-70 bg-white">
  <div class="container">
    <div class="row justify-content-center">

      <div class="sec-title-pink pink"><h3>星美クラスの放課後</h3></div>

      <div class="col-12 general-box">
        <div class="row">
          <div class="col-lg-8 col-12">
            <h3 class="title-s">7時間目</h3>
            <p>
              ５・６年生を対象に、7時間目に学習の時間（火･木曜日）を設けています。<br>
この時間は、子どもたちの学力向上のために特別に設けた時間です。特に受験を意識し、発展的な問題の演習を行います。
            </p>
          </div>
          <div class="col-lg-4 col-12">
            <img src="<?php echo get_template_directory_uri(); ?>/img/day-img/04.webp" class="img-fluid" loading="lazy" alt="朝会／朝の会" />
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<div class="modal fade" id="imageZoomModal" tabindex="-1" role="dialog" aria-labelledby="imageZoomModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content bg-transparent border-0" style="position: relative">
      <button
        type="button"
        class="close"
        data-dismiss="modal"
        aria-label="閉じる"
        style="position: absolute; top: -36px; right: 0; z-index: 3; font-size: 2rem; line-height: 1; color: #fff; opacity: 1"
      >
        <span aria-hidden="true">&times;</span>
      </button>
      <div class="modal-body text-center" style="padding: 30px; background: #fff">
        <img id="imageZoomModalImg" src="" alt="" class="img-fluid" />
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>
