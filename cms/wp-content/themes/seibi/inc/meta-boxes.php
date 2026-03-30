<?php
/**
 * briefing カスタムフィールド（メタボックス）
 *
 * ラジオボタンで学校説明会／学外説明会を選択し、
 * 対応するフィールドグループを切り替え表示する。
 *
 * @package seibi
 */

// -----------------------------------------------
// 共通: メタボックス nonce 検証
// -----------------------------------------------
/**
 * メタボックス保存時のセキュリティチェックをまとめて行う。
 * いずれかのチェックに失敗した場合は false を返す。
 *
 * @param string $nonce_field $_POST のキー名
 * @param string $nonce_action nonce アクション文字列
 * @param int    $post_id      投稿 ID
 * @return bool 保存処理を続行してよければ true
 */
function seibi_verify_meta_nonce( $nonce_field, $nonce_action, $post_id ) {
    if ( ! isset( $_POST[ $nonce_field ] ) ) {
        return false;
    }
    if ( ! wp_verify_nonce( $_POST[ $nonce_field ], $nonce_action ) ) {
        return false;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return false;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return false;
    }
    return true;
}

// -----------------------------------------------
// メタボックス登録
// -----------------------------------------------
function seibi_briefing_add_meta_box() {
    add_meta_box(
        'briefing_details',
        '説明会詳細',
        'seibi_briefing_meta_box_callback',
        'briefing',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'seibi_briefing_add_meta_box' );

// -----------------------------------------------
// メタボックス表示
// -----------------------------------------------
function seibi_briefing_meta_box_callback( $post ) {
    wp_nonce_field( 'seibi_briefing_meta_save', 'seibi_briefing_meta_nonce' );

    $type = get_post_meta( $post->ID, 'briefing_type', true ) ?: 'school';

    // 学校説明会フィールド（一覧ページ・詳細ページ共通）
    $school_fields = [
        'briefing_datetime'          => '日時',
        'briefing_venue'             => '場所',
        'briefing_reception'         => '受付',
        'briefing_session'           => '説明会',
        'briefing_target'            => '対象',
        'briefing_method'            => '参加方法',
        'briefing_web_cancel_period' => '予約期間',
        'briefing_notes'             => '注意事項',
    ];

    // 学外説明会フィールド
    $outside_fields = [
        'outside_datetime'    => '日時',
        'outside_venue'       => '会場',
        'outside_time'        => '時間',
        'outside_description' => '説明文',
    ];
    ?>
    <div style="margin-bottom:12px; padding:8px 12px; background:#f0f6fc; border:1px solid #c3d9f0; border-radius:4px;">
      <label style="font-size:13px; font-weight:bold;">
        <input type="checkbox" name="briefing_reservation_required" value="1" <?php checked( get_post_meta( $post->ID, 'briefing_reservation_required', true ), '1' ); ?> style="margin-right:6px;" />
        要予約（チェックなし = 予約不要）
      </label>
    </div>

    <div style="margin-bottom:16px; padding:12px; background:#f9f9f9; border:1px solid #ddd; border-radius:4px;">
      <strong>種別</strong>&nbsp;&nbsp;
      <label style="margin-right:16px;">
        <input type="radio" name="briefing_type" value="school" <?php checked( $type, 'school' ); ?> />
        学校説明会
      </label>
      <label>
        <input type="radio" name="briefing_type" value="outside" <?php checked( $type, 'outside' ); ?> />
        学外説明会
      </label>
    </div>

    <?php
    $school_link_type  = get_post_meta( $post->ID, 'briefing_link_type', true ) ?: 'none';
    $outside_link_type = get_post_meta( $post->ID, 'outside_link_type',  true ) ?: 'none';
    ?>

    <div id="briefing-school-fields" style="<?php echo $type === 'school' ? '' : 'display:none;'; ?>">
      <table class="form-table"><tbody>
        <tr>
          <th>ボタン・リンク</th>
          <td>
            <label style="display:block; margin-bottom:6px;">
              <input type="radio" name="briefing_link_type" value="none" <?php checked( $school_link_type, 'none' ); ?> />
              リンクなし
            </label>
            <label style="display:block; margin-bottom:6px;">
              <input type="radio" name="briefing_link_type" value="detail" <?php checked( $school_link_type, 'detail' ); ?> />
              詳細ページ（ボタン名:「詳細・参加予約はこちらから」）
            </label>
            <label style="display:block;">
              <input type="radio" name="briefing_link_type" value="external" <?php checked( $school_link_type, 'external' ); ?> />
              外部URL
            </label>
            <div id="briefing-link-external" style="<?php echo $school_link_type === 'external' ? '' : 'display:none;'; ?> margin-top:10px; padding:10px 12px; background:#f9f9f9; border:1px solid #ddd; border-radius:4px;">
              <table class="form-table" style="margin:0;"><tbody>
                <tr>
                  <th style="width:120px;"><label for="briefing_link_label">ボタン名</label></th>
                  <td><input type="text" id="briefing_link_label" name="briefing_link_label" value="<?php echo esc_attr( get_post_meta( $post->ID, 'briefing_link_label', true ) ); ?>" class="widefat" /></td>
                </tr>
                <tr>
                  <th><label for="briefing_link_url">リンク先URL</label></th>
                  <td><input type="url" id="briefing_link_url" name="briefing_link_url" value="<?php echo esc_attr( get_post_meta( $post->ID, 'briefing_link_url', true ) ); ?>" class="widefat" placeholder="https://" /></td>
                </tr>
              </tbody></table>
            </div>
          </td>
        </tr>
        <tr><td colspan="2"><hr style="margin:8px 0;" /></td></tr>
      <?php foreach ( $school_fields as $key => $label ) :
          $value = get_post_meta( $post->ID, $key, true ); ?>
        <tr>
          <th style="width:220px;"><label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label></th>
          <td><input type="text" id="<?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $value ); ?>" class="widefat" /></td>
        </tr>
      <?php endforeach; ?>
      </tbody></table>
      <p style="margin:12px 0 4px; font-weight:bold;">自由入力欄</p>
      <?php wp_editor(
          get_post_meta( $post->ID, 'briefing_capacity_note', true ),
          'briefing_capacity_note',
          [ 'textarea_name' => 'briefing_capacity_note', 'media_buttons' => false, 'teeny' => true, 'textarea_rows' => 20 ]
      ); ?>
    </div>

    <div id="briefing-outside-fields" style="<?php echo $type === 'outside' ? '' : 'display:none;'; ?>">
      <table class="form-table"><tbody>
        <tr>
          <th>ボタン・リンク</th>
          <td>
            <label style="display:block; margin-bottom:6px;">
              <input type="radio" name="outside_link_type" value="none" <?php checked( $outside_link_type, 'none' ); ?> />
              リンクなし
            </label>
            <label style="display:block;">
              <input type="radio" name="outside_link_type" value="external" <?php checked( $outside_link_type, 'external' ); ?> />
              外部URL
            </label>
            <div id="outside-link-external" style="<?php echo $outside_link_type === 'external' ? '' : 'display:none;'; ?> margin-top:10px; padding:10px 12px; background:#f9f9f9; border:1px solid #ddd; border-radius:4px;">
              <table class="form-table" style="margin:0;"><tbody>
                <tr>
                  <th style="width:120px;"><label for="outside_link_label">ボタン名</label></th>
                  <td><input type="text" id="outside_link_label" name="outside_link_label" value="<?php echo esc_attr( get_post_meta( $post->ID, 'outside_link_label', true ) ); ?>" class="widefat" /></td>
                </tr>
                <tr>
                  <th><label for="outside_link_url">リンク先URL</label></th>
                  <td><input type="url" id="outside_link_url" name="outside_link_url" value="<?php echo esc_attr( get_post_meta( $post->ID, 'outside_link_url', true ) ); ?>" class="widefat" placeholder="https://" /></td>
                </tr>
              </tbody></table>
            </div>
          </td>
        </tr>
        <tr><td colspan="2"><hr style="margin:8px 0;" /></td></tr>
      <?php foreach ( $outside_fields as $key => $label ) :
          $value = get_post_meta( $post->ID, $key, true ); ?>
        <tr>
          <th style="width:220px;"><label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label></th>
          <?php if ( $key === 'outside_description' ) : ?>
          <td><textarea id="<?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $key ); ?>" class="widefat" rows="3"><?php echo esc_textarea( $value ); ?></textarea></td>
          <?php else : ?>
          <td><input type="text" id="<?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $value ); ?>" class="widefat" /></td>
          <?php endif; ?>
        </tr>
      <?php endforeach; ?>
      </tbody></table>
    </div>

    <script>
    (function() {
        // 種別（学校説明会 / 学外説明会）切り替え
        var typeRadios  = document.querySelectorAll('input[name="briefing_type"]');
        var schoolDiv   = document.getElementById('briefing-school-fields');
        var outsideDiv  = document.getElementById('briefing-outside-fields');
        typeRadios.forEach(function(radio) {
            radio.addEventListener('change', function() {
                schoolDiv.style.display  = this.value === 'school'  ? '' : 'none';
                outsideDiv.style.display = this.value === 'outside' ? '' : 'none';
            });
        });

        // リンクパターン切り替え（学校説明会）
        document.querySelectorAll('input[name="briefing_link_type"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                document.getElementById('briefing-link-external').style.display =
                    this.value === 'external' ? '' : 'none';
            });
        });

        // リンクパターン切り替え（学外説明会）
        document.querySelectorAll('input[name="outside_link_type"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                document.getElementById('outside-link-external').style.display =
                    this.value === 'external' ? '' : 'none';
            });
        });
    })();
    </script>
    <?php
}

