<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/img/favicon.svg" type="image/svg+xml" />
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?> id="top">
<?php wp_body_open(); ?>

<div id="seibi-splash">
  <div class="splash-img"><img src="<?php echo get_template_directory_uri(); ?>/img/loading.webp" alt="Loading..." /></div>
  <div class="splash-wipe"></div>
</div>

<header class="mobile-header d-lg-none fixed-top">
  <div class="d-flex justify-content-between align-items-center px-3 h-100">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="mobile-logo">
      <img src="<?php echo get_template_directory_uri(); ?>/img/top-logo-sm.svg" alt="Logo" class="header-logo" />
    </a>
    <button class="navbar-toggler-custom" type="button" id="mobileMenuBtn"><span class="bar"></span><span class="bar"></span><span class="bar"></span></button>
  </div>
</header>

<nav class="sidebar" id="sidebarMenu">
  <div id="sidebar-handle">
    <div class="handle-icon-wrapper">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/menu-icon.svg" alt="サレジアン国際学園小学校" class="handle-logo-img" /></a>
      <span class="handle-text">MENU</span>
      <span class="material-symbols-outlined handle-arrow">arrow_right</span>
    </div>
  </div>

  <div class="sidebar-container">
    <div class="sidebar-content">
      <div class="brand-area text-center py-4">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="d-block w-100"><img src="<?php echo get_template_directory_uri(); ?>/img/menu-logo.webp" alt="サレジアン国際学園小学校" class="sidebar-logo" /></a>
        <p class="school-branch-text">星美クラス</p>
      </div>

      <ul class="nav flex-column menu-list" id="sidebarMenuList">
        <li class="nav-item">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav-link">トップページ</a>
        </li>

        <li class="nav-item">
          <a href="#menu-school" class="nav-link" data-toggle="collapse" aria-expanded="false">学校紹介 <span class="arrow">∨</span></a>
          <div class="collapse sub-menu-wrapper" id="menu-school" data-parent="#sidebarMenuList">
            <ul class="sub-menu-list">
              <li><a href="<?php echo esc_url( home_url( '/about/principal/' ) ); ?>" class="nav-link sub-link">校長メッセージ</a></li>
              <li><a href="<?php echo esc_url( home_url( '/about/method/' ) ); ?>" class="nav-link sub-link">建学の精神･教育理念</a></li>
              <li><a href="<?php echo esc_url( home_url( '/about/history/' ) ); ?>" class="nav-link sub-link">星美の歩み</a></li>
              <li><a href="<?php echo esc_url( home_url( '/about/uniform/' ) ); ?>" class="nav-link sub-link">制服</a></li>
              <li><a href="<?php echo esc_url( home_url( '/about/access/' ) ); ?>" class="nav-link sub-link">アクセス</a></li>
              <li><a href="<?php echo esc_url( home_url( '/about/area/' ) ); ?>" class="nav-link sub-link">通学地域</a></li>
              <li><a href="<?php echo esc_url( home_url( '/about/facility/' ) ); ?>" class="nav-link sub-link">施設･設備･環境</a></li>
              <li><a href="<?php echo esc_url( home_url( '/about/security/' ) ); ?>" class="nav-link sub-link">災害･セキュリティ対策</a></li>
              <li><a href="<?php echo esc_url( home_url( '/about/faq/' ) ); ?>" class="nav-link sub-link">よくある質問</a></li>
              <li><a href="<?php echo esc_url( home_url( '/about/download/' ) ); ?>" class="nav-link sub-link">パンフレットダウンロード</a></li>
            </ul>
          </div>
        </li>

        <li class="nav-item">
          <a href="#menu-education" class="nav-link" data-toggle="collapse" aria-expanded="false">星美クラスの教育 <span class="arrow">∨</span></a>
          <div class="collapse sub-menu-wrapper" id="menu-education" data-parent="#sidebarMenuList">
            <ul class="sub-menu-list">
              <li><a href="<?php echo esc_url( home_url( '/feature/characteristics/' ) ); ?>" class="nav-link sub-link">星美クラスの特色</a></li>
              <li><a href="<?php echo esc_url( home_url( '/feature/religion/' ) ); ?>" class="nav-link sub-link">宗教教育</a></li>
              <li><a href="<?php echo esc_url( home_url( '/feature/english/' ) ); ?>" class="nav-link sub-link">6年間の英語教育</a></li>
              <li><a href="<?php echo esc_url( home_url( '/feature/international/' ) ); ?>" class="nav-link sub-link">国際理解教育</a></li>
              <li><a href="<?php echo esc_url( home_url( '/feature/currciculum/' ) ); ?>" class="nav-link sub-link">教科教育</a></li>
              <li><a href="<?php echo esc_url( home_url( '/feature/assistenza/' ) ); ?>" class="nav-link sub-link">アシステンツァ･異学年交流</a></li>
              <li><a href="<?php echo esc_url( home_url( '/feature/barrierfree/' ) ); ?>" class="nav-link sub-link">バリアフリー教育</a></li>
              <li><a href="<?php echo esc_url( home_url( '/feature/stay/' ) ); ?>" class="nav-link sub-link">宿泊体験</a></li>
              <li><a href="<?php echo esc_url( home_url( '/feature/career/' ) ); ?>" class="nav-link sub-link">卒業後の進路</a></li>
            </ul>
          </div>
        </li>

        <li class="nav-item">
          <a href="#menu-life" class="nav-link" data-toggle="collapse" aria-expanded="false">学校生活 <span class="arrow">∨</span></a>
          <div class="collapse sub-menu-wrapper" id="menu-life" data-parent="#sidebarMenuList">
            <ul class="sub-menu-list">
              <li><a href="<?php echo esc_url( home_url( '/life/daily/' ) ); ?>" class="nav-link sub-link">星美クラスの一日</a></li>
              <li><a href="<?php echo esc_url( home_url( '/life/year/' ) ); ?>" class="nav-link sub-link">年間行事</a></li>
              <li><a href="<?php echo esc_url( home_url( '/life/activity/' ) ); ?>" class="nav-link sub-link">委員会･クラブ活動</a></li>
              <li><a href="<?php echo esc_url( home_url( '/life/music-club/' ) ); ?>" class="nav-link sub-link">特別音楽クラブ</a></li>
              <li><a href="<?php echo esc_url( home_url( '/life/after-school/' ) ); ?>" class="nav-link sub-link">サレジアンアフタースクール</a></li>
              <li><a href="<?php echo esc_url( home_url( '/life/cooperation/' ) ); ?>" class="nav-link sub-link">家庭との連携･協力</a></li>
            </ul>
          </div>
        </li>

        <li class="nav-item menu-admission">
          <a href="#menu-admission" class="nav-link" data-toggle="collapse" aria-expanded="false">入試について <span class="arrow">∨</span></a>
          <div class="collapse sub-menu-wrapper" id="menu-admission" data-parent="#sidebarMenuList">
            <ul class="sub-menu-list">
              <li><a href="<?php echo esc_url( home_url( '/admission/requirements/' ) ); ?>" class="nav-link sub-link">児童募集要項</a></li>
              <li><a href="<?php echo esc_url( home_url( '/admission/flow/' ) ); ?>" class="nav-link sub-link">入学までの流れ</a></li>
              <li><a href="<?php echo esc_url( home_url( '/admission/briefing/' ) ); ?>" class="nav-link sub-link">学校説明会･学外説明会</a></li>
              <li><a href="<?php echo esc_url( home_url( '/admission/event/' ) ); ?>" class="nav-link sub-link">公開行事</a></li>
              <li><a href="<?php echo esc_url( home_url( '/admission/transfer/' ) ); ?>" class="nav-link sub-link">編転入について</a></li>
            </ul>
          </div>
        </li>
      </ul>

      <div class="mobile-utility px-3 mt-4">
        <div class="d-flex justify-content-between">
          <a href="<?php echo esc_url( home_url( '/about/faq/' ) ); ?>" class="btn-slide-r btn-ss btn-pink-r">FAQ</a>
          <a href="<?php echo esc_url( home_url( '/about/access/' ) ); ?>" class="btn-slide-r btn-ss btn-pink-r">アクセス</a>
          <a href="<?php echo esc_url( home_url( '/about/download/' ) ); ?>" class="btn-slide-r btn-ss btn-pink-r">ダウンロード</a>
        </div>
      </div>

      <div class="button-group px-3 mt-4 pb-5">
        <div class="inter-banner position-relative">
          <img src="<?php echo get_template_directory_uri(); ?>/img/to-inter.webp" class="img-fluid" alt="サレジアン国際学園" />
          <a href="https://www.salesian.international.seibi.ac.jp/" target="_blank" class="stretched-link"></a>
        </div>
      </div>
    </div>
  </div>
</nav>

<div id="sidebar-overlay"></div>
