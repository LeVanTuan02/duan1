<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator</title>
    <link rel="stylesheet" href="<?=$ADMIN_URL;?>/assets/css/base.css">
    <link rel="stylesheet" href="<?=$ADMIN_URL;?>/assets/css/main.css">
    <link rel="stylesheet" href="<?=$ADMIN_URL;?>/assets/css/responsive.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <header>
                <a href="<?=$SITE_URL;?>" class="sidebar__logo-link">Tea House</a>
                <button class="sidebar__btn-toggle">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </header>

            <div class="sidebar__menu-wrapper">
                <ul class="sidebar__menu-nav">
                    <li class="sidebar__menu-item">
                        <a href="<?=$ADMIN_URL;?>/analytics/?chart" class="sidebar__menu-link">
                            <span class="sidebar__menu-icon">
                                <i class="fas fa-home"></i>
                            </span>
                            <span class="sidebar__menu-text">Dashboard</span>
                        </a>
                    </li>

                    <li class="sidebar__menu-session">
                        <h4 class="sidebar__menu-session-text">Profile</h4>
                        <div class="aside_menu-session-icon hide">
                            <i class="fas fa-ellipsis-h"></i>
                        </div>
                    </li>
    
                    <li class="sidebar__menu-item <?=isset($btn_edit_pass) ? 'sidebar__menu-item--active' : '';?>">
                        <a href="<?=$ADMIN_URL;?>/account/?update_pass" class="sidebar__menu-link">
                            <span class="sidebar__menu-icon">
                                <i class="fas fa-key"></i>
                            </span>
                            <span class="sidebar__menu-text">Đổi mật khẩu</span>
                        </a>
                    </li>
    
                    <li class="sidebar__menu-item">
                        <a href="<?=$ADMIN_URL;?>/account" class="sidebar__menu-link">
                            <span class="sidebar__menu-icon">
                                <i class="fas fa-user-edit"></i>
                            </span>
                            <span class="sidebar__menu-text">Cập nhật thông tin</span>
                        </a>
                    </li>

                    <li class="sidebar__menu-item">
                        <a href="<?=$ADMIN_URL;?>/account/?cart" class="sidebar__menu-link">
                            <span class="sidebar__menu-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </span>
                            <span class="sidebar__menu-text">Đơn hàng của tôi</span>
                        </a>
                    </li>
    
                    <li class="sidebar__menu-session">
                        <h4 class="sidebar__menu-session-text">Order</h4>
                        <div class="aside_menu-session-icon hide">
                            <i class="fas fa-ellipsis-h"></i>
                        </div>
                    </li>

                    <li class="sidebar__menu-item">
                        <a href="<?=$ADMIN_URL;?>/order" class="sidebar__menu-link">
                            <span class="sidebar__menu-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </span>
                            <span class="sidebar__menu-text">Danh sách đơn hàng</span>
                        </a>
                    </li>

                    <li class="sidebar__menu-session">
                        <h4 class="sidebar__menu-session-text">User</h4>
                        <div class="aside_menu-session-icon hide">
                            <i class="fas fa-ellipsis-h"></i>
                        </div>
                    </li>
    
                    <li class="sidebar__menu-item">
                        <a href="/khach-hang" class="sidebar__menu-link">
                            <span class="sidebar__menu-icon">
                                <i class="fas fa-users"></i>
                            </span>
                            <span class="sidebar__menu-text">Danh sách khách hàng</span>
                        </a>
                    </li>
    
                    <li class="sidebar__menu-item">
                        <a href="/khach-hang/?btn_add" class="sidebar__menu-link">
                            <span class="sidebar__menu-icon">
                                <i class="fas fa-user-plus"></i>
                            </span>
                            <span class="sidebar__menu-text">Thêm khách hàng</span>
                        </a>
                    </li>
    
                    <li class="sidebar__menu-session">
                        <h4 class="sidebar__menu-session-text">Category</h4>
                        <div class="aside_menu-session-icon hide">
                            <i class="fas fa-ellipsis-h"></i>
                        </div>
                    </li>
    
                    <li class="sidebar__menu-item">
                        <a href="/loai-hang" class="sidebar__menu-link">
                            <span class="sidebar__menu-icon">
                                <i class="fas fa-list"></i>
                            </span>
                            <span class="sidebar__menu-text">Danh sách loại hàng</span>
                        </a>
                    </li>
    
                    <li class="sidebar__menu-item">
                        <a href="/loai-hang/?btn_add" class="sidebar__menu-link">
                            <span class="sidebar__menu-icon">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="sidebar__menu-text">Thêm loại hàng</span>
                        </a>
                    </li>
    
                    <li class="sidebar__menu-session">
                        <h4 class="sidebar__menu-session-text">Product</h4>
                        <div class="aside_menu-session-icon hide">
                            <i class="fas fa-ellipsis-h"></i>
                        </div>
                    </li>
    
                    <li class="sidebar__menu-item">
                        <a href="<?=$ADMIN_URL;?>/product" class="sidebar__menu-link">
                            <span class="sidebar__menu-icon">
                                <i class="fas fa-list"></i>
                            </span>
                            <span class="sidebar__menu-text">Danh sách sản phẩm</span>
                        </a>
                    </li>

                    <li class="sidebar__menu-item">
                        <a href="<?=$ADMIN_URL;?>/attribute" class="sidebar__menu-link">
                            <span class="sidebar__menu-icon">
                                <i class="fas fa-list"></i>
                            </span>
                            <span class="sidebar__menu-text">Danh sách thuộc tính</span>
                        </a>
                    </li>
    
                    <li class="sidebar__menu-item">
                        <a href="<?=$ADMIN_URL;?>/product/?btn_add" class="sidebar__menu-link">
                            <span class="sidebar__menu-icon">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="sidebar__menu-text">Thêm sản phẩm</span>
                        </a>
                    </li>

                    <li class="sidebar__menu-session">
                        <h4 class="sidebar__menu-session-text">Analytics</h4>
                        <div class="aside_menu-session-icon hide">
                            <i class="fas fa-ellipsis-h"></i>
                        </div>
                    </li>
    
                    <li class="sidebar__menu-item">
                        <a href="<?=$ADMIN_URL;?>/comment" class="sidebar__menu-link">
                            <span class="sidebar__menu-icon">
                                <i class="fas fa-chart-bar"></i>
                            </span>
                            <span class="sidebar__menu-text">Tổng hợp bình luận</span>
                        </a>
                    </li>
    
                    <li class="sidebar__menu-item">
                        <a href="<?=$ADMIN_URL;?>/analytics" class="sidebar__menu-link">
                            <span class="sidebar__menu-icon">
                                <i class="fas fa-chart-pie"></i>
                            </span>
                            <span class="sidebar__menu-text">Thống kê sản phẩm</span>
                        </a>
                    </li>

                    <li class="sidebar__menu-item">
                        <a href="<?=$ADMIN_URL;?>/analytics/?feedback" class="sidebar__menu-link">
                            <span class="sidebar__menu-icon">
                                <i class="fas fa-chart-line"></i>
                            </span>
                            <span class="sidebar__menu-text">Tổng hợp ý kiến người dùng</span>
                        </a>
                    </li>

                    <li class="sidebar__menu-session">
                        <h4 class="sidebar__menu-session-text">Slider</h4>
                        <div class="aside_menu-session-icon hide">
                            <i class="fas fa-ellipsis-h"></i>
                        </div>
                    </li>
    
                    <li class="sidebar__menu-item">
                        <a href="<?=$ADMIN_URL;?>/slide/?list.php" class="sidebar__menu-link">
                            <span class="sidebar__menu-icon">
                                <i class="fas fa-images"></i>
                            </span>
                            <span class="sidebar__menu-text">Danh sách slide</span>
                        </a>
                    </li>
    
                    <li class="sidebar__menu-item">
                        <a href="<?=$ADMIN_URL;?>/slide/?btn_add" class="sidebar__menu-link">
                            <span class="sidebar__menu-icon">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="sidebar__menu-text">Thêm slide</span>
                        </a>
                    </li>
    
                    <li class="sidebar__menu-session">
                        <h4 class="sidebar__menu-session-text">System</h4>
                        <div class="aside_menu-session-icon hide">
                            <i class="fas fa-ellipsis-h"></i>
                        </div>
                    </li>
    
                    <li class="sidebar__menu-item">
                        <a href="<?=$ADMIN_URL;?>/setting" class="sidebar__menu-link">
                            <span class="sidebar__menu-icon">
                                <i class="fas fa-cogs"></i>
                            </span>
                            <span class="sidebar__menu-text">Cấu hình hệ thống</span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

        <header class="header__top-mobile">
            <div class="header__top-mobile-logo">
                <a href="" class="sidebar__logo-link">Tea House</a>
            </div>

            <div class="header__top-bar">
                <i class="fas fa-bars"></i>
            </div>
        </header>
        
        <header class="header__top">
            <ul class="header__top-menu">
                <li class="header__top-item header__top-item--active">
                    <a href="#" class="header__top-link">Pages</a>
                </li>
                <li class="header__top-item">
                    <a href="#" class="header__top-link">Features</a>
                </li>
                <li class="header__top-item">
                    <a href="#" class="header__top-link">Apps</a>
                </li>
            </ul>

            <ul class="header__toolbar">
                <li class="header__toolbar-item">
                    <span class="header__toolbar-user-text">Hi,</span>
                    <span class="header__toolbar-user-name">Admin</span>
                    <span class="header__toolbar-user-label">A</span>
                </li>
            </ul>
        </header>

        <?php include_once $VIEW_PAGE;?>

        <section class="user__panel">
            <div class="user__panel-overlay"></div>
            <div class="user__panel-content">
                <div class="user__panel-heading">
                    <div class="user__panel-title">User Profile</div>
                    <div class="user__panel-heading-icon">
                        <i class="far fa-times-circle"></i>
                    </div>
                </div>

                <div class="user__panel-body">
                    <div class="user__panel-info">
                        <div class="user__panel-img">
                            <img src="" alt="">
                        </div>
                        <div class="user__panel-info-details">
                            <span class="user__panel-info-name">Admin</span>
                            <span class="user__panel-info-email">admin@gmail.com</span>
                            <a href="/tai-khoan/?btn_logout" class="user__panel-btn">Đăng xuất</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <footer class="footer">
            <span class="footer__text">2021 ©</span>
            <a href="" target="_blank" class="footer__copyright">Tea House</a>
        </footer>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha512-YUkaLm+KJ5lQXDBdqBqk7EVhJAdxRnVdT2vtCzwPHSweCzyMgYV/tgGF4/dCyqtCC2eCphz0lRQgatGVdfR0ww==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="<?=$ADMIN_URL;?>/assets/js/script.js"></script>
</body>
</html>