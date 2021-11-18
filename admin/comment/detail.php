        <main class="content">
            <header class="content__header-wrap">
                <div class="content__header">
                    <div class="content__header-item">
                        <h5 class="content__header-title content__header-title-has-separator">Bình luận</h5>
                        <span class="content__header-description">Bình luận về sản phẩm <strong><?=$listCmt[0]['product_name'];?></strong></span>
                    </div>
                    <div class="content__header-item">
                        <button class="content__header-item-btn content__header-item-btn-select-all">Chọn tất cả</button>
                        <button class="content__header-item-btn content__header-item-btn-unselect-all">Bỏ chọn tất cả</button>
                        <button class="content__header-item-btn content__header-item-btn-del-all">Xóa các mục chọn</button>
                        <a href="<?=$ADMIN_URL;?>/comment" class="content__header-item-btn">DS BL</a>
                    </div>
                </div>
            </header>

            <div class="content__table-section">
                <div class="content__table-wrap">
                    <div class="content__table-heading-wrap">
                        <div class="content__table-heading">
                            <h3 class="content__table-title">Comment Management</h3>
                            <span class="content__table-text">Comment management made easy</span>
                        </div>

                        <form action="" class="content__table-heading-form" method="POST">
                            <input type="text" class="content__table-heading-form-control" name="detail_keyword" placeholder="Nhập nội dung bình luận">
                            <select name="ma_kh" class="content__table-heading-form-select">
                                <option value="">-- KH bình luận --</option>
                                <option value="">A D M I N</option>
                            </select>
                            <select name="rating" class="content__table-heading-form-select">
                                <option value="">-- Đánh giá --</option>
                                <option value="1">1 sao</option>
                                <option value="2">2 sao</option>
                                <option value="3">3 sao</option>
                                <option value="4">4 sao</option>
                                <option value="5">5 sao</option>
                            </select>
                            <button class="content__table-heading-form-btn">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>

                    <?php
                        if (empty($listCmt)) {
                            echo '<div class="alert alert-success">Chưa có bình luận nào</div>';
                            die();
                        }
                    ?>

                    <table class="content__table-table">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" name="select_all" class="select_all">
                                </th>
                                <th>Nội dung</th>
                                <th>Ngày bình luận</th>
                                <th>Người bình luận</th>
                                <th>Mã KH bình luận</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>

                        <tbody class="content__table-body">
                            <?php foreach ($listCmt as $item): ?>
                            <tr>
                                <td>
                                    <input type="checkbox" data-id="<?=$item['id'];?>">
                                </td>
                                <td>
                                    <textarea cols="30" readonly rows="4" class="content__table-comment"><?=$item['content'];?></textarea>
                                </td>
                                <td>
                                    <span class="content__table-text-success">
                                        <?=date_format(date_create($item['created_at']), 'd/m/Y H:i');?>
                                    </span>
                                </td>
                                <td>
                                    <span class="content__table-text-black"><?=$item['fullName'];?></span>
                                </td>
                                <td>
                                    <?=$item['username'];?>
                                </td>
                                <td>
                                    <div class="user_list-action">
                                        <a onclick="return confirm('Bạn có chắc muốn xóa bình luận này không?') ?
                                        window.location.href = '?btn_delete&p_id=<?=$p_id;?>&id=<?=$item['id'];?>' : false;
                                        " class="content__table-action danger">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <ul class="content__table-pagination">
                        <li class="content__table-pagination-item">
                            <a href="" class="content__table-pagination-link content__table-pagination-link-first">
                                <i class="fas fa-angle-double-left"></i>
                            </a>
                        </li>
                        <li class="content__table-pagination-item">
                            <a href="" class="content__table-pagination-link content__table-pagination-link-pre">
                                <i class="fas fa-angle-left"></i>
                            </a>
                        </li>
                        <li class="content__table-pagination-item">
                            <a href="" class="content__table-pagination-link content__table-pagination-link--active">1</a>
                        </li>
                        <li class="content__table-pagination-item">
                            <a href="" class="content__table-pagination-link">2</a>
                        </li>
                        <li class="content__table-pagination-item">
                            <a href="" class="content__table-pagination-link content__table-pagination-link-next">
                                <i class="fas fa-angle-right"></i>
                            </a>
                        </li>
                        
                        <li class="content__table-pagination-item">
                            <a href="" class="content__table-pagination-link content__table-pagination-link-last">
                                <i class="fas fa-angle-double-right"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </main>