// -----------------------------------------------
// メタボックス保存
// -----------------------------------------------
function seibi_briefing_meta_save( $post_id ) {
    if ( ! seibi_verify_meta_nonce( 'seibi_briefing_meta_nonce', 'seibi_briefing_meta_save', $post_id ) ) {
        return;
    }

    // 要予約フラグ
    update_post_meta( $post_id, 'briefing_reservation_required', isset( $_POST['briefing_reservation_required'] ) ? '1' : '0' );

    // 種別
    $type = isset( $_POST['briefing_type'] ) && $_POST['briefing_type'] === 'outside' ? 'outside' : 'school';
    update_post_meta( $post_id, 'briefing_type', $type );

    // 学校説明会フィールド
    $school_text_fields = [
        'briefing_datetime',
        'briefing_venue',
        'briefing_reception',
        'briefing_session',
        'briefing_target',
        'briefing_method',
        'briefing_web_cancel_period',
        'briefing_notes',
        'briefing_link_label',
    ];
    foreach ( $school_text_fields as $key ) {
        update_post_meta( $post_id, $key, sanitize_text_field( wp_unslash( $_POST[ $key ] ?? '' ) ) );
    }
    update_post_meta( $post_id, 'briefing_capacity_note', wp_kses_post( wp_unslash( $_POST['briefing_capacity_note'] ?? '' ) ) );
    $briefing_link_type = in_array( $_POST['briefing_link_type'] ?? '', [ 'none', 'detail', 'external' ], true )
        ? $_POST['briefing_link_type']
        : 'none';
    update_post_meta( $post_id, 'briefing_link_type', $briefing_link_type );
    update_post_meta( $post_id, 'briefing_link_url', esc_url_raw( wp_unslash( $_POST['briefing_link_url'] ?? '' ) ) );

    // 学外説明会フィールド
    $outside_text_fields = [
        'outside_datetime',
        'outside_venue',
        'outside_time',
        'outside_link_label',
    ];
    foreach ( $outside_text_fields as $key ) {
        update_post_meta( $post_id, $key, sanitize_text_field( wp_unslash( $_POST[ $key ] ?? '' ) ) );
    }
    $outside_link_type = in_array( $_POST['outside_link_type'] ?? '', [ 'none', 'detail', 'external' ], true )
        ? $_POST['outside_link_type']
        : 'none';
    update_post_meta( $post_id, 'outside_link_type', $outside_link_type );
    update_post_meta( $post_id, 'outside_link_url', esc_url_raw( wp_unslash( $_POST['outside_link_url'] ?? '' ) ) );
    update_post_meta( $post_id, 'outside_description', sanitize_textarea_field( wp_unslash( $_POST['outside_description'] ?? '' ) ) );
}
add_action( 'save_post_briefing', 'seibi_briefing_meta_save' );


