        <main class="content">
            <header class="content__header-wrap">
                <div class="content__header">
                    <div class="content__header-item">
                        <h5 class="content__header-title content__header-title-has-separator">Sản phẩm</h5>
                        <span class="content__header-description">Cập nhật thuộc tính</span>
                    </div>
                    <div class="content__header-item">
                        <button class="content__header-item-btn content__header-item-btn-reset">Nhập lại</button>
                        <a href="<?=$ADMIN_URL;?>/attribute/?detail&p_id=<?=$p_id;?>" class="content__header-item-btn">DS thuộc tính</a>
                    </div>
                </div>
            </header>

            <div class="content__home">
                <div class="content__home-wrap">
                    <form action="" class="content__form" method="POST" enctype="multipart/form-data">
                        <h5 class="content__form-title">Thông tin chi tiết thuộc tính:</h5>
                        <div class="form__group">
                            <label for="luot_xem">Sản phẩm</label>
                            <div class="form-control disabled">
                                <input type="text" name="product_name" value="<?=$productInfo['product_name'];?>" readonly>
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="ten_hh">Tên thuộc tính</label>
                            <div class="form-control">
                                <select name="size">
                                    <option value="0">Chọn Size</option>
                                    <option value="S" <?=(isset($attribute['size']) && $attribute['size'] == 'S') || $attributeInfo['size'] == 'S' ? 'selected' : '';?> >Size S</option>
                                    <option value="M" <?=(isset($attribute['size']) && $attribute['size'] == 'M') || $attributeInfo['size'] == 'M' ? 'selected' : '';?> >Size M</option>
                                    <option value="L" <?=(isset($attribute['size']) && $attribute['size'] == 'L') || $attributeInfo['size'] == 'L' ? 'selected' : '';?> >Size L</option>
                                </select>
                                <span class="form-message">
                                    <?=$errorMessage['size'] ?? '';?>
                                </span>
                            </div>
                        </div>

    
                        <div class="form__group">
                            <label for="giam_gia">Số lượng</label>
                            <div class="form-control">
                                <input type="number" name="quantity" placeholder="Nhập số lượng" value="<?=$attribute['quantity'] ?? $attributeInfo['quantity'];?>">
                                <span class="form-message">
                                    <?=$errorMessage['quantity'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="giam_gia">Đơn giá</label>
                            <div class="form-control">
                                <input type="number" name="price" placeholder="Nhập đơn giá" value="<?=$attribute['price'] ?? $attributeInfo['price'];?>">
                                <span class="form-message">
                                    <?=$errorMessage['price'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <?=isset($MESSAGE) ? '<div class="alert alert-success">'.$MESSAGE.'</div>' : '';?>

                        <div class="form__group form__btn-submit">
                            <button type="submit" name="btn_update">Cập nhật thuộc tính</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>