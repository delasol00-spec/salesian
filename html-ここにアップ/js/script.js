// GSAPプラグインを最初に一度だけ登録
gsap.registerPlugin(ScrollTrigger);

$(document).ready(function () {
  const $sidebar = $("#sidebarMenu");
  const $mobileBtn = $("#mobileMenuBtn");
  const $overlay = $("#sidebar-overlay");
  let isLocked = false;

  // --- 1. 初期状態のクリア ---
  // スマホの時はPC用の隠しクラスを最初から持たせない
  if (window.innerWidth <= 991) {
    $sidebar.removeClass("is-hidden");
  }

  // --- 2. PC用コントロール（992px以上のみ動作） ---
  function isPC() {
    return window.innerWidth >= 992;
  }

  $sidebar
    .on("mouseenter", function () {
      if (isPC()) $sidebar.removeClass("is-hidden");
    })
    .on("mouseleave", function () {
      if (isPC() && !isLocked && $(window).scrollTop() > 50) {
        $sidebar.addClass("is-hidden");
      }
    });

  $("#sidebar-handle").on("click", function (e) {
    if (isPC()) {
      e.stopPropagation();
      isLocked = !isLocked;
      $(this).css("background-color", isLocked ? "#d44d64" : "");
      if (isLocked) $sidebar.removeClass("is-hidden");
    }
  });

  $(window).on("scroll", function () {
    if (isPC() && !isLocked) {
      if ($(window).scrollTop() > 50) {
        $sidebar.addClass("is-hidden");
      } else {
        $sidebar.removeClass("is-hidden");
      }
    }
  });

  // --- 3. スマホ用コントロール（991px以下のみ動作） ---
  $("#mobileMenuBtn, #sidebar-overlay").on("click", function (e) {
    if (window.innerWidth <= 991) {
      e.preventDefault();

      // スマホ時はPC用のクラスを完全に排除
      $sidebar.removeClass("is-hidden");

      const isOpen = $sidebar.hasClass("active");
      if (!isOpen) {
        $sidebar.addClass("active");
        $mobileBtn.addClass("active");
        $overlay.stop().fadeIn(300);
        $("body").css("overflow", "hidden");
      } else {
        $sidebar.removeClass("active");
        $mobileBtn.removeClass("active");
        $overlay.stop().fadeOut(300);
        $("body").css("overflow", "");
      }
    }
  });

  // --- 4. スライドショー・トップへ戻る（共通機能） ---
  // (ここには以前のスライドショーやトップへ戻るボタンのコードをそのまま入れてください)
  const slides = $(".slideshow .slide-item");
  const captionTextElement = $("#caption-text");
  let currentSlideIndex = 0;
  function updateCaption() {
    if (slides.length > 0) {
      const currentCaption = slides.eq(currentSlideIndex).data("text");
      captionTextElement.text(currentCaption);
      currentSlideIndex = (currentSlideIndex + 1) % slides.length;
    }
  }
  updateCaption();
  setInterval(updateCaption, 5000);

  const $backToTop = $(".pagetop-container");
  $(window).on("scroll", function () {
    if ($(window).scrollTop() > 600) {
      $backToTop.addClass("show");
    } else {
      $backToTop.removeClass("show");
    }
  });
  $backToTop.on("click", function () {
    $("html, body").animate({ scrollTop: 0 }, 600, "swing");
  });

  // --- 5. 現在地のアコーディオン自動展開（再々修正版） ---
  // URLを正規化して比較しやすくする関数
  const normalize = (url) => {
    try {
      url = decodeURIComponent(url); // 日本語ファイル名などの文字化け対応
    } catch (e) {}
    // ハッシュやクエリパラメータを除去し、末尾の / index.html .html を削除
    return url
      .split("#")[0]
      .split("?")[0]
      .replace(/\/index\.html$/, "")
      .replace(/\/$/, "")
      .replace(/\.html$/, "");
  };

  // 現在のページの絶対URLを正規化
  const currentUrl = normalize(window.location.href);
  const currentPath = normalize(window.location.pathname);

  $sidebar.find("a").each(function () {
    const $link = $(this);
    const hrefAttr = $link.attr("href");

    // アコーディオンの開閉ボタン（data-toggle="collapse"）は除外
    if ($link.attr("data-toggle") === "collapse") {
      return;
    }

    // 無効なリンク、および「#」から始まるリンクは無視
    // ※ href="#" のままだと、すべての「#」リンクが「現在地」と判定されてしまうため
    if (!hrefAttr || hrefAttr.startsWith("#") || hrefAttr.startsWith("javascript:")) {
      return;
    }

    // リンク先のパスとURLを取得
    const linkUrl = normalize(this.href);
    const linkPath = normalize(this.pathname);

    // 判定：完全一致 または パスが末尾一致（絶対パス記述対策）
    let isMatch = false;
    if (linkUrl === currentUrl) {
      isMatch = true;
    } else if (linkPath !== "" && currentPath.endsWith(linkPath)) {
      isMatch = true;
    }

    if (isMatch) {
      $link.addClass("current-active");

      // 親のアコーディオンを展開
      const $parentCollapse = $link.closest(".collapse");
      if ($parentCollapse.length) {
        $parentCollapse.addClass("show");

        // このアコーディオンを操作するトリガーボタンの状態も更新（矢印の向きなど）
        const triggerId = $parentCollapse.attr("id");
        if (triggerId) {
          // href="#id" または data-target="#id" で指定されているトリガーを探す
          const $trigger = $sidebar.find(`[data-toggle="collapse"][href="#${triggerId}"], [data-toggle="collapse"][data-target="#${triggerId}"]`);
          $trigger.attr("aria-expanded", "true");
          $trigger.removeClass("collapsed");
          $trigger.closest(".nav-item").addClass("open"); // 矢印操作用クラス
        }
      }
    }
  });

  // --- 6. ページ内リンクのスムーススクロール ---
  $('a[href^="#"]')
    .not('.top-link, [data-toggle="collapse"]')
    .on("click", function (e) {
      const href = $(this).attr("href");
      const $target = $(href === "#" || href === "" ? "html" : href);

      if ($target.length) {
        e.preventDefault();

        // スクロール先の位置調整（スマホヘッダーがある場合はその分を引く）
        const headerHeight = window.innerWidth <= 991 ? 60 : 0;
        const position = $target.offset().top - headerHeight;

        $("html, body").stop().animate(
          {
            scrollTop: position,
          },
          800,
          "swing",
        ); // 0.8秒かけて移動
      }
    });
});

