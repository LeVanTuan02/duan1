
<?php

    require_once 'pdo.php';

    function comment_insert($content, $product_id, $user_id, $comment_parent_id,  $created_at) {
        $sql = "INSERT INTO comment(content, product_id, user_id, comment_parent_id,  created_at)
        VALUES(?, ?, ?, ?, ?)";
        pdo_execute($sql, $content, $product_id, $user_id, $comment_parent_id,  $created_at);
    }

    function comment_update($content, $product_id, $user_id, $comment_parent_id,  $created_at, $id) {
        $sql = "UPDATE comment SET content = ?, product_id = ?, user_id = ?, comment_parent_id = ?,  created_at = ? WHERE id = ?";
        pdo_execute($sql, $content, $product_id, $user_id, $comment_parent_id,  $created_at, $id);
    }

    function comment_delete($id) {
        $sql = "DELETE FROM comment WHERE id = ?";

        if (is_array($id)) {
            foreach ($id as $id_item) {
                pdo_execute($sql, $id_item);
            }
        } else {
            pdo_execute($sql, $id);
        }
    }

    function comment_select_all() {
        $sql = "SELECT * FROM comment ORDER BY id DESC";
        return pdo_query($sql);
    }

    function comment_select_by_id($id) {
        $sql = "SELECT * FROM comment WHERE id = ?";
        return pdo_query_one($sql, $id);
    }

    function comment_exits($id) {
        $sql = "SELECT COUNT(*) FROM comment WHERE id = ?";
        return pdo_query_value($sql, $id) > 0;
    }

?>