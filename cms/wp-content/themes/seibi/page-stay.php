<?php
/**
 * 宿泊学習
 * URL: /feature/stay/
 *
 * @package seibi
 */

get_header(); ?>

<div class="container-fluid p-0">
  <main class="sub-page-view">
    <div class="sub-hero">
      <img src="<?php echo get_template_directory_uri(); ?>/img/stay-img/main.webp" alt="宿泊学習" class="sub-hero-img" />
    </div>
    <section class="page-title">
      <h1><?php the_title(); ?></h1>
      <div class="inner-border"></div>
    </section>
  </main>
</div>

<section class="p-70-70">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 col-md-6">
        <img src="<?php echo get_template_directory_uri(); ?>/img/stay-img/01.webp" class="img-fluid" loading="lazy" alt="総合的な学習" />
      </div>
      <div class="col-lg-8 col-md-6">
        <p>
          各学年の学習テーマ探求のため、テーマに沿った場所で宿泊体験を実施しています。<br />
          子どもたちは自然や文化、歴史にふれ、現地の方との交流を通して、学習テーマの本質を理解していきます。<br />
          また実際に体験することで好奇心、探究心を刺激させ、自主的に学ぶ姿勢を養います。<br />
          このように星美では、実体験をもとにした正しい価値観、考え方の教育を大切にしています。
        </p>
      </div>
    </div>
  </div>
</section>

<section class="p-70-70 bg-white">
  <div class="container">
    <h2 class="col-12 sec-title-pink pink">各学年ごとの宿泊体験</h2>

    <div class="row mb50 mt30">
      <div class="col-md-6 col-12">
        <div class="stay-box">
          <h3>3年生 富士林間学校</h3>
          <img src="<?php echo get_template_directory_uri(); ?>/img/stay-img/03.webp" alt="富士林間学校" class="img-fluid" />
          <p>「環境」をテーマに山梨県の富士の裾野で行われる宿泊体験です。富士周辺の植物や樹々、地質などの自然体系を観察し、大自然の雄大さと神秘にふれていきます。</p>
        </div>
      </div>

      <div class="col-md-6 col-12">
        <div class="stay-box">
          <h3>4年生 高原学校</h3>
          <img src="<?php echo get_template_directory_uri(); ?>/img/stay-img/04.webp" alt="高原学校" class="img-fluid" />
          <p>自然と人々との関わりや、地域の特色を生かして人々が生活してきた様子を学習しつつ、神様がお造りになった大自然の営みの中で命の大切さを実感します。</p>
        </div>
      </div>

      <div class="col-md-6 col-12">
        <div class="stay-box">
          <h3>5年生 雪の学校</h3>
          <img src="<?php echo get_template_directory_uri(); ?>/img/stay-img/05.webp" alt="雪の学校" class="img-fluid" />
          <p>雪国でなければできない厳しい体験や、豊かな伝統的な文化にふれることを目的として実施しています。また、スキーレッスンや雪上運動会も実施しています。</p>
        </div>
      </div>

      <div class="col-md-6 col-12">
        <div class="stay-box">
          <h3>6年生 広島平和学習</h3>
          <img src="<?php echo get_template_directory_uri(); ?>/img/stay-img/06.webp" alt="広島平和学習" class="img-fluid" />
          <p>平和への思いを深め、広島での見学、体験を通して感じたことを「祈りの箱舟」に乗せて、平和の誓いとともに祈りを捧げてきます。</p>
        </div>
      </div>

      <div class="col-md-6 col-12">
        <div class="stay-box">
          <h3>希望者のみ　オーストラリア・ホームステイ</h3>
          <img src="<?php echo get_template_directory_uri(); ?>/img/stay-img/07.webp" alt="オーストラリア・ホームステイ" class="img-fluid" />
          <p>シドニーの姉妹校であるセント・リーターズ小学校で現地の子ども達と創立者ドン・ボスコの精神を大切に一緒に学び、交流を深めます。</p>
        </div>
      </div>
    </div>
  </div>
</section>

<?php get_footer();
