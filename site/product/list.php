<div class="content">

            <div class="on">
                <nav class="left">
                    <a class="tt" href="<?=$SITE_URL;?>">TRANG CHỦ</a>
                    <span class="">/</span>
                    <span class="td" href="#">THỰC ĐƠN</span>
                </nav>

                <div class="right">
                    <!-- <span>Hiển thị 1–12 của 17 kết quả</span> -->

                    <select name="serch" id="">
                        <option value="1">Mới nhất</option>
                        <option value="2">Thứ tự mức độ phổ biến</option>
                        <option value="3">Thứ tự theo điểm đánh giá</option>
                        <option value="4">Thứ tự theo giá: Thấp đến cao</option>
                        <option value="5">Thứ tự theo giá: Cao đến thấp</option>
                    </select>
                </div>

            </div>
       
            <div class="product_1">
            <?php foreach($item as $item):?>
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
        </div>
        <!-- END CONTENT -->