// slider
$(document).ready(function() {
    $('.slider__list').slick({
        infinite: true,
        dots: true,
        autoplay: true,
        speed: 800,
        prevArrow: '<button class="slider__btn slider__btn-pre"><i class="fas fa-chevron-left"></i></button>',
        nextArrow: '<button class="slider__btn slider__btn-next"><i class="fas fa-chevron-right"></i></button>'
    });

    // category
    $('.content__cate-list').slick({
        slidesToShow: 4,
        slideToScroll: 4,
        infinite: true,
        prevArrow: '<button class="content__cate-btn content__cate-btn-pre"><i class="fas fa-chevron-left"></i></button>',
        nextArrow: '<button class="content__cate-btn content__cate-btn-next"><i class="fas fa-chevron-right"></i></button>',
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2
                }
            }
        ]
    });

    // feedback
    $('.content__feedback-list').slick({
        autoplay: true,
        dots: true,
        prevArrow: '<button class="content__feedback-list-btn content__feedback-list-btn-pre"><i class="fas fa-chevron-left"></i></button>',
        nextArrow: '<button class="content__feedback-list-btn content__feedback-list-btn-next"><i class="fas fa-chevron-right"></i></button>'
    });

    // slider bottom
    $('.content__slider-bottom').slick({
        slidesToShow: 5,
        autoplay: true,
        prevArrow: '<button class="content__slider-bottom-btn content__slider-bottom-btn-pre"><i class="fas fa-chevron-left"></i></button>',
        nextArrow: '<button class="content__slider-bottom-btn content__slider-bottom-btn-next"><i class="fas fa-chevron-right"></i></button>',
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2
                }
            }
        ]
    });
});

// event handlers
// trượt menu + btn scrollTop
$(window).on('scroll', () => {
    var heightScroll = $(window).scrollTop();
    if (heightScroll > 150) {
        $('.header__menu-wrap').addClass('fixed');
    } else {
        $('.header__menu-wrap').removeClass('fixed');
    }

    var heightScreen = $(window)[0].innerHeight;
    if (heightScroll >= heightScreen) {
        $('.btn-scrollTop').addClass('active');
    } else {
        $('.btn-scrollTop').removeClass('active');
    }
});

// click button scrollTop
$('.btn-scrollTop').on('click', () => {
    $(window).scrollTop(0);
});

// đóng mở menu tablet mobile
function toggleMenu() {
    $('.menu__mobile').toggleClass('active');
}

$('.header__menu-mobile-icon-bar').on('click', () => { toggleMenu(); });

$('.menu__mobile-btn-close').on('click', () => { toggleMenu(); });

$('.menu__mobile-overlay').on('click', () => { toggleMenu(); });

// đóng mở danh sách yêu thích
function toggleWishlist() {
    $('.wishlist').toggleClass('active');
}

$('.wishlist__overlay').on('click', () => { toggleWishlist(); });

$('.wishlist__header-icon').on('click', () => { toggleWishlist(); });

// danh sách yêu thích
// toastr
toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}
const site_url = 'http://localhost/duan1/site';
// add wishlist
$('.content__menu-item-icon-heart').on('click', function() {
    var id = $(this).attr('data-id');

    if (id) {
        $.ajax({
            url: site_url + '/wishlist/index.php',
            type: 'POST',
            data: {
                id: id,
                add_wishlist: ''
            },
            success: function() {
                toastr.success('Thêm sản phẩm vào danh sách yêu thích thành công');
            },
            error: function() {
                toastr.error('Có lỗi xảy ra, vui lòng thử lại');
            }
        })
        .always(function() {
            renderQuantityFromSession();
        });
    }
});

// render wishlist
$('.header__top-list-item-heart').on('click', function() {
    $.ajax({
        url: site_url + '/wishlist/index.php',
        type: 'POST',
        data: {
            render_wishlist: ''
        },
        success: function(data) {
            $('.wishlist__body-list').html(data);
        },
        error: function() {
            $('.wishlist__body-list').html('Có lỗi xảy ra, vui lòng thử lại');
        }
    })
    .always(function() {
        toggleWishlist();
    });
});

// delete wishlist
function delete_wishlist(id) {
    if (id) {
        $.ajax({
            url: site_url + '/wishlist/index.php',
            type: 'POST',
            data: {
                id: id,
                delete_wishlist: ''
            },
            success: function(response) {
                if (response) $(`.wishlist__body-list-item-${id}`).remove();
            },
            error: function() {
                $('.wishlist__body-list').html('Có lỗi xảy ra, vui lòng thử lại');
            }
        })
        .always(function() {
            renderQuantityFromSession();  
        });
    }
}

// render quantity wishlist/cart
function renderQuantityFromSession() {
    // số lượng wishlist
    $.ajax({
        url: site_url + '/wishlist/index.php',
        type: 'POST',
        data: {
            get_quantity: ''
        },
        success: function(res) {
            $('.header__top-list-item-heart-label').text(res);
            $('.header__menu-mobile-icon-heart').text(res);
        },
        error: function() {
            console.log('Có lỗi xảy ra, vui lòng thử lại');
        }
    });

    // số lượng sản phẩm trong giỏ hàng
    $.ajax({
        url: site_url + '/wishlist/index.php',
        type: 'POST',
        data: {
            get_quantity_cart: ''
        }, success: function(result) {
            $('.header__top-list-item-cart-label').text(result);
            $('.header__menu-mobile-icon-cart').text(result);
        }, error: function() {
            console.log('Lỗi');
        }
    });
}
renderQuantityFromSession();

// update giỏ hàng
$('.content__cart-detail-action-link-update').on('click', function(e) {
    e.preventDefault();
});