<?php

namespace image_uploader;

require_once dirname(__FILE__) . '/../fcm_init.php';

// アップロード時の変更箇所。IMAGES_DIR, THUMBNAIL_DIR, upload.php header
ini_set('display_errors', 1); // xampp みたいなエラーメッセージ出してくれる

define('MAX_FILE_SIZE', 10 * 1024 * 1024); // N * 1MB
define('THUMBNAIL_WIDTH', 400);

define('IU_USE_FORM', false); // <form> タグを書くか
define('IU_USE_SUBMIT_BTN', true); // 送信ボタンを置くか
define('IU_SHOW_POSTED_IMAGES', false); // アップロードした画像一覧を表示するかどうか
define('IU_REDIRECT', false); // アップロード後にリダイレクトするかどうか

define('IU_HCM', FCM_HCM);
define('IU_REDIRECT_TO', 'http://localhost/php_hp_gallery/upload.php'); // リダイレクト先の指定
define('IU_PATH', '/home/enin-world/www/fp_common_modules/image_uploader_2/');
define('IMAGES_DIR', IU_PATH . 'img');
define('THUMBNAIL_DIR', IU_PATH . 'thumb');
