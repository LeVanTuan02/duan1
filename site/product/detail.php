<div class="content">
            <div class="content_1">

            <div class="content_on">

                <div class="content_pro">
                    <img src="<?=$IMG_URL . '/' . $itemData['product_image'];?>" alt="" width="80%" height="auto">
                    <!-- <button><a href="#"><span class="material-icons-outlined">
                                zoom_out_map
                            </span></a></button> -->
                </div>

            </div>
            <!-- end_on -->

            <div class="content_between">
                <nav>
                    <a href="#">TRANG CHỦ</a>
                    /
                    <a href="#">TRÀ HOA QUẢ</a>
                </nav>
                <H1><?=$itemData['product_name'];?></H1>
                <div>
                    -----
                </div>
                <span><?=$itemData['price'];?></span>
                <p class="info">
                <p> <?=$itemData['description'];?></p>
                
                </p>

                <p class="status">Còn hàng</p>

                <form class="cart" action="">

                    <select name="btn_size" id="">
                        <option value=""><?=$itemData['size'];?></option>
                    </select>

                    <input class="minus" type="submit" value="-">
                    <input class="text" type="text" value="1">
                    <input class="plus" type="submit" value="+">

                    <button class="submit" name="submit">THÊM VÀO GIỎ HÀNG</button>
                </form>

            </div>
            <!-- end_between -->

            
        </div>
            <!-- end_under -->

            <div class="feedback">

                <ul>
                    <li><a href="#">Đánh giá</a></li>
                </ul>

                <div class="form">
                    <form class="form_pro" action="">
                        <h3>Bình luận về sản phẩm “Trà vải” </h3>
                        <label class="danh_gia" for="">Đánh giá của bạn*</label>
                        <p>
                           
                            <div class="stars">
                               
                                  <input class="star star-5" id="star-5" type="radio" name="star"/>
                                  <label class="star star-5" for="star-5"></label>
                                  <input class="star star-4" id="star-4" type="radio" name="star"/>
                                  <label class="star star-4" for="star-4"></label>
                                  <input class="star star-3" id="star-3" type="radio" name="star"/>
                                  <label class="star star-3" for="star-3"></label>
                                  <input class="star star-2" id="star-2" type="radio" name="star"/>
                                  <label class="star star-2" for="star-2"></label>
                                  <input class="star star-1" id="star-1" type="radio" name="star"/>
                                  <label class="star star-1" for="star-1"></label>
                              
                              </div>
                        </p>

                        <label class="nx" for="">Nhận xét của bạn*</label>
                        <textarea name="" id="" cols="30" rows="10">

                        </textarea>
                       
                        <input type="submit" value="Gửi đi">
                    </form>
                </div>

                <div class="comment">
                    <img src="assets/images/chang-trai-lai-3-dong-mau-va-nhung-bac-si-noi-tieng-tren-mang-4abe91-300x300.jpg"  alt="" width="70px">
                    <div class="info_cmt">
                        <div class="stars">
                            <form class="form_star" action="">
                              <input class="star star-5" id="star-5" type="radio" name="star"/>
                              <label class="star star-5" for="star-5"></label>
                              <input class="star star-4" id="star-4" type="radio" name="star"/>
                              <label class="star star-4" for="star-4"></label>
                              <input class="star star-3" id="star-3" type="radio" name="star"/>
                              <label class="star star-3" for="star-3"></label>
                              <input class="star star-2" id="star-2" type="radio" name="star"/>
                              <label class="star star-2" for="star-2"></label>
                              <input class="star star-1" id="star-1" type="radio" name="star"/>
                              <label class="star star-1" for="star-1"></label>
                            </form>
                          </div>
                        <p><a class="name_cmt" href="#">Ai đó</a>- <a class="date" href="#">16-11-2021</a></p>
                        <p class="cmt">Mlem</p>
                       
                </div>
                
            </div>
            <!-- <p>----------------------------------------------------------------------------------------------------------------------</p> -->

            <!--  -->
            <h3 class="pro_plus_text">Sản phẩm tương tự</h3>
            <div class="product_plus">
               <?php foreach($item_tt as $item):?>
                <div class="pro">
                    <div class="cha">
                        <div class="img">
                          <img src="<?=$IMG_URL . '/' . $item['product_image'];?>" alt="" width="245px" height="275px">
                        </div>
                     <div class="content_con">
                      <button class="bt"> <a  href="<?=$SITE_URL;?>/product/?detail&id=<?=$item['id'];?>">Xem nhanh</a></button>
                     </div>
                     
                  </div>
                      
                      <div class="content_pro">
                          <a href="#"><?php $item['product_name'];?></a>
                          <div>
                              <span><?php $item['price'];?></span>
                          </div>
                         
                      </div>
                  </div>
                <?php endforeach;?>

            </div>

            <!-- OK -->
        </div>
        <!-- END CONTENT -->