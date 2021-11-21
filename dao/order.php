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

    function order_select_all($start = 0, $limit = 0) {
        $sql = "SELECT * FROM `order` ORDER BY id DESC";
        if ($limit) {
            $sql .= " LIMIT $start, $limit";
        }
        
        return pdo_query($sql);
    }

    function order_select_by_id($id) {
        $sql = "SELECT * FROM `order` WHERE id = ?";
        return pdo_query_one($sql, $id);
    }

    // ds đơn hàng của tôi
    function order_select_all_by_user_id($id, $start = 0, $limit = 0) {
        $sql = "SELECT * FROM `order` WHERE user_id = ? ORDER BY id DESC";
        if ($limit) {
            $sql .= " LIMIT $start, $limit";
        }
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

    function convert_number_to_words($number) {
        $hyphen      = ' ';
        $conjunction = '  ';
        $separator   = ' ';
        $negative    = 'âm ';
        $decimal     = ' phẩy ';
        $dictionary  = array(
        0                   => 'Không',
        1                   => 'Một',
        2                   => 'Hai',
        3                   => 'Ba',
        4                   => 'Bốn',
        5                   => 'Năm',
        6                   => 'Sáu',
        7                   => 'Bảy',
        8                   => 'Tám',
        9                   => 'Chín',
        10                  => 'Mười',
        11                  => 'Mười một',
        12                  => 'Mười hai',
        13                  => 'Mười ba',
        14                  => 'Mười bốn',
        15                  => 'Mười năm',
        16                  => 'Mười sáu',
        17                  => 'Mười bảy',
        18                  => 'Mười tám',
        19                  => 'Mười chín',
        20                  => 'Hai mươi',
        30                  => 'Ba mươi',
        40                  => 'Bốn mươi',
        50                  => 'Năm mươi',
        60                  => 'Sáu mươi',
        70                  => 'Bảy mươi',
        80                  => 'Tám mươi',
        90                  => 'Chín mươi',
        100                 => 'trăm',
        1000                => 'ngàn',
        1000000             => 'triệu',
        1000000000          => 'tỷ',
        1000000000000       => 'nghìn tỷ',
        1000000000000000    => 'ngàn triệu triệu',
        1000000000000000000 => 'tỷ tỷ'
        );
    
        if (!is_numeric($number)) {
            return false;
        }
    
        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING
            );
            return false;
        }
    
        if ($number < 0) {
            return $negative . convert_number_to_words(abs($number));
        }
        
        $string = $fraction = null;
        
        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }
    
        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
            break;
            case $number < 100:
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
            break;
            case $number < 1000:
                $hundreds  = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= convert_number_to_words($remainder);
                }
            break;
        }
    
        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }
    
        return $string;
    }

?>