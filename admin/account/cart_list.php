        <main class="content">
            <header class="content__header-wrap">
                <div class="content__header">
                    <div class="content__header-item">
                        <h5 class="content__header-title content__header-title-has-separator">Đơn hàng</h5>
                        <span class="content__header-description">Danh sách đơn hàng</span>
                    </div>
                </div>
            </header>

            <div class="content__table-section">
                <div class="content__table-wrap">
                    <div class="content__table-heading-wrap">
                        <div class="content__table-heading">
                            <h3 class="content__table-title">Order Management</h3>
                            <span class="content__table-text">Order management made easy</span>
                        </div>

                        <!-- <form action="" class="content__table-heading-form" method="POST">
                            <input type="text" class="content__table-heading-form-control" name="keyword" placeholder="Nhập tên hàng hóa">
                            <button class="content__table-heading-form-btn">
                                <i class="fas fa-search"></i>
                            </button>
                        </form> -->
                    </div>

                    <?php
                        if (empty($myCarts)) {
                            echo '<div class="alert alert-success">Chưa có đơn hàng nào</div>';
                            die();
                        }
                    ?>

                    <table class="content__table-table">
                        <thead>
                            <tr>
                                <!-- <th>
                                    <input type="checkbox" data-id="<?=$item['id'];?>">
                                </th> -->
                                <th>Mã đơn hàng</th>
                                <th>Tên người nhận</th>
                                <th>Ngày đặt</th>
                                <th>Tổng giá trị đơn hàng</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($myCarts as $item): ?>
                            <tr>
                                <!-- <td>
                                    <input type="checkbox" data-id="">
                                </td> -->
                                <td>
                                    DH<?=$item['id'];?>
                                </td>
                                <td>
                                    <span class="content__table-text-black">
                                        <?=$item['customer_name'];?>
                                    </span>
                                </td>
                                <td>
                                    <span class="content__table-text-success">
                                        <?=date_format(date_create($item['created_at']), 'd/m/Y H:i');?>
                                    </span>
                                </td>
                                <td>
                                    <?=number_format($item['total_price'], 0, '', ',');?> VNĐ
                                </td>
                                <td>
                                    <?php
                                        switch($item['status']) {
                                            case 0:
                                                echo '<span class="content__table-stt-active">Đơn hàng mới</span>';
                                                break;
                                            case 1:
                                                echo '<span class="content__table-stt-active">Đã xác nhận</span>';
                                                break;
                                            case 2:
                                                echo '<span class="content__table-stt-active">Đang giao hàng</span>';
                                                break;
                                            case 3:
                                                echo '<span class="content__table-stt-active">Đã giao hàng</span>';
                                                break;
                                            case 4:
                                                echo '<span class="content__table-stt-locked">Đã hủy</span>';
                                        }
                                    ?>
                                    <!-- <span class="content__table-stt-locked">Hết hàng</span> -->
                                </td>
                                <td>
                                    <a href="<?=$ADMIN_URL;?>/account/?cart_detail&id=<?=$item['id'];?>" class="content__table-stt-active">Chi tiết</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <ul class="content__table-pagination">
                        <li class="content__table-pagination-item">
                            <a href="<?=$ADMIN_URL;?>/account/?cart" class="content__table-pagination-link content__table-pagination-link-first">
                                <i class="fas fa-angle-double-left"></i>
                            </a>
                        </li>
                        <?php
                            if ($currentPage > 1) {
                                echo '
                                <li class="content__table-pagination-item">
                                    <a href="' . $ADMIN_URL . '/account/?cart&page='. ($currentPage - 1) .'" class="content__table-pagination-link content__table-pagination-link-pre">
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
                                        <a href="'.$ADMIN_URL . '/account/?cart&page='. $i .'" class="content__table-pagination-link content__table-pagination-link--active">' . $i . '</a>
                                    </li>
                                    ';
                                } else {
                                    echo '
                                    <li class="content__table-pagination-item">
                                        <a href="'.$ADMIN_URL . '/account/?cart&page='. $i .'" class="content__table-pagination-link">' . $i . '</a>
                                    </li>
                                    ';
                                }
                            }
                        ?>

                        <?php
                            if ($currentPage < $totalPage) {
                                echo '
                                <li class="content__table-pagination-item">
                                    <a href="' . $ADMIN_URL . '/account/?cart&page='. ($currentPage + 1) .'" class="content__table-pagination-link content__table-pagination-link-next">
                                        <i class="fas fa-angle-right"></i>
                                    </a>
                                </li>';
                            }
                        ?>
                        
                        
                        <li class="content__table-pagination-item">
                            <a href="<?=$ADMIN_URL;?>/account/?cart&page=<?=$totalPage;?>" class="content__table-pagination-link content__table-pagination-link-last">
                                <i class="fas fa-angle-double-right"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </main>