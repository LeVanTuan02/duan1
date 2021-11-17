<?php

    require_once 'pdo.php';

    function order_insert($user_id, $customer_name, $address, $phone, $total_price, $message, $status, $created_at) {
        $sql = "INSERT INTO order(user_id, customer_name, address, phone, total_price, message, status, created_at)
        VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
        pdo_execute($sql, $user_id, $customer_name, $address, $phone, $total_price, $message, $status, $created_at);
    }

    function order_update($user_id, $customer_name, $address, $phone, $total_price, $message, $status, $created_at, $id) {
        $sql = "UPDATE order SET user_id = ?, customer_name = ?, address = ?, phone = ?, total_price = ?, message = ?, status = ?, created_at = ? WHERE id = ?";
        pdo_execute($sql, $user_id, $customer_name, $address, $phone, $total_price, $message, $status, $created_at, $id);
    }

    function order_delete($id) {
        $sql = "DELETE FROM order WHERE id = ?";

        if (is_array($id)) {
            foreach ($id as $id_item) {
                pdo_execute($sql, $id_item);
            }
        } else {
            pdo_execute($sql, $id);
        }
    }

    function order_select_all() {
        $sql = "SELECT * FROM order ORDER BY id DESC";
        return pdo_query($sql);
    }

    function order_select_by_id($id) {
        $sql = "SELECT * FROM order WHERE id = ?";
        return pdo_query_one($sql, $id);
    }

    function order_exits($id) {
        $sql = "SELECT COUNT(*) FROM order WHERE id = ?";
        return pdo_query_value($sql, $id) > 0;
    }

?>