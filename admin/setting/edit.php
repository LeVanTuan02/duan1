        <main class="content">
            <header class="content__header-wrap">
                <div class="content__header">
                    <div class="content__header-item">
                        <h5 class="content__header-title content__header-title-has-separator">Cài đặt</h5>
                        <span class="content__header-description">Cấu hình trang web</span>
                    </div>
                </div>
            </header>

            <div class="content__home">
                <div class="content__home-wrap">
                    <form action="" class="content__form" method="POST" enctype="multipart/form-data">
                        <h5 class="content__form-title">Cài đặt trang web</h5>
    
                        <div class="form__group">
                            <label for="title">Tiêu đề</label>
                            <div class="form-control">
                                <input type="text" name="title" placeholder="Nhập tiêu đề Website" value="<?=isset($title) ? $title : $settingInfo['title'] ?? '';?>">
                                <span class="form-message">
                                    <?=$errorMessage['title'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="phone">Số điện thoại</label>
                            <div class="form-control">
                                <input type="text" name="phone" placeholder="Nhập số điện thoại" value="<?=isset($phone) ? $phone : $settingInfo['phone'] ?? '';?>">
                                <span class="form-message">
                                    <?=$errorMessage['phone'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="email">Email</label>
                            <div class="form-control">
                                <input type="text" name="email" placeholder="Nhập địa chỉ email" value="<?=isset($email) ? $email : $settingInfo['email'] ?? '';?>">
                                <span class="form-message">
                                    <?=$errorMessage['email'] ?? '';?>
                                </span>
                            </div>
                        </div>
    
                        <div class="form__group">
                            <label for="address">Địa chỉ</label>
                            <div class="form-control">
                                <input type="text" name="address" placeholder="Nhập địa chỉ" value="<?=isset($address) ? $address : $settingInfo['address'] ?? '';?>">
                                <span class="form-message">
                                    <?=$errorMessage['address'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="map">Iframe Google map</label>
                            <div class="form-control">
                                <input type="text" name="map" placeholder="Nhập HTML Iframe Goolge map" value="<?=isset($map) ? $map : $settingInfo['map'] ?? '';?>">
                                <span class="form-message">
                                    <?=$errorMessage['map'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="facebook">Facebook</label>
                            <div class="form-control">
                                <input type="text" name="facebook" placeholder="Nhập link Facebook" value="<?=isset($facebook) ? $facebook : $settingInfo['facebook'] ?? '';?>">
                                <span class="form-message">
                                    <?=$errorMessage['facebook'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="youtube">Youtube</label>
                            <div class="form-control">
                                <input type="text" name="youtube" placeholder="Nhập link Youtube" value="<?=isset($youtube) ? $youtube : $settingInfo['youtube'] ?? '';?>">
                                <span class="form-message">
                                    <?=$errorMessage['youtube'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="instagram">Instagram</label>
                            <div class="form-control">
                                <input type="text" name="instagram" placeholder="Nhập link Instagram" value="<?=isset($instagram) ? $instagram : $settingInfo['instagram'] ?? '';?>">
                                <span class="form-message">
                                    <?=$errorMessage['instagram'] ?? '';?>
                                </span>
                            </div>
                        </div>
    
                        <div class="form__group">
                            <label for="tiktok">Tiktok</label>
                            <div class="form-control">
                                <input type="text" name="tiktok" placeholder="Nhập link tiktok" value="<?=isset($tiktok) ? $tiktok : $settingInfo['tiktok'] ?? '';?>">
                                <span class="form-message">
                                    <?=$errorMessage['tiktok'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <div class="form__group">
                            <label for="username">Trạng thái</label>
                            <div class="form-control">
                                <select name="status">
                                    <option value="">-- Vui lòng chọn trạng thái --</option>
                                    <option value="0" <?=(isset($status) && !$status) || (isset($settingInfo['status']) && !$settingInfo['status']) ? 'selected' : '';?> >Đóng website</option>
                                    <option value="1" <?=(isset($status) && $status) || (isset($settingInfo['status']) && $settingInfo['status']) ? 'selected' : '';?> >Mở website</option>
                                </select>
                                <span class="form-message">
                                    <?=$errorMessage['status'] ?? '';?>
                                </span>
                            </div>
                        </div>

                        <?=isset($MESSAGE) ? '<div class="alert alert-success">'.$MESSAGE.'</div>' : '';?>
    
                        <div class="form__group form__btn-submit">
                            <button type="submit" name="btn_update">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>