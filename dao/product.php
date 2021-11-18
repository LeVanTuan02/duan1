<?php

    require_once 'pdo.php';

    function product_insert($product_name, $product_image, $description, $cate_id, $discount, $created_at, $update_at) {
        $sql = "INSERT INTO product(product_name, product_image, description, cate_id, discount, created_at, update_at)
        VALUES(?, ?, ?, ?, ?, ?, ?)";
        pdo_execute($sql, $product_name, $product_image, $description, $cate_id, $discount, $created_at, $update_at);
    }

    function product_update($product_name, $product_image, $description, $cate_id, $discount, $update_at, $id) {
        $sql = "UPDATE product SET product_name = ?, product_image = ?, description = ?, cate_id = ?, discount = ?, update_at = ? WHERE id = ?";
        pdo_execute($sql, $product_name, $product_image, $description, $cate_id, $discount, $update_at, $id);
    }

    function product_delete($id) {
        $sql = "DELETE FROM product WHERE id = ?";

        if (is_array($id)) {
            foreach ($id as $id_item) {
                pdo_execute($sql, $id_item);
            }
        } else {
            pdo_execute($sql, $id);
        }
    }

    function product_select_all() {
        $sql = "SELECT p.*, SUM(a.quantity) AS totalProduct FROM product p LEFT JOIN attribute a ON p.id = a.product_id GROUP BY p.id ORDER BY id DESC";
        return pdo_query($sql);
    }

    function product_select_by_id($id) {
        $sql = "SELECT * FROM product WHERE id = ?";
        return pdo_query_one($sql, $id);
    }

    function product_exits($id) {
        $sql = "SELECT COUNT(*) FROM product WHERE id = ?";
        return pdo_query_value($sql, $id) > 0;
    }

    // cập nhật trạng thái sản phẩm (còn hàng, hết hàng)
    function product_update_status($id) {
        $status = 0;
        $sql_get_quantity = "SELECT SUM(quantity) AS totalQuantity FROM attribute WHERE product_id = $id";
        if (pdo_query_value($sql_get_quantity)) {
            $status = 1;
        }
        $sql = "UPDATE product SET status = $status WHERE id = ?";
        pdo_execute($sql, $id);
    }

    // kiểm tra tên sản phẩm tồ tại không
    function product_name_exits($product_name) {
        $sql = "SELECT * FROM product WHERE product_name = ?";
        return pdo_query_value($sql, $product_name) > 0;
    }

    // thống kê số lượng sản phẩm theo danh mục
    function analytics_quantity_product_by_cate() {
        $sql = "SELECT c.cate_name, c.id, COUNT(*) AS totalProduct FROM product p JOIN category c ON p.cate_id = c.id GROUP BY c.id ORDER BY c.id DESC";
        return pdo_query($sql);
    }

    // thống kê giá sản phẩm theo danh mục
    function analytics_price_product_by_cate() {
        $sql = "SELECT c.cate_name, c.id, MAX(price) AS maxPrice, MIN(price) AS minPrice, AVG(price) AS avgPrice
        FROM ((product p JOIN category c ON p.cate_id = c.id) LEFT JOIN attribute a ON p.id = a.product_id)
        GROUP BY c.id
        ORDER BY c.id DESC";
        return pdo_query($sql);
    }

?>