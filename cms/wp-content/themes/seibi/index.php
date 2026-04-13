<?php

/**
 * トップページ兼フォールバックテンプレート
 * front-page.php・home.php は使用しない。
 *
 * @package seibi
 */

get_header(); ?>

<div class="container-fluid p-0">
  <main class="main-view">
    <div class="utility-nav d-none d-lg-flex">
      <a href="<?php echo esc_url(home_url('/about/faq/')); ?>" class="btn-slide-r btn-ss btn-pink-r">よくある質問</a>
      <a href="<?php echo esc_url(home_url('/about/access/')); ?>" class="btn-slide-r btn-ss btn-pink-r ml-10">アクセス</a>
      <a href="<?php echo esc_url(home_url('/about/download/')); ?>" class="btn-slide-r btn-ss btn-pink-r ml-10">パンフレットダウンロード</a>
    </div>

    <div class="slideshow">
      <div class="slide-item" data-text="共によろこび、共にいきる。"></div>
      <div class="slide-item" data-text="清 い 心"></div>
      <div class="slide-item" data-text="たゆまぬ努力"></div>
      <div class="slide-item" data-text="笑顔あふれる、充実した学校生活。"></div>
      <div class="slide-item" data-text="サレジアン国際学園小学校&#10;星美クラス"></div>

      <div class="hero-caption">
        <p id="caption-text"></p>
      </div>
    </div>
  </main>
</div>

