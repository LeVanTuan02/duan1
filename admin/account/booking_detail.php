        <main class="content">
            <header class="content__header-wrap">
                <div class="content__header">
                    <div class="content__header-item">
                        <h5 class="content__header-title content__header-title-has-separator">Đơn hàng</h5>
                        <span class="content__header-description">Chi tiết hóa đơn</span>
                    </div>
                    <div class="content__header-item">
                        <!-- 0 - chờ xử lý, 1 - đã xác nhận, 2 - đã hủy -->

                        <!-- nếu đang ở trạng thái hủy thì k hiện -->
                        <?php if($bookingInfo['status'] != 2 && $bookingInfo['status'] != 3): ?>
                        <a onclick="return confirm('Bạn có chắc muốn hủy đặt bàn này không?') ?
                        window.location.href = '?booking_cancel&status=2&id=<?=$id;?>' : false;
                        " class="content__header-item-btn">Hủy đặt bàn</a>
                        <?php endif; ?>

                        <a href="<?=$ADMIN_URL;?>/account/?booking" class="content__header-item-btn">DS đặt bàn</a>
                    </div>
                </div>
            </header>

            <div class="content__table-section">
                <div class="content__table-wrap">
                    <div class="content__table-heading-wrap">
                        <div class="content__table-heading">
                            <h3 class="content__table-title">Booking Management</h3>
                            <span class="content__table-text">Booking management made easy</span>
                        </div>
                    </div>

                    <table class="content__table-table content__table-ship">
                        <tbody class="content__table-body">
                            <tr>
                                <td>Bàn đã đặt:</td>
                                <td><?=$bookingInfo['table_name'];?> (<?=$bookingInfo['guest_number'];?> người)</td>
                            </tr>
                            <tr>
                                <td>Họ và tên:</td>
                                <td><?=$bookingInfo['name'];?></td>
                            </tr>
                            <tr>
                                <td>Số điện thoại:</td>
                                <td><?=$bookingInfo['phone'];?></td>
                            </tr>
                            <tr>
                                <td>Email:</td>
                                <td><?=$bookingInfo['email'];?></td>
                            </tr>
                            <tr>
                                <td>Thời gian đặt:</td>
                                <td><?=date('d/m/Y', strtotime($bookingInfo['date_book'])) . ' ' . date('H:i', strtotime($bookingInfo['time_book']))?></td>
                            </tr>
                            <tr>
                                <td>Trạng thái</td>
                                <td>
                                    <?php
                                        if ($bookingInfo['status'] == 0) {
                                            echo 'Chờ xử lý';
                                        } else if ($bookingInfo['status'] == 1) {
                                            echo 'Đã xác nhận';
                                        }  else if ($bookingInfo['status'] == 3) {
                                            echo 'Hoàn thành';
                                        } else {
                                            echo 'Bị hủy';
                                        }
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>