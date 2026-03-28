<?php
/**
 * 年間行事 アーカイブ（一覧）テンプレート
 * URL: /life/year/
 * カスタム投稿タイプ: year
 * タクソノミー: year_month（月カテゴリー）
 * ギャラリー: メタフィールド _year_gallery_ids → Bootstrap Modal で表示
 *
 * @package seibi
 */

get_header(); ?>

<div class="container-fluid p-0">
  <main class="sub-page-view">
    <div class="sub-hero">
      <img src="<?php echo get_template_directory_uri(); ?>/img/year-img/main.webp" alt="年間行事" class="sub-hero-img" />
    </div>
    <section class="page-title">
      <h1>年間行事</h1>
      <div class="inner-border"></div>
    </section>
  </main>
</div>

<?php
// 学年暦順（4月〜3月）の月定義
$months = [
    [ 'name' => '4月',  'img' => '04.webp' ],
    [ 'name' => '5月',  'img' => '05.webp' ],
    [ 'name' => '6月',  'img' => '06.webp' ],
    [ 'name' => '7月',  'img' => '07.webp' ],
    [ 'name' => '8月',  'img' => '08.webp' ],
    [ 'name' => '9月',  'img' => '09.webp' ],
    [ 'name' => '10月', 'img' => '10.webp' ],
    [ 'name' => '11月', 'img' => '11.webp' ],
    [ 'name' => '12月', 'img' => '12.webp' ],
    [ 'name' => '1月',  'img' => '01.webp' ],
    [ 'name' => '2月',  'img' => '02.webp' ],
    [ 'name' => '3月',  'img' => '03.webp' ],
];
?>

<section class="p-70-70">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="row">
          <?php foreach ( $months as $month_data ) :
            $term  = get_term_by( 'name', $month_data['name'], 'year_month' );
            $posts = [];
            if ( $term ) {
                $q = new WP_Query( [
                    'post_type'      => 'year',
                    'tax_query'      => [ [
                        'taxonomy' => 'year_month',
                        'field'    => 'term_id',
                        'terms'    => $term->term_id,
                    ] ],
                    'posts_per_page' => -1,
                    'orderby'        => 'menu_order',
                    'order'          => 'ASC',
                ] );
                $posts = $q->posts;
            }
          ?>
          <div class="col-lg-4 col-md-6 col-12">
            <div class="year-box">
              <h2><?php echo esc_html( $month_data['name'] ); ?></h2>
              <img src="<?php echo get_template_directory_uri(); ?>/img/year-img/<?php echo esc_attr( $month_data['img'] ); ?>" alt="<?php echo esc_attr( $month_data['name'] ); ?>" class="img-fluid" />
              <div class="year-detail">
                <?php if ( $posts ) :
                  foreach ( $posts as $post ) :
                    $ids_str = get_post_meta( $post->ID, '_year_gallery_ids', true );
                    $ids     = $ids_str ? array_filter( array_map( 'intval', explode( ',', $ids_str ) ) ) : [];

                    if ( ! empty( $ids ) ) : ?>
                      <p>
                        <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>">
                          <?php echo esc_html( get_the_title( $post ) ); ?>
                        </a>
                      </p>
                    <?php else : ?>
                      <p><?php echo esc_html( get_the_title( $post ) ); ?></p>
                    <?php endif;
                  endforeach;
                endif; ?>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<?php get_footer();
