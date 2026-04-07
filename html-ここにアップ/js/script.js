/**
 * script.js — サレジアン国際学園小学校 星美クラス 共通スクリプト
 *
 * 依存: jQuery 3.x, Bootstrap 4.x (アコーディオン), GSAP + ScrollTrigger (トップページのみ)
 *
 * ブレイクポイント
 *   PC / iPad横画面 : 992px 以上 → ピンク帯 + ドロワーメニュー
 *   iPad縦 / スマホ  : 991px 以下 → 青ヘッダー + ハンバーガー
 */
(function ($) {
  "use strict";

  /* ============================================================
   * 定数
   * ============================================================ */
  var BP = 992; // CSS と Bootstrap lg ブレイクポイントに合わせる

  /* ============================================================
   * ユーティリティ
   * ============================================================ */

  function isPC() {
    return window.innerWidth >= BP;
  }

  function isTopPage() {
    var p = window.location.pathname || "";
    return p.endsWith("/seibi/") || p.endsWith("/seibi/index.html");
  }

  function isPageBottom(buffer) {
    buffer = buffer !== undefined ? buffer : 400;
    var scrollable = document.documentElement.scrollHeight - window.innerHeight;
    if (scrollable <= buffer) return true;
    return window.scrollY >= scrollable - buffer;
  }

  function debounce(fn, ms) {
    var t;
    return function () {
      clearTimeout(t);
      t = setTimeout(fn, ms);
    };
  }

  function normalizeUrl(url) {
    try { url = decodeURIComponent(url); } catch (e) {}
    return url
      .split("#")[0].split("?")[0]
      .replace(/\/index\.html$/, "")
      .replace(/\/$/, "")
      .replace(/\.html$/, "");
  }

  /* ============================================================
   * data-include パーシャル読み込み
   * ============================================================ */

  function getIncludePrefix() {
    var pathname = decodeURIComponent(window.location.pathname || "");
    var marker = "/seibi/";
    var idx = pathname.indexOf(marker);

    if (idx !== -1) {
      var rest = pathname.slice(idx + marker.length);
      if (!rest) return "";
      var segs = rest.split("/").filter(Boolean);
      if (!segs.length) return "";
      var isFile = segs[segs.length - 1].includes(".");
      var depth = isFile ? segs.length - 1 : segs.length;
      return "../".repeat(Math.max(0, depth));
    }

    // フォールバック
    var parts = pathname.split("/").filter(Boolean);
    var si = parts.lastIndexOf("seibi");
    var after = si >= 0 ? parts.slice(si + 1) : parts;
    var d = Math.max(0, after.length - (pathname.endsWith("/") ? 0 : 1));
    return "../".repeat(d);
  }

  function rewriteRelativeLinks(container) {
    var prefix = getIncludePrefix();
    if (!prefix) return;

    function skip(v) {
      return !v || v.startsWith("#") || v.startsWith("/") || v.startsWith("./") ||
        v.startsWith("../") || /^https?:/.test(v) || /^(mailto|tel|javascript):/.test(v);
    }
    container.querySelectorAll("[href]").forEach(function (el) {
      var v = el.getAttribute("href");
      if (!skip(v)) el.setAttribute("href", prefix + v);
    });
    container.querySelectorAll("[src]").forEach(function (el) {
      var v = el.getAttribute("src");
      if (!skip(v)) el.setAttribute("src", prefix + v);
    });
  }

  function loadPartial(el) {
    var path = el.getAttribute("data-include");
    if (!path) return Promise.resolve();

    var url = new URL(path, window.location.href).href;

    function doFetch() {
      return fetch(url, { cache: "no-cache" }).then(function (res) {
        if (!res.ok) throw new Error("HTTP " + res.status);
        return res.text();
      });
    }

    function doXhr() {
      return new Promise(function (resolve, reject) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", url, true);
        xhr.onload = function () {
          if (xhr.status >= 200 && xhr.status < 300) resolve(xhr.responseText);
          else reject(new Error("XHR " + xhr.status));
        };
        xhr.onerror = reject;
        xhr.send();
      });
    }

    return doFetch()
      .catch(function () { return doXhr(); })
      .then(function (html) {
        el.innerHTML = html;
        rewriteRelativeLinks(el);
      })
      .catch(function (err) {
        console.warn("[include] 読み込み失敗:", url, err);
      });
  }

  function loadPartialsIfNeeded() {
    var targets = Array.from(document.querySelectorAll("[data-include]"));
    if (!targets.length) return Promise.resolve();
    return Promise.all(targets.map(loadPartial));
  }

  /* ============================================================
   * サイドバー / メニュー制御
   * ============================================================ */

  var menuLocked = false; // PC: クリックでピン留め中

  function getSidebar() {
    return document.getElementById("sidebarMenu");
  }

  /* --- PC 専用 ------------------------------------------------ */

  /**
   * メニューを開く。pinned=true のときオーバーレイも表示。
   */
  function openSidebarPC(pinned) {
    var sb = getSidebar();
    if (!sb) return;
    sb.classList.remove("is-hidden");
    if (pinned) {
      document.body.classList.add("menu-open");
    }
  }

  /**
   * メニューを閉じる（is-hidden を付与）。
   */
  function closeSidebarPC() {
    var sb = getSidebar();
    if (!sb) return;
    sb.classList.add("is-hidden");
    menuLocked = false;
    document.body.classList.remove("menu-open");
    // ハンドル背景色をリセット
    var handle = document.getElementById("sidebar-handle");
    if (handle) handle.style.backgroundColor = "";
  }

  /**
   * スクロール位置に応じて is-hidden を切り替える（ロック中は無視）。
   */
  function updateSidebarOnScroll() {
    if (!isPC()) return;
    var sb = getSidebar();
    if (!sb) return;

    if (isPageBottom()) {
      // ページ最下部では展開して次のページへ誘導
      sb.classList.remove("is-hidden");
    } else if (window.scrollY > 50) {
      sb.classList.add("is-hidden");
    } else {
      // トップページのみ上部で展開、下層ページは格納
      if (isTopPage()) sb.classList.remove("is-hidden");
      else sb.classList.add("is-hidden");
    }
  }

  /* --- モバイル専用 ------------------------------------------- */

  function openSidebarMobile() {
    var sb = getSidebar();
    var btn = document.getElementById("mobileMenuBtn");
    if (!sb) return;
    sb.classList.remove("is-hidden"); // PCクラスが残っていても安全
    sb.classList.add("active");
    if (btn) btn.classList.add("active");
    document.body.classList.add("menu-open");
    document.body.style.overflow = "hidden"; // スクロールロック
  }

  function closeSidebarMobile() {
    var sb = getSidebar();
    var btn = document.getElementById("mobileMenuBtn");
    if (sb) sb.classList.remove("active");
    if (btn) btn.classList.remove("active");
    document.body.classList.remove("menu-open");
    document.body.style.overflow = "";
  }

  /* --- イベント登録（全体） ------------------------------------ */

  function initMenuControls() {

    /* ── PC: ピンク帯タップ / クリック ────────────────────── */
    // ① touchend: iOS Safari の 300ms 遅延をなくすためタッチ端末はこちらで即時処理。
    //    e.preventDefault() で続けて発火する ghost click をキャンセルする。
    // ② click:    デスクトップ用フォールバック（touch 非対応端末ではこちらのみ発火）。
    //    touchend で処理済みの場合は click は来ないので二重発火しない。
    function handlePinkBand(e) {
      if (!isPC()) return;
      e.preventDefault();
      e.stopPropagation();
      e.stopImmediatePropagation();

      var sb = getSidebar();
      if (!sb) return;

      if (sb.classList.contains("is-hidden")) {
        // 閉 → 開（オーバーレイなし: PC / iPad横画面ではオーバーレイ不要）
        openSidebarPC(false);
        menuLocked = true;
        document.getElementById("sidebar-handle").style.backgroundColor = "#d44d64";
      } else {
        // 開 → 閉
        closeSidebarPC();
      }
    }

    $(document)
      .off("touchend.sidebarHandle click.sidebarHandle", "#sidebar-handle")
      .on("touchend.sidebarHandle", "#sidebar-handle", handlePinkBand)
      .on("click.sidebarHandle",   "#sidebar-handle", handlePinkBand);

    /* ── PC: ホバープレビュー（デスクトップ用。タッチ端末では発火しない） ─ */
    $(document)
      .off("mouseenter.sidebarPC", "#sidebarMenu")
      .on("mouseenter.sidebarPC", "#sidebarMenu", function () {
        if (isPC()) openSidebarPC(false); // ホバーはオーバーレイなし
      })
      .off("mouseleave.sidebarPC", "#sidebarMenu")
      .on("mouseleave.sidebarPC", "#sidebarMenu", function () {
        // ロック中は閉じない。スクロール上部ではホバー終了後も開いたまま。
        if (isPC() && !menuLocked && window.scrollY > 50) {
          closeSidebarPC();
        }
      });

    /* ── PC: スクロールで自動格納 ──────────────────────────── */
    $(window)
      .off("scroll.sidebarAutoHide")
      .on("scroll.sidebarAutoHide", function () {
        updateSidebarOnScroll();
      });

    /* ── モバイル: ハンバーガーボタン ──────────────────────── */
    $(document)
      .off("click.sidebarMobile", "#mobileMenuBtn")
      .on("click.sidebarMobile", "#mobileMenuBtn", function (e) {
        if (isPC()) return;
        e.preventDefault();
        var sb = getSidebar();
        if (!sb) return;
        if (sb.classList.contains("active")) closeSidebarMobile();
        else openSidebarMobile();
      });

    /* ── オーバーレイクリックで閉じる（PC / モバイル共通） ─── */
    $(document)
      .off("click.sidebarOverlay", "#sidebar-overlay")
      .on("click.sidebarOverlay", "#sidebar-overlay", function () {
        if (isPC()) closeSidebarPC();
        else closeSidebarMobile();
      });

    /* ── ESC キーで閉じる ─────────────────────────────────── */
    $(document)
      .off("keydown.menuEsc")
      .on("keydown.menuEsc", function (e) {
        if (e.key !== "Escape" && e.keyCode !== 27) return;
        if (isPC()) closeSidebarPC();
        else closeSidebarMobile();
      });

    /* ── リサイズ / 向き変更: ブレイクポイントを超えたらリセット ─ */
    $(window)
      .off("resize.sidebarBP orientationchange.sidebarBP")
      .on("resize.sidebarBP orientationchange.sidebarBP", debounce(function () {
        var sb = getSidebar();
        if (!sb) return;
        if (isPC()) {
          // モバイル状態をリセット → PC の初期状態へ
          sb.classList.remove("active");
          document.body.classList.remove("menu-open");
          document.body.style.overflow = "";
          updateSidebarOnScroll();
        } else {
          // PC 状態をリセット → モバイルの初期状態へ
          sb.classList.remove("is-hidden");
          menuLocked = false;
          document.body.classList.remove("menu-open");
          document.body.style.overflow = "";
        }
      }, 200));
  }

  /**
   * data-include 完了後に呼ぶ。サイドバーが DOM に入った時点で初期状態を確定する。
   */
  function applySidebarInitialState() {
    var sb = getSidebar();
    if (!sb) return;
    if (isPC()) {
      sb.classList.remove("active");
      updateSidebarOnScroll();
    } else {
      sb.classList.remove("is-hidden");
      sb.classList.remove("active");
    }
  }

  /* ============================================================
   * 現在地ナビ active 付与（サイドバー）
   * ============================================================ */

  function applyCurrentNavState() {
    var sidebar = document.getElementById("sidebarMenu");
    if (!sidebar) return;

    var curUrl = normalizeUrl(window.location.href);
    var curPath = normalizeUrl(window.location.pathname);

    sidebar.querySelectorAll("a").forEach(function (a) {
      if (a.getAttribute("data-toggle") === "collapse") return;
      var href = a.getAttribute("href");
      if (!href || href.startsWith("#") || href.startsWith("javascript:")) return;

      var linkUrl = normalizeUrl(a.href);
      var linkPath = normalizeUrl(a.pathname);
      var matched = (linkUrl === curUrl) || (linkPath && curPath.endsWith(linkPath));
      if (!matched) return;

      a.classList.add("current-active");

      // 親アコーディオンを展開
      var collapse = a.closest(".collapse");
      if (!collapse) return;
      collapse.classList.add("show");
      var triggerId = collapse.getAttribute("id");
      if (!triggerId) return;
      var trigger = sidebar.querySelector(
        '[data-toggle="collapse"][href="#' + triggerId + '"],' +
        '[data-toggle="collapse"][data-target="#' + triggerId + '"]'
      );
      if (!trigger) return;
      trigger.setAttribute("aria-expanded", "true");
      trigger.classList.remove("collapsed");
      var navItem = trigger.closest(".nav-item");
      if (navItem) navItem.classList.add("open");
    });
  }

  /* ============================================================
   * 現在地 active 付与（フッター サイトマップ）
   * ============================================================ */

  function applyFooterSitemapActive() {
    var links = document.querySelectorAll(".seibi-footer .sitemap-links a");
    if (!links.length) return;

    var curUrl = normalizeUrl(window.location.href);
    var curPath = normalizeUrl(window.location.pathname);

    links.forEach(function (a) {
      a.classList.remove("active");
      var href = a.getAttribute("href");
      if (!href || href.startsWith("#") || href.startsWith("javascript:")) return;
      var linkUrl = normalizeUrl(a.href);
      var linkPath = normalizeUrl(a.pathname);
      if (linkUrl === curUrl || (linkPath && curPath.endsWith(linkPath))) {
        a.classList.add("active");
      }
    });
  }

  /* ============================================================
   * トップへ戻るボタン
   * ============================================================ */

  function initBackToTop() {
    var $btn = $(".pagetop-container");
    if (!$btn.length) return;

    $(window)
      .off("scroll.backToTop")
      .on("scroll.backToTop", function () {
        $btn.toggleClass("show", window.scrollY > 600);
      })
      .triggerHandler("scroll.backToTop");

    $btn.off("click.backToTop").on("click.backToTop", function () {
      $("html, body").animate({ scrollTop: 0 }, 600, "swing");
    });
  }

  /* ============================================================
   * スライドショーキャプション（トップページ）
   * ============================================================ */

  function initSlideshow() {
    var $slides = $(".slideshow .slide-item");
    var $caption = $("#caption-text");
    if (!$slides.length || !$caption.length) return;

    var idx = 0;
    function tick() {
      $caption.text($slides.eq(idx).data("text") || "");
      idx = (idx + 1) % $slides.length;
    }
    tick();
    setInterval(tick, 5000);
  }

  /* ============================================================
   * 説明会カードスライダー（トップページ）
   * ============================================================ */

  function initInfoSlider() {
    var $track = $(".info-slider-track");
    if (!$track.length) return;

    var $cards = $(".info-card");
    var $prev = $(".slider-arrow.prev");
    var $next = $(".slider-arrow.next");
    var cardIdx = 0;
    var autoTimer = null;

    function visCount() {
      return window.innerWidth > 1199 ? 3 : window.innerWidth > 767 ? 2 : 1;
    }

    function updateArrows() {
      var overflow = $cards.length > visCount();
      $prev.toggleClass("is-hidden", !overflow);
      $next.toggleClass("is-hidden", !overflow);
      $track.toggleClass("is-centered", !overflow);
    }

    function slide() {
      var vc = visCount();
      if ($cards.length <= vc) { $track.css("transform", ""); return; }
      var w = $cards.outerWidth();
      var gap = parseFloat($track.css("gap")) || 0;
      $track.css("transform", "translateX(-" + (w + gap) * cardIdx + "px)");
    }

    function goNext() {
      var max = $cards.length - visCount();
      cardIdx = cardIdx < max ? cardIdx + 1 : 0;
      slide();
    }

    function goPrev() {
      var max = $cards.length - visCount();
      cardIdx = cardIdx > 0 ? cardIdx - 1 : max;
      slide();
    }

    function restartAuto() {
      clearInterval(autoTimer);
      autoTimer = setInterval(goNext, 7000);
    }

    $next.on("click", function () { goNext(); restartAuto(); });
    $prev.on("click", function () { goPrev(); restartAuto(); });

    // タッチスワイプ
    var swipeX = 0;
    $(".info-slider-container")
      .on("touchstart", function (e) {
        swipeX = e.originalEvent.touches[0].clientX;
      })
      .on("touchend", function (e) {
        var diff = swipeX - e.originalEvent.changedTouches[0].clientX;
        if (Math.abs(diff) > 50) { diff > 0 ? goNext() : goPrev(); restartAuto(); }
      });

    $(window).on("resize", debounce(function () { updateArrows(); slide(); }, 150));
    updateArrows();
    slide();
    restartAuto();
  }

  /* ============================================================
   * GSAP スクロールアニメーション（トップページ）
   * ============================================================ */

  function initScrollAnimations() {
    if (typeof gsap === "undefined" || typeof ScrollTrigger === "undefined") return;
    gsap.registerPlugin(ScrollTrigger);

    // ズームセクション
    if ($(".zoom-section").length) {
      ScrollTrigger.matchMedia({
        "(min-width: 992px)": function () {
          gsap.timeline({
            scrollTrigger: {
              trigger: ".zoom-section",
              start: "top bottom",
              end: "bottom bottom",
              scrub: 1,
            },
          })
          .fromTo(".zoom-image-wrapper",
            { width: "50%", height: "50vh", x: 0 },
            { width: "calc(100% - 155px)", height: "calc(100vh - 100px)", x: "27.5px", borderRadius: "10px", ease: "none" }
          )
          .to(".zoom-img", { scale: 1, ease: "none" }, "<")
          .to({}, { duration: 0 })
          .fromTo(".zoom-text",
            { opacity: 0, y: 50 },
            { opacity: 1, y: 0, duration: 0.4, ease: "power2.out" },
            "-=0.1"
          )
          .to({}, { duration: 0.3 });
        },
      });
    }

    // ギャラリーセクション
    if ($(".gallery-section").length) {
      ScrollTrigger.matchMedia({
        "(min-width: 992px)": function () {
          document.querySelectorAll(".gallery-item").forEach(function (item) {
            var overlay = item.querySelector(".curtain-overlay");
            var img = item.querySelector("img");
            gsap.timeline({
              scrollTrigger: { trigger: item, start: "top 85%", toggleActions: "play none none reverse" },
            })
            .to(overlay, { scaleX: 0, transformOrigin: "right", duration: 1.2, ease: "power2.inOut" })
            .to(img, { scale: 1, duration: 1.2, ease: "power2.out" }, "<");
          });
        },
      });

      // SVGアイコン（全デバイス共通）
      document.querySelectorAll(".gallery-item2").forEach(function (item) {
        var icon = item.querySelector(".icon-white");
        if (!icon) return;
        gsap.fromTo(icon,
          { opacity: 0, scale: 0.5, filter: "blur(10px)" },
          {
            opacity: 1, scale: 1, filter: "blur(0px)", duration: 1.2, ease: "power2.out",
            scrollTrigger: { trigger: item, start: "top 80%", toggleActions: "play none none reverse" },
          }
        );
      });
    }
  }

  /* ============================================================
   * ページ内スムーススクロール
   * ============================================================ */

  function initSmoothScroll() {
    // ページ内アンカーリンク（トップリンクとアコーディオンは除外）
    $(document).on(
      "click",
      'a[href^="#"]:not(.top-link):not([data-toggle="collapse"])',
      function (e) {
        var href = $(this).attr("href");
        var $target = $(href === "#" || !href ? "html" : href);
        if (!$target.length) return;
        e.preventDefault();
        var offset = isPC() ? 0 : 60; // スマホヘッダー高さ分
        $("html, body").stop().animate({ scrollTop: $target.offset().top - offset }, 800, "swing");
      }
    );

    // .top-link: ページトップへ戻る
    $(document).on("click", ".top-link", function (e) {
      e.preventDefault();
      $("html, body").animate({ scrollTop: 0 }, 1000, "swing");
    });
  }

  /* ============================================================
   * メインエントリ
   * ============================================================ */

  $(document).ready(function () {
    // ─── イベント登録（デリゲーション中心: data-include 前でも安全）───
    initMenuControls();
    initSmoothScroll();
    initSlideshow();
    initScrollAnimations();
    initInfoSlider();

    // ─── 非同期パーシャル読み込み ─────────────────────────────────
    loadPartialsIfNeeded()
      .then(function () {
        // include 完了後: サイドバー・フッターが DOM に入った状態で実行
        applySidebarInitialState(); // is-hidden の初期状態を確定
        applyCurrentNavState();     // サイドバー現在地ハイライト
        applyFooterSitemapActive(); // フッター現在地ハイライト
        initBackToTop();            // フッターの「↑」ボタン（include 後に存在することがある）
      })
      .catch(function (err) {
        console.warn("[script.js] パーシャル読み込みエラー:", err);
      });
  });

})(jQuery);
