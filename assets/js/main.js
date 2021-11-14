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

$('.header__menu-mobile-icon').on('click', () => { toggleMenu(); });

$('.menu__mobile-btn-close').on('click', () => { toggleMenu(); });

$('.menu__mobile-overlay').on('click', () => { toggleMenu(); });

// đóng mở danh sách yêu thích
function toggleWishlist() {
    $('.wishlist').toggleClass('active');
}

$('.header__top-list-item-heart').on('click', () => { toggleWishlist(); });

$('.wishlist__overlay').on('click', () => { toggleWishlist(); });

$('.wishlist__header-icon').on('click', () => { toggleWishlist(); });