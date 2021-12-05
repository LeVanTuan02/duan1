<?php

    require_once '../../global.php';
    require_once '../../dao/user.php';
    require_once '../../dao/attribute.php';
    require_once '../../dao/product.php';
    require_once '../../dao/order.php';
    require_once '../../dao/booking.php';
    require_once '../../dao/table.php';
    require_once '../../dao/order_detail.php';

    check_login(0);

    extract($_REQUEST);

    if (array_key_exists('cart', $_REQUEST)) {
        $titlePage = 'My Cart';
        // phân trang
        $totalOrder = count(order_select_all_by_user_id($_SESSION['user']['id']));
        $limit = 10;
        $totalPage = ceil($totalOrder / $limit);

        $currentPage = $page ?? 1;

        if ($currentPage <= 0) {
            header('Location: ' . $ADMIN_URL . '/account/?order&page=1');
        } else if ($currentPage > $totalPage) {
            $currentPage = $totalPage;
        }

        $start = ($currentPage - 1) * $limit;

        $myCarts = order_select_all_by_user_id($_SESSION['user']['id'], $start, $limit);
        $VIEW_PAGE = "cart_list.php";
    } else if (array_key_exists('cart_cancel', $_REQUEST)) {
        // đơn hàng đã/đang giao không thể hủy
        if (order_check_delivered($id)) {
            echo '<script>
            var result = confirm("Bạn không thể hủy đơn hàng này!")
            if (result) {
                window.location.href = "?cart_detail&id='.$id.'";
            } else {
                window.location.href = "?cart_detail&id='.$id.'";
            }
            </script>';
        } else {
            $updated_at = date('Y-m-d H:i:s');

            // cập nhật trạng thái hủy
            order_update_status(4, $updated_at, $id);

            // lấy thông tin sp từ hóa đơn chi tiết
            $orderDetail = order_detail_select_all_by_o_id($id);
            foreach ($orderDetail as $order) {
                // tăng số lượng sp
                attribute_update_more_quantity($order['product_id'], $order['product_size'], $order['quantity']);

                // cập nhật trạng thái sp (còn hàng, hết hàng)
                product_update_status($order['product_id']);
            }

            // gửi mail thông báo cho admin
            $orderInfo = order_select_by_id($id);

            // thông báo cho khách
            order_cancel_noti($orderDetail, $orderInfo);
            order_cancel_noti_admin($orderDetail, $orderInfo);
            header('Location: ' . $ADMIN_URL . '/account/?cart_detail&id=' . $id);
        }
    } else if (array_key_exists('cart_detail', $_REQUEST)) {
        $titlePage = 'My Cart Detail';
        // chi tiết đơn hàng
        $myCartDetail = order_detail_select_all_by_o_id($id);

        // thông tin đơn hàng
        $myCartInfo = order_select_by_id($id);
        $VIEW_PAGE = "cart_detail.php";
    } else if (array_key_exists('keyword', $_REQUEST)) {
        $listOrder = order_search($keyword, $status, $_SESSION['user']['id']);
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
    } else if (array_key_exists('btn_update_pass', $_REQUEST)) {
        $titlePage = 'Update Password';
        $password = [];
        $errorMessage = [];

        $password['old_password'] = $old_password ?? '';
        $password['new_password'] = $new_password ?? '';
        $password['confirm_password'] = $confirm_password ?? '';

        if (!$password['old_password']) {
            $errorMessage['old_password'] = 'Vui lòng nhập mật khẩu hiện tại';
        } else if (!password_verify($old_password, $_SESSION['user']['password'])) {
            $errorMessage['old_password'] = 'Vui lòng nhập lại, mật khẩu hiện tại không chính xác';
        }

        if (!$password['new_password']) {
            $errorMessage['new_password'] = 'Vui lòng nhập mật khẩu mới';
        } else if (strlen($password['new_password']) < 3) {
            $errorMessage['new_password'] = 'Vui lòng nhập mật khẩu tối thiểu 3 ký tự';
        }

        if (!$password['confirm_password']) {
            $errorMessage['confirm_password'] = 'Vui lòng nhập mật khẩu xác nhận';
        } else if (strlen($password['confirm_password']) < 3) {
            $errorMessage['confirm_password'] = 'Vui lòng nhập mật khẩu tối thiểu 3 ký tự';
        } else if ($password['new_password'] != $password['confirm_password']) {
            $errorMessage['confirm_password'] = 'Vui lòng nhập lại, mật khẩu xác nhận không chính xác';
        }

        if (empty($errorMessage)) {
            $new_password = password_hash($new_password, PASSWORD_DEFAULT);
            user_change_pass($new_password, $_SESSION['user']['id']);
            $MESSAGE = "Cập nhật mật khẩu thành công";
            
            // cập nhật session
            $user = user_select_by_id($_SESSION['user']['id']);
            $_SESSION['user'] = $user;
            unset($password);
        }

        $VIEW_PAGE = "edit_pass.php";
    } else if (array_key_exists('update_pass', $_REQUEST)) {
        $titlePage = 'Update Password';
        $VIEW_PAGE = "edit_pass.php";
    } else if (array_key_exists('btn_update_info', $_REQUEST)) {
        $titlePage = 'Update Info';
        $infoUser = [];
        $errorMessage = [];

        $infoUser['fullName'] = $fullName ?? '';
        $infoUser['email'] = $email ?? '';
        $infoUser['phone'] = $phone ?? '';
        $infoUser['address'] = $address ?? '';

        if (!$infoUser['fullName']) {
            $errorMessage['fullName'] = 'Vui lòng nhập họ tên của bạn';
        }

        if (!$infoUser['email']) {
            $errorMessage['email'] = 'Vui lòng nhập địa chỉ email';
        } else if (!preg_match('/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/', $infoUser['email'])) {
            $errorMessage['email'] = 'Vui lòng nhập lại, email không đúng định dạng';
        } else if ($email != $_SESSION['user']['email'] && user_exits_by_options('email', $email)) {
            // email không được trùng nhau
            $errorMessage['email'] = 'Vui lòng nhập lại, email đã tồn tại trên hệ thống';
        }

        if (!$infoUser['phone']) {
            $errorMessage['phone'] = 'Vui lòng nhập số điện thoại';
        } else if (!preg_match('/(84|0[3|5|7|8|9])+([0-9]{8})\b/', $phone)) {
            $errorMessage['phone'] = 'Vui lòng nhập lại, định dạng không chính xác';
        } else if ($phone != $_SESSION['user']['phone'] && user_exits_by_options('phone', $phone)) {
            $errorMessage['phone'] = 'Vui lòng nhập lại, sđt đã tồn tại trên hệ thống';
        }

        if (!$infoUser['address']) {
            $errorMessage['address'] = 'Vui lòng nhập địa chỉ';
        }

        if (empty($errorMessage)) {
            $user = $_SESSION['user'];
            $avatar = save_file('avatar', $IMG_PATH . '/');
            $avatar = strlen($avatar) > 0 ? $avatar : $user['avatar'];
            user_update($user['username'], $user['password'], $email, $phone, $fullName, $address, $avatar, $user['active'], $user['role'], $user['id']);
            // cập nhật session
            $user = user_select_by_id($_SESSION['user']['id']);
            $_SESSION['user'] = $user;
            $MESSAGE = 'Cập nhật thông tin tài khoản thành công';
        }

        $VIEW_PAGE = "edit_info.php";
    }  else if (array_key_exists('btn_logout', $_REQUEST)) {
        unset($_SESSION['user']);
        header('Location: ' . $SITE_URL . '/account');
    } else if (array_key_exists('booking_detail', $_REQUEST)) {
        $titlePage = 'Booking Detail';
        $bookingInfo = booking_select_by_id($id);
        $VIEW_PAGE = 'booking_detail.php';
    } else if (array_key_exists('booking_cancel', $_REQUEST)) {
        // thông tin đặt bàn
        $bookingInfo = booking_select_by_id($id);

        // cập nhật trạng thái đặt bàn => đã hủy
        booking_update_stt(2, $id);

        // cập nhật trạng thái bàn => bàn trống
        table_update_stt(0, $bookingInfo['table_id']);

        // thông báo cho ad
        booking_send_mail_admin_cancel($bookingInfo);
        header('Location: ' . $ADMIN_URL . '/account/?booking_detail&id=' . $id);
    } else if (array_key_exists('booking', $_REQUEST)) {
        $titlePage = 'List Booking';
        // phân trang
        $totalOrder = count(booking_select_all_by_uid($_SESSION['user']['id']));
        $limit = 10;
        $totalPage = ceil($totalOrder / $limit);

        $currentPage = $page ?? 1;

        if ($currentPage <= 0) {
            header('Location: ' . $ADMIN_URL . '/account/?booking&page=1');
        } else if ($currentPage > $totalPage) {
            $currentPage = $totalPage;
        }

        $start = ($currentPage - 1) * $limit;

        $bookingList = booking_select_all_by_uid($_SESSION['user']['id'], $start, $limit);
        $VIEW_PAGE = 'booking_list.php';
    } else if (array_key_exists('booking_search', $_REQUEST)) {
        // js ajax
        $listBooking = booking_search($bk_keyword, $_SESSION['user']['id']);
        function renderBooking($item) {
            global $ADMIN_URL;
            $html = '';
            $html .= '
            <tr>
                <!-- <td>
                    <input type="checkbox" data-id="">
                </td> -->
                <td>
                    #' . $item['id'] . '
                </td>
                <td>
                    <span class="content__table-text-black">
                        ' . $item['name'] . '
                    </span>
                </td>
                <td>
                    <span class="content__table-text-success">
                        ' . date('d/m/Y', strtotime($item['date_book'])) . ' ' . date('H:i', strtotime($item['time_book'])) . '
                    </span>
                </td>
                <td>
                    ' . $item['table_name'] . '
                </td>
                <td>';
                    switch($item['status']) {
                        case 0:
                            $html .= '<span class="content__table-stt-active">Đang xử lý</span>';
                            break;
                        case 1:
                            $html .= '<span class="content__table-stt-active">Đã xác nhận</span>';
                            break;
                        case 2:
                            $html .= '<span class="content__table-stt-locked">Đã hủy</span>';
                            break;
                    }
                $html .= '
                </td>
                <td>
                    <a href="' . $ADMIN_URL . '/booking/?detail&id=' . $item['id'] . '" class="content__table-stt-active">Chi tiết</a>
                </td>
            </tr>
            ';
            return $html;
        }
        $html = array_map('renderBooking', $listBooking);
        echo join('', $html);
        die();
    } else {
        $titlePage = 'Update Info';
        $VIEW_PAGE = "edit_info.php";
    }

    require_once '../layout.php';

?>