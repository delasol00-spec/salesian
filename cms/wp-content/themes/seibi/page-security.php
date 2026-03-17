<?php
/**
 * 災害・セキュリティ対策
 * URL: /about/security/
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
    <h2 class="col-12 sec-title-pink pink">危機管理体制の徹底</h2>
    <div class="row">
      <div class="col-md-5">
        <img src="<?php echo get_template_directory_uri(); ?>/img/security-img/security-img01.webp" alt="危機管理体制の徹底" class="img-fluid" />
      </div>
      <div class="col-md-7">
        <p>星美では子どもたちの安全と安心を確保するため、様々な対策と訓練を実施しています。<br />特に星美の子どもたちは都内近郊の様々な地区から通学しているため、通学時の危機管理も徹底しています。</p>
        <p>また、通学地区ごとに縦割り班を編成するなど、緊急時でも子どもが孤立しない体制づくりを整えています。</p>
      </div>
    </div>
  </div>
</section>

<section class="p-70-70 bg-white">
  <div class="container">
    <h2 class="col-12 sec-title-pink pink">震災などの災害時対策</h2>
    <div class="row">
      <div class="col-lg-6 col-xs-12 security">
        <h3 class="title-s">防災訓練</h3>
        <p>地震や火災などの災害時に、迅速かつ安全に子どもたちを校庭などの安全な屋外に避難させるための訓練を実施しています。</p>
        <h3 class="title-s">地区別による班編成</h3>
        <p>住んでいる地域ごと、あるいは同じ方面に下校する子ども達が１０人前後の班を作り、緊急時に備えて集団下校できるようにしています。<br />学期毎に一度、地区別班で昼食を摂ったり、遊んだりしながら、お互いに親しくなる機会をつくっています。</p>
        <h3 class="title-s">帰宅困難時の対応</h3>
        <p>電話またはメール、ホームページで、その旨を保護者に知らせ、学校に迎えに来ていただきます。<br />保護者が迎えに来られるまでは、学校で責任をもって保護しています。</p>
      </div>
      <div class="col-lg-6 col-xs-12 security">
        <h3 class="title-s">防災倉庫の設置</h3>
        <img src="<?php echo get_template_directory_uri(); ?>/img/security-img/security-img02.webp" alt="防災倉庫" class="img-fluid mb-2" />
        <p>中高アート広場に幼稚園から短大までの防災倉庫を設置し、有事の際にそなえています。<br />防災倉庫の他にも、小学校校舎内に飲料水・非常用食料等の備蓄を行なっております。</p>
      </div>
    </div>
  </div>
</section>

<section class="p-70-70">
  <div class="container">
    <h2 class="col-12 sec-title-pink pink">防犯･セキュリティ対策</h2>
    <div class="row">
      <div class="col-sm-6 col-xs-12 security">
        <h3 class="title-s">守衛室の設置と入場者の管理</h3>
        <img src="<?php echo get_template_directory_uri(); ?>/img/security-img/security-img03.webp" class="img-fluid mb-2" alt="守衛室" />
        <p>星美では、学園正門に守衛室を設置。学外からの来校者はこの守衛室で入退場を管理され、不審者が入場できないよう監視しています。</p>
        <h3 class="title-s">防犯訓練</h3>
        <img src="<?php echo get_template_directory_uri(); ?>/img/security-img/security-img05.webp" class="img-fluid mb-2" alt="防犯訓練" />
        <p>子どもたちを対象に防犯、不審者対応訓練を実施。地元警察署と連携し、犯罪に巻き込まれそうになった時、不審者に遭遇した時にどのように行動したら良いかを指導しています。</p>
      </div>
      <div class="col-sm-6 col-xs-12 security">
        <h3 class="title-s">登下校ミマモルメと保護者一斉メール配信</h3>
        <img src="<?php echo get_template_directory_uri(); ?>/img/security-img/security-img04.webp" alt="ミマモルメ" class="img-fluid mb-2" />
        <p>平成23年9月から導入しました「登下校 ミマモルメ」は、子どもの登下校を見守ってくれます。子どものカバンなどに入れたICタグによって、子どもが校門を通過すると、ハンズフリーの無線ICタグが自動で感知してその情報を保護者様の携帯電話などにメールで自動配信します。<br />また、学校から、保護者様に対して、学級閉鎖や天候原因などによる登下校時間の変更などの通知といった緊急情報も、登録しているアドレスにメールで一斉送信することが可能です。</p>
      </div>
    </div>
  </div>
</section>

<?php get_footer();
