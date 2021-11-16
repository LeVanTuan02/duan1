
<?php

    require_once 'pdo.php';

    function contact_insert($name, $content, $email, $phone, $created_at) {
        $sql = "INSERT INTO contact(name, content, email, phone,  created_at)
        VALUES(?, ?, ?, ?, ?)";
        pdo_execute($sql, $name, $content, $email, $phone, $created_at);
    }

    function contact_update($name, $content, $email, $phone, $created_at, $id) {
        $sql = "UPDATE contact SET name = ?, content = ?, email = ?, phone = ?,  created_at = ? WHERE id = ?";
        pdo_execute($sql, $name, $content, $email, $phone, $created_at, $id);
    }

    function contact_delete($id) {
        $sql = "DELETE FROM contact WHERE id = ?";

        if (is_array($id)) {
            foreach ($id as $id_item) {
                pdo_execute($sql, $id_item);
            }
        } else {
            pdo_execute($sql, $id);
        }
    }

    function contact_select_all() {
        $sql = "SELECT * FROM contact ORDER BY id DESC";
        return pdo_query($sql);
    }

    function contact_select_by_id($id) {
        $sql = "SELECT * FROM contact WHERE id = ?";
        return pdo_query_one($sql, $id);
    }

    function contact_exits($id) {
        $sql = "SELECT COUNT(*) FROM contact WHERE id = ?";
        return pdo_query_value($sql, $id) > 0;
    }

?>