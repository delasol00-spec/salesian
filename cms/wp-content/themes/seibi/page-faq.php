<?php
/**
 * よくある質問
 * URL: /about/faq/
 *
 * @package salesian
 */

get_header(); ?>

<?php get_template_part( 'template-parts/page-hero', null, [ 'hero_img' => 'img/about/about-bg.webp', 'hero_sp_img' => 'img/about/hero-about-bg.webp' ] ); ?>

<section class="p-70-70">
  <div class="container">
    <div class="row justify-content-center">
      <h2 class="sec-title-pink pink">入学／入試／学費について</h2>
      <div class="col-lg-8 col-md-10 col-12">
        <div class="faq-q r-top-10">通学可能地域の基準・指定はありますか。</div>
        <div class="faq-a r-bottom-10">
          特にありません。
          <div class="btn-group">
            <a href="<?php echo esc_url( home_url( '/about/area/' ) ); ?>" class="btn-slide btn-mini btn-pink btn-right">通学地域 <span class="material-symbols-outlined"> keyboard_double_arrow_right </span></a>
          </div>
        </div>

        <div class="faq-q r-top-10">保育園出身者は、受験で不利になりますか。</div>
        <div class="faq-a r-bottom-10">そのようなことは全くありません。子どもを差別する学校ではありませんので、ご安心ください。</div>

        <div class="faq-q r-top-10">カトリック教会と関わりのある人が有利であると聞きましたが、本当でしょうか。</div>
        <div class="faq-a r-bottom-10">そのようなことは全くありません。本校は入学を希望してくださる方すべてに平等に開かれている学校です。</div>

        <div class="faq-q r-top-10">推薦入試はありますか。</div>
        <div class="faq-a r-bottom-10">原則として「なし」となっています。</div>

        <div class="faq-q r-top-10">転・編入試験はありますか。</div>
        <div class="faq-a r-bottom-10">
          随時受け付けております。詳しくはお問い合わせください。<br />
          お問い合せ先：サレジアン国際学園小学校　事務室<br>
          TEL：03-3906-0053（午前9：00～午後4：30）
          <div class="btn-group">
            <a href="<?php echo esc_url( home_url( '/admission/transfer/' ) ); ?>" class="btn-slide btn-mini btn-pink btn-right">転入について <span class="material-symbols-outlined"> keyboard_double_arrow_right </span></a>
          </div>
        </div>

        <div class="faq-q r-top-10">受験料はどのように納入すればよいですか。</div>
        <div class="faq-a r-bottom-10">銀行振り込みとなります。</div>

        <div class="faq-q r-top-10">面接は両親とも出席しなければならないのでしょうか。</div>
        <div class="faq-a r-bottom-10">ご都合がつく限り、ご両親でお越しください。</div>

        <div class="faq-q r-top-10">選考日当日の保護者の服装に指定はありますか。</div>
        <div class="faq-a r-bottom-10">特にありません。</div>

        <div class="faq-q r-top-10">外国籍なのですが、入学手続き等で準備しなくてはならないものはありますか。</div>
        <div class="faq-a r-bottom-10 mb-5">
          外国籍の方は出願手続の際、「住民票」を提出していただきます。<br />
          手続きについては、「児童募集要項」を参照ください。
          <div class="btn-group">
            <a href="<?php echo esc_url( home_url( '/admission/requirements/' ) ); ?>" class="btn-slide btn-mini btn-pink btn-right">児童募集要項 <span class="material-symbols-outlined"> keyboard_double_arrow_right </span></a>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<?php get_footer();
