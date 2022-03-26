<?php

namespace image_uploader;

use image_uploader\modules as modules;

require_once "ImgUploader.php";
require_once "iu_get_html.php";
//require_once "init.php";
require_once HTML_COMMON_MODULE . "/html_common_module.php";

// セッション宣言
// start_session();
session_start();

// 画像処理には GD というプラグインが必要。入っているかどうかのチェック
//if (!function_exists('imagecreatetruecolor')) {
//  echo "GD が入ってへん！！";
//  exit;
//}

// さまざまな表示のためのエスケープ
//function h($s) {
//  // return htmlspecialchars($s, "ENT_QUOTES", "UTF-8");
//  return htmlspecialchars($s, ENT_QUOTES, "UTF-8"); // ENT_QUOTES にはダブルコートつけない
//}

//$uploader = new ImgUploader();
//
//if ($_SERVER["REQUEST_METHOD"] === "POST") { // 定義済み変数。投稿、送信が行われたらの処理
//  $uploader->upload();
//}
//
//list($success, $error) = $uploader->getResults();
//$images = $uploader->getImages();

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>画像アップロード掲示板</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>
<?php echo iu_get_html(); ?>
</body>
</html>