// ================================================================
// 年間行事 ギャラリー（カスタム投稿タイプ: year）
// ================================================================

function seibi_year_gallery_add_meta_box() {
    add_meta_box(
        'year_gallery',
        'ギャラリー画像',
        'seibi_year_gallery_meta_box_callback',
        'year',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'seibi_year_gallery_add_meta_box' );

function seibi_year_gallery_meta_box_callback( $post ) {
    wp_nonce_field( 'seibi_year_gallery_save', 'seibi_year_gallery_nonce' );
    $ids_str  = get_post_meta( $post->ID, '_year_gallery_ids', true );
    $id_array = $ids_str ? array_filter( explode( ',', $ids_str ) ) : [];
    ?>
    <p style="color:#666;margin-bottom:12px;">画像を追加すると、年間行事ページでクリックしてギャラリーを表示できるようになります。画像がない場合はリンクなしのテキスト表示になります。</p>
    <div id="year-gallery-preview" style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:12px;min-height:40px;padding:8px;border:1px solid #ddd;border-radius:4px;background:#fafafa;">
        <?php foreach ( $id_array as $id ) :
            $url = wp_get_attachment_image_url( (int) $id, 'thumbnail' );
            if ( ! $url ) continue; ?>
            <div class="year-gallery-thumb" data-id="<?php echo esc_attr( $id ); ?>" style="position:relative;width:80px;height:80px;">
                <img src="<?php echo esc_url( $url ); ?>" style="width:80px;height:80px;object-fit:cover;display:block;" />
                <button type="button" class="year-gallery-remove" data-id="<?php echo esc_attr( $id ); ?>" style="position:absolute;top:2px;right:2px;background:rgba(0,0,0,.6);color:#fff;border:none;cursor:pointer;width:20px;height:20px;border-radius:50%;line-height:1;padding:0;font-size:14px;">×</button>
            </div>
        <?php endforeach; ?>
    </div>
    <input type="hidden" id="year_gallery_ids" name="year_gallery_ids" value="<?php echo esc_attr( $ids_str ); ?>" />
    <button type="button" id="year-gallery-add" class="button">＋ 画像を追加</button>
    <button type="button" id="year-gallery-clear" class="button" style="margin-left:6px;color:#a00;">すべて削除</button>
    <script>
    (function($) {
        var frame;
        $('#year-gallery-add').on('click', function(e) {
            e.preventDefault();
            if (frame) { frame.open(); return; }
            frame = wp.media({
                title: '画像を選択',
                button: { text: '追加' },
                multiple: true
            });
            frame.on('select', function() {
                var selection = frame.state().get('selection');
                var ids = $('#year_gallery_ids').val() ? $('#year_gallery_ids').val().split(',').filter(Boolean) : [];
                selection.each(function(attachment) {
                    var id = String(attachment.get('id'));
                    if (ids.indexOf(id) !== -1) return;
                    ids.push(id);
                    var sizes = attachment.get('sizes');
                    var thumb = sizes && sizes.thumbnail ? sizes.thumbnail.url : attachment.get('url');
                    $('#year-gallery-preview').append(
                        '<div class="year-gallery-thumb" data-id="' + id + '" style="position:relative;width:80px;height:80px;">' +
                        '<img src="' + thumb + '" style="width:80px;height:80px;object-fit:cover;display:block;" />' +
                        '<button type="button" class="year-gallery-remove" data-id="' + id + '" style="position:absolute;top:2px;right:2px;background:rgba(0,0,0,.6);color:#fff;border:none;cursor:pointer;width:20px;height:20px;border-radius:50%;line-height:1;padding:0;font-size:14px;">×</button>' +
                        '</div>'
                    );
                });
                $('#year_gallery_ids').val(ids.join(','));
            });
            frame.open();
        });

        $(document).on('click', '.year-gallery-remove', function() {
            var id = String($(this).data('id'));
            $(this).closest('.year-gallery-thumb').remove();
            var ids = $('#year_gallery_ids').val().split(',').filter(function(v) { return v && v !== id; });
            $('#year_gallery_ids').val(ids.join(','));
        });

        $('#year-gallery-clear').on('click', function() {
            $('#year-gallery-preview').empty();
            $('#year_gallery_ids').val('');
        });
    })(jQuery);
    </script>
    <?php
}

function seibi_year_gallery_save( $post_id ) {
    if ( ! seibi_verify_meta_nonce( 'seibi_year_gallery_nonce', 'seibi_year_gallery_save', $post_id ) ) return;

    $raw = isset( $_POST['year_gallery_ids'] ) ? wp_unslash( $_POST['year_gallery_ids'] ) : '';
    // カンマ区切りの数値IDのみ許可
    $ids = array_filter( array_map( 'intval', explode( ',', $raw ) ) );
    update_post_meta( $post_id, '_year_gallery_ids', implode( ',', $ids ) );
}
add_action( 'save_post_year', 'seibi_year_gallery_save' );


// ================================================================
// 児童募集要項 カスタムフィールド（page slug = requirements）
// ================================================================

/**
 * requirements ページにのみメタボックスを追加
 *
 * @param WP_Post $post 現在の投稿オブジェクト
 */
function seibi_requirements_add_meta_boxes( $post ) {
    if ( 'requirements' !== $post->post_name ) {
        return;
    }
    add_meta_box( 'req_general',       '年度・共通設定',           'seibi_req_general_cb',       'page', 'normal', 'high' );
    add_meta_box( 'req_seibi_a', '星美クラス — A日程', 'seibi_req_seibi_a_cb', 'page', 'normal', 'high' );
    add_meta_box( 'req_seibi_b', '星美クラス — B日程', 'seibi_req_seibi_b_cb', 'page', 'normal', 'high' );
    add_meta_box( 'req_seibi_c', '星美クラス — C日程', 'seibi_req_seibi_c_cb', 'page', 'normal', 'high' );
}
add_action( 'add_meta_boxes_page', 'seibi_requirements_add_meta_boxes' );

/**
 * 児童募集要項ページの編集画面でメディアアップローダーを有効化
 */
function seibi_requirements_admin_scripts( $hook ) {
    if ( ! in_array( $hook, [ 'post.php', 'post-new.php' ], true ) ) {
        return;
    }
    $screen = get_current_screen();
    if ( ! $screen || 'page' !== $screen->post_type ) {
        return;
    }
    wp_enqueue_media();
    wp_add_inline_script( 'jquery-core', "(function($){
        $(document).on('click','.req-media-upload',function(e){
            e.preventDefault();
            var btn=\$(this), targetId=btn.data('target');
            var frame=wp.media({title:'PDFを選択',button:{text:'選択'},multiple:false,library:{type:'application/pdf'}});
            frame.on('select',function(){
                var a=frame.state().get('selection').first().toJSON();
                \$('#'+targetId).val(a.id);
                \$('#'+targetId+'_filename').text(a.filename||a.url);
                btn.siblings('.req-media-remove').show();
            });
            frame.open();
        });
        \$(document).on('click','.req-media-remove',function(e){
            e.preventDefault();
            var targetId=\$(this).data('target');
            \$('#'+targetId).val('');
            \$('#'+targetId+'_filename').text('選択されていません');
            \$(this).hide();
        });
    })(jQuery);" );
}
add_action( 'admin_enqueue_scripts', 'seibi_requirements_admin_scripts' );

