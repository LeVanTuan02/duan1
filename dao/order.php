<?php

    require_once 'pdo.php';

    function order_insert($user_id, $customer_name, $address, $phone, $email, $total_price, $message, $status, $created_at) {
        $sql = "INSERT INTO `order`(user_id, customer_name, address, phone, email, total_price, message, status, created_at)
        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
        return pdo_execute($sql, $user_id, $customer_name, $address, $phone, $email, $total_price, $message, $status, $created_at);
    }

    // function order_update($user_id, $customer_name, $address, $phone, $total_price, $message, $status, $created_at, $id) {
    //     $sql = "UPDATE `order` SET user_id = ?, customer_name = ?, address = ?, phone = ?, total_price = ?, message = ?, status = ?, created_at = ? WHERE id = ?";
    //     pdo_execute($sql, $user_id, $customer_name, $address, $phone, $total_price, $message, $status, $created_at, $id);
    // }

    // function order_delete($id) {
    //     $sql = "DELETE FROM `order` WHERE id = ?";

    //     if (is_array($id)) {
    //         foreach ($id as $id_item) {
    //             pdo_execute($sql, $id_item);
    //         }
    //     } else {
    //         pdo_execute($sql, $id);
    //     }
    // }

    function order_select_all() {
        $sql = "SELECT * FROM `order` ORDER BY id DESC";
        return pdo_query($sql);
    }

    function order_select_by_id($id) {
        $sql = "SELECT * FROM `order` WHERE id = ?";
        return pdo_query_one($sql, $id);
    }

    // ds đơn hàng của tôi
    function order_select_all_by_user_id($id) {
        $sql = "SELECT * FROM `order` WHERE user_id = ? ORDER BY id DESC";
        return pdo_query($sql, $id);
    }

    // function order_exits($id) {
    //     $sql = "SELECT COUNT(*) FROM `order` WHERE id = ?";
    //     return pdo_query_value($sql, $id) > 0;
    // }

    // check hủy đơn hàng
    function order_check_delivered($id) {
        $sql = "SELECT * FROM `order` WHERE id = ? AND status IN (2, 3)";
        return pdo_query($sql, $id);
    }

    // cập nhật trạng thái đơn hàng 0 - Đơn hàng mới, 1 - Đã xác nhận, 2 - Đang giao hàng, 3 - Đã giao, 4 - Đã hủy
    function order_update_status($status, $id) {
        $sql = "UPDATE `order` SET status = ? WHERE id = ?";
        pdo_execute($sql, $status, $id);
    }

?>