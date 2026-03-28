<?php
/**
 * 建学の精神・教育理念
 * URL: /about/method/
 *
 * @package salesian
 */

get_header(); ?>

<?php get_template_part( 'template-parts/page-hero', null, [ 'hero_img' => 'img/about/about-bg.webp' ] ); ?>

<section class="p-70-70">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 col-md-6">
        <img src="<?php echo get_template_directory_uri(); ?>/img/about/method.webp" class="img-fluid" loading="lazy" alt="聖母マリア像" />
      </div>
      <div class="col-lg-8 col-md-6">
        <h3 class="sub-title">建学の精神</h3>
        <p>星美学園は、キリスト教的な人間観・世界観により、創立者聖ヨハネ・ボスコと聖マリア・マザレロが実践した理性・宗教・慈愛に基づく「予防教育法による全人間教育」を行うために創設されたカトリック・ミッション・スクールです。</p>
        <p>私たちは、子ども達一人ひとりをかけがえのない存在として大切にし、子ども達が愛されていると感じられる関わりを目指しながら、毎日、子どもと共に過ごしています。</p>
        <p>「清い心」「たゆまぬ努力」を校訓に、進んで善を選び取り、将来、社会に貢献できる児童の育成をめざしています。</p>
        <h3 class="sub-title">教育理念</h3>
        <p>私たちの教育は、一人ひとりをかけがえのない存在として大切にされる神の愛に基づいた教育です。</p>
        <p>青少年・保護者・教育者が一つになって教育共同体を築きます。</p>
        <p class="mb-5">その中で青少年自らが知性を磨き、心を鍛え、正しい判断力と自由な選択能力を養うよう、尊敬と慈しみ、親しみの態度のうちに、青少年を導きます。こうして社会と人々に積極的に貢献できる自立した人間を育成します。</p>
      </div>
    </div>
  </div>
</section>

<?php get_footer();
