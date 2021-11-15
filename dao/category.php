
<?php

    require_once 'pdo.php';

    function category_insert($cate_name, $cate_image) {
        $sql = "INSERT INTO category(cate_name, cate_image)
        VALUES(?, ?, ?, ?, ?, ?, ?)";
        pdo_execute($sql, $cate_name, $cate_image);
    }

    function category_update($cate_name, $cate_image, $id) {
        $sql = "UPDATE category SET cate_name = ?, cate_image = ? WHERE id = ?";
        pdo_execute($sql, $cate_name, $cate_image, $id);
    }

    function category_delete($id) {
        $sql = "DELETE FROM category WHERE id = ?";

        if (is_array($id)) {
            foreach ($id as $id_item) {
                pdo_execute($sql, $id_item);
            }
        } else {
            pdo_execute($sql, $id);
        }
    }

    function category_select_all() {
        $sql = "SELECT * FROM category ORDER BY id DESC";
        return pdo_query($sql);
    }

    function category_select_by_id($id) {
        $sql = "SELECT * FROM category WHERE id = ?";
        return pdo_query_one($sql, $id);
    }

    function category_exits($id) {
        $sql = "SELECT COUNT(*) FROM category WHERE id = ?";
        return pdo_query_value($sql, $id) > 0;
    }

?>