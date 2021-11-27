<div class="content">
            <!-- contact -->
            <section class="content__contact-wrap">
                <div class="grid">
                    <h2 class="content__title content__contact-title">THÔNG TIN LIÊN HỆ</h2>
                    <div class="content__contact">
                        <div class="content__contact-item">
                            <div class="content__contact-item-info">
                                <section class="content__contact-heading">
                                    <h2 class="content__contact-item-title">Thông tin liên hệ</h2>
                                </section>

                                <ul class="content__contact-info-list">
                                    <li class="content__contact-info-item">
                                        <div class="content__contact-info-item-icon">
                                            <i class="fas fa-home"></i>
                                        </div>
                                        25A Trần Nguyên Hãn – Nha Trang
                                    </li>
                                    <li class="content__contact-info-item">
                                        <div class="content__contact-info-item-icon">
                                            <i class="fas fa-phone-alt"></i>
                                        </div>
                                        Hotline:
                                        <a href="" class="content__contact-info-item-link">&nbsp;0347888888</a>
                                    </li>
                                    <li class="content__contact-info-item">
                                        <div class="content__contact-info-item-icon">
                                            <i class="far fa-envelope"></i>
                                        </div>
                                        Email:
                                        <a href="" class="content__contact-info-item-link">&nbsp;zinzinfood@gmail.com</a>
                                    </li>
                                    <li class="content__contact-info-item">
                                        <div class="content__contact-info-item-icon">
                                            <i class="fab fa-facebook-f"></i>
                                        </div>
                                        Facebook:
                                        <a href="" class="content__contact-info-item-link">&nbsp;Tea House</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="content__contact-item-form">
                                <section class="content__contact-heading">
                                    <h2 class="content__contact-item-title">Liên hệ - Góp ý</h2>
                                </section>
                                <form action="" class="content__contact-item-form-inner" method="POST">
                                    
                                    <input type="text" class="content__contact-item-form-control" name="name" placeholder="Nhập tên của bạn" 
                                    value="<?=$contact['name'] ?? '';?>">
                                    <span class="content__contact-item-form-message">
                                        <?=$errorMessage['name'] ?? '';?>
                                    </span>

                                    <input type="text" class="content__contact-item-form-control" name="email" placeholder="Email của bạn"
                                    value="<?=$contact['email'] ?? '';?>">
                                    <span class="content__contact-item-form-message">
                                        <?=$errorMessage['email'] ?? '';?>
                                    </span>
                                    
                                    
                                    <input type="text" class="content__contact-item-form-control" name="phone" placeholder="Số điện thoại"
                                    value="<?=$contact['phone'] ?? '';?>">
                                    <span class="content__contact-item-form-message">
                                        <?=$errorMessage['phone'] ?? '';?>
                                    </span>

                                    <textarea  rows="5" class="content__contact-item-form-control" name="content" placeholder="Nội dung"
                                    <?=$contact['content'] ?? '';?>
                                    ></textarea>
                                    <span class="content__contact-item-form-message">
                                        <?=$errorMessage['content'] ?? '';?>
                                    </span>
                                    
                                    <?=isset($MESSAGE) ? '<div class="alert alert-success">'.$MESSAGE.'</div>' : '';?>

                                    <button class="content__contact-item-form-btn" name="contact_insert">Gửi</button>
                                </form>
                                
                            </div>
                        </div>
                        <div class="content__contact-item">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d251439.10052809623!2d105.64344561640625!3d10.038634899999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a0634ed278bd41%3A0xbe3738aad763afd3!2sTea%20house!5e0!3m2!1svi!2s!4v1636901533062!5m2!1svi!2s" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
            </section>
            <!-- end contact -->