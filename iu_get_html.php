<?php

namespace image_uploader;

use function image_uploader\modules\space_br;

require_once HTML_COMMON_MODULE . "/html_common_module.php";
require_once "ImgUploader.php";

function get_script_html(){
    $html = space_br('<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>', 1);
    $html .= space_br('<script type="text/javascript" src="js/main.js"></script>', 1);
    return $html;
}

function get_uploaded_images($images){
    $html = space_br("<ul>", 1);
    foreach ($images as $image){
        $html .= space_br('<li><a href="' . (basename(IMAGES_DIR)) . "/" . (basename($image)) . '">', 2);
        $html .= space_br('<img src="' . $image . '">', 3);
        $html .= space_br('</a></li>', 2);
    }
    $html .= space_br("</ul>", 1);
    return $html;
}

function get_success_or_error($success, $error){
    if(isset($success)){
        return space_br('<div class="msg success">' . $success . '</div>', 1);
    } else if(isset($error)){
        return space_br('<div class="msg error">' . $error . '</div>', 1);
    } else {
        return "";
    }
}

function create_upload_button(){
    $html = space_br('<div class="btn">', 1);
    $html .= space_br('アップロードやで！！', 2);
    $html .= space_br('<form action="" method="post" enctype="multipart/form-data" id="my-form">', 2);
    $html .= space_br('<input type="hidden" name="MAX_FILE_SIZE" value="' . MAX_FILE_SIZE . '">', 3);
    $html .= space_br('<input type="file" name="image" id="my-file">', 3);
    $html .= space_br("</form>", 2);
    $html .= space_br("</div>", 2);
    return $html;
}

function iu_get_html(){
    if (!function_exists('imagecreatetruecolor')) {
        echo "GD が入ってへん！！";
        exit;
    }

    $uploader = new ImgUploader();

    if ($_SERVER["REQUEST_METHOD"] === "POST") { // 定義済み変数。投稿、送信が行われたらの処理
        $uploader->upload();
    }

    list($success, $error) = $uploader->getResults();
    $images = $uploader->getImages();

    $html = create_upload_button();
    $html .= get_success_or_error($success, $error);
    $html .= get_uploaded_images($images);
    $html .= get_script_html();
    return $html;
}