<div class="info-banner-section">
  <div class="info-banner-wrapper">
    <div class="info-banner-inner">
      <button class="slider-arrow prev">
        <span class="material-symbols-outlined">chevron_left</span>
      </button>

      <div class="info-slider-container">
        <div class="info-slider-track">
          <?php
          // briefing: 「トップページ」タームがついたものだけ（フル投稿オブジェクトで取得）
          $_briefing_posts = get_posts([
            'post_type'   => 'briefing',
            'numberposts' => -1,
            'tax_query'   => [[
              'taxonomy' => 'briefing-flag',
              'field'    => 'slug',
              'terms'    => 'top-page',
            ]],
          ]);
          // event: 「トップページ」タームがついたものだけ（フル投稿オブジェクトで取得）
          $_event_posts = get_posts([
            'post_type'   => 'event',
            'numberposts' => -1,
            'tax_query'   => [[
              'taxonomy' => 'event-flag',
              'field'    => 'slug',
              'terms'    => 'top-page',
            ]],
          ]);

          // 日付メタを付加してマージ（briefing_date / event_date）
          $_slide_posts = [];
          foreach ($_briefing_posts as $_p) {
            $_btype = get_post_meta($_p->ID, 'briefing_type', true) ?: 'school';
            $_date_key = ('outside' === $_btype) ? 'outside_date' : 'briefing_date';
            $_slide_posts[] = ['post' => $_p, 'date' => get_post_meta($_p->ID, $_date_key, true)];
          }
          foreach ($_event_posts as $_p) {
            $_slide_posts[] = ['post' => $_p, 'date' => get_post_meta($_p->ID, 'event_date', true)];
          }

          // YYYY-MM-DD 形式で古い順にソート
          usort($_slide_posts, function($a, $b) {
            return strcmp($a['date'], $b['date']);
          });

          // 最大8件
          $_slide_posts = array_slice($_slide_posts, 0, 8);

          global $post;
          if (! empty($_slide_posts)) :
            foreach ($_slide_posts as $_item) :
              $post = $_item['post'];
              setup_postdata($post);
              $post_type = get_post_type();
              $tag_class = ('briefing' === $post_type) ? 'bg-pink' : 'bg-orange';
              $tag_label = ('briefing' === $post_type) ? '説明会' : 'イベント';

              // リンク先URL・外部リンク判定
              $card_url    = '';
              $is_external = false;
              if ( 'briefing' === $post_type ) {
                  $btype     = get_post_meta( get_the_ID(), 'briefing_type', true ) ?: 'school';
                  $type_key  = ( 'outside' === $btype ) ? 'outside_link_type' : 'briefing_link_type';
                  $url_key   = ( 'outside' === $btype ) ? 'outside_link_url'  : 'briefing_link_url';
                  $link_type = get_post_meta( get_the_ID(), $type_key, true ) ?: 'none';
                  if ( $link_type === 'detail' ) {
                      $card_url = get_the_permalink();
                  } elseif ( $link_type === 'external' ) {
                      $card_url    = get_post_meta( get_the_ID(), $url_key, true );
                      $is_external = true;
                  }
                  // 'none' のときは $card_url = '' のままにする
              } else {
                  $ev_link_type = get_post_meta( get_the_ID(), 'event_link_type', true ) ?: 'none';
                  if ( $ev_link_type === 'detail' ) {
                      $card_url    = get_the_permalink();
                      $is_external = false;
                  } elseif ( $ev_link_type === 'external' ) {
                      $card_url    = get_post_meta( get_the_ID(), 'event_link_url', true );
                      $is_external = true;
                  }
                  // 'none' のときは $card_url = '' のままにする
              }
              $link_target = $is_external ? ' target="_blank" rel="noopener noreferrer"' : '';

              // 要予約フラグ
              $res_key     = ( 'briefing' === $post_type ) ? 'briefing_reservation_required' : 'event_reservation_required';
              $is_required = get_post_meta( get_the_ID(), $res_key, true ) === '1';
              $res_label   = $is_required ? '要予約' : '予約不要';
              if ( 'briefing' === $post_type ) {
                  $res_period = $is_required ? get_post_meta( get_the_ID(), 'briefing_web_cancel_period', true ) : '';
              } else {
                  $res_period = get_post_meta( get_the_ID(), 'event_period', true );
              }
          ?>
              <?php if ( $card_url ) : ?>
              <a href="<?php echo esc_url($card_url); ?>"<?php echo $link_target; ?> class="info-card">
              <?php else : ?>
              <div class="info-card">
              <?php endif; ?>
                <div class="card-header">
                  <span class="info-tag <?php echo esc_attr($tag_class); ?>"><?php echo esc_html($tag_label); ?></span>
                  <h4 class="event-title"><?php the_title(); ?></h4>
                </div>
                <div class="card-body">
                  <span class="material-symbols-outlined">calendar_month</span>
                  <span class="event-date"><?php
                    if ( 'briefing' === $post_type ) {
                        $btype = get_post_meta( get_the_ID(), 'briefing_type', true ) ?: 'school';
                        if ( 'outside' === $btype ) {
                            $d = seibi_format_datetime( get_post_meta( get_the_ID(), 'outside_date', true ) );
                            $t = get_post_meta( get_the_ID(), 'outside_time', true );
                        } else {
                            $d = seibi_format_datetime( get_post_meta( get_the_ID(), 'briefing_date', true ) );
                            $t = get_post_meta( get_the_ID(), 'briefing_time', true );
                        }
                    } else {
                        $d = seibi_format_datetime( get_post_meta( get_the_ID(), 'event_date', true ) );
                        $t = get_post_meta( get_the_ID(), 'event_time', true );
                    }
                    echo esc_html( trim( $d . ( $t ? '　' . $t : '' ) ) );
                  ?></span>
                </div>
                <div class="card-footer">
                  <span class="info-tag bg-blue"><?php echo esc_html($res_label); ?></span><?php if ( $res_period ) echo esc_html($res_period); ?>
                </div>
              <?php if ( $card_url ) : ?>
              </a>
              <?php else : ?>
              </div>
              <?php endif; ?>
          <?php
            endforeach;
            wp_reset_postdata();
          endif;
          ?>
        </div>
      </div>

      <button class="slider-arrow next">
        <span class="material-symbols-outlined">chevron_right</span>
      </button>
    </div>
  </div>
</div>

