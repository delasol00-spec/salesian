<?php
/**
 * 入学をお考えの方へ
 * URL: /examinee/
 *
 * @package seibi
 */

get_header(); ?>

<div class="container-fluid p-0">
  <main class="sub-page-view">
    <div class="sub-hero">
      <picture>
        <source media="(max-width: 991px)" srcset="<?php echo get_template_directory_uri(); ?>/img/examinee-img/main-sp.webp" />
        <img src="<?php echo get_template_directory_uri(); ?>/img/examinee-img/main.webp" alt="" class="sub-hero-img" />
      </picture>
    </div>

    <section class="page-title">
      <h1><?php the_title(); ?></h1>
      <div class="inner-border"></div>
    </section>
  </main>
</div>

<section class="p-70-70 bg-white">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 title-box-s">
        <h2 class="col-12 sec-title-pink pink">入試関連情報</h2>
      </div>
      <div class="col-lg-8 col-12 mb-5">
        <?php
        $args = array(
          'post_type'      => 'information',
          'posts_per_page' => 5,
          'orderby'        => 'date',
          'order'          => 'DESC',
        );
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) : ?>
        <ul class="examinee-blog-list">
          <?php while ( $query->have_posts() ) : $query->the_post(); ?>
          <li>
            <time datetime="<?php echo get_the_date( 'Y-m-d' ); ?>"><?php echo get_the_date( 'Y/m/d' ); ?></time>
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
          </li>
          <?php endwhile; ?>
        </ul>
        <?php wp_reset_postdata(); endif; ?>
      </div>
    </div>
  </div>
</section>

<section class="p-70-70">
  <div class="container">
    <div class="row mt30">
      <div class="col-lg-4 col-6 shisetsu shisetsu-blue">
        <a href="<?php echo esc_url( home_url( '/admission/briefing/' ) ); ?>">
          <img src="<?php echo get_template_directory_uri(); ?>/img/examinee-img/setsumeikai.webp" loading="lazy" alt="学校説明会" class="img-fluid" />
        </a>
        <h5>学校説明会</h5>
      </div>

      <div class="col-lg-4 col-6 shisetsu shisetsu-blue">
        <a href="<?php echo esc_url( home_url( '/admission/event/' ) ); ?>">
          <img src="<?php echo get_template_directory_uri(); ?>/img/examinee-img/koukai.webp" loading="lazy" alt="公開行事" class="img-fluid" />
        </a>
        <h5>公開行事</h5>
      </div>

      <div class="col-lg-4 col-6 shisetsu shisetsu-blue">
        <a href="<?php echo esc_url( home_url( '/about/download/' ) ); ?>">
          <img src="<?php echo get_template_directory_uri(); ?>/img/examinee-img/pamph.webp" loading="lazy" alt="パンフレット" class="img-fluid" />
        </a>
        <h5>パンフレット</h5>
      </div>

      <div class="col-lg-4 col-6 shisetsu shisetsu-blue">
        <a href="<?php echo esc_url( home_url( '/admission/requirements/' ) ); ?>">
          <img src="<?php echo get_template_directory_uri(); ?>/img/examinee-img/youkou2026.png" loading="lazy" alt="児童募集要項" class="img-fluid" />
        </a>
        <h5>児童募集要項</h5>
      </div>

      <div class="col-lg-4 col-6 shisetsu shisetsu-blue">
        <a href="<?php echo esc_url( home_url( '/admission/flow/' ) ); ?>">
          <img src="<?php echo get_template_directory_uri(); ?>/img/examinee-img/flow.webp" loading="lazy" alt="入学までの流れ" class="img-fluid" />
        </a>
        <h5>入学までの流れ</h5>
      </div>

      <div class="col-lg-4 col-6 shisetsu shisetsu-blue">
        <a href="<?php echo esc_url( home_url( '/admission/transfer/' ) ); ?>">
          <img src="<?php echo get_template_directory_uri(); ?>/img/examinee-img/tennyu.webp" loading="lazy" alt="編転入について" class="img-fluid" />
        </a>
        <h5>編転入について</h5>
      </div>

      <div class="col-lg-4 col-6 shisetsu shisetsu-blue">
        <a href="<?php echo esc_url( home_url( '/feature/career/' ) ); ?>">
          <img src="<?php echo get_template_directory_uri(); ?>/img/examinee-img/jisseki.webp" loading="lazy" alt="進学実績" class="img-fluid" />
        </a>
        <h5>進学実績</h5>
      </div>

      <div class="col-lg-4 col-6 shisetsu shisetsu-blue">
        <a href="<?php echo esc_url( home_url( '/about/uniform/' ) ); ?>">
          <img src="<?php echo get_template_directory_uri(); ?>/img/examinee-img/seifku.webp" loading="lazy" alt="制服" class="img-fluid" />
        </a>
        <h5>制服</h5>
      </div>
    </div>
  </div>