// スルスル戻る動き（上段のボタンをクリックした時）
$(".top-link").on("click", function (e) {
  e.preventDefault();

  // 以前の指定より少し時間を延ばし、動きを滑らかにします
  $("html, body").animate(
    { scrollTop: 0 },
    {
      duration: 1000 /* 1秒かけて戻る */,
      easing: "swing" /* 標準のswingでも時間を伸ばすと最後がゆっくり感じられます */,
    },
  );
});

// トップページにのみ存在する要素のアニメーションを、要素がある場合のみ実行する
if ($(".zoom-section").length) {
  ScrollTrigger.matchMedia({
    "(min-width: 992px)": function () {
      const tl = gsap.timeline({
        scrollTrigger: {
          trigger: ".zoom-section",
          start: "top bottom",
          end: "bottom bottom",
          scrub: 1,
        },
      });

      tl.fromTo(
        ".zoom-image-wrapper",
        {
          width: "50%",
          height: "50vh",
          x: 0,
        },
        {
          width: "calc(100% - 155px)",
          height: "calc(100vh - 100px)",
          x: "27.5px",
          borderRadius: "10px",
          ease: "none",
        },
      )
        .to(
          ".zoom-img",
          {
            scale: 1,
            ease: "none",
          },
          "<",
        )
        .to({}, { duration: 0 })
        .fromTo(".zoom-text", { opacity: 0, y: 50 }, { opacity: 1, y: 0, duration: 0.4, ease: "power2.out" }, "-=0.1")
        .to({}, { duration: 0.3 });
    },
  });
}

