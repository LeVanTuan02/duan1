<?php

    require_once '../../global.php';
    require_once '../../dao/product.php';
    require_once '../../dao/order.php';
    require_once '../../dao/order_detail.php';

    extract($_REQUEST);
    if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) $_SESSION['cart'] = [];

    if (array_key_exists('add_cart', $_REQUEST)) {

        $size = $size ?? '';
        $productInfo = product_home_select_by_id($id, $size);

        // mặc định sản phẩm chưa tồn tại
        $isProductExits = false;
        foreach ($_SESSION['cart'] as $key => $cart) {
            if ($cart['id'] == $id && $cart['size'] == $productInfo['size']) {
                $_SESSION['cart'][$key]['quantity'] += 1;
                $isProductExits = true;
            }
        }

        // nếu sản phẩm chưa có trong session
        if (!$isProductExits) {
            $cartInfo = array(
                'id' => $productInfo['id'],
                'product_name' => $productInfo['product_name'],
                'product_image' => $productInfo['product_image'],
                'size' => $productInfo['size'],
                'price' => $productInfo['price'],
                'quantity' => 1
            );
            array_push($_SESSION['cart'], $cartInfo);
        }

        header('Location: ' . $SITE_URL . '/cart');

    } else if (array_key_exists('btn_delete', $_REQUEST)) {
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($id == $item['id']) {
                unset($_SESSION['cart'][$key]);
            }
        }
        header('Location: ' . $SITE_URL . '/cart');
    } else if (array_key_exists('update_cart', $_REQUEST)) {

        // jquery ajax
        foreach ($listQuantity as $cart) {
            foreach ($_SESSION['cart'] as $key => $item) {
                if ($cart['id'] == $item['id']) {
                    if (intval($cart['quantity'])) {
                        $_SESSION['cart'][$key]['quantity'] = intval($cart['quantity']);
                    } else {
                        unset($_SESSION['cart'][$key]);
                    }
                }
            }
        }
        echo 1;
        die();
    } else if (array_key_exists('render_cart', $_REQUEST)) {
        // jquery ajax
        function renderCart($cart_item) {
            global $IMG_URL;
            return '
                <tr data-id="' . $cart_item['id'] . '">
                    <td>
                        <a onclick="return confirm("Bạn có chắc muốn xóa sản phẩm này không?") ?
                        window.location.href = "?btn_delete&id=' . $cart_item['id'] . '" : false;
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
                    <td>' . $cart_item['size'] . '</td>
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
        $totalPrice = array_reduce($_SESSION['cart'], function ($total, $cart_item) {
            return $total + $cart_item['price'] * $cart_item['quantity'];
        }, 0);
        echo number_format($totalPrice, 0, '', ',') . 'đ';
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

            // tính tổng tiền đơn hàng
            $total_price = array_reduce($_SESSION['cart'], function($total, $item) {
                return $total + ($item['price'] * $item['quantity']);
            }, 0);

            // insert order
            $orderId = order_insert($user_id, $customer_name, $customer_address, $customer_phone, $customer_email, $total_price, $customer_message, 0, $created_at);

            // insert order_detail
            foreach ($_SESSION['cart'] as $item) {
                order_detail_insert($orderId, $item['id'], $item['size'], $item['quantity'], $item['price']);
            }

            // xóa session giỏ hàng
            unset($_SESSION['cart']);
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
    } else {
        $VIEW_PAGE = "list.php";
    }

    require_once '../layout.php';

?>