<section class="news news-bg">
  <div class="container">
    <div class="row">
      <div class="col-12 sec-title pink">NEWS & TOPICS</div>
      <div class="news-cate-container">
        <a href="<?php echo esc_url(get_post_type_archive_link('information')); ?>" class="btn-slide btn-s btn-pink">全て</a>
        <a href="<?php echo esc_url(add_query_arg('info_cat','school-life', get_post_type_archive_link('information'))); ?>" class="btn-slide btn-s btn-blue">学校生活</a>
        <a href="<?php echo esc_url(add_query_arg('info_cat','admission', get_post_type_archive_link('information'))); ?>" class="btn-slide btn-s btn-green">入試関連</a>
        <a href="<?php echo esc_url(add_query_arg('info_cat','event', get_post_type_archive_link('information'))); ?>" class="btn-slide btn-s btn-orange">イベント</a>
        <a href="<?php echo esc_url(add_query_arg('info_cat','news', get_post_type_archive_link('information'))); ?>" class="btn-slide btn-s btn-purple">お知らせ</a>
      </div>
    </div>
  </div>
  <div class="news-card-grid">
    <?php
    $news_query = new WP_Query([
      'post_type'      => 'information',
      'posts_per_page' => 8,
      'orderby'        => 'date',
      'order'          => 'DESC',
    ]);
    if ($news_query->have_posts()) :
      while ($news_query->have_posts()) : $news_query->the_post();
        $terms     = get_the_terms(get_the_ID(), 'information-category');
        $term      = ($terms && ! is_wp_error($terms)) ? $terms[0] : null;
        $cat_label = $term ? esc_html($term->name) : '';
        $cat_slug  = $term ? $term->slug : '';
        $bg_map    = [
          'school-life' => 'bg-blue',
          'admission'   => 'bg-green',
          'event'       => 'bg-orange',
          'news'        => 'bg-purple',
        ];
        $cat_class = isset($bg_map[$cat_slug]) ? $bg_map[$cat_slug] : 'bg-blue';
    ?>
        <article class="news-card">
          <a href="<?php the_permalink(); ?>" class="news-card-link">
            <div class="news-card-header">
              <span class="news-date"><?php echo esc_html( get_the_date('Y.m.d') ); ?></span>
              <?php if ($cat_label) : ?>
                <span class="news-category <?php echo esc_attr($cat_class); ?>"><?php echo $cat_label; ?></span>
              <?php endif; ?>
            </div>

            <div class="news-card-image">
              <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('medium', ['alt' => get_the_title()]); ?>
              <?php else : ?>
                <img src="<?php echo get_template_directory_uri(); ?>/img/news_title.svg" alt="<?php the_title_attribute(); ?>" />
              <?php endif; ?>
            </div>

            <div class="news-card-body">
              <h3 class="news-card-title"><?php the_title(); ?></h3>
            </div>
          </a>
        </article>
    <?php
      endwhile;
      wp_reset_postdata();
    endif;
    ?>
  </div>
  <div class="col-12 mb-lg-5 mt-lg-5">
    <a class="btn-slide btn-l btn-pink" href="<?php echo esc_url(get_post_type_archive_link('information')); ?>"><span class="text">NEWS & TOPICS一覧</span></a>
  </div>
</section>

<section class="sec01">
  <div class="container">
    <div class="row justify-content-lg-end justyfy-content-md-center">
      <div class="sec01-col">
        <p>
          子どもを愛するだけではたりません。<br />
          子どもたちが愛されていると<br />
          感じなければなりません。
        </p>
        <span>(ドン・ボスコ)</span>
      </div>
    </div>
  </div>
</section>

<section class="section50 always-bg">
  <div class="container">
    <div class="row">
      <div class="col-12 sec-title pink">星美の予防教育法</div>
    </div>
  </div>
</section>

