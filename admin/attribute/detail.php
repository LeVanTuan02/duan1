        <main class="content">
            <header class="content__header-wrap">
                <div class="content__header">
                    <div class="content__header-item">
                        <h5 class="content__header-title content__header-title-has-separator">Sản phẩm</h5>
                        <span class="content__header-description">Danh sách thuộc tính của <?=$productInfo['product_name'];?></span>
                    </div>
                    <div class="content__header-item">
                        <a href="<?=$ADMIN_URL;?>/product/?btn_edit&id=<?=$p_id;?>" class="content__header-item-btn">Xem SP</a>
                        <a href="<?=$ADMIN_URL;?>/attribute/?btn_add&p_id=<?=$p_id;?>" class="content__header-item-btn">Thêm thuộc tính</a>
                        <a href="<?=$ADMIN_URL;?>/attribute" class="content__header-item-btn">DS thuộc tính</a>
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
                    </div>

                    <?php
                        if (empty($attributeById)) {
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
                                <th>Mã thuộc tính</th>
                                <th>Tên thuộc tính</th>
                                <th>Số lượng</th>
                                <td>Đơn giá</td>
                                <th>Hành động</th>
                            </tr>
                        </thead>

                        <tbody class="content__table-body">
                            <?php foreach ($attributeById as $item): ?>
                            <tr>
                                <!-- <td>
                                    <input type="checkbox" data-id="<?=$item['id'];?>">
                                </td> -->
                                <td>
                                    <?=$item['id'];?>
                                </td>
                                <td>
                                    <span class="content__table-text-black"><?=$item['size'];?></span>
                                </td>
                                <td>
                                    <?=$item['quantity'];?>
                                </td>
                                <td>
                                    <?=number_format($item['price'], 0, '', ',');?> VNĐ
                                </td>
                                <td>
                                    <div class="user_list-action">
                                        <a onclick="return confirm('Bạn có chắc muốn xóa thuộc tính này không?') ?
                                        window.location.href = '?btn_delete&p_id=<?=$p_id;?>&id=<?=$item['id'];?>' : false;
                                        " class="content__table-action danger">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <a href="<?=$ADMIN_URL;?>/attribute/?btn_edit&p_id=<?=$p_id;?>&id=<?=$item['id'];?>" class="content__table-action info">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- <ul class="content__table-pagination">
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
                    </ul> -->
                </div>
            </div>
        </main>