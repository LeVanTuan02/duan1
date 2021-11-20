<?php

    require_once '../../global.php';
    require_once '../../dao/product.php';

    extract($_REQUEST);
    if (!isset($_SESSION['wishlist']) || !is_array($_SESSION['wishlist'])) $_SESSION['wishlist'] = [];

    if (array_key_exists('add_wishlist', $_REQUEST)) {
        $isProductExits = false;

        foreach($_SESSION['wishlist'] as $item) {
            if ($item['id'] == $id) $isProductExits = true;
        }

        // nếu sp chưa tồn tại trong session
        if (!$isProductExits) {
            $productInfo = product_home_select_by_id($id);
            $productInfo['date'] = date('Y-m-d H:i:s');
            array_push($_SESSION['wishlist'], $productInfo);
        }
    } else if (array_key_exists('render_wishlist', $_REQUEST)) {
        if (!$_SESSION['wishlist']) {
            echo '<p class="wishlist__body-message">Không có sản phẩm nào trong danh sách yêu thích</p>';
        } else {
            $html = array_map(function($item) {
                global $IMG_URL;
                return
                '<li class="wishlist__body-list-item wishlist__body-list-item-'.$item['id'].'">
                    <a href="/site/hang-hoa/chi-tiet.php?ma_hh=49" class="wishlist__body-list-item-image-link">
                        <img src="'.$IMG_URL.'/'.$item['product_image'].'" alt="" class="wishlist__body-list-item-image">
                    </a>
        
                    <div class="wishlist__body-list-item-info">
                        <a href="/site/hang-hoa/chi-tiet.php?ma_hh=49" class="wishlist__body-list-item-title">'.$item['product_name'].'</a>
                        <span class="wishlist__body-list-item-price">'.number_format($item['price'], 0, '', ',').'₫</span>
                        <span class="wishlist__body-list-item-time">'.date_format(date_create($item['date']), 'd/m/Y H:i').'</span>
                    </div>
        
                    <div class="wishlist__body-icon-delete" onclick="delete_wishlist('.$item['id'].');">
                        <i class="fas fa-trash"></i>
                    </div>
                </li>';
            }, $_SESSION['wishlist']);
            echo join('', $html);
        }
    } else if (array_key_exists('delete_wishlist', $_REQUEST)) {
        foreach ($_SESSION['wishlist'] as $key => $item) {
            if ($item['id'] == $id) {
                unset($_SESSION['wishlist'][$key]);
                echo 1;
            }
        }
    } else if (array_key_exists('get_quantity', $_REQUEST)) {
        echo count($_SESSION['wishlist']);
    } else if (array_key_exists('get_quantity_cart', $_REQUEST)) {
        echo count($_SESSION['cart']);
    }

?>