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

    // 学校説明会フィールド
    $school_fields = [
        'briefing_datetime'          => '日時',
        'briefing_target'            => '対象',
        'briefing_reception'         => '受付',
        'briefing_session'           => '説明会',
        'briefing_web_cancel_period' => 'WEB予約・キャンセル受付期間',
    ];

    // 学外説明会フィールド
    $outside_fields = [
        'outside_datetime'    => '日時',
        'outside_venue'       => '会場',
        'outside_time'        => '時間',
        'outside_description' => '説明文',
    ];
    ?>
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

    <div id="briefing-school-fields" style="<?php echo $type === 'school' ? '' : 'display:none;'; ?>">
      <table class="form-table"><tbody>
      <?php foreach ( $school_fields as $key => $label ) :
          $value = get_post_meta( $post->ID, $key, true ); ?>
        <tr>
          <th style="width:220px;"><label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label></th>
          <td><input type="text" id="<?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $value ); ?>" class="widefat" /></td>
        </tr>
      <?php endforeach; ?>
        <tr><td colspan="2"><hr style="margin:8px 0;" /></td></tr>
        <tr>
          <th><label for="briefing_button_text">ボタンテキスト</label></th>
          <td><input type="text" id="briefing_button_text" name="briefing_button_text" value="<?php echo esc_attr( get_post_meta( $post->ID, 'briefing_button_text', true ) ); ?>" class="widefat" /></td>
        </tr>
        <tr>
          <th><label for="briefing_button_url">リンク先URL</label></th>
          <td><input type="url" id="briefing_button_url" name="briefing_button_url" value="<?php echo esc_attr( get_post_meta( $post->ID, 'briefing_button_url', true ) ); ?>" class="widefat" placeholder="https://" /></td>
        </tr>
      </tbody></table>
    </div>

    <div id="briefing-outside-fields" style="<?php echo $type === 'outside' ? '' : 'display:none;'; ?>">
      <table class="form-table"><tbody>
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
        <tr><td colspan="2"><hr style="margin:8px 0;" /></td></tr>
        <tr>
          <th><label for="outside_button_text">ボタンテキスト</label></th>
          <td><input type="text" id="outside_button_text" name="outside_button_text" value="<?php echo esc_attr( get_post_meta( $post->ID, 'outside_button_text', true ) ); ?>" class="widefat" /></td>
        </tr>
        <tr>
          <th><label for="outside_button_url">リンク先URL</label></th>
          <td><input type="url" id="outside_button_url" name="outside_button_url" value="<?php echo esc_attr( get_post_meta( $post->ID, 'outside_button_url', true ) ); ?>" class="widefat" placeholder="https://" /></td>
        </tr>
      </tbody></table>
    </div>

    <script>
    (function() {
        var radios = document.querySelectorAll('input[name="briefing_type"]');
        var schoolDiv  = document.getElementById('briefing-school-fields');
        var outsideDiv = document.getElementById('briefing-outside-fields');
        radios.forEach(function(radio) {
            radio.addEventListener('change', function() {
                schoolDiv.style.display  = this.value === 'school'  ? '' : 'none';
                outsideDiv.style.display = this.value === 'outside' ? '' : 'none';
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
    if ( ! isset( $_POST['seibi_briefing_meta_nonce'] ) ) {
        return;
    }
    if ( ! wp_verify_nonce( $_POST['seibi_briefing_meta_nonce'], 'seibi_briefing_meta_save' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // 種別
    $type = isset( $_POST['briefing_type'] ) && $_POST['briefing_type'] === 'outside' ? 'outside' : 'school';
    update_post_meta( $post_id, 'briefing_type', $type );

    // 学校説明会フィールド
    $school_fields = [
        'briefing_datetime',
        'briefing_target',
        'briefing_reception',
        'briefing_session',
        'briefing_web_cancel_period',
        'briefing_button_text',
        'briefing_button_url',
    ];
    foreach ( $school_fields as $key ) {
        update_post_meta( $post_id, $key, sanitize_text_field( wp_unslash( $_POST[ $key ] ?? '' ) ) );
    }

    // 学外説明会フィールド
    $outside_fields = [
        'outside_datetime',
        'outside_venue',
        'outside_time',
        'outside_button_text',
        'outside_button_url',
    ];
    foreach ( $outside_fields as $key ) {
        update_post_meta( $post_id, $key, sanitize_text_field( wp_unslash( $_POST[ $key ] ?? '' ) ) );
    }
    update_post_meta( $post_id, 'outside_description', sanitize_textarea_field( wp_unslash( $_POST['outside_description'] ?? '' ) ) );
}
add_action( 'save_post_briefing', 'seibi_briefing_meta_save' );
