<?php

    require_once '../../global.php';
    require_once '../../dao/product.php';
<<<<<<< Updated upstream
    require_once '../../dao/contact.php';
=======
    require_once '../../dao/settings.php';
>>>>>>> Stashed changes
    require_once '../../dao/analytic.php';

    $isWebsiteOpen = settings_select_all();
    if (!$isWebsiteOpen || !$isWebsiteOpen['status']) header('Location: ' . $SITE_URL . '/home/close.php');

    extract($_REQUEST);


    if (array_key_exists('intro', $_REQUEST)) {
        $VIEW_PAGE = "intro.php";
    } else if (array_key_exists('order', $_REQUEST)) {
        $VIEW_PAGE = "order.php";
    } else if(array_key_exists('contact_insert', $_REQUEST)){

        $title = 'Liên hệ - Góp ý';
        $errorMessage = [];
        $contact = [];

        if (isset($_SESSION['user'])) {
            $name = $_SESSION['user']['fullName'];
            $email = $_SESSION['user']['email'];
            $phone = $_SESSION['user']['phone'];
            // $name = $_SESSION['user']['fullName'];
        }
        $contact['name'] = $name ?? '';
        $contact['email'] = $email ?? '';
        $contact['phone'] = $phone ?? '';
        $contact['content'] = $content ?? '';

        if (!$contact['name']) {
            $errorMessage['name'] = 'Vui lòng nhập họ tên';
        } else if (!preg_match('/^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂẾưăạảấầẩẫậắằẳẵặẹẻẽềềểếỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s\W|_]+$/', $contact['name'])) {
            $errorMessage['name'] = 'Vui lòng nhập lại, họ tên không đúng định dạng';
        }
        
        if (!$contact['email']) {
            $errorMessage['email'] = 'Vui lòng nhập email';
        } else if (!preg_match('/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/', $contact['email'])) {
            $errorMessage['email'] = 'Vui lòng nhập lại, email không đúng định dạng';
        }

        if (!$contact['phone']) {
            $errorMessage['phone'] = 'Vui lòng nhập số điện thoại';
        } else if (!preg_match('/(84|0[3|5|7|8|9])+([0-9]{8})\b/', $contact['phone'])) {
            $errorMessage['phone'] = 'Vui lòng nhập lại, số điện thoại không đúng định dạng';
        }

        if (!$contact['content']) {
            $errorMessage['content'] = 'Vui lòng nhập nội dung góp ý';
        }

        if (empty($errorMessage)) {
            $created_at = Date('Y-m-d H:i:s');
            contact_insert($name, $content, $email, $phone, $created_at);
            unset($contact);
            $MESSAGE = 'Gửi góp ý thành công';
        }
        $VIEW_PAGE = "contact.php";
    } else if (array_key_exists('contact', $_REQUEST)) {
        $VIEW_PAGE = 'contact.php';
    }
     else {
        // danh sách menu
        $listProduct = product_home_select_all(0, 8);

        // danh mục sản phẩm
        $categoryInfo = analytics_quantity_product_by_cate();
        $VIEW_PAGE = "home.php";
    }

    require_once '../layout.php';

?>