        <main class="content">
            <header class="content__header-wrap">
                <div class="content__header">
                    <div class="content__header-item">
                        <h5 class="content__header-title content__header-title-has-separator">Sản phẩm</h5>
                        <span class="content__header-description">Danh sách sản phẩm</span>
                    </div>
                    <div class="content__header-item">
                        <button class="content__header-item-btn content__header-item-btn-select-all">Chọn tất cả</button>
                        <button class="content__header-item-btn content__header-item-btn-unselect-all">Bỏ chọn tất cả</button>
                        <button class="content__header-item-btn content__header-item-btn-del-all">Xóa các mục chọn</button>
                        <a href="<?=$ADMIN_URL.'/product/?btn_add';?>" class="content__header-item-btn">Thêm SP</a>
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
                            <input type="text" class="content__table-heading-form-control" name="keyword" placeholder="Nhập tên sản phẩm">
                            <select name="ma_loai" class="content__table-heading-form-select">
                                <option value="">-- Loại hàng --</option>
                                <?php foreach ($categoryList as $item): ?>
                                    <option value="<?=$item['ma_loai'];?>"><?=$item['ten_loai'];?></option>
                                <?php endforeach; ?>
                            </select>
                            <button class="content__table-heading-form-btn">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>

                    <?php
                        if (empty($listProduct)) {
                            echo '<div class="alert alert-success">Chưa có sản phẩm nào</div>';
                            die();
                        }
                    ?>

                    <table class="content__table-table">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" name="select_all" class="select_all">
                                </th>
                                <th>Mã hàng</th>
                                <th>Hàng hóa</th>
                                <th>Lượt xem</th>
                                <th>Ngày tạo</th>
                                <td>Số lượng</td>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>

                        <tbody class="content__table-body">
                            <?php foreach ($listProduct as $item): ?>
                            <tr>
                                <td>
                                    <input type="checkbox" data-id="<?=$item['id'];?>">
                                </td>
                                <td><?=$item['id'];?></td>
                                <td class="content__table-cell-flex">
                                    <div class="content__table-img">
                                        <img src="<?=$IMG_URL . '/' . $item['product_image'];?>" class="content__table-avatar" alt="">
                                    </div>

                                    <div class="content__table-info">
                                        <span class="content__table-name"><?=$item['product_name'];?></span>
                                    </div>
                                </td>
                                <td>
                                    <?=$item['view'];?>
                                </td>
                                <td>
                                    <span class="content__table-text-success">
                                        <?=date_format(date_create($item['created_at']), 'd/m/Y');?>
                                    </span>
                                </td>
                                <td><?=$item['totalProduct'] ?? 0;?></td>
                                <td>
                                    <?php if ($item['status']): ?>
                                    <span class="content__table-stt-active">Còn hàng</span>
                                    <?php else: ?>
                                    <span class="content__table-stt-locked">Hết hàng</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="user_list-action">
                                        <a onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này không?') ?
                                        window.location.href = '?btn_delete&id=<?=$item['id'];?>' : false;
                                        " class="content__table-action danger">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <a href="<?=$ADMIN_URL;?>/product/?btn_edit&id=<?=$item['id'];?>" class="content__table-action info">
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