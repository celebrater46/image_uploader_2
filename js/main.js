"use strict";

$(function() {
    $(".msg").fadeOut(3000);
    $("#my-file").on("change", function() { // ファイルが変更されたら自動的に submit
        $("#my-form").submit();
    });
});