// -----------------------------------------------
// 内部ヘルパー関数
// -----------------------------------------------

/** 表示切り替えチェックボックス行 */
function _req_show_checkbox( $post, $key ) {
    $checked = get_post_meta( $post->ID, $key, true );
    printf(
        '<tr><td colspan="2" style="padding:8px 0 12px;">'
        . '<label style="font-size:14px; font-weight:bold;">'
        . '<input type="checkbox" name="%1$s" value="1"%2$s style="margin-right:6px;" />'
        . 'この日程を表示する'
        . '</label></td></tr>',
        esc_attr( $key ),
        checked( $checked, '1', false )
    );
}

/** テキスト入力行 */
function _req_text_row( $post, $key, $label, $placeholder = '' ) {
    $v = get_post_meta( $post->ID, $key, true );
    printf(
        '<tr><th style="width:220px;"><label for="%1$s">%2$s</label></th>'
        . '<td><input type="text" id="%1$s" name="%1$s" value="%3$s" class="widefat" placeholder="%4$s" /></td></tr>',
        esc_attr( $key ),
        esc_html( $label ),
        esc_attr( $v ),
        esc_attr( $placeholder )
    );
}

/** テキストエリア行 */
function _req_textarea_row( $post, $key, $label, $rows = 3 ) {
    $v = get_post_meta( $post->ID, $key, true );
    printf(
        '<tr><th style="width:220px;"><label for="%1$s">%2$s</label></th>'
        . '<td><textarea id="%1$s" name="%1$s" class="widefat" rows="%4$d">%3$s</textarea></td></tr>',
        esc_attr( $key ),
        esc_html( $label ),
        esc_textarea( $v ),
        $rows
    );
}

