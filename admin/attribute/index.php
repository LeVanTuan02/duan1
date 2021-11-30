<?php

    require_once '../../global.php';
    require_once '../../dao/attribute.php';
    require_once '../../dao/product.php';

    check_login();
    extract($_REQUEST);

    if (array_key_exists('btn_insert', $_REQUEST)) {
        $titlePage = 'Add Attibutes';
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

        if ($attribute['quantity'] == '') {
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
        $titlePage = 'Add Attibutes';
        $productInfo = product_select_by_id($p_id);
        $VIEW_PAGE = "add.php";
    } else if (array_key_exists('btn_update', $_REQUEST)) {
        $titlePage = 'Update Attibutes';
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

        if ($attribute['quantity'] == '') {
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
        $titlePage = 'Update Attibutes';
        $productInfo = product_select_by_id($p_id);
        $attributeInfo = attribute_select_by_id($id);
        $VIEW_PAGE = "edit.php";
    } else if (array_key_exists('btn_delete', $_REQUEST)) {
        // xóa thuộc tính trang chi tiết thuộc tính
        attribute_delete($id);
        
        // cập nhật trạng thái sản phẩm
        echo product_update_status($p_id);
        header('Location: ' . $ADMIN_URL . '/attribute/?detail&p_id=' . $p_id);
    } else if (array_key_exists('btn_delete_all', $_REQUEST)) {
        // xóa toàn bộ thuộc tính của sp theo id
        attribute_delete_all_by_pid($p_id);
        
        // cập nhật trạng thái sản phẩm
        product_update_status($p_id);
        header('Location: ' . $ADMIN_URL . '/attribute');
    } else if (array_key_exists('detail', $_REQUEST)) {
        $titlePage = 'Attribute Details';
        // danh sách thuộc tính của 1 sp
        $attributeById = attribute_select_all_by_id($p_id);

        // lấy tên sản phẩm của thuộc tính
        $productInfo = product_select_by_id($p_id);
        $VIEW_PAGE = "detail.php";
    } else if (array_key_exists('keyword', $_REQUEST)) {
        // jquery ajax
        $listAttribute = attribute_search($keyword);
        function renderAttribute($item) {
            global $IMG_URL;
            global $ADMIN_URL;
            return '
            <tr>
                <!-- <td>
                    <input type="checkbox" data-id="' . $item['id'] . '">
                </td> -->
                <td>
                    ' . $item['id'] . '
                </td>
                <td class="content__table-cell-flex">
                    <div class="content__table-img">
                        <img src="' . $IMG_URL . '/' . $item['product_image'] . '" class="content__table-avatar" alt="">
                    </div>

                    <div class="content__table-info">
                        <span class="content__table-name">' . $item['product_name'] . '</span>
                    </div>
                </td>
                <td>
                    ' . $item['totalAttribute'] . '
                </td>
                <td>
                    <div class="user_list-action">
                        <a onclick="return confirm(\'Bạn có chắc muốn xóa sản phẩm này không?\') ?
                        window.location.href = \'?btn_delete_all&p_id=' . $item['id'] . ' : false;
                        " class="content__table-action danger">
                            <i class="fas fa-trash"></i>
                        </a>
                        <a href="' . $ADMIN_URL . '/attribute/?detail&p_id=' . $item['id'] . '" class="content__table-action info">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                </td>
            </tr>
            ';
        }
        $html = array_map('renderAttribute', $listAttribute);
        echo join('', $html);
        die();
    } else {
        $titlePage = 'List Attibutes';
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