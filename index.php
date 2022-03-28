<?php

namespace image_uploader;

require_once "ImgUploader.php";
require_once "iu_get_html.php";
require_once HTML_COMMON_MODULE . "/html_common_module.php";

// セッション宣言
session_start();

//$uploader = iu_get_html("");

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>画像アップロード掲示板</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>
<?php echo iu_get_html("", true); ?>
</body>
</html>