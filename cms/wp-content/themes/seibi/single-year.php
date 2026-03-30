<?php
/**
 * 年間行事 詳細テンプレート（ギャラリーページ）
 * カスタム投稿タイプ: year
 * ギャラリー画像: メタフィールド _year_gallery_ids → Bootstrap Modal で表示
 * デザイン: インラインCSS（デザイン確定後に pages.css へ移行予定）
 *
 * @package seibi
 */

get_header();

if ( have_posts() ) : the_post();

$ids_str  = get_post_meta( get_the_ID(), '_year_gallery_ids', true );
$id_array = $ids_str ? array_filter( array_map( 'intval', explode( ',', $ids_str ) ) ) : [];

// ヒーロー画像：1枚目の画像を使用、なければ月代表写真にフォールバック
$hero_url = '';
if ( ! empty( $id_array ) ) {
    $hero_url = wp_get_attachment_image_url( reset( $id_array ), 'full' );
}
if ( ! $hero_url ) {
    $hero_url = get_template_directory_uri() . '/img/year-img/main.webp';
}
?>

<div class="container-fluid p-0">
  <main class="sub-page-view">
    <div class="sub-hero">
      <img src="<?php echo esc_url( $hero_url ); ?>" class="sub-hero-img" alt="<?php the_title_attribute(); ?>" />
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
      <div class="col-12">

        <?php if ( ! empty( $id_array ) ) : ?>
        <div class="row row-gutter-1">
          <?php foreach ( $id_array as $attachment_id ) :
            $img_url = wp_get_attachment_image_url( $attachment_id, 'large' );
            $img_full = wp_get_attachment_image_url( $attachment_id, 'full' );
            if ( ! $img_url ) continue;
          ?>
          <div class="col-lg-3 col-md-4 col-sm-6">
            <img src="<?php echo esc_url( $img_url ); ?>"
                 data-full="<?php echo esc_url( $img_full ); ?>"
                 alt="<?php the_title_attribute(); ?>"
                 class="img-fluid year-grid-img js-year-zoom"
                 role="button"
                 tabindex="0"
                 style="cursor:zoom-in;" />
          </div>
          <?php endforeach; ?>
        </div>
        <?php else : ?>
        <p style="text-align:center;color:#888;">画像はまだ登録されていません。</p>
        <?php endif; ?>

        <div class="col-12 mb-lg-5 text-center" style="margin-top:3rem;">
          <a class="btn-slide btn-l btn-pink mb-3" href="<?php echo esc_url( get_post_type_archive_link( 'year' ) ); ?>">
            <span class="text">年間行事一覧に戻る<span class="material-symbols-outlined">open_in_new</span></span>
          </a>
        </div>

      </div>
    </div>
  </div>
</section>

<!-- ギャラリーモーダル -->
<div class="modal fade" id="yearImageModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content bg-transparent border-0" style="position:relative;">
      <button type="button"
              class="close"
              data-dismiss="modal"
              aria-label="閉じる"
              style="position:absolute;top:-36px;right:0;z-index:3;font-size:2rem;line-height:1;color:#fff;opacity:1;">
        <span aria-hidden="true">&times;</span>
      </button>
      <div class="modal-body text-center" style="position:relative;padding:30px;background:#fff;">
        <button type="button"
                id="yearImagePrev"
                aria-label="前の画像"
                style="position:absolute;left:8px;top:50%;transform:translateY(-50%);border:0;background:rgba(0,0,0,.45);color:#fff;width:40px;height:40px;border-radius:50%;font-size:1.5rem;line-height:1;z-index:2;">
          &#8249;
        </button>
        <img id="yearImageModalImg" class="img-fluid" src="" alt="" style="max-height:80vh;" />
        <button type="button"
                id="yearImageNext"
                aria-label="次の画像"
                style="position:absolute;right:8px;top:50%;transform:translateY(-50%);border:0;background:rgba(0,0,0,.45);color:#fff;width:40px;height:40px;border-radius:50%;font-size:1.5rem;line-height:1;z-index:2;">
          &#8250;
        </button>
      </div>
    </div>
  </div>
</div>

<script>
(function () {
    var images       = Array.prototype.slice.call(document.querySelectorAll('.js-year-zoom'));
    var modalImg     = document.getElementById('yearImageModalImg');
    var prevBtn      = document.getElementById('yearImagePrev');
    var nextBtn      = document.getElementById('yearImageNext');
    var currentIndex = 0;

    if (!images.length || !modalImg || !prevBtn || !nextBtn) return;

    function renderImage(index) {
        currentIndex  = (index + images.length) % images.length;
        modalImg.src  = images[currentIndex].dataset.full || images[currentIndex].src;
        modalImg.alt  = images[currentIndex].alt;
    }

    function openAt(index) {
        renderImage(index);
        (function($){ $('#yearImageModal').modal('show'); })(jQuery);
    }

    images.forEach(function (img, index) {
        img.addEventListener('click', function () { openAt(index); });
        img.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); openAt(index); }
        });
    });

    prevBtn.addEventListener('click', function () { renderImage(currentIndex - 1); });
    nextBtn.addEventListener('click', function () { renderImage(currentIndex + 1); });

    document.addEventListener('keydown', function (e) {
        if (!document.body.classList.contains('modal-open')) return;
        if (e.key === 'ArrowLeft')  { e.preventDefault(); renderImage(currentIndex - 1); }
        if (e.key === 'ArrowRight') { e.preventDefault(); renderImage(currentIndex + 1); }
    });
})();
</script>

<?php endif; ?>

<?php get_footer();