<section class="gallery-section with-sidebar-offset">
  <div class="container-fluid p-0">
    <div class="row no-gutters">
      <div class="col-md-6 order-1">
        <div class="gallery-item">
          <div class="curtain-overlay"></div>
          <img src="<?php echo get_template_directory_uri(); ?>/img/edu03.webp" loading="lazy" alt="愛情による信頼と理解" />
        </div>
      </div>

      <div class="col-md-6 order-2">
        <div class="gallery-item2">
          <div class="icon-wrapper">
            <img src="<?php echo get_template_directory_uri(); ?>/img/yobou03.svg" class="icon-white" alt="" />
          </div>
        </div>
      </div>

      <div class="col-md-6 order-4 order-md-3">
        <div class="gallery-item2 gallery-bg-p">
          <div class="icon-wrapper">
            <img src="<?php echo get_template_directory_uri(); ?>/img/yobou02.svg" class="icon-white" alt="" />
          </div>
        </div>
      </div>

      <div class="col-md-6 order-3 order-md-4">
        <div class="gallery-item">
          <div class="curtain-overlay curtain-overlay2"></div>
          <img src="<?php echo get_template_directory_uri(); ?>/img/edu02.webp" loading="lazy" alt="共に生きる愛の現存" />
        </div>
      </div>

      <div class="col-md-6 order-5">
        <div class="gallery-item">
          <div class="curtain-overlay curtain-overlay3"></div>
          <img src="<?php echo get_template_directory_uri(); ?>/img/edu01.webp" loading="lazy" alt="祈りと心の喜び" />
        </div>
      </div>

      <div class="col-md-6 order-6">
        <div class="gallery-item2 gallery-bg-g">
          <div class="icon-wrapper">
            <img src="<?php echo get_template_directory_uri(); ?>/img/yobou01.svg" class="icon-white" alt="" />
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="zoom-section">
  <div class="zoom-container">
    <div class="zoom-image-wrapper">
      <img src="<?php echo get_template_directory_uri(); ?>/img/assistenza.webp" loading="lazy" class="zoom-img" alt="アシステンツァ" />
    </div>
    <div class="zoom-text">
      <h2>アシステンツァ</h2>
      <p>子どもたちに安心感と信頼感を</p>
      <div class="col-12">
        <a class="btn-slide btn-l btn-pink" href="<?php echo esc_url(home_url('/feature/assistenza/')); ?>"><span class="text">アシステンツァについて</span></a>
      </div>
    </div>
  </div>
</section>

<section class="school-topics">
  <div class="school-topics-container">
    <a href="<?php echo esc_url(home_url('/feature/english/')); ?>" class="school-topics-box">
      <div class="school-topics-image">
        <img src="<?php echo get_template_directory_uri(); ?>/img/english.webp" loading="lazy" alt="6年間の英語教育" />
      </div>
      <div class="school-topics-content">
        <h3 class="school-topics-title">英語教育</h3>
        <p class="school-topics-text">星美の英語教育は、１年生から６年生までの６年間実施しています。 英語の音に慣れ親しみ、英語で表現する基本的なコミュニケーション能力の育成はもちろん、コミュニケーションを通して海外の文化に目を向け、国際理解の感覚を養うことを大切にしています。</p>
        <div class="btn-slide school-topics-link-ui">詳しく見る</div>
      </div>
    </a>

    <a href="<?php echo esc_url(home_url('/feature/religion/')); ?>" class="school-topics-box">
      <div class="school-topics-image">
        <img src="<?php echo get_template_directory_uri(); ?>/img/shukyo.webp" loading="lazy" alt="宗教教育" />
      </div>
      <div class="school-topics-content">
        <h3 class="school-topics-title">宗教教育</h3>
        <p class="school-topics-text">星美クラスでは、ミッションスクールとしてカトリック教育を土台とした宗教教育を行い、人生の目的と意義を指し示し、神と人との前に誠実な心、人のために奉仕する愛の心を育てる教育活動を展開しています。</p>
        <div class="btn-slide school-topics-link-ui">詳しく見る</div>
      </div>
    </a>

    <a href="<?php echo esc_url(home_url('/feature/currciculum/')); ?>" class="school-topics-box">
      <div class="school-topics-image">
        <img src="<?php echo get_template_directory_uri(); ?>/img/sougou.webp" loading="lazy" alt="総合的な学習" />
      </div>
      <div class="school-topics-content">
        <h3 class="school-topics-title">総合的な学習</h3>
        <p class="school-topics-text">人と自然、人と人の「関わり」を大切にし、「心」と「生きる力」を総合的な学習の中で実体験を通して学んでいきます。</p>
        <div class="btn-slide school-topics-link-ui">詳しく見る</div>
      </div>
    </a>

    <a href="<?php echo esc_url(home_url('/feature/stay/')); ?>" class="school-topics-box">
      <div class="school-topics-image">
        <img src="<?php echo get_template_directory_uri(); ?>/img/shukuhaku.webp" loading="lazy" alt="宿泊学習" />
      </div>
      <div class="school-topics-content">
        <h3 class="school-topics-title">宿泊学習</h3>
        <p class="school-topics-text">各学年の学習テーマ探求のため、テーマに沿った場所で宿泊学習を実施しています。実体験をもとにした正しい価値観、考え方の教育を大切にしています。</p>
        <div class="btn-slide school-topics-link-ui">詳しく見る</div>
      </div>
    </a>
  </div>
</section>

<?php get_footer();
