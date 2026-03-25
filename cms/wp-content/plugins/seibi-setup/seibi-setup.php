<?php
/**
 * Plugin Name: Seibi Setup
 * Description: 固定ページの一括作成・サイト初期設定を行うセットアップツール
 * Version: 1.1.0
 * Author: DELASOL
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// -----------------------------------------------
// 管理画面メニュー
// -----------------------------------------------
add_action( 'admin_menu', function() {
    add_management_page(
        'Seibi セットアップ',
        'Seibi セットアップ',
        'manage_options',
        'seibi-setup',
        'seibi_setup_page'
    );
} );

// -----------------------------------------------
// ページ定義
// -----------------------------------------------
function seibi_get_page_definitions(): array {
    return [
        // 学校紹介
        [
            'title'  => '学校紹介',
            'slug'   => 'about',
            'parent' => '',
        ],
        [
            'title'  => '校長メッセージ',
            'slug'   => 'principal',
            'parent' => 'about',
        ],
        [
            'title'  => '建学の精神・教育理念',
            'slug'   => 'method',
            'parent' => 'about',
        ],
        [
            'title'  => '星美の歩み',
            'slug'   => 'history',
            'parent' => 'about',
        ],
        [
            'title'  => '制服',
            'slug'   => 'uniform',
            'parent' => 'about',
        ],
        [
            'title'  => 'アクセス',
            'slug'   => 'access',
            'parent' => 'about',
        ],
        [
            'title'  => '通学地域',
            'slug'   => 'area',
            'parent' => 'about',
        ],
        [
            'title'  => '施設・設備・環境',
            'slug'   => 'facility',
            'parent' => 'about',
        ],
        [
            'title'  => '災害・セキュリティ対策',
            'slug'   => 'security',
            'parent' => 'about',
        ],
        [
            'title'  => 'よくお寄せいただく質問',
            'slug'   => 'faq',
            'parent' => 'about',
        ],
        [
            'title'  => 'パンフレットダウンロード',
            'slug'   => 'download',
            'parent' => 'about',
        ],
        [
            'title'  => 'このサイトについて',
            'slug'   => 'site',
            'parent' => 'about',
        ],
        [
            'title'  => '個人情報保護方針',
            'slug'   => 'privacy',
            'parent' => 'about',
        ],

        // 星美クラスの教育
        [
            'title'  => '星美クラスの教育',
            'slug'   => 'feature',
            'parent' => '',
        ],
        [
            'title'  => '宗教教育',
            'slug'   => 'religion',
            'parent' => 'feature',
        ],
        [
            'title'  => '英語教育',
            'slug'   => 'english',
            'parent' => 'feature',
        ],
        [
            'title'  => '総合的な学習',
            'slug'   => 'integrated-studies',
            'parent' => 'feature',
        ],
        [
            'title'  => '宿泊学習',
            'slug'   => 'stay',
            'parent' => 'feature',
        ],
        [
            'title'  => '教科教育',
            'slug'   => 'currciculum',
            'parent' => 'feature',
        ],
        [
            'title'  => '進学実績',
            'slug'   => 'career',
            'parent' => 'feature',
        ],
        [
            'title'  => 'アシステンツァ',
            'slug'   => 'assistenza',
            'parent' => 'feature',
        ],

        // 学校生活
        [
            'title'  => '学校生活',
            'slug'   => 'life',
            'parent' => '',
        ],
        [
            'title'  => '星美クラスの一日',
            'slug'   => 'daily',
            'parent' => 'life',
        ],
        [
            'title'  => '委員会・クラブ活動（特別音楽クラブ）',
            'slug'   => 'activity',
            'parent' => 'life',
        ],
        [
            'title'  => 'サレジアンアフタースクール',
            'slug'   => 'after-school',
            'parent' => 'life',
        ],

        // 入試について
        [
            'title'  => '入試について',
            'slug'   => 'admission',
            'parent' => '',
        ],
        [
            'title'  => '児童募集要項',
            'slug'   => 'requirements',
            'parent' => 'admission',
        ],
        [
            'title'  => '入学までの流れ',
            'slug'   => 'flow',
            'parent' => 'admission',
        ],
        [
            'title'  => '編転入学について',
            'slug'   => 'transfer',
            'parent' => 'admission',
        ],
    ];
}

// -----------------------------------------------
// ページ作成処理
// -----------------------------------------------
function seibi_create_pages(): array {
    $definitions = seibi_get_page_definitions();
    $results     = [];

    // 親ページのID解決用キャッシュ（slug → post_id）
    $slug_to_id = [];

    foreach ( $definitions as $def ) {
        $slug      = $def['slug'];
        $title     = $def['title'];
        $parent_slug = $def['parent'];

        // 既存チェック（post_name で検索。get_page_by_path は子ページを見つけられないため使わない）
        $existing_posts = get_posts( [
            'post_type'   => 'page',
            'post_status' => [ 'publish', 'draft', 'private' ],
            'name'        => $slug,
            'numberposts' => 1,
        ] );
        $existing = $existing_posts[0] ?? null;
        if ( $existing ) {
            $slug_to_id[ $slug ] = $existing->ID;
            $results[] = [
                'status' => 'skip',
                'slug'   => $slug,
                'title'  => $title,
                'id'     => $existing->ID,
            ];
            continue;
        }

        $parent_id = 0;
        if ( $parent_slug && isset( $slug_to_id[ $parent_slug ] ) ) {
            $parent_id = $slug_to_id[ $parent_slug ];
        } elseif ( $parent_slug ) {
            $parent_posts = get_posts( [
                'post_type'   => 'page',
                'post_status' => [ 'publish', 'draft', 'private' ],
                'name'        => $parent_slug,
                'numberposts' => 1,
            ] );
            if ( $parent_posts ) {
                $parent_id = $parent_posts[0]->ID;
                $slug_to_id[ $parent_slug ] = $parent_id;
            }
        }

        $post_id = wp_insert_post( [
            'post_title'  => $title,
            'post_name'   => $slug,
            'post_status' => 'publish',
            'post_type'   => 'page',
            'post_parent' => $parent_id,
        ], true );

        if ( is_wp_error( $post_id ) ) {
            $results[] = [
                'status'  => 'error',
                'slug'    => $slug,
                'title'   => $title,
                'message' => $post_id->get_error_message(),
            ];
        } else {
            $slug_to_id[ $slug ] = $post_id;
            $results[] = [
                'status' => 'created',
                'slug'   => $slug,
                'title'  => $title,
                'id'     => $post_id,
            ];
        }
    }

    return $results;
}

// -----------------------------------------------
// 全固定ページ削除処理
// -----------------------------------------------
function seibi_delete_all_pages(): array {
    $pages = get_posts( [
        'post_type'      => 'page',
        'post_status'    => [ 'publish', 'draft', 'private', 'trash' ],
        'numberposts'    => -1,
        'fields'         => 'ids',
    ] );

    $results = [];
    foreach ( $pages as $id ) {
        $title = get_the_title( $id );
        $slug  = get_post_field( 'post_name', $id );
        $del   = wp_delete_post( $id, true ); // true = 完全削除（ゴミ箱をスキップ）
        $results[] = [
            'status' => $del ? 'deleted' : 'error',
            'id'     => $id,
            'title'  => $title,
            'slug'   => $slug,
        ];
    }
    return $results;
}

// -----------------------------------------------
// カテゴリー定義（タクソノミー別）
// -----------------------------------------------
function seibi_get_category_groups(): array {
    return [
        [
            'label'    => 'お知らせ',
            'taxonomy' => 'information-category',
            'items'    => [
                [ 'name' => 'お知らせ', 'slug' => 'news'        ],
                [ 'name' => '学校生活', 'slug' => 'school-life' ],
                [ 'name' => '入試関連', 'slug' => 'admission'   ],
                [ 'name' => 'イベント', 'slug' => 'event'       ],
            ],
        ],
        [
            'label'    => '学校説明会',
            'taxonomy' => 'briefing-flag',
            'items'    => [
                [ 'name' => 'トップページ', 'slug' => 'top-page' ],
            ],
        ],
        [
            'label'    => '公開行事',
            'taxonomy' => 'event-flag',
            'items'    => [
                [ 'name' => 'トップページ', 'slug' => 'top-page' ],
            ],
        ],
    ];
}

// -----------------------------------------------
// カテゴリー作成処理
// -----------------------------------------------
function seibi_create_categories(): array {
    $groups  = seibi_get_category_groups();
    $results = [];

    foreach ( $groups as $group ) {
        foreach ( $group['items'] as $def ) {
            $existing = get_term_by( 'slug', $def['slug'], $group['taxonomy'] );

            if ( $existing ) {
                $results[] = [
                    'status'   => 'skip',
                    'group'    => $group['label'],
                    'name'     => $def['name'],
                    'slug'     => $def['slug'],
                    'id'       => $existing->term_id,
                ];
                continue;
            }

            $term = wp_insert_term( $def['name'], $group['taxonomy'], [
                'slug' => $def['slug'],
            ] );

            if ( is_wp_error( $term ) ) {
                $results[] = [
                    'status'  => 'error',
                    'group'   => $group['label'],
                    'name'    => $def['name'],
                    'slug'    => $def['slug'],
                    'message' => $term->get_error_message(),
                ];
            } else {
                $results[] = [
                    'status' => 'created',
                    'group'  => $group['label'],
                    'name'   => $def['name'],
                    'slug'   => $def['slug'],
                    'id'     => $term['term_id'],
                ];
            }
        }
    }

    return $results;
}

// -----------------------------------------------
// 管理画面ページ
// -----------------------------------------------
function seibi_setup_page() {
    $create_results   = null;
    $category_results = null;
    $delete_results   = null;

    // 全固定ページ削除
    if ( isset( $_POST['seibi_delete_pages'] ) && check_admin_referer( 'seibi_setup' ) ) {
        $delete_results = seibi_delete_all_pages();
    }

    // 固定ページ作成
    if ( isset( $_POST['seibi_create_pages'] ) && check_admin_referer( 'seibi_setup' ) ) {
        $create_results = seibi_create_pages();
    }

    // カテゴリー作成
    if ( isset( $_POST['seibi_create_categories'] ) && check_admin_referer( 'seibi_setup' ) ) {
        $category_results = seibi_create_categories();
    }

    // 現在の状態を取得
    $definitions = seibi_get_page_definitions();
    ?>
    <div class="wrap">
        <h1>Seibi セットアップ</h1>

        <?php if ( $delete_results !== null ) : ?>
            <div class="notice notice-warning">
                <p><?php echo count( $delete_results ); ?> 件の固定ページを削除しました。</p>
            </div>
            <table class="widefat striped" style="margin-bottom: 20px;">
                <thead>
                    <tr><th>状態</th><th>ID</th><th>スラッグ</th><th>ページタイトル</th></tr>
                </thead>
                <tbody>
                    <?php foreach ( $delete_results as $r ) : ?>
                        <tr>
                            <td>
                                <?php if ( $r['status'] === 'deleted' ) : ?>
                                    <span style="color:green;">✓ 削除</span>
                                <?php else : ?>
                                    <span style="color:red;">✗ エラー</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo esc_html( $r['id'] ); ?></td>
                            <td><code><?php echo esc_html( $r['slug'] ); ?></code></td>
                            <td><?php echo esc_html( $r['title'] ); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <?php if ( $create_results !== null ) : ?>
            <div class="notice notice-success">
                <p>ページ作成処理が完了しました。</p>
            </div>
            <table class="widefat striped" style="margin-bottom: 20px;">
                <thead>
                    <tr>
                        <th>状態</th><th>スラッグ</th><th>ページタイトル</th><th>ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $create_results as $r ) : ?>
                        <tr>
                            <td>
                                <?php if ( $r['status'] === 'created' ) : ?>
                                    <span style="color:green;">✓ 作成</span>
                                <?php elseif ( $r['status'] === 'skip' ) : ?>
                                    <span style="color:gray;">— スキップ（既存）</span>
                                <?php else : ?>
                                    <span style="color:red;">✗ エラー: <?php echo esc_html( $r['message'] ?? '' ); ?></span>
                                <?php endif; ?>
                            </td>
                            <td><code><?php echo esc_html( $r['slug'] ); ?></code></td>
                            <td><?php echo esc_html( $r['title'] ); ?></td>
                            <td><?php echo isset( $r['id'] ) ? esc_html( $r['id'] ) : '—'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <?php if ( $category_results !== null ) : ?>
            <div class="notice notice-success">
                <p>カテゴリー作成処理が完了しました。</p>
            </div>
            <table class="widefat striped" style="margin-bottom: 20px;">
                <thead>
                    <tr><th>状態</th><th>グループ</th><th>カテゴリー名</th><th>スラッグ</th><th>ID</th></tr>
                </thead>
                <tbody>
                    <?php foreach ( $category_results as $r ) : ?>
                        <tr>
                            <td>
                                <?php if ( $r['status'] === 'created' ) : ?>
                                    <span style="color:green;">✓ 作成</span>
                                <?php elseif ( $r['status'] === 'skip' ) : ?>
                                    <span style="color:gray;">— スキップ（既存）</span>
                                <?php else : ?>
                                    <span style="color:red;">✗ エラー: <?php echo esc_html( $r['message'] ?? '' ); ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo esc_html( $r['group'] ); ?></td>
                            <td><?php echo esc_html( $r['name'] ); ?></td>
                            <td><code><?php echo esc_html( $r['slug'] ); ?></code></td>
                            <td><?php echo isset( $r['id'] ) ? esc_html( $r['id'] ) : '—'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <form method="post">
            <?php wp_nonce_field( 'seibi_setup' ); ?>

            <h2>0. 固定ページの全削除</h2>
            <p style="color:#b32d2e;"><strong>⚠ 注意:</strong> サイト内のすべての固定ページを完全に削除します（ゴミ箱をスキップ）。実行後は元に戻せません。</p>
            <?php
            $existing_page_count = wp_count_posts( 'page' );
            $total = array_sum( (array) $existing_page_count );
            ?>
            <p>現在の固定ページ数: <strong><?php echo intval( $total ); ?> 件</strong></p>
            <p>
                <button type="submit" name="seibi_delete_pages" class="button button-large"
                    style="background:#b32d2e;color:#fff;border-color:#8a1f1f;"
                    onclick="return confirm('すべての固定ページを完全に削除します。よろしいですか？');">
                    全固定ページを削除する
                </button>
            </p>

            <hr>

            <h2>1. 固定ページの一括作成</h2>
            <p>サイトマップに基づいてすべての固定ページを作成します。既存のページはスキップされます。</p>

            <table class="widefat striped" style="margin-bottom: 16px;">
                <thead>
                    <tr><th>ページタイトル</th><th>スラッグ</th><th>親ページ</th><th>現在の状態</th></tr>
                </thead>
                <tbody>
                    <?php foreach ( $definitions as $def ) :
                        $existing_posts = get_posts( [
                            'post_type'   => 'page',
                            'post_status' => [ 'publish', 'draft', 'private' ],
                            'name'        => $def['slug'],
                            'numberposts' => 1,
                        ] );
                        $existing = $existing_posts[0] ?? null;
                    ?>
                        <tr>
                            <td><?php echo esc_html( $def['title'] ); ?></td>
                            <td><code><?php echo esc_html( $def['slug'] ); ?></code></td>
                            <td><code><?php echo esc_html( $def['parent'] ?: '—' ); ?></code></td>
                            <td>
                                <?php if ( $existing ) : ?>
                                    <span style="color:green;">✓ 作成済み (ID: <?php echo esc_html( $existing->ID ); ?>)</span>
                                <?php else : ?>
                                    <span style="color:#aaa;">未作成</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <p>
                <button type="submit" name="seibi_create_pages" class="button button-primary button-large">
                    固定ページを一括作成する
                </button>
            </p>

            <hr>

            <h2>2. お知らせカテゴリーの作成</h2>
            <p>カスタム分類 <code>information-category</code> にカテゴリーを登録します。既存のカテゴリーはスキップされます。</p>

            <table class="widefat striped" style="margin-bottom: 16px;">
                <thead>
                    <tr><th>グループ</th><th>カテゴリー名</th><th>スラッグ</th><th>現在の状態</th></tr>
                </thead>
                <tbody>
                    <?php foreach ( seibi_get_category_groups() as $group ) :
                        foreach ( $group['items'] as $cat ) :
                            $existing_cat = get_term_by( 'slug', $cat['slug'], $group['taxonomy'] );
                    ?>
                        <tr>
                            <td><?php echo esc_html( $group['label'] ); ?></td>
                            <td><?php echo esc_html( $cat['name'] ); ?></td>
                            <td><code><?php echo esc_html( $cat['slug'] ); ?></code></td>
                            <td>
                                <?php if ( $existing_cat ) : ?>
                                    <span style="color:green;">✓ 作成済み (ID: <?php echo $existing_cat->term_id; ?>)</span>
                                <?php else : ?>
                                    <span style="color:#aaa;">未作成</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; endforeach; ?>
                </tbody>
            </table>

            <p>
                <button type="submit" name="seibi_create_categories" class="button button-primary button-large">
                    カテゴリーを一括作成する
                </button>
            </p>

        </form>
    </div>
    <?php
}
