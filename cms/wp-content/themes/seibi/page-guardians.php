<?php

/**
 * 保護者の方
 * URL: /guardians/
 * ※ Basic 認証あり（inc/auth.php で制御）
 *
 * @package seibi
 */

get_header(); ?>

<main class="sub-page-view">
  <div class="sub-hero">
    <picture>
      <source media="(max-width: 991px)" srcset="<?php echo get_template_directory_uri(); ?>/img/guardian-img/main-sp.png" />
      <img src="<?php echo get_template_directory_uri(); ?>/img/guardian-img/main.png" alt="" class="sub-hero-img" />
    </picture>
  </div>

  <section class="page-title">
    <h1><?php the_title(); ?></h1>
    <div class="inner-border"></div>
  </section>
</main>

<section class="p-70-70">
  <div class="container">
    <div class="row justify-content-center">
      <div class="sec-title-pink pink">
        <h3>各種届出ダウンロード</h3>
      </div>
      <div class="col-lg-10 col-12">
        <p>
          各種届出・申請フォームのダウンロードがご利用いただけます。<br>
          ダウンロードしたフォームをプリントアウトしていただき、必要事項をご記入の上、学校へご提出ください。
        </p>
        <ul class="dl">
          <li><a href="<?php echo get_template_directory_uri(); ?>/docs/toukoukakuninsyo.pdf" target="_blank"><strong>登校許可確認証</strong>（学校保健法に指定された伝染性の疾病と診断された医療機関で必要）<span>（PDF 578KB）</span></a></li>
          <li><a href="<?php echo get_template_directory_uri(); ?>/docs/jidoushinjouhenkoutodoke.pdf" target="_blank"><strong>児童身上変更届</strong>（住所その他登下校経路変更時に必要）<span>（PDF 196KB）</span></a></li>
          <li><a href="<?php echo get_template_directory_uri(); ?>/docs/jidoushinjouhenkoutodoke.docx" target="_blank">　<span>（Word 413KB）</span></a></li>
        </ul>
      </div>
    </div>
  </div>
</section>

<section class="p-70-70 bg-white">
  <div class="container">
    <div class="row justify-content-center">
      <div class="sec-title-pink pink">
        <h3>制服販売サイト</h3>
      </div>
      <div class="col-lg-8">
        <p>
          制服販売サイトを利用するには、7iDに登録いただく必要があります。<br>
          リンク先はそごう・西武のWEBサイト、e.デパートの特設ページとなり、こちらはスマートフォン、ＰＣからのご利用が可能です。<br>
          ページで商品を選択後、購入の段階で、7iDが必要となります。必要事項を入力の上、7iDを取得下さい。（従来より7iDをお持ちの方はそのIDがご使用いただけます）
        </p>
        <div class="col-12 mt-lg-5 text-center">
          <a class="btn-slide btn-l btn-pink mb-3 mb-sm-2" href="https://edepart.sogo-seibu.jp/brand/005199" target="_blank"><span class="text">サレジアン国際学園小学校 制服販売サイト<span class="material-symbols-outlined">open_in_new</span></span></a><br>
          <small>そごう･西武用品販売へリンクします</small>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="p-70-70">
  <div class="container">
    <div class="row justify-content-center">
      <div class="sec-title-pink pink">
        <h3>体操着等販売サイト</h3>
      </div>
      <div class="col-lg-8">
        <p>
          体操着等販売サイトを利用するには、ご利用前に会員登録が必要です。初めて利用される方は下記「会員登録」より必要事項をご記入の上ご利用ください。<br>
          (リンク先は日勝スポーツ工業のサイトになります)
        </p>
        <div class="col-12 text-center mt-lg-5 mb-lg-4 mb-sm-3">
          <a class="btn-slide btn-l btn-pink mb-3 mb-sm-2" href="https://www.nissho-online.com/shop/idinfo.html?gid=seibi" target="_blank"><span class="text">日勝スポーツ工業 会員登録<span class="material-symbols-outlined">open_in_new</span></span></a><br>
          <small>日勝スポーツ工業のオンライン登録サイトへリンクします</small>
        </div>
        <div class="col-12 text-center">
          <a class="btn-slide btn-l btn-pink mb-3 mb-sm-2" href="https://www.nissho-online.com/" target="_blank"><span class="text">体操着等のご注文はこちらへ<span class="material-symbols-outlined">open_in_new</span></span></a><br>
          <small>リンク先でIDとパスワードを入力してご利用ください</small>
        </div>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>