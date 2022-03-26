<?php

namespace image_uploader;

use image_uploader\modules as modules;

require_once "ImgUploader.php";
require_once "init.php";
require_once HTML_COMMON_MODULE . "/html_common_module.php";

// セッション宣言
// start_session();
session_start();

// 画像処理には GD というプラグインが必要。入っているかどうかのチェック
if (!function_exists('imagecreatetruecolor')) {
  echo "GD が入ってへん！！";
  exit;
}

// さまざまな表示のためのエスケープ
//function h($s) {
//  // return htmlspecialchars($s, "ENT_QUOTES", "UTF-8");
//  return htmlspecialchars($s, ENT_QUOTES, "UTF-8"); // ENT_QUOTES にはダブルコートつけない
//}

$uploader = new ImgUploader();

if ($_SERVER["REQUEST_METHOD"] === "POST") { // 定義済み変数。投稿、送信が行われたらの処理
  $uploader->upload();
}

list($success, $error) = $uploader->getResults();
$images = $uploader->getImages();

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>画像アップロード掲示板</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>
  <div class="btn">
    アップロードやで！！
    <form action="" method="post" enctype="multipart/form-data" id="my-form">
      <!-- ファイルの最大サイズの指定 -->
      <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo modules\h(MAX_FILE_SIZE); ?>">
      <input type="file" name="image" id="my-file">
      <!-- <input type="submit" value="upload"> -->
    </form>
  </div>

  <?php if(isset($success)) : ?>
    <div class="msg success"><?php echo modules\h($success); ?></div>
  <?php endif; ?>
  <?php if(isset($error)) : ?>
    <div class="msg error"><?php echo modules\h($error); ?></div>
  <?php endif; ?>

  <ul>
    <?php foreach ($images as $image) : ?>
      <li>
        <a href="<?php echo modules\h(basename(IMAGES_DIR)) . "/" . modules\h(basename($image)); // basename() はパスからファイル名を取得 ?>">
          <img src="<?php echo modules\h($image); ?>">
        </a>
      </li>  
      <?php endforeach; ?> 
  </ul>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script type="text/javascript" src="js/main.js"></script>
</body>
</html>