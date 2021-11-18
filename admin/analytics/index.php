<?php

    require_once '../../global.php';
    require_once '../../dao/product.php';
    require_once '../../dao/analytic.php';

    extract($_REQUEST);

    if (array_key_exists('chart', $_REQUEST)) {
        // thống kê loại hàng
        $quantityAnalytics = analytics_quantity_product_by_cate();

        // thống kê user
        $userAnalytics = analytics_user();

        // thống kê kh đky theo tháng
        $userRegAnalytics = analytics_user_reg();
        $VIEW_PAGE = "chart.php";
    } else if (array_key_exists('btn_delete', $_REQUEST)) {
        comment_delete($id);
        header('Location: ' . $ADMIN_URL . '/comment/?detail&p_id=' . $p_id);
    } else {
        $quantityAnalytics = analytics_quantity_product_by_cate();
        $priceAnalytics = analytics_price_product_by_cate();
        
        $dataAnalytics = [];
        foreach ($quantityAnalytics as $qnt) {
            foreach ($priceAnalytics as $price) {
                if ($qnt['id'] == $price['id']) {
                    $newArr = array_merge($qnt, $price);
                    array_push($dataAnalytics, $newArr);
                }
            }
        }

        $VIEW_PAGE = "list.php";
    }

    require_once '../layout.php';

?>