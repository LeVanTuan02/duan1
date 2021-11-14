<?php

    require_once 'pdo.php';

    function product_insert($product_name, $product_image, $description, $cate_id, $discount, $status, $created_at, $update_at) {
        $sql = "INSERT INTO product(product_name, product_image, description, cate_id, discount, status, created_at, update_at)
        VALUES(?, ?, ?, ?, ?, ?, ?)";
        pdo_execute($sql, $product_name, $product_image, $description, $cate_id, $discount, $status, $created_at, $update_at);
    }

    function product_update($product_name, $product_image, $description, $cate_id, $discount, $status, $created_at, $update_at, $id) {
        $sql = "UPDATE product SET product_name = ?, product_image = ?, description = ?, cate_id = ?, discount = ?, status = ?, created_at = ?, update_at = ? WHERE id = ?";
        pdo_execute($sql, $product_name, $product_image, $description, $cate_id, $discount, $status, $created_at, $update_at, $id);
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
        $sql = "SELECT * FROM product ORDER BY id DESC";
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

?>