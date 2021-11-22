<?php

    require_once 'global.php';
    require_once 'dao/order.php';

    // $_SESSION['cart'][0]['quantity'] = 3;
    echo "<pre>";
    var_dump($_SESSION['cart']);


    // unset($_SESSION['cart']);
    // order_send_mail_customer('levantuan.fpoly@gmail.com', 'Lê Tuân');



?>