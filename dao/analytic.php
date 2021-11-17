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

?>