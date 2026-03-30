<?php
/**
 * 校長メッセージ
 * URL: /about/principal/
 *
 * @package salesian
 */

get_header(); ?>

<?php get_template_part( 'template-parts/page-hero', null, [ 'hero_img' => 'img/about/about-bg.webp' ] ); ?>

<section class="p-70-70">
  <div class="container">
    <div class="row">
      <h2 class="col-12 sec-title pink">共に喜び 共に生きる</h2>
      <div class="col-lg-4 col-md-6">
        <img src="<?php echo get_template_directory_uri(); ?>/img/about/principal.webp" class="img-fluid" loading="lazy" alt="サレジアン国際学園小学校 学校長　星野 和江" />
      </div>
      <div class="col-lg-8 col-md-6">
        <p>
          サレジアン国際学園小学校は、キリスト教的な人間観・世界観により、創立者聖ヨハネ・ボスコと聖マリア・マザレロが実践した理性・宗教・慈愛に基づく「予防教育法による全人間教育」を行うために創設されたカトリックミッションスクールです。<br />
          創立者聖ヨハネ・ボスコは、「愛情がなければ信頼はなく、信頼がなければ教育はない」と言い、教育における信頼関係を大切にしました。
        </p>
        <p>私たちは、子ども達一人ひとりをかけがえのない存在として大切にし、子ども達が愛されていると感じられる関わりを目指しながら、毎日、子どもと共に過ごしています。</p>
        <p>「清い心」「たゆまぬ努力」を校訓に、進んで善を選び取り、将来、社会に貢献できる児童の育成をめざしています。</p>
        <p>&nbsp;</p>
        <p class="right mt30">星美学園小学校 学校長　星野 和江</p>
      </div>
    </div>
  </div>
</section>

<?php get_footer();
