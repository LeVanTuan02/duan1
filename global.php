<?php

    session_start();

    // biến toàn cục
    $ROOT_URL = '/duan1';
    $ADMIN_URL = "$ROOT_URL/admin";
    $SITE_URL = "$ROOT_URL/site";
    $IMG_URL = "$ROOT_URL/uploads";

    $IMG_PATH = $_SERVER['DOCUMENT_ROOT'] . $IMG_URL;

    function save_file($filename, $dir_path) {
        $file_upload = $_FILES[$filename];
        $file_name = $file_upload['name'];
        $file_dir_path = $dir_path . $file_name;
        move_uploaded_file($file_upload['tmp_name'], $file_dir_path);
        return $file_name;
    }


?>