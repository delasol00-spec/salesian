<?php
/**
 * 施設・設備・環境
 * URL: /about/facility/
 *
 * @package salesian
 */

get_header(); ?>

<?php get_template_part( 'template-parts/page-hero', null, [ 'hero_img' => 'img/about/about-bg.webp', 'hero_sp_img' => 'img/about/hero-about-bg.webp' ] ); ?>

<section class="p-70-70">
  <div class="container">
    <h2 class="sec-title-pink pink">施設・教室</h2>
    <div class="row mt30">
      <div class="col-lg-4 col-xs-6 shisetsu">
        <img src="<?php echo get_template_directory_uri(); ?>/img/facility-img/shukyo.webp" loading="lazy" alt="宗教室" class="img-fluid" />
        <h5>宗教室</h5>
      </div>
      <div class="col-lg-4 col-xs-6 shisetsu">
        <img src="<?php echo get_template_directory_uri(); ?>/img/facility-img/chapel.webp" loading="lazy" alt="チャペル" class="img-fluid" />
        <h5>チャペル</h5>
      </div>
      <div class="col-lg-4 col-xs-6 shisetsu">
        <img src="<?php echo get_template_directory_uri(); ?>/img/facility-img/tosho.webp" loading="lazy" alt="図書室" class="img-fluid" />
        <h5>図書室</h5>
      </div>
      <div class="col-lg-4 col-xs-6 shisetsu">
        <img src="<?php echo get_template_directory_uri(); ?>/img/facility-img/housou.webp" loading="lazy" alt="放送室" class="img-fluid" />
        <h5>放送室</h5>
      </div>
      <div class="col-lg-4 col-xs-6 shisetsu">
        <img src="<?php echo get_template_directory_uri(); ?>/img/facility-img/shichokaku.webp" loading="lazy" alt="視聴覚室" class="img-fluid" />
        <h5>視聴覚室</h5>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-3 col-xs-6 shisetsu">
        <img src="<?php echo get_template_directory_uri(); ?>/img/facility-img/rika01.webp" loading="lazy" alt="第一理科室" class="img-fluid" />
        <h5>第一理科室</h5>
      </div>
      <div class="col-lg-3 col-xs-6 shisetsu">
        <img src="<?php echo get_template_directory_uri(); ?>/img/facility-img/rika02.webp" loading="lazy" alt="第二理科室" class="img-fluid" />
        <h5>第二理科室</h5>
      </div>
      <div class="col-lg-3 col-xs-6 shisetsu">
        <img src="<?php echo get_template_directory_uri(); ?>/img/facility-img/ongaku01.webp" loading="lazy" alt="第一音楽室" class="img-fluid" />
        <h5>第一音楽室</h5>
      </div>
      <div class="col-lg-3 col-xs-6 shisetsu">
        <img src="<?php echo get_template_directory_uri(); ?>/img/facility-img/ongaku02.webp" loading="lazy" alt="第二音楽室" class="img-fluid" />
        <h5>第二音楽室</h5>
      </div>
      <div class="col-lg-3 col-xs-6 shisetsu">
        <img src="<?php echo get_template_directory_uri(); ?>/img/facility-img/kaiga.webp" loading="lazy" alt="絵画室" class="img-fluid" />
        <h5>絵画室</h5>
      </div>
      <div class="col-lg-3 col-xs-6 shisetsu">
        <img src="<?php echo get_template_directory_uri(); ?>/img/facility-img/zukou.webp" loading="lazy" alt="工作室" class="img-fluid" />
        <h5>工作室</h5>
      </div>
      <div class="col-lg-3 col-xs-6 shisetsu">
        <img src="<?php echo get_template_directory_uri(); ?>/img/facility-img/sodan.webp" loading="lazy" alt="相談室" class="img-fluid" />
        <h5>相談室</h5>
      </div>
      <div class="col-lg-3 col-xs-6 shisetsu">
        <img src="<?php echo get_template_directory_uri(); ?>/img/facility-img/kateika.webp" loading="lazy" alt="アフタースクール" class="img-fluid" />
        <h5>アフタースクール</h5>
      </div>
    </div>
  </div>
