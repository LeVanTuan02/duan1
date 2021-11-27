        <main class="content">
            <header class="content__header-wrap">
                <div class="content__header">
                    <div class="content__header-item">
                        <h5 class="content__header-title content__header-title-has-separator">Đơn hàng</h5>
                        <span class="content__header-description">Chi tiết hóa đơn</span>
                    </div>
                    <div class="content__header-item">

                        <?php if ($myCartInfo['status'] != 3 && $myCartInfo['status'] != 4): ?>
                        <a onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này không?') ?
                        window.location.href = '?cart_cancel&id=<?=$id;?>' : false;
                        " class="content__header-item-btn">Hủy ĐH</a>
                        <?php endif; ?>

                        <a href="<?=$ADMIN_URL;?>/account/?cart" class="content__header-item-btn">DS hóa đơn</a>
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
                    </div>

                    <table class="content__table-table">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Sản phẩm</th>
                                <th>Size</th>
                                <th>Đơn giá</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>

                        <tbody class="content__table-body">
                            <?php
                                $totalPrice = 0;
                                $index = 0;
                                foreach ($myCartDetail as $item) {
                                    $index++;
                                    $totalPrice += $item['quantity'] * $item['price'];
                            ?>
                            <tr>
                                <td><?=$index;?></td>
                                <td class="content__table-cell-flex">
                                    <div class="content__table-img">
                                        <img src="<?=$IMG_URL . '/' . $item['product_image'];?>" class="content__table-avatar" alt="">
                                    </div>

                                    <div class="content__table-info">
                                        <a href="" target="_blank" class="content__table-name"><?=$item['product_name'];?></a>
                                    </div>
                                </td>
                                <td>
                                    <?=$item['product_size'];?>
                                </td>
                                <td>
                                    <?=number_format($item['price'], 0, '', ',');?> VNĐ
                                </td>
                                <td><?=$item['quantity'];?></td>
                                <td><?=number_format($item['price'] * $item['quantity'], 0, '', ',');?> VNĐ</td>
                            </tr>
                            <?php } ?>
                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="6">
                                    Tổng tiền: <?=number_format($totalPrice, 0, '', ',');?> VNĐ
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                <?php
                                    switch($myCartInfo['status']) {
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
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6" class="content__table-stt-date">
                                    (<?=date_format(date_create($myCartInfo['updated_at']), 'd/m/Y H:i')?>)
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="content__table-wrap">
                    <div class="content__table-heading-wrap">
                        <div class="content__table-heading">
                            <h3 class="content__table-title">Thông tin vận chuyển</h3>
                        </div>
                    </div>

                    <table class="content__table-table content__table-ship">
                        <tbody class="content__table-body">
                            <tr>
                                <td>Họ và tên:</td>
                                <td><?=$myCartInfo['customer_name'];?></td>
                            </tr>
                            <tr>
                                <td>Địa chỉ:</td>
                                <td><?=$myCartInfo['address'];?></td>
                            </tr>
                            <tr>
                                <td>Số điện thoại:</td>
                                <td><?=$myCartInfo['phone'];?></td>
                            </tr>
                            <tr>
                                <td>Thời gian đặt:</td>
                                <td><?=date_format(date_create($myCartInfo['created_at']), 'd/m/Y H:i')?></td>
                            </tr>
                            <tr>
                                <td>Tin nhắn từ khách hàng:</td>
                                <td><?=nl2br($myCartInfo['message']);?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>