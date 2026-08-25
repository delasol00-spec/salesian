<?php
/**
 * 宿泊学習
 * URL: /feature/stay/
 *
 * @package seibi
 */

get_header(); ?>

<?php get_template_part( 'template-parts/page-hero', null, [ 'hero_img' => 'img/stay-img/main.webp', 'hero_alt' => '宿泊学習' ] ); ?>

<section class="p-70-70">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 col-md-6">
        <img src="<?php echo get_template_directory_uri(); ?>/img/stay-img/01.webp" class="img-fluid" loading="lazy" alt="総合的な学習" />
      </div>
      <div class="col-lg-8 col-md-6">
        <h3 class="sub-title">本物と向き合い生きていく力を養う</h3>
        <p>
          星美クラスでは、年間を通して様々な体験行事が行われます。<br>
          そのほとんどが体験型学習を基本とする本物に向き合う行事で、学園内では得ることのできない貴重な体験の数々を通して、
          子どもたちは探究心に目覚め自ら考える思考を身につけていきます。<br>
          また、その体験を多くの仲間たちと実践することで、社会に出てからも必ず必要となる共同作業の大切さや
          他者を思いやる心の大切さを学び、同時にコミュニケーション能力も養われます。
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
          <img src="<?php echo get_template_directory_uri(); ?>/img/stay-img/08.webp" alt="オーストラリア・ホームステイ" class="img-fluid" />
          <p>ブリスベンにあるセント・リーターズ小学校で現地の子ども達と交流を深め、一緒に学びます。</p>
        </div>
      </div>
    </div>
  </div>
</section>

<?php get_footer();
