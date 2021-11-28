<?php

    require_once '../../global.php';
    require_once '../../dao/settings.php';
    require_once '../../dao/product.php';
    require_once '../../dao/attribute.php';
    require_once '../../dao/order.php';
    require_once '../../dao/order_detail.php';
    require_once '../../dao/voucher.php';

    $isWebsiteOpen = settings_select_all();
    if (!$isWebsiteOpen || !$isWebsiteOpen['status']) header('Location: ' . $SITE_URL . '/home/close.php');

    extract($_REQUEST);
    if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) $_SESSION['cart'] = [];
    if (!isset($_SESSION['voucher']) || !is_array($_SESSION['voucher'])) $_SESSION['voucher'] = [];

    if (array_key_exists('add_cart', $_REQUEST)) {

        $qnt = $qnt ?? 1;
        $size = $size ?? '';
        $productInfo = product_home_select_by_id($id, $size);

        // check số lượng
        // nếu số lượng mua nhiều hơn số lượng hiện có
        if ($qnt > $productInfo['quantity']) {
            echo json_encode(array(
                'success' => false
            ));
            die();
        }
        // else {
        //     // cập nhật giảm số lượng sp
        //     $newQnt = $productInfo['quantity'] - $qnt;
        //     attribute_update_quantity($id, $size, $newQnt);
        // }

        // mặc định sản phẩm chưa tồn tại
        $isProductExits = false;
        // duyệt mảng cart, nếu idsp và size đã tồn tại => cập nhật số lượng
        foreach ($_SESSION['cart'] as $key => $cart) {
            if ($cart['id'] == $id && $cart['size'] == $productInfo['size']) {
                $_SESSION['cart'][$key]['quantity'] += $qnt;
                $isProductExits = true;
            }
        }

        // nếu sản phẩm chưa có trong session
        if (!$isProductExits) {
            $cartInfo = array(
                'id_cart' => md5(rand(1, 10) . substr(microtime(true), -3, 3)),
                'id' => $productInfo['id'],
                'product_name' => $productInfo['product_name'],
                'product_image' => $productInfo['product_image'],
                'size' => $productInfo['size'],
                'price' => $productInfo['price'],
                'quantity' => $qnt
            );
            array_push($_SESSION['cart'], $cartInfo);
        }

        echo json_encode(array(
            'success' => true,
        ));
        die();

    } else if (array_key_exists('btn_delete', $_REQUEST)) {
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($id_cart == $item['id_cart']) {
                unset($_SESSION['cart'][$key]);
            }
        }
        // unset($_SESSION['cart'][$index]);
        header('Location: ' . $SITE_URL . '/cart');
    } else if (array_key_exists('update_cart', $_REQUEST)) {

        // jquery ajax $listQuantity [['id' => '', 'size' => '', 'quantity'] => '', ['id' => '', 'size' => '', 'quantity'] => '']
        $success = true;
        $message = [];
        foreach ($listQuantity as $cart) {
            foreach ($_SESSION['cart'] as $key => $item) {
                if ($cart['id'] == $item['id'] && $cart['size'] == $item['size']) {
                    // lấy số lượng sp
                    $getQuantity = attribute_get_quantity($cart['id'], $cart['size']);
                    // nếu số lượng ban đầu khác số lượng sau khi cập nhật
                    // nếu sl bđ > sl sau cập nhật
                    // tăng sl sp trong data
                    // if ($_SESSION['cart'][$key]['quantity'] > $cart['quantity']) {
                    //     // sl bđ + sl giảm
                    //     $newQnt = $getQuantity + $_SESSION['cart'][$key]['quantity'] - $cart['quantity'];
                    //     attribute_update_quantity($cart['id'], $cart['size'], $newQnt);
                    // } else {
                    //     if ($cart['quantity'] <= $getQuantity) {
                    //         // cập nhật số lượng
                    //         $newQnt = $getQuantity + $_SESSION['cart'][$key]['quantity'] - $cart['quantity'];
                    //         attribute_update_quantity($cart['id'], $cart['size'], $newQnt);
                    //     } else {
                    //         die();
                    //     }
                    // }

                    // nếu sp đã hết hàng
                    if (!$getQuantity || $getQuantity['quantity'] == 0) {
                        $success = false;
                        $message[] = $_SESSION['cart'][$key]['product_name'] . ' size ' . $_SESSION['cart'][$key]['size'] . ' đã hết hàng.';
                    }
                    // nếu số lượng cập nhật nhiều hơn sp hiện có
                    else if ($cart['quantity'] > $getQuantity['quantity']) {
                        $success = false;
                        $message[] = $_SESSION['cart'][$key]['product_name'] . ' size ' . $_SESSION['cart'][$key]['size'] . ' vượt quá số lượng sản phẩm hiện có.';
                    } else {
                        if (intval($cart['quantity'])) {
                            // cập nhật số lượng trong ss
                            $_SESSION['cart'][$key]['quantity'] = intval($cart['quantity']);
                        } else {
                            // sl = 0 => xóa khỏi ss
                            unset($_SESSION['cart'][$key]);
                        }
                    }

                }
            }
        }
        echo json_encode(array(
            'success' => $success,
            'message' => $message,
        ));
        die();
    } else if (array_key_exists('render_cart', $_REQUEST)) {
        // jquery ajax
        function renderCart($cart_item) {
            global $IMG_URL;
            return '
                <tr data-id="' . $cart_item['id'] . '">
                    <td>
                        <a onclick="return confirm(\'Bạn có chắc muốn xóa sản phẩm này không?\') ?
                        window.location.href = \'?btn_delete&id_cart=' . $cart_item['id_cart'] . '\' : false;
                        " class="content__cart-detail-table-btn">
                            <i class="far fa-times-circle"></i>
                        </a>
                    </td>
                    <td>
                        <a href="" class="content__cart-detail-table-link">
                            <img src="' . $IMG_URL . '/' . $cart_item['product_image'] . '" alt="" class="content__cart-detail-table-img">
                        </a>
                    </td>
                    <td>
                        <a href="" class="content__cart-detail-table-link">' . $cart_item['product_name'] . '</a>
                    </td>
                    <td class="content__cart-detail-size">' . $cart_item['size'] . '</td>
                    <td class="content__cart-detail-price">
                        <span class="">' . number_format($cart_item['price'], 0, '', ',') . 'đ</span>
                    </td>
                    <td>
                        <form action="" class="content__cart-detail-table-qnt">
                            <button type="button" onclick="quantity.value = Number(quantity.value) - 1" class="content__cart-detail-table-qnt-btn content__cart-detail-table-qnt-btn--minus">-</button>
                            <input type="number" min="0" name="quantity" class="content__cart-detail-table-qnt-control" value="' . $cart_item['quantity'] . '">
                            <button type="button" onclick="quantity.value = Number(quantity.value) + 1" class="content__cart-detail-table-qnt-btn content__cart-detail-table-qnt-btn--plus">+</button>
                        </form>
                    </td>
                    <td>
                        <span class="content__cart-detail-price-total">' . number_format(($cart_item['price'] * $cart_item['quantity']), 0, '', ',') . 'đ</span>
                    </td>
                </tr>
            ';
        }
        $html = array_map("renderCart", $_SESSION['cart']);
        echo join('', $html);
        die();
    } else if (array_key_exists('render_totalPrice', $_REQUEST)) {
        // jquery ajax
        // tính tổng tiền ban đầu
        $totalPrice = array_reduce($_SESSION['cart'], function ($total, $cart_item) {
            return $total + $cart_item['price'] * $cart_item['quantity'];
        }, 0);

        // tính số tiền giảm
        $totalPriceVoucher = 0;
        $html = '';
        // tiền ban đầu
        $html .= '
        <tr>
            <td>Tạm tính</td>
            <td class="content__cart-checkout-table-price">'. number_format($totalPrice, 0, '', ',').'đ</td>
        </tr>
        ';
        foreach ($_SESSION['voucher'] as $voucher) {
            // nếu giảm theo tiền
            if($voucher['condition']) {
                $totalPriceVoucher += $voucher['voucher_number'];
            } else {
                // giảm theo % tổng đơn
                $totalPriceVoucher += ($totalPrice * $voucher['voucher_number'])/100;
            }

            $html .= '
            <tr>
                <td>
                    Voucher <strong>' . $voucher['code'] . '</strong>
                    <a class="content__cart-checkout-table-delete" onclick="return confirm(\'Bạn có chắc muốn xóa Voucher này không?\') ?
                    window.location.href = \'?delete_voucher&id=' . $voucher['id'] . '\' : false;
                    ">
                        <i class="fas fa-times"></i>
                    </a>
                </td>';

                if($voucher['condition']) {
                    $html .= '<td class="content__cart-checkout-table-price">- ' . number_format($voucher['voucher_number']) . ' VNĐ</td>';

                } else {
                    $html .= '<td class="content__cart-checkout-table-price">- ' . $voucher['voucher_number'] . '%</td>';
                }

            $html .= '
            </tr>';
        }

        // tiền sau áp voucher
        $totalPrice = $totalPrice - $totalPriceVoucher;
        $totalPrice = number_format($totalPrice > 0 ? $totalPrice : 0) . 'đ';

        echo json_encode(array(
            'html' => $html,
            'totalPrice' => $totalPrice
        ));
        die();
    } else if (array_key_exists('btn_checkout', $_REQUEST)) {
        // validate
        $errorMessage = [];
        $customer = [];

        $customer['customer_name'] = $customer_name ?? '';
        $customer['customer_phone'] = $customer_phone ?? '';
        $customer['customer_email'] = $customer_email ?? '';
        $customer['customer_address'] = $customer_address ?? '';
        $customer['customer_message'] = $customer_message ?? '';

        if (!$customer['customer_name']) {
            $errorMessage['customer_name'] = 'Vui lòng nhập tên người nhận';
        }

        if (!$customer['customer_phone']) {
            $errorMessage['customer_phone'] = 'Vui lòng nhập số điện thoại người nhận';
        } else if (!preg_match('/(84|0[3|5|7|8|9])+([0-9]{8})\b/', $customer['customer_phone'])) {
            $errorMessage['customer_phone'] = 'Vui lòng nhập lại, số điện thoại không đúng định dạng';
        }

        if (!$customer['customer_email']) {
            $errorMessage['customer_email'] = 'Vui lòng nhập email người nhận';
        } else if (!preg_match('/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/', $customer['customer_email'])) {
            $errorMessage['customer_email'] = 'Vui lòng nhập lại, email không đúng định dạng';
        }

        if (!$customer['customer_address']) {
            $errorMessage['customer_address'] = 'Vui lòng nhập địa chỉ nhận hàng';
        }

        // nếu không có lỗi
        if (empty($errorMessage)) {
            $user_id = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : 0;
            $created_at = date('Y-m-d H:i:s');

            // tính tổng tiền đơn hàng (khi chưa có voucher)
            $total_price = array_reduce($_SESSION['cart'], function($total, $item) {
                return $total + ($item['price'] * $item['quantity']);
            }, 0);

            // cập nhật số lượng voucher và tính tổng tiền giảm
            $totalPriceVoucher = 0; //tổng tiền được giảm từ voucher
            foreach ($_SESSION['voucher'] as $voucher) {
                voucher_update_qnt($voucher['id']);
                // nếu giảm theo tiền
                if($voucher['condition']) {
                    $totalPriceVoucher += $voucher['voucher_number'];
                } else {
                    // giảm theo % tổng đơn
                    $totalPriceVoucher += ($total_price * $voucher['voucher_number'])/100;
                }
            }
            $total_price = $total_price - $totalPriceVoucher;
            $total_price = $total_price > 0 ? $total_price : 0; //tổng tiền đã trừ voucher

            // insert order
            $orderId = order_insert($user_id, $customer_name, $customer_address, $customer_phone, $customer_email, $total_price, $customer_message, 0, $created_at, $created_at);

            // insert order_detail và giảm số lượng sp
            foreach ($_SESSION['cart'] as $item) {
                order_detail_insert($orderId, $item['id'], $item['size'], $item['quantity'], $item['price']);

                // cập nhật sl sp trong database
                attribute_update_quantity($item['id'], $item['size'], $item['quantity']);

                // cập nhật lại trạng thái (còn hàng, hết hàng)
                product_update_status($item['id']);
            }

            // gửi email cho khách hàng
            order_send_mail_customer($customer_email, $customer_name, $customer_address, $customer_phone, $customer_message, $total_price, $totalPriceVoucher);

            // thông báo cho admin
            order_send_mail_admin($customer_email, $customer_name, $customer_address, $customer_phone, $customer_message, $total_price, $totalPriceVoucher);

            // xóa session giỏ hàng
            unset($_SESSION['cart']);
            // xóa voucher
            unset($_SESSION['voucher']);
            header('Location: ' . $SITE_URL . '/cart/?thankyou');
        }

        $VIEW_PAGE = "checkout.php";
    } else if (array_key_exists('checkout', $_REQUEST)) {
        if (!isset($_SESSION['cart']) || !$_SESSION['cart']) header('Location: ' . $SITE_URL . '/cart');
        $VIEW_PAGE = "checkout.php";
    } else if (array_key_exists('thankyou', $_REQUEST)) {
        // if (!isset($_SESSION['cart']) || !$_SESSION['cart']) header('Location: ' . $SITE_URL . '/cart');
        $VIEW_PAGE = "thankyou.php";
    }  else if (array_key_exists('get_quantity', $_REQUEST)) {
        echo count($_SESSION['cart']);
        die();
    } else if (array_key_exists('check_voucher', $_REQUEST)) {
        $voucherInfo = voucher_select_by_code($voucher);
        $currentTime = date('Y-m-d H:i:s');
        $success = false;;
        $message = '';
        if ($voucherInfo) {
            if (!$voucherInfo['quantity']) {
                $message = 'Voucher đã hết lượt sử dụng';
            } else if ($currentTime < $voucherInfo['time_start']) {
                $message = 'Voucher chưa đến thời gian có hiệu lực sử dụng';
            } else if ($currentTime > $voucherInfo['time_end']) {
                $message = 'Voucher đã quá hạn sử dụng';
            } else if (!$voucherInfo['status']) {
                $message = 'Voucher đã bị khóa';
            } else {
                // check mã gg tồn tại
                $isVoucherExits = array_filter($_SESSION['voucher'], function ($voucher_item) use ($voucher) {
                    return $voucher_item['code'] == strtoupper($voucher);
                });

                if ($isVoucherExits) {
                    $message = 'Bạn đã sử dụng mã này';
                } else {
                    $success = true;
                    $message = 'Áp mã giảm giá thành công';
                    array_push($_SESSION['voucher'], $voucherInfo);
                }
            }
        } else {
            $message = 'Voucher không tồn tại';
        }
        echo json_encode(array(
            'success' => $success,
            'message' => $message
        ));
        die();
    } else if (array_key_exists('delete_voucher', $_REQUEST)) {
        foreach ($_SESSION['voucher'] as $key => $item) {
            if ($id == $item['id']) {
                unset($_SESSION['voucher'][$key]);
            }
        }
        header('Location: ' . $SITE_URL . '/cart');
    }
    else {
        $VIEW_PAGE = "list.php";
    }

    require_once '../layout.php';

?>