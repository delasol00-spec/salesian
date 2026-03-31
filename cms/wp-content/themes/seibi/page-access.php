<?php
/**
 * アクセス
 * URL: /about/access/
 *
 * @package salesian
 */

get_header(); ?>

<?php get_template_part( 'template-parts/page-hero', null, [ 'hero_img' => 'img/about/about-bg.webp', 'hero_sp_img' => 'img/about/hero-about-bg.webp' ] ); ?>

<section class="p-70-70">
  <div class="container">
    <div class="row map">
      <div class="col-md-8 col-12 mb-3">
        <a href="javascript:void(0);" data-toggle="modal" data-target="#mapModal">
          <img src="<?php echo get_template_directory_uri(); ?>/img/about/map.webp" alt="アクセスマップ" class="img-fluid" />
        </a>
      </div>
      <div class="col-md-4 col-12">
        <div class="access-col">
          <h4 class="access-title">JR赤羽駅から</h4>
          <p>
            赤羽駅西口より 北方向へ<br />徒歩約10分<br />
            <small>(線路沿い北側に見えています)</small>
          </p>
        </div>
        <div class="access-col">
          <h4 class="access-title">東京メトロ 赤羽岩淵駅から</h4>
          <p>
            東京メトロ南北線・埼玉高速鉄道<br>
｢赤羽岩淵駅｣下車<br>
２番出口より 徒歩約８分
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="p-70-70 bg-white">
  <div class="container">
    <div class="row map">
      <div class="col-md-8 col-12 mb-3">
        <a href="javascript:void(0);" data-toggle="modal" data-target="#mapModal">
          <img src="<?php echo get_template_directory_uri(); ?>/img/about/map2.webp" alt="アクセスマップ" class="img-fluid" />
        </a>
      </div>
      <div class="col-md-4 col-12">
        <div class="access-col">
          <h4 class="access-title">JR赤羽駅利用</h4>
          <div class="line">
            <p class="mb5">JR宇都宮線・高崎線</p>
            <p><span class="station">大宮駅から</span>　<span class="minuites">15分</span></p>
          </div>
          <div class="line">
            <p class="mb5">JR宇都宮線・高崎線</p>
            <p><span class="station">上野駅から</span>　<span class="minuites">11分</span></p>
          </div>
          <div class="line">
            <p class="mb5">JR京浜東北線</p>
            <p><span class="station">東京駅から</span>　<span class="minuites">20分</span></p>
          </div>
          <div class="line">
            <p class="mb5">JR埼京線</p>
            <p><span class="station">池袋駅から</span>　<span class="minuites">8分</span></p>
          </div>
          <div class="line">
            <p class="mb5">JR埼京線</p>
            <p><span class="station">新宿駅から</span>　<span class="minuites">13分</span></p>
          </div>
          <div class="line">
            <p class="mb5">JR埼京線</p>
            <p><span class="station">渋谷駅から</span>　<span class="minuites">19分</span></p>
          </div>
        </div>
        <div class="access-col">
          <h4 class="access-title">東京メトロ 赤羽岩淵駅利用</h4>
          <div class="line">
            <p class="mb5">東京メトロ 南北線/埼玉高速鉄道</p>
            <p><span class="station">浦和美園駅から</span>　<span class="minuites">19分</span></p>
          </div>
          <div class="line">
            <p class="mb5">東京メトロ 南北線</p>
            <p><span class="station">目黒駅から</span>　<span class="minuites">32分</span></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Map Modal -->
<div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-body p-0">
        <button type="button" class="close position-absolute" data-dismiss="modal" aria-label="Close" style="right: 15px; top: 10px; z-index: 10">
          <span aria-hidden="true">&times;</span>
        </button>
        <img src="<?php echo get_template_directory_uri(); ?>/img/about/map.webp" alt="アクセスマップ" class="img-fluid w-100" />
      </div>
    </div>
  </div>
</div>

<?php get_footer();
