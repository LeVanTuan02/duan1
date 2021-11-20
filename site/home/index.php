<?php

    require_once '../../global.php';
    require_once '../../dao/product.php';
    require_once '../../dao/analytic.php';

    extract($_REQUEST);

    if (array_key_exists('', $_REQUEST)) {
        
    } else if (array_key_exists('', $_REQUEST)) {

    }
    else {
        // danh sách menu
        $listProduct = product_home_select_all(0, 8);

        // danh mục sản phẩm
        $categoryInfo = analytics_quantity_product_by_cate();
        $VIEW_PAGE = "home.php";
    }

    require_once '../layout.php';

?>