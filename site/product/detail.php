        <div class="content">
            <div class="content_1">

                <div class="content_on">

                    <div class="content_pro">
                        <button class="content__menu-item-icon-heart" data-id="<?=$itemData['id'];?>">
                            <i class="fas fa-heart"></i>
                        </button>
                        <img src="<?=$IMG_URL . '/' . $itemData['product_image'];?>" alt="" width="80%" height="auto">
                        <!-- <button><a href="#"><span class="material-icons-outlined">
                                    zoom_out_map
                                </span></a></button> -->
                    </div>

                </div>
                <!-- end_on -->

                <div class="content_between">
                    <nav>
                        <a href="<?=$SITE_URL;?>">TRANG CHỦ</a>
                        /
                        <a href="<?=$SITE_URL . '/product/?category&cate_id=' . $itemData['cate_id'];?>"><?=$itemData['cate_name'];?></a>
                    </nav>
                    <H1><?= $itemData['product_name']; ?></H1>
                    <div>
                        -----
                    </div>
                    <span class="product_price"><?= number_format($itemData['price']); ?>đ</span>
                    <p class="info">
                        <?= nl2br($itemData['description']); ?>
                    </p>

                    <p class="status product__quantity">Còn <?=$itemData['quantity'];?> sản phẩm</p>

                    <form class="cart" action="" onsubmit="return false;">

                        <select name="size" id="" data-id="<?= $itemData['id']; ?>">
                            <option value="S" <?=$itemData['size'] == 'S' ? 'selected': '';?> >Size S</option>
                            <option value="M" <?=$itemData['size'] == 'M' ? 'selected': '';?> >Size M</option>
                            <option value="L" <?=$itemData['size'] == 'L' ? 'selected': '';?> >Size L</option>
                        </select>

                        <input class="minus" type="submit" value="-" onclick="quantity.value = Number(quantity.value) - 1;">
                        <input class="text" type="number" value="1" name="quantity" min="1">
                        <input class="plus" onclick="quantity.value = Number(quantity.value) + 1;" type="submit" value="+">

                        <button class="submit" name="submit">THÊM VÀO GIỎ HÀNG</button>
                    </form>

                </div>
                <!-- end_between -->
            </div>
            <!-- end_under -->

            <div class="feedback">
                
                <ul>
                    <li>Đánh giá</li>
                </ul>

                <!-- nếu chưa đăng nhập -->
                <?php if (!isset($_SESSION['user']) || !$_SESSION['user']): ?>
                    <p>Vui lòng 
                    <a href="<?=$SITE_URL;?>/account/?page=product&id=<?=$id;?>" class="feedback__login">đăng nhập</a>    
                    để bình luận</p>
                <?php else: ?>
                <div class="form">
                    <form class="form_pro" action="" data-id="<?=$itemData['id'];?>" onsubmit="return false;">
                        <h3>Bình luận về sản phẩm “<?= $itemData['product_name'] ?>” </h3>
                        <label class="danh_gia" for="">Đánh giá của bạn*</label>
                        <p>
                        <div class="stars">
                            <input type="radio" hidden name="star" id="star-5" value="5">
                            <label for="star-5" title="5 sao" class="star__item">
                                <i class="fas fa-star"></i>
                            </label>
                            <input type="radio" hidden name="star" id="star-4" value="4">
                            <label for="star-4" title="4 sao" class="star__item">
                                <i class="fas fa-star"></i>
                            </label>
                            <input type="radio" hidden name="star" id="star-3" value="3">
                            <label for="star-3" title="3 sao" class="star__item">
                                <i class="fas fa-star"></i>
                            </label>
                            <input type="radio" hidden name="star" id="star-2" value="2">
                            <label for="star-2" title="2 sao" class="star__item">
                                <i class="fas fa-star"></i>
                            </label>
                            <input type="radio" hidden name="star" id="star-1" value="1">
                            <label for="star-1" title="1 sao" class="star__item">
                                <i class="fas fa-star"></i>
                            </label>

                        </div>
                        </p>

                        <label class="nx" for="">Nhận xét của bạn*</label>
                        <textarea name="" id="" cols="30" rows="10" class="form__comment-content"></textarea>

                        <input type="submit" value="Gửi đi" class="form__comment_btn">
                    </form>
                </div>

                <div class="comment__list">
                    <!-- nếu không có bình luận nào -->
                    <?php if (!$listComment): ?>
                        <p>Chưa có đánh giá nào</p>
                    <?php endif; ?>

                    <?php foreach($listComment as $cmt): ?>
                    <div class="comment comment-<?=$cmt['id'];?>">
                        <img src="<?=$IMG_URL . '/' . $cmt['avatar'];?>" alt="" width="70px">
                        <div class="info_cmt info_cmt-<?=$cmt['id'];?>" data-id="<?=$cmt['id'];?>" data-product-id="<?=$cmt['product_id'];?>">
                            <div class="stars">
                                <!-- số sao còn lại -->
                                <?php for($i = 1; $i <= (5 - $cmt['rating_number']); $i++):?>
                                <div class="star">
                                    <i class="fas fa-star"></i>
                                </div>
                                <?php endfor; ?>

                                <!-- số đánh giá -->
                                <?php for($i = 1; $i <= $cmt['rating_number']; $i++):?>
                                <div class="star star__item--active">
                                    <i class="fas fa-star"></i>
                                </div>
                                <?php endfor; ?>
                            </div>
                            <div class="cmt_title">
                                <span class="cmt__title-name"><?=$cmt['fullName'];?></span>
                                <span class="cmt__title-date">
                                    (<?=date_format(date_create($cmt['created_at']), "d");?>
                                    Tháng <?=date_format(date_create($cmt['created_at']), "m");?>,
                                    <?=date_format(date_create($cmt['created_at']), "Y");?>)
                                </span>
                            </div>
                            <p class="cmt">
                                <?=$cmt['content'];?>
                            </p>
                            <ul class="info_cmt-actions">
                                <!-- admin và người cmt có quyền xóa bình luận -->
                                <?php if ($cmt['user_id'] == $_SESSION['user']['id'] || $_SESSION['user']['role']): ?>
                                <li class="info_cmt-action info_cmt-action--delete" onclick="deleteComment(<?=$cmt['id'];?>);">Xóa</li>
                                <?php endif; ?>
                                <li class="info_cmt-action info_cmt-action--rep" onclick="repCmt(event);">Trả lời</li>
                            </ul>

                            <div action="" class="comment__rep">
                                <ul class="comment__rep-list">
                                    <!-- duyệt mảng cmt rep -->
                                    <?php foreach ($listCommentRep as $cmtRep): ?>
                                        <!-- nếu có comment rep -->
                                        <?php if ($cmtRep['comment_parent_id'] == $cmt['id']): ?>
                                        <li class="comment__rep-item comment__rep-item-<?=$cmtRep['id'];?>">
                                            <img src="<?=$IMG_URL . '/' . $cmtRep['avatar'];?>" alt="">
                                            <div class="comment__rep-item-info">
                                                <div class="comment__rep-item-title">
                                                    <span class="comment__rep-item-name"><?=$cmtRep['fullName']?></span>
                                                    <span class="cmt__title-date">
                                                        (<?=date_format(date_create($cmtRep['created_at']), "d");?>
                                                        Tháng <?=date_format(date_create($cmtRep['created_at']), "m");?>,
                                                        <?=date_format(date_create($cmtRep['created_at']), "Y");?>)
                                                    </span>
                                                </div>
                                                <p class="comment__rep-item-content">
                                                    <?=nl2br($cmtRep['content']);?>
                                                </p>
                                                <ul class="info_cmt-actions">
                                                    <!-- admin và người cmt có quyền xóa bình luận -->
                                                    <?php if ($cmtRep['user_id'] == $_SESSION['user']['id'] || $_SESSION['user']['role']): ?>
                                                    <li class="info_cmt-action info_cmt-action--delete" onclick="deleteComment(<?=$cmtRep['id'];?>);">Xóa</li>
                                                    <?php endif; ?>
                                                    <li class="info_cmt-action info_cmt-action--rep" onclick="repCmt(event);">Trả lời</li>
                                                </ul>
                                            </div>
                                        </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                                
                                <!-- form rep comment -->
                                <form action="" class="comment__rep-form" onsubmit="return false;"></form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>

                    <button class="comment__list-button see_all" onclick="seeMore();">Xem tất cả</button>

                </div>
                <?php endif; ?>

                <!-- <p>----------------------------------------------------------------------------------------------------------------------</p> -->

                <!--  -->
                <h3 class="pro_plus_text">Sản phẩm tương tự</h3>
                
                <div class="product_plus">
                    <?php foreach($item_tt as $item):?>
                    <div class="pro">
                        <div class="cha">
                            <div class="img">
                                <img src="<?=$IMG_URL . '/' . $item['product_image'];?>" alt="" width="245px" height="275px">
                            </div>
                            <div class="content_con">
                                <button class="bt"> <a  href="<?=$SITE_URL;?>/product/?detail&id=<?=$item['id'];?>">Xem chi tiết</a></button>
                            </div>
                        
                        </div>
                        
                        <div class="content_pro">
                            <a href="<?=$SITE_URL . '/product/?detail&id=' . $item['id'];?>"><?php echo $item['product_name'];?></a>
                            <div>
                                <span><?php echo number_format($item['price']);?>đ</span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach;?>
                </div>
            </div>
            <!-- OK -->
        </div>
        <!-- END CONTENT -->