<?php

    require_once '../../global.php';
    require_once '../../dao/product.php';
    require_once '../../dao/category.php';
    extract($_REQUEST);

    if (array_key_exists('search', $_REQUEST)) {
        $VIEW_PAGE = "";
    } else if (array_key_exists('category', $_REQUEST)) {

    } else if (array_key_exists('detail', $_REQUEST)) {
        // chi tiết sản phẩm
        $titleData = "Chi tiết sản phẩm";
        $itemData = product_home_select_by_id($id);
        extract($itemData);

        $item_tt = product_home_select_all();
        $VIEW_PAGE = "detail.php";
    } else {
        // trang danh sách sp
        $title = "Sản phẩm";
        $item = product_home_select_all();
        // echo "<pre>";
        // var_dump($item);

        $VIEW_PAGE = "list.php";
    }

    require_once '../layout.php';

?>