/** メディアアップロード行（添付ファイルID を保存） */
function _req_media_row( $post, $key, $label ) {
    $attachment_id = (int) get_post_meta( $post->ID, $key, true );
    $filename = '';
    if ( $attachment_id ) {
        $file     = get_attached_file( $attachment_id );
        $filename = $file ? basename( $file ) : '（ファイルが見つかりません）';
    }
    printf(
        '<tr><th style="width:220px;"><label>%1$s</label></th>'
        . '<td>'
        . '<input type="hidden" id="%2$s" name="%2$s" value="%3$s" />'
        . '<button type="button" class="button req-media-upload" data-target="%2$s">PDFを選択</button> '
        . '<button type="button" class="button req-media-remove" data-target="%2$s"%4$s>削除</button>'
        . '<span id="%2$s_filename" style="margin-left:8px;color:#555;">%5$s</span>'
        . '</td></tr>',
        esc_html( $label ),
        esc_attr( $key ),
        esc_attr( $attachment_id ?: '' ),
        $attachment_id ? '' : ' style="display:none;"',
        esc_html( $filename ?: '選択されていません' )
    );
}

/** URL 入力行 */
function _req_url_row( $post, $key, $label ) {
    $v = get_post_meta( $post->ID, $key, true );
    printf(
        '<tr><th style="width:220px;"><label for="%1$s">%2$s</label></th>'
        . '<td><input type="url" id="%1$s" name="%1$s" value="%3$s" class="widefat" placeholder="https://" /></td></tr>',
        esc_attr( $key ),
        esc_html( $label ),
        esc_attr( $v )
    );
}

