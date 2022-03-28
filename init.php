<?php

namespace image_uploader;

// アップロード時の変更箇所。IMAGES_DIR, THUMBNAIL_DIR, upload.php header
ini_set('display_errors', 1); // xampp みたいなエラーメッセージ出してくれる
define('MAX_FILE_SIZE', 1 * 1024 * 1024); // 1MB
define('THUMBNAIL_WIDTH', 400);
//define('IMAGES_DIR', __DIR__ . '/img'); // 画像ファイルのディレクトリ（__DIR__ は現在のディレクトリ取得）
//define('THUMBNAIL_DIR', __DIR__ . '/s'); // サムネイルディレクトリ
// define('IMAGES_DIR', 'http://localhost/myapps/image_uploader/img');
// define('THUMBNAIL_DIR', 'http://localhost/myapps/image_uploader/s');
define('IMAGES_DIR', 'J:\Dropbox\PC5_cloud\pg\xampp\htdocs\myapps\image_uploader\img'); // ローカル開発環境のディレクトリはこちらが正解
define('THUMBNAIL_DIR', 'J:\Dropbox\PC5_cloud\pg\xampp\htdocs\myapps\image_uploader\s');
define('HTML_COMMON_MODULE', 'modules');
define('IU_USE_FORM', false); // <form> タグを書くか
define('IU_USE_SUBMIT_BTN', true); // 送信ボタンを置くか
define('IU_SHOW_POSTED_IMAGES', false); // アップロードした画像一覧を表示するかどうか