<?php
/**
 * 施設・設備・環境
 * URL: /about/facility/
 *
 * @package salesian
 */

get_header(); ?>

<div class="container-fluid p-0">
  <main class="sub-page-view">
    <div class="sub-hero">
      <img src="<?php echo get_template_directory_uri(); ?>/img/about/about-bg.webp" alt="" class="sub-hero-img" />
    </div>
    <section class="page-title">
      <h1><?php the_title(); ?></h1>
      <div class="inner-border"></div>
    </section>
  </main>
</div>

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
        <img src="<?php echo get_template_directory_uri(); ?>/img/facility-img/sodan.webp" loading="lazy" alt="相談室" class="img-fluid" />
        <h5>相談室</h5>
      </div>
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
        <img src="<?php echo get_template_directory_uri(); ?>/img/facility-img/kateika.webp" loading="lazy" alt="アフタースクール" class="img-fluid" />
        <h5>アフタースクール</h5>
      </div>
      <div class="col-lg-3 col-xs-6 shisetsu">
        <img src="<?php echo get_template_directory_uri(); ?>/img/facility-img/kaiga.webp" loading="lazy" alt="絵画室" class="img-fluid" />
        <h5>絵画室</h5>
      </div>
      <div class="col-lg-3 col-xs-6 shisetsu">
        <img src="<?php echo get_template_directory_uri(); ?>/img/facility-img/zukou.webp" loading="lazy" alt="工作室" class="img-fluid" />
        <h5>工作室</h5>
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

<?php get_footer();