/** セクション区切りヘッダー行 */
function _req_section_header( $label ) {
    printf(
        '<tr><td colspan="2" style="padding:10px 0 4px; font-weight:bold; color:#2271b1; border-bottom:2px solid #2271b1; font-size:12px;">%s</td></tr>',
        esc_html( $label )
    );
}

// -----------------------------------------------
// コールバック: 年度・共通設定
// -----------------------------------------------
function seibi_req_general_cb( $post ) {
    wp_nonce_field( 'seibi_requirements_meta_save', 'seibi_requirements_meta_nonce' );
    echo '<table class="form-table"><tbody>';
    _req_text_row( $post, 'req_fiscal_year', '年度表示', '例: 令和9年度（2027年度）' );
    echo '</tbody></table>';
}

// -----------------------------------------------
// コールバック: 星美クラス — A日程
// -----------------------------------------------
function seibi_req_seibi_a_cb( $post ) {
    echo '<table class="form-table"><tbody>';
    _req_show_checkbox( $post, 'req_seibi_show_a' );
    _req_text_row( $post, 'req_seibi_count_a',    '募集人数',           '例: 第１学年(男、女)「星美クラス」「インターナショナルクラス」合わせて120名' );
    _req_text_row( $post, 'req_seibi_app_a',      '出願期間（Web出願）', '例: 10月1日(木)〜10月4日（日）' );
    _req_text_row( $post, 'req_seibi_int_a',      '面接期間',           '例: 10月8日（木）〜10月20日（火）' );
    _req_text_row( $post, 'req_seibi_exam_a',     '入学試験',           '例: 11月1日（日）8:50開始' );
    _req_text_row( $post, 'req_seibi_result_a',   '合格発表（Web発表）', '例: 11月2日（月）' );
    _req_section_header( '費用' );
    _req_text_row( $post, 'req_seibi_exam_fee_a',  '受験料', '例: 25,000円' );
    _req_text_row( $post, 'req_seibi_entry_fee_a', '入学金', '例: 250,000円' );
    _req_section_header( '児童募集要項ダウンロード' );
    _req_media_row( $post, 'req_seibi_pdf_id_a', 'PDFファイル' );
    echo '</tbody></table>';
}

// -----------------------------------------------
// コールバック: 星美クラス — B日程
// -----------------------------------------------
function seibi_req_seibi_b_cb( $post ) {
    echo '<table class="form-table"><tbody>';
    _req_show_checkbox( $post, 'req_seibi_show_b' );
    _req_text_row( $post, 'req_seibi_count_b',    '募集人数',           '例: 第１学年(男、女)「星美クラス」「インターナショナルクラス」合わせて120名' );
    _req_text_row( $post, 'req_seibi_app_b',      '出願期間（Web出願）', '例: 11月10日(火)〜11月14日（土）' );
    _req_text_row( $post, 'req_seibi_int_b',      '面接期間',           '例: 11月16日（月）〜 11月19日（木）' );
    _req_text_row( $post, 'req_seibi_exam_b',     '入学試験',           '例: 11月20日（金）8:50開始' );
    _req_text_row( $post, 'req_seibi_result_b',   '合格発表（Web発表）', '例: 11月21日（土）' );
    _req_section_header( '費用' );
    _req_text_row( $post, 'req_seibi_exam_fee_b',  '受験料', '例: 25,000円' );
    _req_text_row( $post, 'req_seibi_entry_fee_b', '入学金', '例: 250,000円' );
    _req_section_header( '児童募集要項ダウンロード' );
    _req_media_row( $post, 'req_seibi_pdf_id_b', 'PDFファイル' );
    echo '</tbody></table>';
}

