<?php

    require_once '../../global.php';
    require_once '../../dao/comment.php';

    check_login();
    extract($_REQUEST);

    if (array_key_exists('detail', $_REQUEST)) {
        // phân trang
        $totalOrder = count(comment_select_all_by_pid($p_id));
        $limit = 1;
        $totalPage = ceil($totalOrder / $limit);

        $currentPage = $page ?? 1;

        if ($currentPage <= 0) {
            header('Location: ' . $ADMIN_URL . '/order/?page=1');
        } else if ($currentPage > $totalPage) {
            $currentPage = $totalPage;
        }

        $start = ($currentPage - 1) * $limit;

        // lấy danh sách bình luận của 1 sp
        $listCmt = comment_select_all_by_pid($p_id, $start, $limit);
        $VIEW_PAGE = "detail.php";
    } else if (array_key_exists('btn_delete', $_REQUEST)) {
        comment_delete($id);
        header('Location: ' . $ADMIN_URL . '/comment/?detail&p_id=' . $p_id);
    } else {
        // phân trang
        $totalOrder = count(comment_select_all());
        $limit = 10;
        $totalPage = ceil($totalOrder / $limit);

        $currentPage = $page ?? 1;

        if ($currentPage <= 0) {
            header('Location: ' . $ADMIN_URL . '/order/?page=1');
        } else if ($currentPage > $totalPage) {
            $currentPage = $totalPage;
        }

        $start = ($currentPage - 1) * $limit;

        $listComment = comment_select_all($start, $limit);
        $VIEW_PAGE = "list.php";
    }

    require_once '../layout.php';

?>