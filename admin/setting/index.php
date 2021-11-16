<?php

    require_once '../../global.php';
    require_once '../../dao/settings.php';

    extract($_REQUEST);

    if (array_key_exists('btn_update', $_REQUEST)) {
        $settingInfo = settings_select_all();

        $setting = [];
        $errorMessage = [];

        $setting['title'] = $title ?? '';
        $setting['phone'] = $phone ?? '';
        $setting['email'] = $email ?? '';
        $setting['address'] = $address ?? '';
        $setting['map'] = $map ?? '';
        $setting['facebook'] = $facebook ?? '';
        $setting['youtube'] = $youtube ?? '';
        $setting['instagram'] = $instagram ?? '';
        $setting['tiktok'] = $tiktok ?? '';
        $setting['status'] = $status ?? '';

        if (!$setting['title']) {
            $errorMessage['title'] = 'Vui lòng nhập tiêu đề website';
        }

        if (!$setting['phone']) {
            $errorMessage['phone'] = 'Vui lòng nhập số điện thoại';
        }

        if (!$setting['email']) {
            $errorMessage['email'] = 'Vui lòng nhập địa chỉ email';
        }

        if (!$setting['address']) {
            $errorMessage['address'] = 'Vui lòng nhập địa chỉ website';
        }

        if (!$setting['map']) {
            $errorMessage['map'] = 'Vui lòng nhập Iframe Google map';
        }

        if ($setting['status'] == '') {
            $errorMessage['status'] = 'Vui lòng chọn trạng thái website';
        }

        if (empty($errorMessage)) {
            if (empty($settingInfo)) {
                settings_insert($title, $phone, $email, $address, $map, $facebook, $youtube, $instagram, $tiktok, $status);
            } else {
                settings_update($title, $phone, $email, $address, $map, $facebook, $youtube, $instagram, $tiktok, $status);
            }
            
            $MESSAGE = 'Cập nhật cấu hình thành công';
        }

        $VIEW_PAGE = "edit.php";
    } else {
        $settingInfo = settings_select_all();

        $VIEW_PAGE = "edit.php";
    }

    require_once '../layout.php';

?>