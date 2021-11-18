
<?php

    require_once 'pdo.php';

    function attribute_insert($product_id, $size, $price, $quantity) {
        $sql = "INSERT INTO attribute(product_id, size, price, quantity)
        VALUES(?, ?, ?, ?)";
        pdo_execute($sql, $product_id, $size, $price, $quantity);
    }

    function attribute_update($size, $price, $quantity, $id) {
        $sql = "UPDATE attribute SET size = ?, price = ?, quantity = ? WHERE id = ?";
        pdo_execute($sql, $size, $price, $quantity, $id);
    }

    function attribute_delete($id) {
        $sql = "DELETE FROM attribute WHERE id = ?";

        if (is_array($id)) {
            foreach ($id as $id_item) {
                pdo_execute($sql, $id_item);
            }
        } else {
            pdo_execute($sql, $id);
        }
    }

    function attribute_select_all() {
        $sql = "SELECT p.*, COUNT(*) totalAttribute FROM attribute a JOIN product p ON a.product_id = p.id GROUP BY p.id";
        return pdo_query($sql);
    }

    function attribute_select_by_id($id) {
        $sql = "SELECT * FROM attribute WHERE id = ?";
        return pdo_query_one($sql, $id);
    }

    // lấy danh sách thuộc tính theo id sp
    function attribute_select_all_by_id($id) {
        $sql = "SELECT * FROM attribute WHERE product_id = ?";
        return pdo_query($sql, $id);
    }

    function attribute_exits($id) {
        $sql = "SELECT COUNT(*) FROM attribute WHERE id = ?";
        return pdo_query_value($sql, $id) > 0;
    }

    // kiểm tra size tồn tại
    function attribute_size_exits($p_id, $size) {
        $sql = "SELECT COUNT(*) FROM attribute WHERE product_id = ? AND size = ?";
        return pdo_query_value($sql, $p_id, $size) > 0;
    }

?>