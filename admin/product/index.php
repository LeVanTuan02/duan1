<?php

    require_once '../../global.php';
    require_once '../../dao/product.php';
    require_once '../../dao/category.php';

    check_login();
    extract($_REQUEST);

    if (array_key_exists('btn_insert', $_REQUEST)) {
        $listCategory = category_select_all();
        $errorMessage = [];
        $product = [];

        $product['product_name'] = $product_name ?? '';
        $product['cate_id'] = $cate_id ?? '';
        $product['discount'] = $discount ?? '';
        $product['description'] = $description ?? '';

        if (!$product['product_name']) {
            $errorMessage['product_name'] = 'Vui lòng nhập tên sản phẩm';
        } else if (product_name_exits($product['product_name'])) {
            $errorMessage['product_name'] = 'Tên sản phẩm đã tồn tại trong hệ thống!';
        }

        if (!$product['cate_id']) {
            $errorMessage['cate_id'] = 'Vui lòng chọn loại hàng';
        }

        if ($product['discount'] == '') {
            $errorMessage['discount'] = 'Vui lòng nhập giảm giá';
        } else if (!is_numeric($product['discount'])) {
            $errorMessage['discount'] = 'Vui lòng nhập số';
        } else if ($product['discount'] < 0) {
            $errorMessage['discount'] = 'Vui lòng nhập giảm giá là số dương';
        }

        if (!$product['description']) {
            $errorMessage['description'] = 'Vui lòng nhập mô tả sản phẩm';
        }

        if (empty($errorMessage)) {
            $date = Date('Y-m-d H:i:s');
            $product_image = save_file('product_image', $IMG_PATH . '/');
            $product_image = strlen($product_image) > 0 ? $product_image : 'image_default.png';

            product_insert($product_name, $product_image, $description, $cate_id, $discount, $date, $date);

            $MESSAGE = "Thêm sản phẩm thành công";
            unset($product);
        }

        $VIEW_PAGE = "add.php";
    } else if (array_key_exists('btn_add', $_REQUEST)) {
        $listCategory = category_select_all();
        $VIEW_PAGE = "add.php";
    } else if (array_key_exists('btn_update', $_REQUEST)) {
        $productInfo = product_select_by_id($id);
        $listCategory = category_select_all();
        $errorMessage = [];
        $product = [];

        $product['product_name'] = $product_name ?? '';
        $product['cate_id'] = $cate_id ?? '';
        $product['discount'] = $discount ?? '';
        $product['description'] = $description ?? '';

        if (!$product['product_name']) {
            $errorMessage['product_name'] = 'Vui lòng nhập tên sản phẩm';
        } else if ($product['product_name'] != $productInfo['product_name'] && product_name_exits($product['product_name'])) {
            $errorMessage['product_name'] = 'Tên sản phẩm đã tồn tại trong hệ thống!';
        }

        if (!$product['cate_id']) {
            $errorMessage['cate_id'] = 'Vui lòng chọn loại hàng';
        }

        if ($product['discount'] == '') {
            $errorMessage['discount'] = 'Vui lòng nhập giảm giá';
        } else if (!is_numeric($product['discount'])) {
            $errorMessage['discount'] = 'Vui lòng nhập số';
        } else if ($product['discount'] < 0) {
            $errorMessage['discount'] = 'Vui lòng nhập giảm giá là số dương';
        }

        if (!$product['description']) {
            $errorMessage['description'] = 'Vui lòng nhập mô tả sản phẩm';
        }

        if (empty($errorMessage)) {
            $date = Date('Y-m-d H:i:s');
            $product_image = save_file('product_image', $IMG_PATH . '/');
            $product_image = strlen($product_image) > 0 ? $product_image : $productInfo['product_image'];

            product_update($product_name, $product_image, $description, $cate_id, $discount, $date, $id);

            $MESSAGE = "Cập nhật sản phẩm thành công, hệ thống tự động chuyển hướng sau 3s";
            header('Refresh: 3; URL = ' . $ADMIN_URL . '/product');
        }

        $VIEW_PAGE = "edit.php";
    } else if (array_key_exists('btn_edit', $_REQUEST)) {
        $listCategory = category_select_all();
        $productInfo = product_select_by_id($id);
        $VIEW_PAGE = "edit.php";
    } else if (array_key_exists('btn_delete', $_REQUEST)) {
        product_delete($id);
        header('Location: ' . $ADMIN_URL . '/product');
    } else {
        // phân trang
        $totalOrder = count(product_select_all());
        $limit = 10;
        $totalPage = ceil($totalOrder / $limit);

        $currentPage = $page ?? 1;

        if ($currentPage <= 0) {
            header('Location: ' . $ADMIN_URL . '/order/?page=1');
        } else if ($currentPage > $totalPage) {
            $currentPage = $totalPage;
        }

        $start = ($currentPage - 1) * $limit;

        $listProduct = product_select_all($start, $limit);
        $VIEW_PAGE = "list.php";
    }

    require_once '../layout.php';

?>