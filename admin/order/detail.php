        <main class="content">
            <header class="content__header-wrap">
                <div class="content__header">
                    <div class="content__header-item">
                        <h5 class="content__header-title content__header-title-has-separator">Đơn hàng</h5>
                        <span class="content__header-description">Chi tiết hóa đơn</span>
                    </div>
                    <div class="content__header-item">
                        <!-- 0 - đơn mới, 1 - đã xác nhận, 2 - đang giao, 3 - đã giao, 4 - hủy -->
                        <?php if($orderInfo['status'] == 0): ?>
                        <a onclick="return confirm('Bạn có chắc muốn xác nhận đơn hàng này không?') ?
                        window.location.href = '?update_stt&status=1&id=<?=$id;?>' : false;
                        " class="content__header-item-btn">Xác nhận ĐH</a>

                        <?php elseif ($orderInfo['status'] == 1): ?>
                        <a onclick="return confirm('Bạn có chắc muốn cập nhật trạng thái đang giao hàng không?') ?
                        window.location.href = '?update_stt&status=2&id=<?=$id;?>' : false;
                        " class="content__header-item-btn">Đang giao hàng</a>

                        <?php elseif ($orderInfo['status'] == 2): ?>
                        <a onclick="return confirm('Bạn có chắc muốn cập nhật trạng thái đã giao hàng không?') ?
                        window.location.href = '?update_stt&status=3&id=<?=$id;?>' : false;
                        " class="content__header-item-btn">Đã giao hàng</a>
                        <?php endif; ?>

                        <!-- nếu đã giao thì ko hủy -->
                        <?php if($orderInfo['status'] != 3 && $orderInfo['status'] != 4): ?>
                        <a onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này không?') ?
                        window.location.href = '?update_stt&status=4&id=<?=$id;?>' : false;
                        " class="content__header-item-btn">Hủy ĐH</a>
                        <?php endif; ?>

                        <a href="<?=$ADMIN_URL;?>/order" class="content__header-item-btn">DS hóa đơn</a>
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
                                foreach ($listOrderDetail as $key => $item) { 
                                    $totalPrice += $item['quantity'] * $item['price'];
                            ?>
                            <tr>
                                <td><?=($key + 1);?></td>
                                <td class="content__table-cell-flex">
                                    <div class="content__table-img">
                                        <img src="<?=$IMG_URL . '/' . $item['product_image'];?>" class="content__table-avatar" alt="">
                                    </div>

                                    <div class="content__table-info">
                                        <a href="<?=$SITE_URL . '/product/?detail&id=' . $item['product_id'];?>" target="_blank" class="content__table-name"><?=$item['product_name'];?></a>
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
                                    Tổng tiền: <?=number_format($orderInfo['total_price'], 0, '', ',');?> VNĐ
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                <?php
                                    switch($orderInfo['status']) {
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
                                    (<?=date_format(date_create($orderInfo['updated_at']), 'd/m/Y H:i')?>)
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
                                <td><?=$orderInfo['customer_name'];?></td>
                            </tr>
                            <tr>
                                <td>Địa chỉ:</td>
                                <td><?=$orderInfo['address'];?></td>
                            </tr>
                            <tr>
                                <td>Số điện thoại:</td>
                                <td><?=$orderInfo['phone'];?></td>
                            </tr>
                            <tr>
                                <td>Thời gian đặt:</td>
                                <td><?=date_format(date_create($orderInfo['created_at']), 'd/m/Y H:i')?></td>
                            </tr>
                            <tr>
                                <td>Tin nhắn từ khách hàng:</td>
                                <td><?=nl2br($orderInfo['message']);?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>