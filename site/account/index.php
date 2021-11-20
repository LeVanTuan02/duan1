<?php

    require_once '../../global.php';
    require_once '../../dao/user.php';

    extract($_REQUEST);

    if (array_key_exists('btn_forgot', $_REQUEST)) {
        $getUser = user_exits($user);

        $userInfo = [];
        $errorMessage = [];

        $userInfo['user'] = $user ?? '';

        if (!$userInfo['user']) {
            $errorMessage['user'] = 'Vui lòng nhập tên đăng nhập hoặc email';
        } else if (!$getUser) {
            $errorMessage['user'] = 'Tên đăng nhập hoặc email không tồn tại trên hệ thống';
        }

        if (empty($errorMessage)) {
            // gửi email
            $token = user_send_reset_pass($getUser['email'], $getUser['fullName']);

            // insert mã token
            user_token_insert($token, $getUser['id']);
            
            unset($userInfo);
            $MESSAGE = 'Email khôi phục mật khẩu đã được gửi. Vui lòng kiểm tra Email và click vào link xác nhận để đổi mật khẩu.';
        }

        $VIEW_PAGE = "forgot_pass.php";
    } else if (array_key_exists('forgot_pass', $_REQUEST)) {
        $VIEW_PAGE = "forgot_pass.php";
    } else if (array_key_exists('btn_update_pass', $_REQUEST)) {
        $passInfo = [];
        $errorMessage = [];

        $passInfo['new_password'] = $new_password ?? '';
        $passInfo['confirm_password'] = $confirm_password ?? '';

        if (!$passInfo['new_password']) {
            $errorMessage['new_password'] = 'Vui lòng nhập mật khẩu mới';
        } else if (strlen($passInfo['new_password']) < 3) {
            $errorMessage['new_password'] = 'Mật khẩu tối thiểu 3 ký tự';
        }

        if (!$passInfo['confirm_password']) {
            $errorMessage['confirm_password'] = 'Vui lòng xác nhận mật khẩu';
        } else if (strlen($passInfo['confirm_password']) < 3) {
            $errorMessage['confirm_password'] = 'Mật khẩu tối thiểu 3 ký tự';
        } else if ($passInfo['new_password'] != $passInfo['confirm_password']) {
            $errorMessage['confirm_password'] = 'Mật khẩu xác nhận không chính xác, vui lòng nhập lại';
        }

        if (empty($errorMessage)) {
            $MESSAGE = 'Đổi mật khẩu thành công';
        }

        $VIEW_PAGE = "forgot_code.php";
    } else if (array_key_exists('code', $_REQUEST)) {
        // khi click link reset pass
        // nếu mã xác nhận ko tồn tại
        if (empty(user_exits_by_options('token', $code))) header('Location: ' . $SITE_URL);
        $VIEW_PAGE = "forgot_code.php";
    } else if (array_key_exists('btn_login', $_REQUEST)) {
        $userInfo = [];
        $errorMessage = [];

        $userInfo['user'] = $user ?? '';
        $userInfo['password'] = $password ?? '';

        if (!$userInfo['user']) {
            $errorMessage['user'] = 'Vui lòng nhập tên tài khoản hoặc email';
        }

        if (!$userInfo['password']) {
            $errorMessage['password'] = 'Vui lòng nhập mật khẩu';
        }

        if (empty($errorMessage)) {
            // nếu tồn tại username hoặc pass
            $getUser = user_exits($user);
            if ($getUser) {
                // check user locked
                if ($getUser['active']) {
                    // check password
                    if (password_verify($password, $getUser['password'])) {
                        $_SESSION['user'] = $getUser;
                        
                        // đăng nhập với vai trò QTV => dashboard
                        if ($getUser['role']) {
                            header('Location: ' . $ADMIN_URL);
                        } else {
                            header('Location: ' . $SITE_URL);
                        }
                    } else {
                        $errorMessage['password'] = 'Mật khẩu không chính xác, vui lòng nhập lại';
                    }
                } else {
                    $errorMessage['user'] = 'Tên tài khoản của bạn đã bị khóa, vui lòng liên hệ QTV';
                }
            } else {
                $errorMessage['user'] = 'Tên tài khoản hoặc email không tồn tại trên hệ thống';
            }
        }

        $VIEW_PAGE = "login.php";
    } else {
        $VIEW_PAGE = "login.php";
    }

    require_once '../layout.php';

?>