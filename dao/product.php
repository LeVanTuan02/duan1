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

        if ($limit && $start >= 0) {
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
        $sql = "SELECT p.*, a.price, a.size, a.quantity, c.cate_name, p.cate_id FROM ((product p JOIN attribute a ON p.id = a.product_id)
        JOIN category c ON p.cate_id = c.id)
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
        $sql_get_quantity = "SELECT SUM(quantity) FROM attribute WHERE product_id = $id";
        if (pdo_query_value($sql_get_quantity) > 0) {
            $status = 1;
        }
        $sql = "UPDATE product SET status = $status WHERE id = ?";
        pdo_execute($sql, $id);
        return $status;
    }

    // kiểm tra tên sản phẩm tồn tại không
    function product_name_exits($product_name) {
        $sql = "SELECT * FROM product WHERE product_name = ?";
        return pdo_query_one($sql, $product_name);
    }

    // lấy giá, số lượng sp từ size và id sp
    function product_get_price_qnt_from_size($id, $size) {
        $sql = "SELECT a.price, a.quantity FROM product p JOIN attribute a ON p.id = a.product_id WHERE p.id = ? AND a.size = ?";
        return pdo_query_one($sql, $id, $size);
    }

    // sản phẩm cùng loại
    function product_relation($id, $cate_id) {
        $sql = "SELECT p.id, p.product_name, p.product_image, MIN(a.price) as price
        FROM product p JOIN attribute a ON p.id = a.product_id
        WHERE NOT p.id = ? AND p.cate_id = ?
        GROUP BY p.id
        ORDER BY p.id DESC LIMIT 4";
        return pdo_query($sql, $id, $cate_id);
    }

    // tìm kiếm sp
    function product_home_search($keyword) {
        $sql = "SELECT p.id, p.product_name, p.product_image, MIN(a.price) as price
        FROM product p JOIN attribute a ON p.id = a.product_id
        WHERE p.product_name LIKE ?
        GROUP BY p.id
        ORDER BY p.id DESC";
        return pdo_query($sql, '%'.$keyword.'%');
    }

    // sp theo danh mục
    function product_home_select_by_cate($cate_id, $start = '', $limit = '') {
        $sql = "SELECT p.id, p.product_name, p.product_image, MIN(a.price) as price, c.cate_name
        FROM ((product p JOIN attribute a ON p.id = a.product_id)
        JOIN category c ON p.cate_id = c.id)
        WHERE p.cate_id = ?
        GROUP BY p.id
        ORDER BY p.id DESC";
        if ($limit && $start >= 0) {
            $sql .= " LIMIT $start, $limit";
        }
        return pdo_query($sql, $cate_id);
    }

    // tăng lượt xem
    function product_update_view($id) {
        $sql = "UPDATE product SET view = view + 1 WHERE id = ?";
        pdo_execute($sql, $id);
    }

    // lọc sp
    function product_filter($type, $cate_id = '') {
        $sql = "SELECT p.*, MIN(a.price) as price, c.cate_name
        FROM ((product p JOIN attribute a ON p.id = a.product_id)
        JOIN category c ON p.cate_id = c.id)";
        if ($cate_id) {
            $sql .= " WHERE p.cate_id = $cate_id";
        }
        $sql .= " GROUP BY p.id";

        switch($type) {
            case 'date_desc':
                $sql .= " ORDER BY p.id DESC";
                break;
            case 'date_asc':
                $sql .= " ORDER BY p.id";
                break;
            case 'price_asc':
                $sql .= " ORDER BY price";
                break;
            case 'price_desc':
                $sql .= " ORDER BY price DESC";
                break;
            case 'view_asc':
                $sql .= " ORDER BY view";
                break;
            case 'view_desc':
                $sql .= " ORDER BY view DESC";
                break;
            default:
                $sql .= " HAVING p.cate_id = ?";
                return pdo_query($sql, $type);

        }

        return pdo_query($sql);
    }


?>