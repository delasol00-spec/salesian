// GSAPプラグインを最初に一度だけ登録
gsap.registerPlugin(ScrollTrigger);

$(document).ready(function () {
  const $mobileBtn = $("#mobileMenuBtn");
  const $overlay = $("#sidebar-overlay");
  let isLocked = false;
  const getSidebar = () => $("#sidebarMenu");

  /** サイドバー／フッター現在地判定で共通利用 */
  function normalizeUrlForCompare(url) {
    try {
      url = decodeURIComponent(url);
    } catch (e) {}
    return url
      .split("#")[0]
      .split("?")[0]
      .replace(/\/index\.html$/, "")
      .replace(/\/$/, "")
      .replace(/\.html$/, "");
  }

  function initBackToTop() {
    const $backToTop = $(".pagetop-container");
    if ($backToTop.length === 0) return;

    $(window)
      .off("scroll.backToTop")
      .on("scroll.backToTop", function () {
        if ($(window).scrollTop() > 600) {
          $backToTop.addClass("show");
        } else {
          $backToTop.removeClass("show");
        }
      });

    $backToTop.off("click.backToTop").on("click.backToTop", function () {
      $("html, body").animate({ scrollTop: 0 }, 600, "swing");
    });

    // 初期表示状態も反映
    $(window).triggerHandler("scroll.backToTop");
  }

  function applyCurrentNavState() {
    const $sidebar = getSidebar();
    if ($sidebar.length === 0) return;

    // --- 5. 現在地のアコーディオン自動展開（再々修正版） ---
    // 現在のページの絶対URLを正規化
    const currentUrl = normalizeUrlForCompare(window.location.href);
    const currentPath = normalizeUrlForCompare(window.location.pathname);

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
      const linkUrl = normalizeUrlForCompare(this.href);
      const linkPath = normalizeUrlForCompare(this.pathname);

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
  }

  /** フッターサイトマップの現在ページリンクに .active を付与 */
  function applyFooterSitemapActive() {
    const $links = $(".seibi-footer .sitemap-links a");
    if ($links.length === 0) return;

    $links.removeClass("active");

    const currentUrl = normalizeUrlForCompare(window.location.href);
    const currentPath = normalizeUrlForCompare(window.location.pathname);

    $links.each(function () {
      const hrefAttr = $(this).attr("href");
      if (!hrefAttr || hrefAttr.startsWith("#") || hrefAttr.startsWith("javascript:")) {
        return;
      }

      const linkUrl = normalizeUrlForCompare(this.href);
      const linkPath = normalizeUrlForCompare(this.pathname);

      let isMatch = false;
      if (linkUrl === currentUrl) {
        isMatch = true;
      } else if (linkPath !== "" && currentPath.endsWith(linkPath)) {
        isMatch = true;
      }

      if (isMatch) {
        $(this).addClass("active");
      }
    });
  }

  /**
   * 現在ページから seibi ルートまでの相対（../）を返す。
   * footer/side-menu 内の「seibi 直下相対」リンクを、深い階層からも正しく辿れるようにする。
   */
  function getIncludePrefix() {
    const pathname = decodeURIComponent(window.location.pathname || "");
    const marker = "/seibi/";
    const idx = pathname.indexOf(marker);

    if (idx !== -1) {
      let rest = pathname.slice(idx + marker.length);
      if (!rest) return "";
      const segments = rest.split("/").filter(Boolean);
      if (segments.length === 0) return "";
      const lastSeg = segments[segments.length - 1];
      const isFile = lastSeg.includes(".");
      const depth = isFile ? segments.length - 1 : segments.length;
      return "../".repeat(Math.max(0, depth));
    }

    // フォールバック（marker が無い環境・旧ロジック）
    const pathParts = pathname.split("/").filter(Boolean);
    const seibiIndex = pathParts.lastIndexOf("seibi");
    const afterSeibi = seibiIndex >= 0 ? pathParts.slice(seibiIndex + 1) : pathParts;
    const isDirectoryUrl = pathname.endsWith("/");
    const depth = Math.max(0, afterSeibi.length - (isDirectoryUrl ? 0 : 1));
    return "../".repeat(depth);
  }

  function rewriteRelativeLinks(containerEl) {
    const prefix = getIncludePrefix();
    if (!prefix) return;

    const shouldSkip = (v) =>
      !v ||
      v.startsWith("#") ||
      v.startsWith("/") ||
      v.startsWith("./") ||
      v.startsWith("../") ||
      v.startsWith("http://") ||
      v.startsWith("https://") ||
      v.startsWith("mailto:") ||
      v.startsWith("tel:") ||
      v.startsWith("javascript:");

    containerEl.querySelectorAll("[href]").forEach((node) => {
      const v = node.getAttribute("href");
      if (shouldSkip(v)) return;
      node.setAttribute("href", prefix + v);
    });

    containerEl.querySelectorAll("[src]").forEach((node) => {
      const v = node.getAttribute("src");
      if (shouldSkip(v)) return;
      node.setAttribute("src", prefix + v);
    });
  }

  function loadTextViaXHR(url) {
    return new Promise((resolve, reject) => {
      const xhr = new XMLHttpRequest();
      xhr.open("GET", url, true);
      xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
          resolve(xhr.responseText);
        } else {
          reject(new Error("HTTP " + xhr.status));
        }
      };
      xhr.onerror = function () {
        reject(new Error("network"));
      };
      xhr.send();
    });
  }

  async function loadPartial(el) {
    const includePath = el.getAttribute("data-include");
    if (!includePath) return;

    const resolvedUrl = new URL(includePath, window.location.href).href;

    let html = null;
    try {
      const res = await fetch(resolvedUrl, { cache: "no-cache" });
      if (!res.ok) {
        throw new Error("HTTP " + res.status);
      }
      html = await res.text();
    } catch (e1) {
      try {
        html = await loadTextViaXHR(resolvedUrl);
      } catch (e2) {
        console.warn(
          "[include] 読み込み失敗（file:// で直開きの場合は fetch/XHR とも不可なことがあります。`python3 -m http.server` 等で http 表示してください）",
          resolvedUrl,
          e1,
        );
        return;
      }
    }

    el.innerHTML = html;
    rewriteRelativeLinks(el);
  }

  async function loadPartialsIfNeeded() {
    const targets = Array.from(document.querySelectorAll("[data-include]"));
    if (targets.length === 0) return;
    await Promise.all(targets.map((el) => loadPartial(el)));
  }

  function isPC() {
    return window.innerWidth >= 992;
  }

  function isTopPage() {
    const path = window.location.pathname || "";
    return path.endsWith("/seibi/") || path.endsWith("/seibi/index.html");
  }

  function isPageBottom(buffer = 400) {
    const scrollableHeight = document.documentElement.scrollHeight - window.innerHeight;
    // スクロール余地が少ないページでは途中判定を避ける
    if (scrollableHeight <= buffer) return false;
    return window.scrollY >= scrollableHeight - buffer;
  }

  function initSidebarControls() {
    const $sidebar = getSidebar();
    if ($sidebar.length === 0) return;

    // --- 1. 初期状態のクリア ---
    if (window.innerWidth <= 991) {
      $sidebar.removeClass("is-hidden");
    }

    // --- 2. PC用コントロール（992px以上のみ動作） ---
    $(document)
      .off("mouseenter.sidebarPC", "#sidebarMenu")
      .on("mouseenter.sidebarPC", "#sidebarMenu", function () {
        if (isPC()) getSidebar().removeClass("is-hidden");
      })
      .off("mouseleave.sidebarPC", "#sidebarMenu")
      .on("mouseleave.sidebarPC", "#sidebarMenu", function () {
        if (isPC() && !isLocked && $(window).scrollTop() > 50) {
          // 非トップページでは最下部時は表示を維持
          if (!isTopPage() && isPageBottom()) {
            getSidebar().removeClass("is-hidden");
          } else {
            getSidebar().addClass("is-hidden");
          }
        }
      })
      .off("click.sidebarHandle", "#sidebar-handle")
      .on("click.sidebarHandle", "#sidebar-handle", function (e) {
        if (isPC()) {
          e.stopPropagation();
          isLocked = !isLocked;
          $(this).css("background-color", isLocked ? "#d44d64" : "");
          if (isLocked) getSidebar().removeClass("is-hidden");
        }
      });

    $(window)
      .off("scroll.sidebarAutoHide")
      .on("scroll.sidebarAutoHide", function () {
        if (isPC() && !isLocked) {
          if (!isTopPage() && isPageBottom()) {
            // 非トップページは最下部到達時に自動表示
            getSidebar().removeClass("is-hidden");
          } else if ($(window).scrollTop() > 50) {
            getSidebar().addClass("is-hidden");
          } else {
            // トップページだけ上部で表示、それ以外は上部でも閉じた状態
            if (isTopPage()) {
              getSidebar().removeClass("is-hidden");
            } else {
              getSidebar().addClass("is-hidden");
            }
          }
        }
      });

    // 初期表示状態をスクロール位置に合わせて反映
    if (isPC() && !isLocked) {
      if (!isTopPage()) {
        if (isPageBottom()) {
          $sidebar.removeClass("is-hidden");
        } else {
          $sidebar.addClass("is-hidden");
        }
      } else {
        $sidebar.removeClass("is-hidden");
      }
    }

    // --- 3. スマホ用コントロール（991px以下のみ動作） ---
    $("#mobileMenuBtn, #sidebar-overlay")
      .off("click.sidebarMobile")
      .on("click.sidebarMobile", function (e) {
        if (window.innerWidth <= 991) {
          e.preventDefault();

          const $sidebarNow = getSidebar();
          if ($sidebarNow.length === 0) return;

          // スマホ時はPC用のクラスを完全に排除
          $sidebarNow.removeClass("is-hidden");

          const isOpen = $sidebarNow.hasClass("active");
          if (!isOpen) {
            $sidebarNow.addClass("active");
            $mobileBtn.addClass("active");
            $overlay.stop().fadeIn(300);
            $("body").css("overflow", "hidden");
          } else {
            $sidebarNow.removeClass("active");
            $mobileBtn.removeClass("active");
            $overlay.stop().fadeOut(300);
            $("body").css("overflow", "");
          }
        }
      });
  }

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
  initBackToTop();
  initSidebarControls();

  // --- 5. 外部HTML（サイドバー/フッター等）読み込み→現在地反映 ---
  loadPartialsIfNeeded().finally(() => {
    try {
      initSidebarControls();
      applyCurrentNavState();
      applyFooterSitemapActive();
      initBackToTop();
    } catch (e) {
      console.warn("[include] 初期化エラー", e);
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
$(document).on("click", ".top-link", function (e) {
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
  let autoSlideTimer = null;

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

  function goNext() {
    let visibleCount = window.innerWidth > 1199 ? 3 : window.innerWidth > 767 ? 2 : 1;
    if (cardIndex < $cards.length - visibleCount) {
      cardIndex++;
    } else {
      cardIndex = 0;
    }
    moveSlider();
  }

  function goPrev() {
    let visibleCount = window.innerWidth > 1199 ? 3 : window.innerWidth > 767 ? 2 : 1;
    if (cardIndex > 0) {
      cardIndex--;
    } else {
      cardIndex = $cards.length - visibleCount;
    }
    moveSlider();
  }

  function startAutoSlide() {
    if (autoSlideTimer) {
      clearInterval(autoSlideTimer);
    }
    autoSlideTimer = setInterval(goNext, 7000);
  }

  $nextBtn.on("click", function () {
    goNext();
    startAutoSlide();
  });

  $prevBtn.on("click", function () {
    goPrev();
    startAutoSlide();
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
        goNext();
      } else {
        goPrev();
      }
      startAutoSlide();
    }
  });

  $(window).on("resize", function () {
    updateSliderVisibility();
    moveSlider();
  });
  updateSliderVisibility();
  moveSlider();
  startAutoSlide();
}
