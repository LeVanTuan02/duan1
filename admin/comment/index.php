<?php

    require_once '../../global.php';
    require_once '../../dao/comment.php';

    extract($_REQUEST);

    if (array_key_exists('detail', $_REQUEST)) {
        // lấy danh sách bình luận của 1 sp
        $listCmt = comment_select_all_by_pid($p_id);
        $VIEW_PAGE = "detail.php";
    } else if (array_key_exists('btn_delete', $_REQUEST)) {
        comment_delete($id);
        header('Location: ' . $ADMIN_URL . '/comment/?detail&p_id=' . $p_id);
    } else {
        $listComment = comment_select_all();
        $VIEW_PAGE = "list.php";
    }

    require_once '../layout.php';

?>