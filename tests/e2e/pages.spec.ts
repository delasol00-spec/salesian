import { test, expect } from '@playwright/test';

const BASE_URL = 'http://localhost:8110/seibi';

// ============================================================
// 全ページ 200 OK チェック
// ============================================================
const pages = [
  { name: 'トップページ',              path: '/' },
  { name: '校長メッセージ',            path: '/about/principal/' },
  { name: '建学の精神・教育理念',       path: '/about/method/' },
  { name: '星美の歩み',                path: '/about/history/' },
  { name: '制服',                      path: '/about/uniform/' },
  { name: 'アクセス',                  path: '/about/access/' },
  { name: '通学地域',                  path: '/about/area/' },
  { name: '施設・設備・環境',           path: '/about/facility/' },
  { name: '災害・セキュリティ対策',     path: '/about/security/' },
  { name: 'よくある質問',              path: '/about/faq/' },
  { name: 'パンフレットダウンロード',   path: '/about/download/' },
  { name: 'このサイトについて',         path: '/about/site/' },
  { name: '個人情報保護方針',           path: '/about/privacy/' },
  { name: '宗教教育',                  path: '/feature/religion/' },
  { name: '英語教育',                  path: '/feature/english/' },
  { name: '総合的な学習',              path: '/feature/integrated-studies/' },
  { name: '宿泊学習',                  path: '/feature/stay/' },
  { name: '教科教育',                  path: '/feature/currciculum/' },
  { name: '進学実績',                  path: '/feature/career/' },
  { name: 'アシステンツァ',            path: '/feature/assistenza/' },
  { name: '星美クラスの一日',           path: '/life/daily/' },
  { name: '年間行事',                  path: '/life/year/' },
  { name: '委員会・クラブ活動',         path: '/life/activity/' },
  { name: 'サレジアンアフタースクール', path: '/life/after-school/' },
  { name: '児童募集要項',              path: '/admission/requirements/' },
  { name: '入学までの流れ',            path: '/admission/flow/' },
  { name: '学校説明会・公開行事',       path: '/admission/briefing/' },
  { name: '公開行事',                  path: '/admission/event/' },
  { name: '編転入学について',           path: '/admission/transfer/' },
  { name: 'お知らせ',                  path: '/information/' },
  { name: '入学をお考えの方へ',         path: '/examinee/' },
  { name: '卒業生の方へ',              path: '/graduate/' },
];

for (const { name, path } of pages) {
  test(`[200] ${name} (${path})`, async ({ page }) => {
    const res = await page.goto(`${BASE_URL}${path}`);
    expect(res?.status(), `${name} が 200 を返すこと`).toBe(200);
  });
}

// ============================================================
// リダイレクトチェック（セクショントップ）
// ============================================================
const redirects = [
  { name: '学校紹介',         from: '/about/',     to: '/about/principal/' },
  { name: '星美クラスの教育', from: '/feature/',   to: '/feature/religion/' },
  { name: '学校生活',         from: '/life/',      to: '/life/daily/' },
  { name: '入試について',     from: '/admission/', to: '/admission/requirements/' },
];

for (const { name, from, to } of redirects) {
  test(`[redirect] ${name}: ${from} → ${to}`, async ({ page }) => {
    await page.goto(`${BASE_URL}${from}`);
    expect(page.url(), `${name} のリダイレクト先`).toContain(to);
  });
}

// ============================================================
// 共通UIチェック
// ============================================================

test('下層ページにヒーロー画像(.sub-hero)が存在する', async ({ page }) => {
  await page.goto(`${BASE_URL}/about/principal/`);
  await expect(page.locator('.sub-hero')).toBeVisible();
});

test('404ページが返される（存在しないURL）', async ({ page }) => {
  const res = await page.goto(`${BASE_URL}/this-page-does-not-exist/`);
  expect(res?.status()).toBe(404);
});
