<?php

    require_once '../../global.php';
    require_once '../../dao/product.php';

    if (array_key_exists('search', $_REQUEST)) {
        $VIEW_PAGE = "";
    } else if (array_key_exists('category', $_REQUEST)) {

    } else if (array_key_exists('', $_REQUEST)) {
        // chi tiết sản phẩm




        
    } else {
        // trang danh sách sp



        $VIEW_PAGE = "list.php";
    }

    require_once '../layout.php';

?>