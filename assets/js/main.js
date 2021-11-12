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

    $('.content__cate-list').slick({
        slidesToShow: 4,
        slideToScroll: 4,
        infinite: true,
        prevArrow: '<button class="content__cate-btn content__cate-btn-pre"><i class="fas fa-chevron-left"></i></button>',
        nextArrow: '<button class="content__cate-btn content__cate-btn-next"><i class="fas fa-chevron-right"></i></button>'
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