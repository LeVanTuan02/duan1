<?php

    require_once '../../global.php';
    require_once '../../dao/product.php';
    require_once '../../dao/analytic.php';

    extract($_REQUEST);

    if (array_key_exists('btn_contact', $_REQUEST)) {
        // trang liên hệ

    
        
    } else if (array_key_exists('contact', $_REQUEST)) {
        // trang liên hệ

    
        
    } else if (array_key_exists('intro', $_REQUEST)) {
        $VIEW_PAGE = "intro.php";
    } else if (array_key_exists('order', $_REQUEST)) {
        $VIEW_PAGE = "order.php";
    } else {
        // danh sách menu
        $listProduct = product_home_select_all(0, 8);

        // danh mục sản phẩm
        $categoryInfo = analytics_quantity_product_by_cate();
        $VIEW_PAGE = "home.php";
    }

    require_once '../layout.php';

?>