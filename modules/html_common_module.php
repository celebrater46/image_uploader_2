<?php

namespace image_uploader\modules;

function space_br($html, $num): string
{
    $space = str_repeat("    ", $num);
    return $space . $html . "\n";
}

function delete_br($line){
    return str_replace(["\n", "\r", "\r\n"], "", $line);
}

function h($s): string
{
    return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}