// -----------------------------------------------
// コールバック: 星美クラス — C日程
// -----------------------------------------------
function seibi_req_seibi_c_cb( $post ) {
    echo '<table class="form-table"><tbody>';
    _req_show_checkbox( $post, 'req_seibi_show_c' );
    _req_text_row( $post, 'req_seibi_count_c',    '募集人数',           '例: 第１学年(男、女)「星美クラス」「インターナショナルクラス」合わせて120名' );
    _req_text_row( $post, 'req_seibi_app_c',      '出願期間（Web出願）', '例: 12月14日（月）〜12月27日（日）' );
    _req_text_row( $post, 'req_seibi_int_c',      '面接期間',           '例: 2027年1月4日（月）まで' );
    _req_text_row( $post, 'req_seibi_exam_c',     '入学試験',           '例: 2027年1月6日（水）未定' );
    _req_text_row( $post, 'req_seibi_result_c',   '合格発表（Web発表）', '例: 2027年1月8日（金）17:00' );
    _req_section_header( '費用' );
    _req_text_row( $post, 'req_seibi_exam_fee_c',  '受験料', '例: 25,000円' );
    _req_text_row( $post, 'req_seibi_entry_fee_c', '入学金', '例: 250,000円' );
    _req_section_header( '児童募集要項ダウンロード' );
    _req_media_row( $post, 'req_seibi_pdf_id_c', 'PDFファイル' );
    echo '</tbody></table>';
}


// -----------------------------------------------
// 保存処理
// -----------------------------------------------
function seibi_requirements_meta_save( $post_id ) {
    if ( ! seibi_verify_meta_nonce( 'seibi_requirements_meta_nonce', 'seibi_requirements_meta_save', $post_id ) ) {
        return;
    }

    $text_fields = [
        'req_fiscal_year',
        // 星美クラス A日程
        'req_seibi_count_a',
        'req_seibi_app_a',    'req_seibi_int_a',    'req_seibi_exam_a',    'req_seibi_result_a',
        'req_seibi_exam_fee_a', 'req_seibi_entry_fee_a',
        // 星美クラス B日程
        'req_seibi_count_b',
        'req_seibi_app_b',    'req_seibi_int_b',    'req_seibi_exam_b',    'req_seibi_result_b',
        'req_seibi_exam_fee_b', 'req_seibi_entry_fee_b',
        // 星美クラス C日程
        'req_seibi_count_c',
        'req_seibi_app_c',    'req_seibi_int_c',    'req_seibi_exam_c',    'req_seibi_result_c',
        'req_seibi_exam_fee_c', 'req_seibi_entry_fee_c',
    ];
    foreach ( $text_fields as $key ) {
        update_post_meta( $post_id, $key, sanitize_text_field( wp_unslash( $_POST[ $key ] ?? '' ) ) );
    }

    foreach ( [ 'req_seibi_pdf_id_a', 'req_seibi_pdf_id_b', 'req_seibi_pdf_id_c' ] as $key ) {
        update_post_meta( $post_id, $key, absint( $_POST[ $key ] ?? 0 ) );
    }

    // 表示切り替えチェックボックス（未チェック時はPOSTに含まれないため個別処理）
    foreach ( [ 'req_seibi_show_a', 'req_seibi_show_b', 'req_seibi_show_c' ] as $key ) {
        update_post_meta( $post_id, $key, isset( $_POST[ $key ] ) ? '1' : '0' );
    }
}
add_action( 'save_post_page', 'seibi_requirements_meta_save' );


// ================================================================
// 公開行事 カスタムフィールド（post type = event）
// ================================================================

