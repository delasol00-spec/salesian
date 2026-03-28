<?php
/**
 * 学校紹介 セクション親ページ
 * URL: /about/
 * Slug: about
 *
 * このページ単独のコンテンツは存在しない。
 * 最初の子ページ（校長メッセージ）へリダイレクトする。
 *
 * @package salesian
 */

seibi_redirect_to_first_child();
