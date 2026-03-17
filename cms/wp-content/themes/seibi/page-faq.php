<?php
/**
 * よくある質問
 * URL: /about/faq/
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
    <div class="row justify-content-center">
      <h2 class="sec-title-pink pink">入学／入試／学費について</h2>
      <div class="col-md-8">
        <div class="faq-q r-top-10">通学可能地域の基準・指定はありますか。</div>
        <div class="faq-a r-bottom-10">特にありません。</div>
        <div class="faq-q r-top-10">保育園出身者は、受験で不利になりますか。</div>
        <div class="faq-a r-bottom-10">そのようなことは全くありません。子どもを差別する学校ではありませんので、ご安心ください。</div>
        <div class="faq-q r-top-10">カトリック教会と関わりのある人が有利であると聞きましたが、本当でしょうか。</div>
        <div class="faq-a r-bottom-10">そのようなことは全くありません。本校は入学を希望してくださる方すべてに平等に開かれている学校です。</div>
        <div class="faq-q r-top-10">推薦入試はありますか。</div>
        <div class="faq-a r-bottom-10">原則として「なし」となっています。</div>
        <div class="faq-q r-top-10">転・編入試験はありますか。</div>
        <div class="faq-a r-bottom-10">随時受け付けております。詳しくはお問い合わせください。<br>お問い合せ先：星美学園小学校　事務室　03-3906-0053（午前9：00～午後4：30）</div>
      </div>
    </div>
  </div>
</section>

<?php get_footer();