</section>

<section class="p-70-70 bg-white">
  <div class="container">
    <div class="row justify-content-center">
      <div class="sec-title-pink pink col-12"><h3>卒業生の声</h3></div>

      <div class="col-md-10 col-12">
        <div class="graduate-voice">
          <h3 class="title-s">心に息づく星美の校訓</h3>
          <div class="row">
            <div class="col-lg-3 col-12 graduater">
              <img src="<?php echo get_template_directory_uri(); ?>/img/examinee-img/endo1.webp" loading="lazy" alt="遠藤 歩華" class="img-fluid" />
              <div class="graduater-info">
                <h4>遠藤 歩華</h4>
                <p class="graduate-spec">2015年3月卒業 69期生<br>
                  国際基督教大学 アーツ・サイエンス学科<br>
                  大学院：東京大学言語情報科学専攻、現在修士1年</p>
              </div>
            </div>
            <div class="col-lg-9 col-12">
              <p>私は小学校から高校までの12年間を星美で過ごしました。小学校での6年間は、今に繋がる力、特に心の力を鍛えていただいた気がします。<br>
                4年生の時、約1週間のオーストラリア留学プログラムに参加しました。ホームステイ先では単語をなんとか並べ、身振り手振りでコミュニケーションを取ったことを覚えています。<br>
                また、食事や学校の雰囲気など、「当たり前」が覆された体験でした。日本以外での生活に興味を持ち、高校でも1年間留学をしたのですが、小学生でもどうにかなったという経験が、留学という決断を後押ししてくれた気がします。</p>

              <p>また、聖歌隊での3年間、祈りとともに、熱いご指導を受けながら仲間と切磋琢磨し歌い続けたことも私にとっての宝物です。
                朝練の前やお昼休みにも友達と練習していました。何か一つのことに根気強く挑んだ貴重な時間だったと思います。</p>

              <img src="<?php echo get_template_directory_uri(); ?>/img/examinee-img/endo2.webp" loading="lazy" alt="遠藤 歩華" class="graduate-voice-photo" />

              <p>現在は、海外大学院への進学も視野に入れながら、人間の言語を研究しております。<br>
              今振り返ると、特にしたいことが見つからず学業に励んでいた時期も、留学先で必死だった時も、やりたいことが見つかった現在も、きっとどうにかなるというマインドと根気強さが支えになっていると感じます。<br>
              これからも、「清い心」と「たゆまぬ努力」を忘れずに、日々精進して参ります。</p>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-10 col-12">
        <div class="graduate-voice graduate-voice-blue">
          <h3 class="title-s">卒業生として、親として</h3>
          <div class="row">
            <div class="col-lg-3 col-12 graduater">
              <img src="<?php echo get_template_directory_uri(); ?>/img/examinee-img/uchida1.webp" loading="lazy" alt="内田 亮介" class="img-fluid" />
              <div class="graduater-info">
                <h4>内田 亮介</h4>
                <p class="graduate-spec">1994年3月卒業 48期生<br>
                  信州大学医学部医学科卒業<br>
                  医師</p>
              </div>
            </div>
            <div class="col-lg-9 col-12">
              <p>私は星美学園小学校の卒業生であるとともに2人の子供を通わせる保護者でもあり、３年前からは耳鼻咽喉科の校医を担当しています。妻も星美で同じ６年間を過ごした同級生です。<br>
                長男の入学前に、まだ小さかった次男と妻を家に置き、1人で学校説明会に参加しました。<br>
                卒業以来30年ぶりに上る学校前の師団坂。赤羽駅はだいぶ様変わりしましたが、星美は卒業したときと変わらぬ姿で私を迎えてくれました。<br>
                説明会では私の在校時にはなかった広島平和学習の発表を披露していただき、一生懸命練習したことがすぐに分かる息の合った発表を見ながら、
                『そうそう、これが星美の教育だよね』と１人うなずいていました。<br>
                母校としてのひいき目もあるかもしれませんが、すれ違った生徒さんのしっかりした挨拶にも感心しきり。<br>
                帰りの師団坂では、子供はやはり星美にお願いしようと決めていました。</p>
              <img src="<?php echo get_template_directory_uri(); ?>/img/examinee-img/uchida2.webp" loading="lazy" alt="内田 亮介" class="graduate-voice-photo" />
              <p>我が子を星美に通わせて改めて気づいたのは、私の根底には星美の教育が根付いていることでした。<br>
                校訓である『清い心』は医師としての倫理観、『たゆまぬ努力』は日々更新される新たな治療への自己研鑽につながっています。
                倫理観は仕事に対するプライドと言ってもいいかもしれません。自分自身にプライドを持ち、
                努力を続けられるような教育が今も昔も星美学園小学校にはあると思います。</p>
              <p>私自身、星美学園小学校を卒業できたこと、親として再び星美の教育に触れることができたことに感謝し、一個人として、そして親としても成長していきたいと思っています。</p>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-10 col-12">
        <div class="graduate-voice">
          <h3 class="title-s">共に喜び共に生きた日々</h3>
          <div class="row">
            <div class="col-lg-3 col-12 graduater">
              <img src="<?php echo get_template_directory_uri(); ?>/img/examinee-img/amikura1.webp" loading="lazy" alt="網倉 瑞姫" class="img-fluid" />
              <div class="graduater-info">
                <h4>網倉 瑞姫</h4>
                <p class="graduate-spec">2018年3月卒業 72期生<br>
                  早稲田大学教育学部英語英文科</p>
              </div>
            </div>
            <div class="col-lg-9 col-12">
              <p>卒業して何年経っても、温かさを感じられる場所が星美学園だと思っています。小学校で学んだことは、今後の自分の生き方や価値観に大きく影響すると思いますが、
                その大切な時期を星美学園で過ごすことができて本当に良かったです。</p>

              <p>1年生から始まる英語の授業や宿題、また4年生の時に児童全員で作り上げる英語劇を通して積極的に英語に触れてきたことで、英語の楽しさを知ることができました。
                その影響で大学でも英語を学びたいと思い、英語英文科で学んでいます。英語を好きになったことで、日本だけでなく、世界に目を向ける意識が高まりました。</p>

              <img src="<?php echo get_template_directory_uri(); ?>/img/examinee-img/amikura2.webp" loading="lazy" alt="網倉 瑞姫" class="graduate-voice-photo" />

              <p>私は将来、ニュース番組に携わり、世界中で、目を向けられていない状況で苦しんでいるような人々にも、多くの人の目が向けられる契機となるような報道をしていきたいと考えています。<br>
                そう思うようになったのは、星美学園で英語を好きになったこと、そして星美学園のカトリックの教えを通して、困っている人々の存在を知ろうとする、また助けようと努力する姿勢を身につけることができたからであると感じています。<br>
                星美学園は私の原点が詰まっている場所です。</p>

              <p>先生方も児童ひとりひとりに寄り添ってくださり、親身になって指導してくださいます。<br>
                何年経っても、児童のことを応援し続けてくださる星美の先生方が大好きです。</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php get_footer();
