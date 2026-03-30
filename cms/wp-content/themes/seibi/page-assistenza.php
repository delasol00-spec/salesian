<?php
/**
 * アシステンツァ
 * URL: /feature/assistenza/
 *
 * @package seibi
 */

get_header(); ?>

<div class="container-fluid p-0">
  <main class="sub-page-view">
    <div class="sub-hero">
      <img src="<?php echo get_template_directory_uri(); ?>/img/assistenza-img/main.webp" alt="アシステンツァ" class="sub-hero-img" />
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
        <h2 class="col-12 sec-title-pink pink">子どもたちに安心感と信頼感を。</h2>
        <div class="col-lg-8 col-12">
        <p>星美では、"アシステンツァ"という合い言葉があります。<br>
          イタリア語で"常に寄り添う"という意味のこの言葉は、子どもたちと行動を共にし、何かあったときには、すぐに手を差しのべられる関わり方を指します。<br>
          この関わりを通して、安心と信頼関係が子どもたちとの間に生まれ、家族的雰囲気を作り出しています。 </p>
        </div>
        </div>
  </div>
</section>

<section class="page-parallax">
  <div class="page-parallax-image assistenza-para-img" role="img" aria-label="アシステンツァ">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
          <h2 class="col-12 sec-title-pink pink">星美の予防教育法</h2>
          <div class="religion-text">
            <p class="gakunen-pill">宗教</p><br>
            <h4 class="assistenza-title">祈りと心の喜び</h4>
            <p>神の愛を知り、愛された喜びの中で、愛することを学び、生命の尊厳、人間の品位を身につける。</p>
          </div>
          <div class="religion-text">
            <p class="gakunen-pill">慈愛</p><br>
            <h4 class="assistenza-title">共にいきる愛の現存</h4>
            <p>晴れやかな明るい心、教師と児童のうちとけた交流、通じる愛のうちに深められた信頼により暖かい人間関係が結べる。</p>
          </div>
          <div class="religion-text">
            <p class="gakunen-pill">理性</p>
            <h4 class="assistenza-title">愛情による信頼と理解</h4>
            <p>磨かれた理性、神から与えられた能力を愛の応えとして、最大限発揮させ、学ぶことの正しい意味を知る。</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php get_footer();
