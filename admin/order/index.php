<?php

    require_once '../../global.php';
    require_once '../../dao/order.php';
    require_once '../../dao/attribute.php';
    require_once '../../dao/product.php';
    require_once '../../dao/settings.php';
    require_once '../../dao/order_detail.php';

    check_login();

    require_once '../../vendor/dompdf/autoload.inc.php';
    use Dompdf\Dompdf;

    extract($_REQUEST);

    if (array_key_exists('update_stt', $_REQUEST)) {
        $updated_at = Date('Y-m-d H:i:s');
        
        // lấy thông tin sp từ hóa đơn chi tiết
        $orderDetail = order_detail_select_all_by_o_id($id);

        
        switch ($status) {
            case '4':
                // cập nhật sl của sp
                foreach ($orderDetail as $order) {
                    attribute_update_more_quantity($order['product_id'], $order['product_size'], $order['quantity']);

                    // cập nhật trạng thái sp (còn hàng, hết hàng)
                    product_update_status($order['product_id']);
                }

                // cập nhật trạng thái đơn hàng
                order_update_status($status, $updated_at, $id);

                // thông tin hóa đơn
                $orderInfo = order_select_by_id($id);

                // gửi mail thông báo hủy
                order_cancel_noti($orderDetail, $orderInfo);
                break;
            case '3':
                // cập nhật trạng thái đơn hàng
                order_update_status($status, $updated_at, $id);

                // thông tin hóa đơn
                $orderInfo = order_select_by_id($id);

                // thông báo đặt thành công
                order_success_noti($orderDetail, $orderInfo);
                break;
            default:
                order_update_status($status, $updated_at, $id);
        }
        header('Location: ' . $ADMIN_URL . '/order/?detail&id=' . $id);
    } else if (array_key_exists('detail', $_REQUEST)) {
        $titlePage = 'Order Details';
        // chi tiết hóa đơn
        $listOrderDetail = order_detail_select_all_by_o_id($id);

        // thông tin hóa đơn
        $orderInfo = order_select_by_id($id);

        $VIEW_PAGE = "detail.php";
    } else if (array_key_exists('invoice', $_REQUEST)) {
        // xuất hóa đơn

        require_once 'invoice.php';
        exit();
    } else if(array_key_exists('keyword', $_REQUEST)) {
        $listOrder = order_search($keyword);
        function renderOrder($order_item) {
            global $ADMIN_URL;
            $html = '';
            $html .= '
            <tr>
                <!-- <td>
                    <input type="checkbox" data-id="">
                </td> -->
                <td>
                    DH' . $order_item['id'] . '
                </td>
                <td>
                    <span class="content__table-text-black">
                        ' . $order_item['customer_name'] . '
                    </span>
                </td>
                <td>
                    <span class="content__table-text-success">
                        ' . date_format(date_create($order_item['created_at']), 'd/m/Y H:i') . '
                    </span>
                </td>
                <td>
                    ' . number_format($order_item['total_price'], 0, '', ',') . ' VNĐ
                </td>
                <td>';
                    switch($order_item['status']) {
                        case 0:
                            $html .= '<span class="content__table-stt-active">Đơn hàng mới</span>';
                            break;
                        case 1:
                            $html .= '<span class="content__table-stt-active">Đã xác nhận</span>';
                            break;
                        case 2:
                            $html .= '<span class="content__table-stt-active">Đang giao hàng</span>';
                            break;
                        case 3:
                            $html .= '<span class="content__table-stt-active">Đã giao hàng</span>';
                            break;
                        case 4:
                            $html .= '<span class="content__table-stt-locked">Đã hủy</span>';
                    }
                $html .= '
                </td>
                <td>
                    <a href="' . $ADMIN_URL . '/order/?detail&id=' . $order_item['id'] . '" class="content__table-stt-active">Chi tiết</a>
                    <!-- <a href="' . $ADMIN_URL . '/order/?invoice&id=' . $order_item['id'] . '" target="_blank" class="content__table-stt-active">
                        <i class="fas fa-download"></i>
                        Xuất hóa đơn
                    </a> -->
                </td>
            </tr>
            ';
            return $html;
        }
        $html = array_map('renderOrder', $listOrder);
        echo join('', $html);
        die();
    } else {
        $titlePage = 'List Order';
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