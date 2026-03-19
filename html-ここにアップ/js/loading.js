window.addEventListener("load", function () {
  const splash = document.getElementById("seibi-splash");
  // ロード完了後、少し待ってからフェーズ1（画像消去・背景80%）へ
  setTimeout(function () {
    splash.classList.add("phase1");
    // フェーズ1のアニメーション時間(0.5s)後にフェーズ2（丸拡大・背景0%）へ
    setTimeout(function () {
      splash.classList.add("phase2");
      // フェーズ2のアニメーション時間(0.8s)後に非表示
      setTimeout(() => {
        splash.style.display = "none";
      }, 800);
    }, 500);
  }, 800);
});
