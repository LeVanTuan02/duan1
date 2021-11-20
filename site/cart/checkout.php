        <!-- CONTENT -->
        <div class="content">
            <section class="content__checkout-wrap grid">
                <form class="content__checkout" method="POST">
                    <div class="content__customer-info">
                        <h3 class="content__customer-info-title">Thông tin thanh toán</h3>

                        <div class="content__customer-info-form-row">
                            <div class="content__customer-info-form-group">
                                <label for="" class="content__customer-info-form-label">Họ và tên *</label>
                                <input type="text" name="customer_name" class="content__customer-info-form-control input"placeholder="Nhập đầy đủ họ và tên của bạn"
                                value="<?=$customer_name ?? $_SESSION['user']['fullName'] ?? '';?>">
                                <span class="content__customer-info-form-message">
                                    <?=$errorMessage['customer_name'] ?? '';?>
                                </span>
                            </div>

                            <div class="content__customer-info-form-group">
                                <label for="" class="content__customer-info-form-label">Điện thoại *</label>
                                <input type="text" name="customer_phone" class="content__customer-info-form-control input" placeholder="Số điện thoại người nhận hàng"
                                value="<?=$customer_phone ?? $_SESSION['user']['phone'] ?? '';?>">
                                <span class="content__customer-info-form-message">
                                    <?=$errorMessage['customer_phone'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <div class="content__customer-info-form-group">
                            <label for="" class="content__customer-info-form-label">Email *</label>
                            <input type="text" name="customer_email" class="content__customer-info-form-control input"
                            placeholder="Nhập địa chỉ email" value="<?=$customer_email ?? $_SESSION['user']['email'] ?? '';?>">
                            <span class="content__customer-info-form-message">
                                <?=$errorMessage['customer_email'] ?? '';?>
                            </span>
                        </div>

                        <div class="content__customer-info-form-group">
                            <label for="" class="content__customer-info-form-label">Địa chỉ *</label>
                            <input type="text" name="customer_address" class="content__customer-info-form-control input"
                            placeholder="Ví dụ: Số xx Ngõ xx Phú Kiều, Bắc Từ Liêm, Hà Nội" value="<?=$customer_address ?? $_SESSION['user']['address'] ?? '';?>">
                            <span class="content__customer-info-form-message">
                                <?=$errorMessage['customer_address'] ?? '';?>
                            </span>
                        </div>

                        <h3 class="content__customer-info-title">Thông tin bổ sung</h3>

                        <div class="content__customer-info-form-group">
                            <label for="" class="content__customer-info-form-label">Ghi chú đơn hàng (Tùy chọn)</label>
                            <textarea rows="5" name="customer_message" class="content__customer-info-form-control input"
                            placeholder="Ghi chú về đơn hàng, ví dụ thời gian hay chỉ dẫn địa điểm giao hàng chi tiết hơn."><?=$customer_message ?? '';?></textarea>
                        </div>
                    </div>

                    <div class="content__cart-review">
                        <div class="content__cart-review-inner">
                            <h3 class="content__customer-info-title">Đơn hàng của bạn</h3>
                            <table class="content__cart-review-table">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Tạm tính</th>
                                    </tr>
                                </thead>
    
                                <tbody>
                                    <?php
                                        $totalPrice = 0;
                                        foreach ($_SESSION['cart'] as $item):
                                            $totalPrice += $item['price'] * $item['quantity'];
                                    ?>
                                    <tr>
                                        <td>
                                            <?=$item['product_name'];?>
                                            <strong class="content__cart-review-table-qnt">x <?=$item['quantity'];?></strong>
                                        </td>
                                        <td>
                                            <span class="content__cart-detail-table-price">
                                                <?=number_format($item['price'], 0, '', ',');?>đ
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
    
                                <tfoot>
                                    <tr>
                                        <td>Tổng</td>
                                        <td>
                                            <span class="content__cart-detail-table-price">
                                                <?=number_format($totalPrice, 0, '', ',');?>đ
                                            </span>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
    
                            <button class="content__cart-review-btn" name="btn_checkout">Đặt hàng</button>
                        </div>
                    </div>
                </form>
            </section>
        </div>
        <!-- END CONTENT -->