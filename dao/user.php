
<?php

    require_once 'pdo.php';

    function user_insert($username, $password, $email, $phone, $fullName, $address, $avatar, $active, $role, $token, $created_at) {
        $sql = "INSERT INTO user(username, password, email, phone, fullName, address, avatar, active, role, token, created_at)
        VALUES(?, ?, ?, ?, ?, ?, ?)";
        pdo_execute($sql, $username, $password, $email, $phone, $fullName, $address, $avatar, $active, $role, $token, $created_at);
    }

    function user_update($username, $password, $email, $phone, $fullName, $address, $avatar, $active, $role, $token, $created_at, $id) {
        $sql = "UPDATE user SET username = ?, password = ?, email = ?, phone = ?, fullName = ?, address = ?, avatar = ?, active = ?, role = ?, token = ?, created_at = ?  WHERE id = ?";
        pdo_execute($sql,$username, $password, $email, $phone, $fullName, $address, $avatar, $active, $role, $token, $created_at, $id);
    }

    function user_delete($id) {
        $sql = "DELETE FROM user WHERE id = ?";

        if (is_array($id)) {
            foreach ($id as $id_item) {
                pdo_execute($sql, $id_item);
            }
        } else {
            pdo_execute($sql, $id);
        }
    }

    function user_select_all() {
        $sql = "SELECT * FROM user ORDER BY id DESC";
        return pdo_query($sql);
    }

    function user_select_by_id($id) {
        $sql = "SELECT * FROM user WHERE id = ?";
        return pdo_query_one($sql, $id);
    }

    function user_exits($id) {
        $sql = "SELECT COUNT(*) FROM user WHERE id = ?";
        return pdo_query_value($sql, $id) > 0;
    }

?>