if ($(".gallery-section").length) {
  ScrollTrigger.matchMedia({
    "(min-width: 992px)": function () {
      const items = document.querySelectorAll(".gallery-item");

      items.forEach((item) => {
        const overlay = item.querySelector(".curtain-overlay");
        const img = item.querySelector("img");

        const tl = gsap.timeline({
          scrollTrigger: {
            trigger: item,
            start: "top 85%",
            toggleActions: "play none none reverse",
          },
        });

        tl.to(overlay, {
          scaleX: 0,
          transformOrigin: "right",
          duration: 1.2,
          ease: "power2.inOut",
        }).to(
          img,
          {
            scale: 1,
            duration: 1.2,
            ease: "power2.out",
          },
          "<",
        );
      });
    },
  });

  // SVGアイコンのボワッと表示アニメーション（全デバイス共通）
  const iconItems = document.querySelectorAll(".gallery-item2");
  iconItems.forEach((item) => {
    const icon = item.querySelector(".icon-white");
    if (icon) {
      gsap.fromTo(
        icon,
        {
          opacity: 0,
          scale: 0.5, // 少し小さい状態から
          filter: "blur(10px)", // ぼかしを入れて「ボワッと」感を演出
        },
        {
          opacity: 1,
          scale: 1,
          filter: "blur(0px)",
          duration: 1.2,
          ease: "power2.out",
          scrollTrigger: {
            trigger: item,
            start: "top 80%", // 画面の下の方に入ってきたら開始
            toggleActions: "play none none reverse", // スクロールバックで戻った時にリセット
          },
        },
      );
    }
  });
}

/* 説明会情報スライダー（トップページにのみ存在） */
if ($(".info-slider-track").length > 0) {
  const $track = $(".info-slider-track");
  const $cards = $(".info-card");
  const $prevBtn = $(".slider-arrow.prev");
  const $nextBtn = $(".slider-arrow.next");
  let cardIndex = 0;

  function updateSliderVisibility() {
    let visibleCount = window.innerWidth > 1199 ? 3 : window.innerWidth > 767 ? 2 : 1;

    if ($cards.length <= visibleCount) {
      $track.addClass("is-centered");
      $prevBtn.addClass("is-hidden");
      $nextBtn.addClass("is-hidden");
    } else {
      $track.removeClass("is-centered");
      $prevBtn.removeClass("is-hidden");
      $nextBtn.removeClass("is-hidden");
    }
  }
  function moveSlider() {
    let visibleCount = window.innerWidth > 1199 ? 3 : window.innerWidth > 767 ? 2 : 1;

    if ($cards.length <= visibleCount) {
      $track.css("transform", "translateX(0)");
      return;
    }

    const cardWidth = $cards.outerWidth();
    const gap = parseFloat($track.css("gap")) || 0;
    const moveDistance = (cardWidth + gap) * cardIndex;
    $track.css("transform", `translateX(-${moveDistance}px)`);
  }

  $nextBtn.on("click", function () {
    let visibleCount = window.innerWidth > 1199 ? 3 : window.innerWidth > 767 ? 2 : 1;
    if (cardIndex < $cards.length - visibleCount) {
      cardIndex++;
    } else {
      cardIndex = 0;
    }
    moveSlider();
  });

  $prevBtn.on("click", function () {
    let visibleCount = window.innerWidth > 1199 ? 3 : window.innerWidth > 767 ? 2 : 1;
    if (cardIndex > 0) {
      cardIndex--;
    } else {
      cardIndex = $cards.length - visibleCount;
    }
    moveSlider();
  });

  let touchStartX = 0;
  let touchMoveX = 0;

  $(".info-slider-container").on("touchstart", function (e) {
    touchStartX = e.originalEvent.touches[0].clientX;
    touchMoveX = 0;
  });

  $(".info-slider-container").on("touchmove", function (e) {
    touchMoveX = e.originalEvent.touches[0].clientX;
  });

  $(".info-slider-container").on("touchend", function (e) {
    if (window.innerWidth > 992) return;
    if (touchMoveX === 0) return;

    const diff = touchStartX - touchMoveX;
    if (Math.abs(diff) > 50) {
      if (diff > 0) {
        $nextBtn.trigger("click");
      } else {
        $prevBtn.trigger("click");
      }
    }
  });

  $(window).on("resize", function () {
    updateSliderVisibility();
    moveSlider();
  });
  updateSliderVisibility();
}
