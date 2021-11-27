<?php

    require_once '../../global.php';
    require_once '../../dao/product.php';
    require_once '../../dao/comment.php';
    require_once '../../dao/rating.php';

    extract($_REQUEST);

    if (array_key_exists('keyword', $_REQUEST)) {
        $itemData = product_home_search($keyword);
        $VIEW_PAGE = "search.php";
    } else if (array_key_exists('category', $_REQUEST)) {
        $itemData = product_home_select_by_cate($cate_id);
        $VIEW_PAGE = "category.php";
    } else if (array_key_exists('detail', $_REQUEST)) {
        // danh sách bình luận
        $listDataComment = comment_home_select_all_by_pid($id);

        // danh sách cmt chính
        $listComment = array_filter($listDataComment, function ($comment) {
            return !$comment['comment_parent_id'];
        });

        // danh sách comment trả lời
        $listCommentRep = array_filter($listDataComment, function ($comment) {
            return $comment['comment_parent_id'];
        });
        $listCommentRep = array_reverse($listCommentRep);

        // chi tiết sản phẩm
        $titleData = "Chi tiết sản phẩm";
        $itemData = product_home_select_by_id($id);

        // sp cùng loại
        $item_tt = product_relation($id, $itemData['cate_id']);

        $VIEW_PAGE = "detail.php";
    } else if (array_key_exists('get_price', $_REQUEST)) {
        // lấy giá, số lượng sp từ size và id sp
        $productSizeQnt = product_get_price_qnt_from_size($id, $size);
        if ($productSizeQnt) {
            echo json_encode(array(
                'success' => true,
                'price' => number_format($productSizeQnt['price']),
                'quantity' => $productSizeQnt['quantity']
            ));
        } else {
            echo json_encode(array(
                'success' => false
            ));
        }
        die();
    } else if (array_key_exists('comment', $_REQUEST)) {
        // submit form bình luận chính
        $user_id = $_SESSION['user']['id'];
        $ratingExits = rating_exits($product_id, $user_id);
        if ($ratingExits) {
            rating_update($product_id, $user_id, $rating_number, $ratingExits['id']);
        } else {
            rating_insert($product_id, $user_id, $rating_number);
        }

        $created_at = date('Y-m-d H:i:s');
        $lastInsertId = comment_insert($content, $product_id, $user_id, 0, $created_at);
        echo $lastInsertId ?? false;
        die();
    } else if (array_key_exists('btn_repCmt', $_REQUEST)) {
        // click buttom trả lời
        echo '
        <img src="'. $IMG_URL . '/' . $_SESSION['user']['avatar'] .'" alt="" class="comment__rep-form-avatar">
        <div class="comment__rep-form-wrap">
            <textarea type="text" rows="1" class="comment__rep-form-control" placeholder="Nhập nội dung trả lời" data-id="'. $id .'" data-product-id="'. $product_id .'"></textarea>
            <button class="comment__rep-form-send" onclick="repComment(event);">
                <i class="fas fa-reply"></i>
            </button>
        </div>
        ';
        die();
    } else if (array_key_exists('repCmt_insert', $_REQUEST)) {
        // submit form rep cmt
        $created_at = date('Y-m-d H:i:s');
        $lastInsertId =  comment_insert($content, $product_id, $_SESSION['user']['id'], $comment_parent_id, $created_at);
        echo $lastInsertId ?? false;
        die();
    } else if (array_key_exists('delete_cmt', $_REQUEST)) {
        comment_delete($id);
        echo true;
        die();
    } else if (array_key_exists('render_cmt_rep', $_REQUEST)) {
        $cmtInfo = comment_select_by_id($id);
        $html = '';
        $html .= '
        <li class="comment__rep-item comment__rep-item-' . $cmtInfo['id'] . '">
            <img src="' . $IMG_URL . '/' . $cmtInfo['avatar'] . '" alt="">
            <div class="comment__rep-item-info">
                <div class="comment__rep-item-title">
                    <span class="comment__rep-item-name">' . $cmtInfo['fullName'] . '</span>
                    <span class="cmt__title-date">
                        (' . date_format(date_create($cmtInfo['created_at']), "d") . '
                        Tháng ' . date_format(date_create($cmtInfo['created_at']), "m") . ',
                        ' . date_format(date_create($cmtInfo['created_at']), "Y") . ')
                    </span>
                </div>
                <p class="comment__rep-item-content">
                    ' . nl2br($cmtInfo['content']) . '
                </p>
                <ul class="info_cmt-actions">
                <!-- admin và người cmt có quyền xóa bình luận -->';

                if ($cmtInfo['user_id'] == $_SESSION['user']['id'] || $_SESSION['user']['role']) {
                    $html .= '<li class="info_cmt-action info_cmt-action--delete" onclick="deleteComment(' . $cmtInfo['id'] . ');">Xóa</li>';
                }

                $html .= '
                    <li class="info_cmt-action info_cmt-action--rep">Trả lời</li>
                </ul>
            </div>
        </li>
        ';
        echo $html;
        die();
    } else if (array_key_exists('render_cmt', $_REQUEST)) {
        $cmtInfo = comment_select_by_id($id);
        $html = '';
        $html .= '
        <div class="comment comment-'. $cmtInfo['id'] .'">
            <img src="' . $IMG_URL . '/' . $cmtInfo['avatar'] . '" alt="" width="70px">
            <div class="info_cmt info_cmt-' . $cmtInfo['id'] . '" data-id="' . $cmtInfo['id'] . '" data-product-id="' . $cmtInfo['product_id'] . '">
                <div class="stars">
                    <!-- số sao còn lại -->';
                for($i = 1; $i <= (5 - $cmtInfo['rating_number']); $i++) {
                    $html .= '
                    <div class="star">
                        <i class="fas fa-star"></i>
                    </div>';
                }

                for($i = 1; $i <= $cmtInfo['rating_number']; $i++) {
                    $html .= '
                    <div class="star star__item--active">
                        <i class="fas fa-star"></i>
                    </div>
                    ';
                }
                $html .= '
                </div>
                <div class="cmt_title">
                    <span class="cmt__title-name">' . $cmtInfo['fullName'] . '</span>
                    <span class="cmt__title-date">
                        (' . date_format(date_create($cmtInfo['created_at']), "d") . '
                        Tháng ' . date_format(date_create($cmtInfo['created_at']), "m") . ',
                        ' . date_format(date_create($cmtInfo['created_at']), "Y") . ')
                    </span>
                </div>
                <p class="cmt">
                    ' . $cmtInfo['content'] . '
                </p>
                <ul class="info_cmt-actions">
                    <!-- admin và người cmt có quyền xóa bình luận -->';

                if ($cmtInfo['user_id'] == $_SESSION['user']['id'] || $_SESSION['user']['role']) {
                    $html .= '<li class="info_cmt-action info_cmt-action--delete" onclick="deleteComment(' . $cmtInfo['id'] . ');">Xóa</li>';
                }
                    $html .= '
                    <li class="info_cmt-action info_cmt-action--rep" onclick="repCmt(event);">Trả lời</li>
                </ul>

                <div action="" class="comment__rep">
                    <ul class="comment__rep-list">
                        <!-- duyệt mảng cmt rep -->
                    </ul>
                    
                    <!-- form rep comment -->
                    <form action="" class="comment__rep-form" onsubmit="return false;"></form>
                </div>
            </div>
        </div>
        ';
        echo $html;
        die();
    } else {
        // trang danh sách sp
        $title = "Sản phẩm";
        $item = product_home_select_all();
        // echo "<pre>";
        // var_dump($item);

        $VIEW_PAGE = "list.php";
    }

    require_once '../layout.php';

?>