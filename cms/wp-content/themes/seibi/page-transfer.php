<?php
/**
 * 編転入学について
 * URL: /admission/transfer/
 *
 * @package seibi
 */

get_header(); ?>

<div class="container-fluid p-0">
  <main class="sub-page-view">
    <div class="sub-hero">
      <img src="<?php echo get_template_directory_uri(); ?>/img/admission/admission-bg.webp" alt="" class="sub-hero-img" />
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
      <div class="col-lg-10">

        <div class="event-col-white">
          <h3 class="r-top-10">転入試験のお知らせ</h3>
          <div class="event-spec">
            <p>本年度の転入試験は、終了いたしました。</p>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<?php get_footer();
