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
                            <input type="text" class="content__table-heading-form-control" name="keyword" placeholder="Nhập tên hàng hóa">
                            <button class="content__table-heading-form-btn">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>

                    <?php
                        // if (empty($listComment)) {
                        //     echo '<div class="alert alert-success">Chưa có bình luận nào</div>';
                        //     die();
                        // }
                    ?>

                    <table class="content__table-table">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" data-id="<?=$item['id'];?>">
                                </th>
                                <th>Mã đơn hàng</th>
                                <th>Ngày đặt</th>
                                <th>Số lượng sản phẩm</th>
                                <th>Tổng giá trị đơn hàng</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>
                                    <input type="checkbox" data-id="">
                                </td>
                                <td>
                                    DH1
                                </td>
                                <td>
                                    <span class="content__table-text-success">
                                        17/11/2021 19:00
                                    </span>
                                </td>
                                <td>
                                    100
                                </td>
                                <td>
                                    100,000 VNĐ
                                </td>
                                <td>
                                    <span class="content__table-stt-active">Đơn hàng mới</span>
                                    <!-- <span class="content__table-stt-locked">Hết hàng</span> -->
                                </td>
                                <td>
                                    <a href="" class="content__table-stt-active">Chi tiết</a>
                                </td>
                            </tr>
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