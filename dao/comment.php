
<?php

    require_once 'pdo.php';

    function comment_insert($content, $product_id, $user_id, $comment_parent_id,  $created_at) {
        $sql = "INSERT INTO comment(content, product_id, user_id, comment_parent_id,  created_at)
        VALUES(?, ?, ?, ?, ?)";
        pdo_execute($sql, $content, $product_id, $user_id, $comment_parent_id,  $created_at);
    }

    // function comment_update($content, $product_id, $user_id, $comment_parent_id,  $created_at, $id) {
    //     $sql = "UPDATE comment SET content = ?, product_id = ?, user_id = ?, comment_parent_id = ?,  created_at = ? WHERE id = ?";
    //     pdo_execute($sql, $content, $product_id, $user_id, $comment_parent_id,  $created_at, $id);
    // }

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

    // function comment_select_all() {
    //     $sql = "SELECT * FROM comment ORDER BY id DESC";
    //     return pdo_query($sql);
    // }

    // lấy danh sách bình luận theo mã sp
    function comment_select_all_by_pid($p_id, $start = 0, $limit = 0) {
        $sql = "SELECT c.*, u.fullName, u.username, p.product_name FROM ((`comment` c JOIN product p ON c.product_id = p.id)
        JOIN `user` u ON c.user_id = u.id) WHERE p.id = ? ORDER BY c.id DESC";
        if ($limit) {
            $sql .= " LIMIT $start, $limit";
        }
        return pdo_query($sql, $p_id);
    }

    function comment_exits($id) {
        $sql = "SELECT COUNT(*) FROM comment WHERE id = ?";
        return pdo_query_value($sql, $id) > 0;
    }

    // thống kê bình luận theo sản phẩm
    function comment_select_all($start = 0, $limit = 0) {
        $sql = "SELECT p.product_name, p.id, COUNT(*) AS totalComment, MIN(c.created_at) AS oldest, MAX(c.created_at) AS latest
        FROM `comment` c JOIN product p ON c.product_id = p.id GROUP BY p.id ORDER BY c.id DESC";
        if ($limit) {
            $sql .= " LIMIT $start, $limit";
        }
        return pdo_query($sql);
    }

?>