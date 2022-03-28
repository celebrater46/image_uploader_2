<?php

namespace image_uploader;

class ImgUploader {
  public $_imageFileName;
  private $_imageType;

  public function upload() {
    try {
      // エラーチェック
      $this->_validateUpload();

      // 画像の形式が違うと処理も変わるので、形式をチェック
      $ext = $this->_validateImageType();
       var_dump($ext); // うまく行ったかチェック！
      // exit;

      // 保存
      $savePath = $this->_save($ext);

      // 必要ならサムネイル生成
      $this->_createThumbnail($savePath);

      $_SESSION["success"] = "アップロードしたで！！";

      // テスト用
      echo "Upload succeeded." . "<br>";

    } catch (\Exception $e) {
      $_SESSION["error"] = $e->getMessage();
        // テスト用
        echo "Upload failed." . "<br>";
      // exit;
    }
    // リダイレクトにはヘッダ命令
    // header("Location: http://" . $_SERVER["HTTP_HOST"]);
    // header("Location: C:\xampp\htdocs\PG\DotInstall\PHP\php7\index.php");
    // header("Location: http://localhost/PG/DotInstall/PHP/php7/index.php"); // リダイレクトは http～が正解
    if(IU_REDIRECT){
      header("Location: " . IU_REDIRECT_TO);
    }
    exit;
  }

  public function getResults() {
    $success = null; // 初期化
    $error = null; 
    if (isset($_SESSION["success"])) {
      $success = $_SESSION["success"];
      unset($_SESSION["success"]); // 変数に格納したので要らんからすぐに消す（残ってるとリロードした時に何度も出てくる）
    }
    if (isset($_SESSION["error"])) {
      $error = $_SESSION["error"];
      unset($_SESSION["error"]); 
    }
    return [$success, $error];
  }

  public function getImages() {
    $images = [];
    $files = [];
    $imageDir = opendir(IMAGES_DIR);
    // echo $imageDir . PHP_EOL; // テスト用
    // var_dump($imageDir);
    $test = 0; // テスト用
    while (false !== ($file = readdir($imageDir))) {
      if ($file === "." || $file === "..") {
        continue;
      }
      $files[] = $file;
      if (file_exists(THUMBNAIL_DIR . "/" . $file)) { // サムネイルがあるかどうか
        // $images[] = basename(THUMBNAIL_DIR . "/" . $file); // 括弧の位置がおかしかったおかげで画像が表示されなかった（ディレクトリ生成に失敗していた）
        $images[] = basename(THUMBNAIL_DIR) . "/" . $file;
      } else {
        // $images[] = basename(IMAGES_DIR . "/" . $file); // 上に同じ
        $images[] = basename(IMAGES_DIR) . "/" . $file;
      }

      // 50回の制限を超えたらエラーに
      $test++;
      if ($test > 50) { 
        throw new \Exception("無限ループが発生しとるで！！"); 
        exit;
      }
    }
    array_multisort($files, SORT_DESC, $images); // ファイルの逆順にイメージを並べる
    return $images;
  }

  private function _createThumbnail($savePath) {
    $imageSize = getimagesize($savePath); //画像サイズの取得
    $width = $imageSize[0]; // 幅は 0 高さは 1 で渡ってくる
    $height = $imageSize[1];
    if ($width > THUMBNAIL_WIDTH) {
      $this->_createThumbnailMain($savePath, $width, $height);
    }
  }

  private function _createThumbnailMain($savePath, $width, $height) {
    switch ($this->_imageType) {
      case IMAGETYPE_GIF:
        $srcImage = imagecreatefromgif($savePath); // 画像リソースの作成
        break;
      case IMAGETYPE_JPEG:
        $srcImage = imagecreatefromjpeg($savePath); // 画像リソースの作成
        break;
      case IMAGETYPE_PNG:
        $srcImage = imagecreatefrompng($savePath); // 画像リソースの作成
        break;
    }

    $thumbHeight = round($height * THUMBNAIL_WIDTH / $width);
    $thumbImage = imagecreatetruecolor(THUMBNAIL_WIDTH, $thumbHeight);
    imagecopyresampled($thumbImage, $srcImage, 0, 0, 0, 0, THUMBNAIL_WIDTH, $thumbHeight, $width, $height); // コピー先リソース、コピー元リソース、コピー先のX座標、同Y座標、コピー元のX座標、Y座興、コピー元の幅、高さ、コピー元の幅、高さ

    switch ($this->_imageType) {
      case IMAGETYPE_GIF:
        imagegif($thumbImage, THUMBNAIL_DIR . "/" . $this->_imageFileName);
        break;
      case IMAGETYPE_JPEG:
        imagejpeg($thumbImage, THUMBNAIL_DIR . "/" . $this->_imageFileName);
        break;
      case IMAGETYPE_PNG:
        imagepng($thumbImage, THUMBNAIL_DIR . "/" . $this->_imageFileName);
        break;
    }
  }

  private function _save($ext) {
    $this->_imageFileName = sprintf(
      '%s_%s.%s',
      time(),
      sha1(uniqid(mt_rand(), true)),
      $ext
    );
    $savePath = IMAGES_DIR . '/' . $this->_imageFileName;
    $res = move_uploaded_file($_FILES['image']['tmp_name'], $savePath);
    if ($res === false) {
      throw new \Exception('Could not upload!');
    }
    return $savePath;
  }

  private function _validateImageType() {
    $this->_imageType = exif_imagetype($_FILES["image"]["tmp_name"]); // 画像の種類を判別してくれる
    switch ($this->_imageType) {
      case IMAGETYPE_GIF:
        return "gif"; // 語尾に「やで」とかつけると拡張子の後ろに追加されちゃう。
      case IMAGETYPE_JPEG:
        return "jpg";
      case IMAGETYPE_PNG:
        return "png";
      default:
        throw new \Exception("gif jpg png 以外は認めへんっ！！");
    }
  }

  private function _validateUpload() {
     var_dump($_FILES);
    // exit;

    if (!isset($_FILES["image"]) || !isset($_FILES["image"]["error"])) { // 右のは改ざんされたフォームからのチェック
      // 変なファイル飛んできたらエスケープ
      throw new \Exception("そんなファイルはアップロードできん。");
    }

    // エラーの種類に応じた処理
    switch ($_FILES["image"]["error"]) {
      case UPLOAD_ERR_OK: // うまくいった場合
        return true;
      case UPLOAD_ERR_INI_SIZE: // 既定のサイズを超えていた場合
      case UPLOAD_ERR_FORM_SIZE:
        throw new \Exception("ファイルサイズが大きすぎるゥ！！！");
      default:
        throw new \Exception("何かわからんけど……エラー。" . $_FILES["image"]["error"]);
    }
  }
}