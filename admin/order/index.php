<?php

    require_once '../../global.php';
    require_once '../../dao/order.php';
    require_once '../../dao/settings.php';
    require_once '../../dao/order_detail.php';

    check_login();

    require_once '../../vendor/dompdf/autoload.inc.php';
    use Dompdf\Dompdf;

    extract($_REQUEST);

    if (array_key_exists('update_stt', $_REQUEST)) {
        order_update_status($status, $id);
        header('Location: ' . $ADMIN_URL . '/order/?detail&id=' . $id);
    } else if (array_key_exists('detail', $_REQUEST)) {
        // chi tiết hóa đơn
        $listOrderDetail = order_detail_select_all_by_o_id($id);

        // thông tin hóa đơn
        $orderInfo = order_select_by_id($id);

        $VIEW_PAGE = "detail.php";
    } else if (array_key_exists('invoice', $_REQUEST)) {
        // xuất hóa đơn

        require_once 'invoice.php';
        exit();
    } else {
        // phân trang
        $totalOrder = count(order_select_all());
        $limit = 10;
        $totalPage = ceil($totalOrder / $limit);

        $currentPage = $page ?? 1;

        if ($currentPage <= 0) {
            header('Location: ' . $ADMIN_URL . '/order/?page=1');
        } else if ($currentPage > $totalPage) {
            $currentPage = $totalPage;
        }

        $start = ($currentPage - 1) * $limit;

        $listOrder = order_select_all($start, $limit);

        $VIEW_PAGE = "list.php";
    }

    require_once '../layout.php';

?>