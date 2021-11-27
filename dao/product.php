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

    function product_select_all($start = 0, $limit = 0) {
        $sql = "SELECT p.*, c.cate_name, SUM(a.quantity) AS totalProduct
        FROM ((product p LEFT JOIN attribute a ON p.id = a.product_id)
        JOIN category c ON p.cate_id = c.id)
        GROUP BY p.id
        ORDER BY id DESC";
        if ($limit) {
            $sql .= " LIMIT $start, $limit";
        }
        return pdo_query($sql);
    }

    // tìm kiếm backend
    function product_search($keyword, $cate_id) {
        $sql = "SELECT p.*, c.cate_name, SUM(a.quantity) AS totalProduct
        FROM ((product p LEFT JOIN attribute a ON p.id = a.product_id)
        JOIN category c ON p.cate_id = c.id) WHERE 1";

        $sql_last = " GROUP BY p.id ORDER BY id DESC";

        if ($keyword && $cate_id) {
            $sql .= " AND p.product_name LIKE ? AND p.cate_id = ?" . $sql_last;
            return pdo_query($sql, '%'.$keyword.'%', $cate_id);
        } else if ($keyword) {
            $sql .= " AND p.product_name LIKE ?" . $sql_last;
            return pdo_query($sql, '%'.$keyword.'%');
        } else if ($cate_id) {
            $sql .= " AND p.cate_id = ?" . $sql_last;
            return pdo_query($sql, $cate_id);
        } else {
            $sql .= $sql_last;
            return pdo_query($sql);
        }
        
    }

    // sản phẩm trang khách hàng
    function product_home_select_all($start = 0, $limit = 0) {
        $sql = "SELECT p.id, p.product_name, p.product_image, MIN(a.price) as price
        FROM product p JOIN attribute a ON p.id = a.product_id
        GROUP BY p.id
        ORDER BY p.id DESC";

        if ($limit) {
            $sql .= " LIMIT $start, $limit";
            // return pdo_query($sql, $start, $limit);
        }

        return pdo_query($sql);
    }

    function product_select_by_id($id) {
        $sql = "SELECT * FROM product WHERE id = ?";
        return pdo_query_one($sql, $id);
    }

    // lấy sản phẩm theo id trang khách hàng
    function product_home_select_by_id($id, $size = '') {
        $sql = "SELECT p.*, a.price, a.size, a.quantity FROM product p JOIN attribute a ON p.id = a.product_id
        WHERE p.id = ?";

        if ($size) {
            $sql .= " AND a.size = ?";
            // return $sql;
            return pdo_query_one($sql, $id, $size);
        }

        $sql .= " ORDER BY a.price";

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
        if (pdo_query_one($sql_get_quantity)) {
            $status = 1;
        }
        $sql = "UPDATE product SET status = $status WHERE id = ?";
        pdo_execute($sql, $id);
    }

    // kiểm tra tên sản phẩm tồn tại không
    function product_name_exits($product_name) {
        $sql = "SELECT * FROM product WHERE product_name = ?";
<<<<<<< Updated upstream
        return pdo_query_one($sql, $product_name) > 0;
    }
    function product_relation($cate_id, $id) {
        $sql = "SELECT p.*, ct.cate_name FROM product p JOIN category ct ON p.cate_id = ct.id
        WHERE NOT p.id = ? AND p.cate_id = ? ORDER BY cate_id DESC LIMIT 0, 4";
        return pdo_query($sql,$cate_id, $id);
=======
        return pdo_query_one($sql, $product_name);
    }

    // lấy giá, số lượng sp từ size và id sp
    function product_get_price_qnt_from_size($id, $size) {
        $sql = "SELECT a.price, a.quantity FROM product p JOIN attribute a ON p.id = a.product_id WHERE p.id = ? AND a.size = ?";
        return pdo_query_one($sql, $id, $size);
>>>>>>> Stashed changes
    }


?>