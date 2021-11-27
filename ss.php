<?php

    require_once 'global.php';
    require_once 'dao/order.php';

    echo "<pre>";
    var_dump($_SESSION['user']);

    // unset($_SESSION['user']);
    // order_send_mail_customer('levantuan.fpoly@gmail.com', 'Lê Tuân');



?>