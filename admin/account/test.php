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

                        <form action="" class="content__table-heading-form" method="POST">
                            <input type="text" class="content__table-heading-form-control form__control-my-order" name="keyword" placeholder="Nhập tên KH hoặc mã ĐH">
                            <select name="status" class="content__table-heading-form-select form__select-my-order">
                                <option value="">-- Trạng thái --</option>
                                <option value="0">Đơn hàng mới</option>
                                <option value="1">Đã xác nhận</option>
                                <option value="2">Đang giao hàng</option>
                                <option value="3">Đã giao hàng</option>
                                <option value="4">Đã hủy</option>
                            </select>
                            <button type="button" class="content__table-heading-form-btn">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>

                

                    <table class="content__table-table">
                        <thead>
                            <tr>
                                <!-- <th>
                                    <input type="checkbox" data-id="<?=$item['id'];?>">
                                </th> -->
                                <th>Ngày</th>
                                <th>Số đơn hàng</th>
                                <th>Tổng số tiền trong ngày</th>
                               
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach($thong_ke as $thong_ke):?>
                            <tr>
                                <td><?=$thong_ke['ngay'];?></td>
                                <td><?=$thong_ke['tong'];?></td>
                                <td><?=$thong_ke['tien'].' '.'VND';?></td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>

                  
                </div>
            </div>
        </main>