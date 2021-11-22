<?php

    require_once '../../global.php';
    require_once '../../dao/product.php';
    require_once '../../dao/analytic.php';

    check_login();
    extract($_REQUEST);

    if (array_key_exists('chart', $_REQUEST)) {
        // thống kê đơn hàng mới, đã xác nhận, đã hủy
        $totalOrderNew = analytics_select_totalOrder_by_stt(0); //đơn mới
        $totalOrderVerified = analytics_select_totalOrder_by_stt(1); //đã xác nhận
        $totalOrderShip = analytics_select_totalOrder_by_stt(2); //đang giao
        $totalOrderSuccess = analytics_select_totalOrder_by_stt(3); //đã giao
        $totalOrderCancel = analytics_select_totalOrder_by_stt(4); //đã hủy
        $totalOrder = $totalOrderNew + $totalOrderVerified + $totalOrderShip + $totalOrderSuccess + $totalOrderCancel;

        // thống kê loại hàng
        $quantityAnalytics = analytics_quantity_product_by_cate();

        // thống kê user
        $userAnalytics = analytics_user();

        // thống kê doanh thu
        $priceAnalytics = analytics_price();

        // thống kê kh đky theo tháng
        $userRegAnalytics = analytics_user_reg();
        $VIEW_PAGE = "chart.php";
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