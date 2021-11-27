        <main class="content">
            <header class="content__header-wrap">
                <div class="content__header">
                    <div class="content__header-item">
                        <h5 class="content__header-title content__header-title-has-separator">Sản phẩm</h5>
                        <span class="content__header-description">Danh sách thuộc tính</span>
                    </div>
                    <div class="content__header-item">
                        <!-- <button class="content__header-item-btn content__header-item-btn-select-all">Chọn tất cả</button>
                        <button class="content__header-item-btn content__header-item-btn-unselect-all">Bỏ chọn tất cả</button>
                        <button class="content__header-item-btn content__header-item-btn-del-all">Xóa các mục chọn</button> -->
                    </div>
                </div>
            </header>

            <div class="content__table-section">
                <div class="content__table-wrap">
                    <div class="content__table-heading-wrap">
                        <div class="content__table-heading">
                            <h3 class="content__table-title">Product Management</h3>
                            <span class="content__table-text">Product management made easy</span>
                        </div>

                        <form action="" class="content__table-heading-form" method="POST">
                            <input type="text" class="content__table-heading-form-control form__control-attribute" name="keyword" placeholder="Nhập tên sản phẩm">
                            <button class="content__table-heading-form-btn" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>

                    <?php
                        if (empty($listAttribute)) {
                            echo '<div class="alert alert-success">Chưa có thuộc tính nào</div>';
                            die();
                        }
                    ?>

                    <table class="content__table-table">
                        <thead>
                            <tr>
                                <!-- <th>
                                    <input type="checkbox" name="select_all" class="select_all">
                                </th> -->
                                <th>Mã SP</th>
                                <th>Sản phẩm</th>
                                <td>Số thuộc tính</td>
                                <th>Hành động</th>
                            </tr>
                        </thead>

                        <tbody class="content__table-body">
                            <?php foreach ($listAttribute as $item): ?>
                            <tr>
                                <!-- <td>
                                    <input type="checkbox" data-id="<?=$item['id'];?>">
                                </td> -->
                                <td>
                                    <?=$item['id'];?>
                                </td>
                                <td class="content__table-cell-flex">
                                    <div class="content__table-img">
                                        <img src="<?=$IMG_URL . '/' . $item['product_image'];?>" class="content__table-avatar" alt="">
                                    </div>

                                    <div class="content__table-info">
                                        <span class="content__table-name"><?=$item['product_name'];?></span>
                                    </div>
                                </td>
                                <td>
                                    <?=$item['totalAttribute'];?>
                                </td>
                                <td>
                                    <div class="user_list-action">
                                        <a onclick="return confirm('Bạn có chắc muốn xóa toàn bộ thuộc tính của sản phẩm này không?') ?
                                        window.location.href = '?btn_delete_all&p_id=<?=$item['id'];?>' : false;
                                        " class="content__table-action danger">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <a href="<?=$ADMIN_URL;?>/attribute/?detail&p_id=<?=$item['id'];?>" class="content__table-action info">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <ul class="content__table-pagination">
                        <li class="content__table-pagination-item">
                            <a href="<?=$ADMIN_URL;?>/attribute" class="content__table-pagination-link content__table-pagination-link-first">
                                <i class="fas fa-angle-double-left"></i>
                            </a>
                        </li>
                        <?php
                            if ($currentPage > 1) {
                                echo '
                                <li class="content__table-pagination-item">
                                    <a href="' . $ADMIN_URL . '/attribute/?page='. ($currentPage - 1) .'" class="content__table-pagination-link content__table-pagination-link-pre">
                                        <i class="fas fa-angle-left"></i>
                                    </a>
                                </li>';
                            }
                        ?>
                        <?php
                            for ($i = 1; $i <= $totalPage; $i++) {
                                if ($currentPage == $i) {
                                    echo '
                                    <li class="content__table-pagination-item">
                                        <a href="'.$ADMIN_URL . '/attribute/?page='. $i .'" class="content__table-pagination-link content__table-pagination-link--active">' . $i . '</a>
                                    </li>
                                    ';
                                } else {
                                    echo '
                                    <li class="content__table-pagination-item">
                                        <a href="'.$ADMIN_URL . '/attribute/?page='. $i .'" class="content__table-pagination-link">' . $i . '</a>
                                    </li>
                                    ';
                                }
                            }
                        ?>

                        <?php
                            if ($currentPage < $totalPage) {
                                echo '
                                <li class="content__table-pagination-item">
                                    <a href="' . $ADMIN_URL . '/attribute/?page='. ($currentPage + 1) .'" class="content__table-pagination-link content__table-pagination-link-next">
                                        <i class="fas fa-angle-right"></i>
                                    </a>
                                </li>';
                            }
                        ?>
                        
                        
                        <li class="content__table-pagination-item">
                            <a href="<?=$ADMIN_URL;?>/attribute/?page=<?=$totalPage;?>" class="content__table-pagination-link content__table-pagination-link-last">
                                <i class="fas fa-angle-double-right"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </main>