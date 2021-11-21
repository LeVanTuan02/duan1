<?php

    require_once '../../global.php';
    require_once '../../dao/attribute.php';
    require_once '../../dao/product.php';

    check_login();
    extract($_REQUEST);

    if (array_key_exists('btn_insert', $_REQUEST)) {
        $productInfo = product_select_by_id($p_id);

        $errorMessage = [];
        $attribute = [];

        $attribute['size'] = $size ?? '';
        $attribute['price'] = $price ?? '';
        $attribute['quantity'] = $quantity ?? '';

        if (!$attribute['size']) {
            $errorMessage['size'] = 'Vui lòng chọn Size';
        } else if (attribute_size_exits($p_id, $attribute['size'])) {
            $errorMessage['size'] = 'Size ' . $attribute['size'] . ' đã tồn tại trong hệ thống!';
        }

        if (!$attribute['price']) {
            $errorMessage['price'] = 'Vui lòng nhập giá sản phẩm';
        } else if (!is_numeric($attribute['price'])) {
            $errorMessage['price'] = 'Vui lòng nhập số';
        } else if ($attribute['price'] < 0) {
            $errorMessage['price'] = 'Vui lòng nhập số dương';
        }

        if (!$attribute['quantity']) {
            $errorMessage['quantity'] = 'Vui lòng nhập số lượng';
        } else if (!is_numeric($attribute['quantity'])) {
            $errorMessage['quantity'] = 'Vui lòng nhập số';
        } else if ($attribute['quantity'] < 0) {
            $errorMessage['quantity'] = 'Vui lòng nhập số dương';
        }

        if (empty($errorMessage)) {
            attribute_insert($p_id, $size, $price, $quantity);

            // cập nhật trạng thái sản phẩm
            product_update_status($p_id);
            $MESSAGE = 'Thêm thuộc tính thành công';
            unset($attribute);
        }

        $VIEW_PAGE = "add.php";
    } else if (array_key_exists('btn_add', $_REQUEST)) {
        $productInfo = product_select_by_id($p_id);
        $VIEW_PAGE = "add.php";
    } else if (array_key_exists('btn_update', $_REQUEST)) {
        $productInfo = product_select_by_id($p_id);
        $attributeInfo = attribute_select_by_id($id);

        $errorMessage = [];
        $attribute = [];

        $attribute['size'] = $size ?? '';
        $attribute['price'] = $price ?? '';
        $attribute['quantity'] = $quantity ?? '';

        if (!$attribute['size']) {
            $errorMessage['size'] = 'Vui lòng chọn Size';
        } else if ($attribute['size'] != $attributeInfo['size'] && attribute_size_exits($p_id, $attribute['size'])) {
            $errorMessage['size'] = 'Size ' . $attribute['size'] . ' đã tồn tại trong hệ thống!';
        }

        if (!$attribute['price']) {
            $errorMessage['price'] = 'Vui lòng nhập giá sản phẩm';
        } else if (!is_numeric($attribute['price'])) {
            $errorMessage['price'] = 'Vui lòng nhập số';
        } else if ($attribute['price'] < 0) {
            $errorMessage['price'] = 'Vui lòng nhập số dương';
        }

        if (!$attribute['quantity']) {
            $errorMessage['quantity'] = 'Vui lòng nhập số lượng';
        } else if (!is_numeric($attribute['quantity'])) {
            $errorMessage['quantity'] = 'Vui lòng nhập số';
        } else if ($attribute['quantity'] < 0) {
            $errorMessage['quantity'] = 'Vui lòng nhập số dương';
        }

        if (empty($errorMessage)) {
            attribute_update($size, $price, $quantity, $id);

            $MESSAGE = 'Cập nhật thuộc tính thành công, hệ thống tự động chuyển hướng sau 3s';
            header('Refresh: 3; URL = ' . $ADMIN_URL . '/attribute/?detail&p_id=' . $p_id);
        }

        $VIEW_PAGE = "edit.php";
    } else if (array_key_exists('btn_edit', $_REQUEST)) {
        $productInfo = product_select_by_id($p_id);
        $attributeInfo = attribute_select_by_id($id);
        $VIEW_PAGE = "edit.php";
    } else if (array_key_exists('btn_delete', $_REQUEST)) {
        attribute_delete($id);
        
        // cập nhật trạng thái sản phẩm
        product_update_status($p_id);
        header('Location: ' . $ADMIN_URL . '/attribute/?detail&p_id=' . $p_id);
    } else if (array_key_exists('detail', $_REQUEST)) {
        // danh sách thuộc tính của 1 sp
        $attributeById = attribute_select_all_by_id($p_id);
        $VIEW_PAGE = "detail.php";
    }
    else {
        // phân trang
        $totalOrder = count(attribute_select_all());
        $limit = 10;
        $totalPage = ceil($totalOrder / $limit);

        $currentPage = $page ?? 1;

        if ($currentPage <= 0) {
            header('Location: ' . $ADMIN_URL . '/order/?page=1');
        } else if ($currentPage > $totalPage) {
            $currentPage = $totalPage;
        }

        $start = ($currentPage - 1) * $limit;

        $listAttribute = attribute_select_all($start, $limit);
        $VIEW_PAGE = "list.php";
    }

    require_once '../layout.php';

?>