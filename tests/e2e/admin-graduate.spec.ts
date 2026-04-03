import { test, expect } from '@playwright/test';
import * as fs from 'fs';
import * as path from 'path';
import * as dotenv from 'dotenv';

// .env.test を読み込む
dotenv.config({ path: path.resolve(__dirname, '../../.env.test') });

const WP_ADMIN_URL = 'http://localhost:8110/seibi/cms/wp-admin';
const LOGIN_URL    = 'http://localhost:8110/seibi/cms/wp-login.php';

const ADMIN_USER    = process.env.WP_ADMIN_USER    ?? '';
const ADMIN_PASS    = process.env.WP_ADMIN_PASS    ?? '';
const GRADUATE_USER = process.env.WP_GRADUATE_USER ?? '';
const GRADUATE_PASS = process.env.WP_GRADUATE_PASS ?? '';

// ---- ログインヘルパー ----
async function loginAs(page: any, username: string, password: string) {
  await page.goto(LOGIN_URL);
  await page.fill('#user_login', username);
  await page.fill('#user_pass', password);
  await page.click('#wp-submit');

  // ログイン失敗（エラーメッセージが出た場合）を即座に検出
  const errorDiv = page.locator('#login_error');
  const adminUrl = page.waitForURL(/wp-admin/, { timeout: 10000 });

  const result = await Promise.race([
    errorDiv.waitFor({ state: 'visible', timeout: 10000 }).then(() => 'error'),
    adminUrl.then(() => 'success'),
  ]).catch(() => 'timeout');

  if (result === 'error') {
    const msg = await errorDiv.textContent();
    throw new Error(`WordPressログイン失敗: ${msg?.trim()}\n→ .env.test の認証情報を確認してください`);
  }
  if (result === 'timeout') {
    throw new Error('WordPressログイン後の画面遷移がタイムアウトしました');
  }
}

// ============================================================
// 卒業生ユーザーの権限チェック
// ============================================================
test.describe('卒業生ユーザー権限', () => {
  test.beforeEach(async ({ page }) => {
    test.skip(!GRADUATE_USER || !GRADUATE_PASS, '.env.test に WP_GRADUATE_USER / WP_GRADUATE_PASS が未設定');
    await loginAs(page, GRADUATE_USER, GRADUATE_PASS);
  });

  test('「卒業生の方へ」メニューが表示されている', async ({ page }) => {
    await page.goto(`${WP_ADMIN_URL}/`);
    // 管理画面サイドバーに graduate の投稿タイプメニューが存在するか
    await expect(
      page.locator('#menu-posts-graduate'),
      '「卒業生の方へ」メニューが存在すること'
    ).toBeVisible();
  });

  test('「投稿」メニューが非表示になっている', async ({ page }) => {
    await page.goto(`${WP_ADMIN_URL}/`);
    // 通常の投稿メニュー（#menu-posts）が存在しないこと
    await expect(
      page.locator('#menu-posts'),
      '「投稿」メニューが非表示であること'
    ).not.toBeVisible();
  });

  test('「固定ページ」メニューが非表示になっている', async ({ page }) => {
    await page.goto(`${WP_ADMIN_URL}/`);
    await expect(
      page.locator('#menu-pages'),
      '「固定ページ」メニューが非表示であること'
    ).not.toBeVisible();
  });

  test('/wp-admin/edit.php に直アクセスすると卒業生一覧にリダイレクトされる', async ({ page }) => {
    await page.goto(`${WP_ADMIN_URL}/edit.php`);
    await expect(
      page,
      '卒業生一覧ページ（edit.php?post_type=graduate）にリダイレクトされること'
    ).toHaveURL(/edit\.php\?post_type=graduate/);
  });

  test('/wp-admin/edit-comments.php に直アクセスすると卒業生一覧にリダイレクトされる', async ({ page }) => {
    await page.goto(`${WP_ADMIN_URL}/edit-comments.php`);
    await expect(page).toHaveURL(/edit\.php\?post_type=graduate/);
  });
});

// ============================================================
// 管理者の権限チェック
// ============================================================
test.describe('管理者権限', () => {
  test.beforeEach(async ({ page }) => {
    test.skip(!ADMIN_USER || !ADMIN_PASS, '.env.test に WP_ADMIN_USER / WP_ADMIN_PASS が未設定');
    await loginAs(page, ADMIN_USER, ADMIN_PASS);
  });

  test('管理者は「固定ページ」メニューが表示されている', async ({ page }) => {
    await page.goto(`${WP_ADMIN_URL}/`);
    await expect(page.locator('#menu-pages')).toBeVisible();
  });

  test('ユーザー編集画面に「卒業生ページ管理」チェックボックスが表示される', async ({ page }) => {
    // ユーザー一覧から最初のeditorユーザーのIDを取得してプロフィール編集画面へ
    await page.goto(`${WP_ADMIN_URL}/users.php`);

    // editor ロールのユーザー行を探す
    const editorRow = page.locator('tr').filter({ hasText: '編集者' }).first();
    const editLink = editorRow.locator('a').filter({ hasText: '編集' }).first();

    // editor ユーザーが存在しない場合はスキップ
    const count = await editLink.count();
    test.skip(count === 0, '編集者ユーザーが存在しないためスキップ');

    // クリックは固定サイドバーで viewport 外になるため href を直接取得して遷移
    const href = await editLink.getAttribute('href');
    await page.goto(href!);
    await expect(
      page.locator('#seibi_graduate_access'),
      '「卒業生ページ管理」チェックボックスが表示されること'
    ).toBeVisible();
  });
});