function seibi_event_add_meta_box() {
    add_meta_box(
        'event_details',
        '行事詳細',
        'seibi_event_meta_box_callback',
        'event',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'seibi_event_add_meta_box' );

function seibi_event_meta_box_callback( $post ) {
    wp_nonce_field( 'seibi_event_meta_save', 'seibi_event_meta_nonce' );

    $text_fields = [
        'event_date'      => '日時',
        'event_place'     => '場所',
        'event_reception' => '受付',
        'event_items'     => '持ち物',
        'event_target'    => '参加対象',
        'event_method'    => '参加方法',
        'event_period'    => '予約期間',
        'event_notes'     => '注意事項',
    ];
    $event_link_type = get_post_meta( $post->ID, 'event_link_type', true ) ?: 'none';
    printf(
        '<div style="margin-bottom:12px; padding:8px 12px; background:#f0f6fc; border:1px solid #c3d9f0; border-radius:4px;">'
        . '<label style="font-size:13px; font-weight:bold;">'
        . '<input type="checkbox" name="event_reservation_required" value="1"%s style="margin-right:6px;" />'
        . '要予約（チェックなし = 予約不要）'
        . '</label></div>',
        checked( get_post_meta( $post->ID, 'event_reservation_required', true ), '1', false )
    );
    echo '<table class="form-table"><tbody>';
    ?>
    <tr>
      <th>ボタン・リンク</th>
      <td>
        <label style="display:block; margin-bottom:6px;">
          <input type="radio" name="event_link_type" value="none" <?php checked( $event_link_type, 'none' ); ?> />
          リンクなし
        </label>
        <label style="display:block; margin-bottom:6px;">
          <input type="radio" name="event_link_type" value="detail" <?php checked( $event_link_type, 'detail' ); ?> />
          詳細ページ（ボタン名:「詳細・参加予約はこちらから」）
        </label>
        <label style="display:block;">
          <input type="radio" name="event_link_type" value="external" <?php checked( $event_link_type, 'external' ); ?> />
          外部URL
        </label>
        <div id="event-link-external" style="<?php echo $event_link_type === 'external' ? '' : 'display:none;'; ?> margin-top:10px; padding:10px 12px; background:#f9f9f9; border:1px solid #ddd; border-radius:4px;">
          <table class="form-table" style="margin:0;"><tbody>
            <tr>
              <th style="width:120px;"><label for="event_link_label">ボタン名</label></th>
              <td><input type="text" id="event_link_label" name="event_link_label" value="<?php echo esc_attr( get_post_meta( $post->ID, 'event_link_label', true ) ); ?>" class="widefat" /></td>
            </tr>
            <tr>
              <th><label for="event_link_url">リンク先URL</label></th>
              <td><input type="url" id="event_link_url" name="event_link_url" value="<?php echo esc_attr( get_post_meta( $post->ID, 'event_link_url', true ) ); ?>" class="widefat" placeholder="https://" /></td>
            </tr>
          </tbody></table>
        </div>
      </td>
    </tr>
    <tr><td colspan="2"><hr style="margin:8px 0;" /></td></tr>
    <?php
    foreach ( $text_fields as $key => $label ) {
        $value = get_post_meta( $post->ID, $key, true );
        printf(
            '<tr><th style="width:260px;"><label for="%1$s">%2$s</label></th>'
            . '<td><input type="text" id="%1$s" name="%1$s" value="%3$s" class="widefat" /></td></tr>',
            esc_attr( $key ),
            esc_html( $label ),
            esc_attr( $value )
        );
    }
    echo '</tbody></table>';
    echo '<p style="margin:12px 0 4px; font-weight:bold;">自由入力欄</p>';
    wp_editor(
        get_post_meta( $post->ID, 'event_capacity_note', true ),
        'event_capacity_note',
        [ 'textarea_name' => 'event_capacity_note', 'media_buttons' => false, 'teeny' => true, 'textarea_rows' => 20 ]
    );
    ?>
    <script>
    (function() {
        document.querySelectorAll('input[name="event_link_type"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                document.getElementById('event-link-external').style.display =
                    this.value === 'external' ? '' : 'none';
            });
        });
    })();
    </script>
    <?php
}

function seibi_event_meta_save( $post_id ) {
    if ( ! seibi_verify_meta_nonce( 'seibi_event_meta_nonce', 'seibi_event_meta_save', $post_id ) ) {
        return;
    }

    $text_fields = [
        'event_date', 'event_place', 'event_reception',
        'event_items', 'event_target', 'event_method',
        'event_period', 'event_notes', 'event_link_label',
    ];
    foreach ( $text_fields as $key ) {
        update_post_meta( $post_id, $key, sanitize_text_field( wp_unslash( $_POST[ $key ] ?? '' ) ) );
    }
    $event_link_type = in_array( $_POST['event_link_type'] ?? '', [ 'none', 'detail', 'external' ], true )
        ? $_POST['event_link_type']
        : 'none';
    update_post_meta( $post_id, 'event_link_type', $event_link_type );
    update_post_meta( $post_id, 'event_link_url', esc_url_raw( wp_unslash( $_POST['event_link_url'] ?? '' ) ) );
    update_post_meta( $post_id, 'event_capacity_note', wp_kses_post( wp_unslash( $_POST['event_capacity_note'] ?? '' ) ) );
    update_post_meta( $post_id, 'event_reservation_required', isset( $_POST['event_reservation_required'] ) ? '1' : '0' );
}
add_action( 'save_post_event', 'seibi_event_meta_save' );
