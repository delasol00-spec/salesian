// 1. まず本体のスクリプトを動的に読み込む
var script = document.createElement('script');
script.async = true;
script.src = 'https://www.googletagmanager.com/gtag/js?id=G-MW6F9J7550';
document.head.appendChild(script);

// 2. gtagの設定
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', 'G-MW6F9J7550');