</section>

<section class="p-70-70 bg-white">
  <div class="container">
    <h2 class="sec-title-pink pink">運動／多目的施設</h2>
    <div class="row mt30">
      <div class="col-lg-6 col-xs-12 shisetsu">
        <img src="<?php echo get_template_directory_uri(); ?>/img/facility-img/ground.webp" loading="lazy" alt="校庭" class="img-fluid" />
        <h5>校庭</h5>
      </div>
      <div class="col-lg-6 col-xs-12 shisetsu">
        <img src="<?php echo get_template_directory_uri(); ?>/img/facility-img/gym.webp" loading="lazy" alt="体育館" class="img-fluid" />
        <h5>体育館</h5>
      </div>
      <div class="col-lg-4 col-xs-6 shisetsu">
        <img src="<?php echo get_template_directory_uri(); ?>/img/facility-img/hall.webp" loading="lazy" alt="多目的ホール" class="img-fluid" />
        <h5>多目的ホール</h5>
      </div>
      <div class="col-lg-4 col-xs-6 shisetsu">
        <img src="<?php echo get_template_directory_uri(); ?>/img/facility-img/playzone.webp" loading="lazy" alt="プレイゾーン" class="img-fluid" />
        <h5>プレイゾーン</h5>
      </div>
      <div class="col-lg-4 col-xs-6 shisetsu">
        <img src="<?php echo get_template_directory_uri(); ?>/img/facility-img/pool.webp" loading="lazy" alt="プール" class="img-fluid" />
        <h5>プール</h5>
      </div>
    </div>
  </div>
</section>

<section class="p-70-70">
  <div class="container">
    <h2 class="sec-title-pink pink">設備</h2>
    <div class="row">
      <div class="col-sm-6 col-xs-12 shisetsu">
        <img src="<?php echo get_template_directory_uri(); ?>/img/facility-img/fac02.webp" loading="lazy" alt="体育館" class="img-fluid" />
        <p>
          <span>子どもたちが発信する学内放送</span><br>
          星美クラスの放送設備は音声だけでなく、映像配信もできる最新の設備を整えています。<br />
          放送委員が中心となって、朝会や各種案内などを全教室にあるテレビモニターを通して学内へ配信します。
        </p>
      </div>
    </div>
  </div>
</section>

<section class="p-70-70 bg-white">
  <div class="container">
    <div class="row">
      <h2 class="sec-title-pink pink">教育環境</h2>
    </div>
    <div class="row mt30">
      <div class="col-sm-6 col-xs-12 shisetsu shisetsu2">
        <img src="<?php echo get_template_directory_uri(); ?>/img/facility-img/fac06.webp" loading="lazy" alt="校庭" class="img-fluid" />
        <p>
          <span>緑豊かな落ち着いた学園</span><br />
          本校のある星美学園キャンパスは赤羽の高台にあり、季節ごとに豊かな表情を見せる木々や草花に囲まれています。<br />
          学習に集中できる環境のほか、キャンパス内の種類豊かな植物たちが自然の教材となっています。
        </p>
      </div>
      <div class="col-sm-6 col-xs-12 shisetsu shisetsu2">
        <img src="<?php echo get_template_directory_uri(); ?>/img/facility-img/fac07.webp" loading="lazy" alt="体育館" class="img-fluid" />
        <p>
          <span>校庭、運動施設の充実</span><br />
          都内にありながら広い校庭があり、体育の授業や休み時間には子どもたちが伸び伸びと駆け回る風景を見ることができます。<br />
          その他、体育館、プール、多目的ホールなど子どもたちの教育に必要な教育設備を完備しています。
        </p>
      </div>
    </div>
  </div>
</section>

<?php get_footer();
