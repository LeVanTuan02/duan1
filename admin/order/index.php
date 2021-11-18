<?php

    require_once '../../global.php';
    require_once '../../dao/order.php';
    require_once '../../dao/order_detail.php';

    extract($_REQUEST);

    if (array_key_exists('update_stt', $_REQUEST)) {
        order_update_status($status, $id);
        header('Location: ' . $ADMIN_URL . '/order/?detail&id=' . $id);
    } else if (array_key_exists('detail', $_REQUEST)) {
        // chi tiết hóa đơn
        $listOrderDetail = order_detail_select_all_by_o_id($id);

        $orderInfo = order_select_by_id($id);
        $VIEW_PAGE = "detail.php";
    } else {
        $listOrder = order_select_all();
        $VIEW_PAGE = "list.php";
    }

    require_once '../layout.php';

?>