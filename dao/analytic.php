<?php

    require_once 'pdo.php';

    // thống kê tài khoản (khóa, hoạt động)
    function analytics_user() {
        $sql = "SELECT active, COUNT(*) AS total FROM `user` GROUP BY active ORDER BY active DESC";
        return pdo_query($sql);
    }

    // thống kê kh đăng ký theo tháng
    function analytics_user_reg() {
        $sql = "SELECT MONTH(created_at) AS month, COUNT(*) AS total FROM `user` GROUP BY MONTH(created_at)";
        return pdo_query($sql);
    }

    // thống kê doanh thu theo tháng
    function analytics_price() {
        $sql = "SELECT MONTH(created_at) AS month, SUM(total_price) AS totalPrice FROM `order` WHERE status = 3 GROUP BY MONTH(created_at)";
        return pdo_query($sql);
    }
    
    // thống kê số lượng sản phẩm theo danh mục
    function analytics_quantity_product_by_cate() {
        $sql = "SELECT c.cate_name, c.cate_image, c.id, COUNT(*) AS totalProduct FROM product p JOIN category c ON p.cate_id = c.id GROUP BY c.id ORDER BY c.id DESC";
        return pdo_query($sql);
    }

    // thống kê giá sản phẩm theo danh mục
    function analytics_price_product_by_cate() {
        $sql = "SELECT c.cate_name, c.id, MAX(price) AS maxPrice, MIN(price) AS minPrice, AVG(price) AS avgPrice
        FROM ((product p JOIN category c ON p.cate_id = c.id) LEFT JOIN attribute a ON p.id = a.product_id)
        GROUP BY c.id
        ORDER BY c.id DESC";
        return pdo_query($sql);
    }

    // thống kê đơn hàng (mới, đã hủy
    function analytics_select_totalOrder_by_stt($status) {
        $sql = "SELECT COUNT(*) AS total FROM `order` WHERE `status` = ?";
        return pdo_query_value($sql, $status);
    }
    

?>