<?php

    require_once '../../global.php';
    require_once '../../dao/order.php';

    extract($_REQUEST);

    if (array_key_exists('detail', $_REQUEST)) {
        $VIEW_PAGE = "detail.php";
    }
    else {
        $VIEW_PAGE = "list.php";
    }

    require_once '../layout.php';

?>