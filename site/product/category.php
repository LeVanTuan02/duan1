<div class="content">

            <div class="on">
                <nav class="left">
                    <a class="tt" href="<?=$SITE_URL;?>">TRANG CHỦ</a>
                    <span class="">/</span>
                    <span class="td"><?=$itemData[0]['cate_name'];?></span>
                </nav>

                <div class="right">
                    <!-- <span>Hiển thị 1–12 của 17 kết quả</span> -->

                    <select name="filter" class="product_filter" data-id="<?=$cate_id;?>">
                        <option value="date_desc">Ngày thêm: Mới nhất</option>
                        <option value="date_asc">Ngày thêm: Cũ nhất</option>
                        <option value="price_asc">Thứ tự theo giá: Thấp đến cao</option>
                        <option value="price_desc">Thứ tự theo giá: Cao đến thấp</option>
                        <option value="view_asc">Thứ tự theo lượt xem: Thấp đến cao</option>
                        <option value="view_desc">Thứ tự theo lượt xem: Cao đến thấp</option>
                    </select>
                </div>
            </div>
       
            <div class="product_1">
            <?php foreach($itemData as $item):?>
                <div class="pro">
                  <div class="cha">
                      <div class="img">
                        <img src="<?=$IMG_URL . '/' . $item['product_image'];?>" alt="" width="245px" height="245px">
                      </div>
                   <div class="content_con">
                    <button class="bt" name="btn_pro"> <a href="<?=$SITE_URL;?>/product/?detail&id=<?=$item['id'];?>">Xem chi tiết</a></button>
                   </div>
                   
                </div>
                    
                    <div class="content_pro">
                        <a href="<?=$SITE_URL . '/product/?detail&id=' . $item['id'];?>"><?=$item['product_name'];?></a>
                        <div>
                            <span><?=number_format($item['price']);?>đ</span>
                        </div>
                       
                    </div>
                </div>
            <?php endforeach;?>
            </div>
       
       

            <!-- Done -->

            <!-- phân trang -->
            <ul class="content__table-pagination">
                <li class="content__table-pagination-item">
                    <a href="<?=$SITE_URL;?>/product/?category&cate_id=<?=$cate_id;?>" class="content__table-pagination-link content__table-pagination-link-first">
                        <i class="fas fa-angle-double-left"></i>
                    </a>
                </li>
                <?php
                    if ($currentPage > 1) {
                        echo '
                        <li class="content__table-pagination-item">
                            <a href="' . $SITE_URL . '/product/?category&cate_id='.$cate_id.'&page='. ($currentPage - 1) .'" class="content__table-pagination-link content__table-pagination-link-pre">
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
                                <a href="'.$SITE_URL . '/product/?category&cate_id='.$cate_id.'&page='. $i .'" class="content__table-pagination-link content__table-pagination-link--active">' . $i . '</a>
                            </li>
                            ';
                        } else {
                            echo '
                            <li class="content__table-pagination-item">
                                <a href="'.$SITE_URL . '/product/?category&cate_id='.$cate_id.'&page='. $i .'" class="content__table-pagination-link">' . $i . '</a>
                            </li>
                            ';
                        }
                    }
                ?>

                <?php
                    if ($currentPage < $totalPage) {
                        echo '
                        <li class="content__table-pagination-item">
                            <a href="' . $SITE_URL . '/product/?category&cate_id='.$cate_id.'&page='. ($currentPage + 1) .'" class="content__table-pagination-link content__table-pagination-link-next">
                                <i class="fas fa-angle-right"></i>
                            </a>
                        </li>';
                    }
                ?>
                
                
                <li class="content__table-pagination-item">
                    <a href="<?=$SITE_URL;?>/product/?category&cate_id=<?=$cate_id;?>/?page=<?=$totalPage;?>" class="content__table-pagination-link content__table-pagination-link-last">
                        <i class="fas fa-angle-double-right"></i>
                    </a>
                </li>
            </ul>
        </div>
        <!-- END CONTENT -->