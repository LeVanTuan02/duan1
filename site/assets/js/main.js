const site_url = 'http://localhost/duan1/site';

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
        url: site_url + '/cart/index.php',
        type: 'POST',
        data: {
            get_quantity: ''
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
    // loading js
    var spinHandle = loadingOverlay().activate();
    
    e.preventDefault();

    var listQuantity = [];

    // lấy danh sách id và quantity tương ứng
    var tableRowElements = $('.content__cart-detail-table tbody tr');
    $.each(tableRowElements, function(i, row) {
        listQuantity[i] = {
            id: row.dataset.id,
            quantity: row.querySelector('.content__cart-detail-table-qnt-control').value,
            size: row.querySelector('.content__cart-detail-size').innerText
        };
    });

    // cập nhật giỏ hàng
    $.ajax({
        url: site_url + '/cart/index.php',
        type: 'POST',
        dataType: 'json',
        data: {
            listQuantity: listQuantity,
            update_cart: ''
        },
        success: function(response) {
            setTimeout(function() {
                loadingOverlay().cancel(spinHandle);
            }, 1000);

            if (response.success) {
                setTimeout(function() {
                    toastr.success('Giỏ hàng đã được cập nhật');
                }, 1100);
            } else {
                setTimeout(function() {
                    $.each(response.message, function(key, message) {
                        toastr.info(message);
                    })
                }, 1100);
            }

            setTimeout(function() {
                renderCart();
                renderTotalPrice();
            }, 1000);
        },
        error: function() {
            console.log('Lỗi');
        }
    });

});

// render cart
function renderCart() {
    $.ajax({
        url: site_url + '/cart/index.php',
        type: 'POST',
        data: {
            render_cart: ''
        },
        success: function(data) {
            $('.content__cart-detail-table tbody').html(data);

        },
        error: function() {
            console.log('Lỗi');
        }
    });
}

// render tổng tiền
function renderTotalPrice() {
    $.ajax({
        url: site_url + '/cart/index.php',
        type: 'POST',
        data: {
            render_totalPrice: ''
        },
        success: function(res) {
            $('.content__cart-checkout-total-price').html(res);
        },
        error: function() {
            console.log('Lỗi');
        }
    })
}

// click thanh toán
$('.content__cart-checkout-btn').on('click', function(e) {
    // loading js
    var spinHandle = loadingOverlay().activate();
    
    e.preventDefault();

    var listQuantity = [];

    // lấy danh sách id và quantity tương ứng
    var tableRowElements = $('.content__cart-detail-table tbody tr');
    $.each(tableRowElements, function(i, row) {
        listQuantity[i] = {
            id: row.dataset.id,
            quantity: row.querySelector('.content__cart-detail-table-qnt-control').value,
            size: row.querySelector('.content__cart-detail-size').innerText
        };
    });

    // cập nhật giỏ hàng
    $.ajax({
        url: site_url + '/cart/index.php',
        type: 'POST',
        dataType: 'json',
        data: {
            listQuantity: listQuantity,
            update_cart: ''
        },
        success: function(response) {
            setTimeout(function() {
                loadingOverlay().cancel(spinHandle);
            }, 1000);

            if (response.success) {
                // setTimeout(function() {
                //     toastr.success('Giỏ hàng đã được cập nhật');
                // }, 1100);
                // chuyển sang trang thanh toán
                setTimeout(function() {
                    window.location.href = '?checkout';
                }, 1200);
            } else {
                setTimeout(function() {
                    $.each(response.message, function(key, message) {
                        toastr.info(message);
                    })
                }, 1100);
            }

            setTimeout(function() {
                renderCart();
                renderTotalPrice();
            }, 1000);
        },
        error: function() {
            console.log('Lỗi');
        }
    });

});

// đổi size trang sản phẩm
$('select[name="size"]').on('change', function() {
    var id = $(this).attr('data-id');
    var size = $(this).val();
    $.ajax({
        url: site_url + '/product/index.php',
        type: 'POST',
        dataType: 'json',
        data: {
            id: id,
            size: size,
            get_price: ''
        }, success: function(result) {
            if (result.success) {
                $('.product_price').html(`${result.price}đ`);
                // hiện số lượng sp
                $('.product__quantity').show();
                $('.product__quantity').html(`Còn ${result.quantity} sản phẩm`);

                $('.cart .submit').css({'cursor': 'pointer', 'opacity': '1'});
                $('.cart .submit').removeClass('disabled');
            } else {
                $('.product_price').html('Hết hàng');
                // ẩn số lượng sp
                $('.product__quantity').hide();
                $('.cart .submit').css({'cursor': 'not-allowed', 'opacity': '0.3'});
                $('.cart .submit').addClass('disabled');
            }
        }, error: function() {
            console.log('lỗi')
        }
    });
});

// thêm vào giỏ hàng
$('.cart .submit').on('click', function() {

    var formElement = $(this).parent('.cart');
    var id = formElement.find('select').attr('data-id');
    var size = formElement.find('select').val();
    var qnt = formElement.find('input[name="quantity"]').val();

    if (!$(this).hasClass('disabled')) {
        if (qnt <= 0) {
            toastr.error('Vui lòng chọn lại số lượng');
        } else {
            $.ajax({
                url: site_url + '/cart/index.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    id: id,
                    size: size,
                    qnt: qnt,
                    add_cart: ''
                }, success: function(result) {
                    if (result.success) {
                        toastr.success('Thêm vào giỏ hàng thành công');

                        // cập nhật tổng số sản phẩm trên header
                        renderQuantityFromSession();
                    } else {
                        toastr.info(`Số lượng sản phẩm hiện tại không đủ, vui lòng chọn ít hơn ${result.message} SP`);
                    }
                }, error: function() {
                    console.log('lỗi');
                }
            });
        }
    
    } else {
        toastr.info('Sản phẩm/size này không còn hàng');
    }
    formElement.find('input[name="quantity"]').val(1);
});

// bình luận
$('.form__comment_btn').on('click', function() {
    var formElement = $(this).parent('.form_pro');
    var content = formElement.find('.form__comment-content').val();
    var rating_number = formElement.find('input:checked').val();
    var product_id = formElement.attr('data-id');

    if (!rating_number) {
        toastr.info('Vui lòng chọn mức đánh giá');
    } else if (!content) {
        toastr.info('Vui lòng nhập nội dung');
    } else {
        $.ajax({
            url: site_url + '/product/index.php',
            type: 'POST',
            data: {
                product_id: product_id,
                rating_number: rating_number,
                content: content,
                comment: ''
            }, success: function(result) {
                if (result) {
                    toastr.success('Đánh giá sản phẩm thành công');
                    render_cmt(result);
                    formElement.trigger('reset');
                }
            }, error: function() {
                console.log('lỗi');
            }
        });
    }
});

// khi click button rep cmt
// $('.info_cmt-action--rep').on('click', function() {
//     var parentComment = $(this).closest('.info_cmt');
//     // id của cmt chính (cmt được trả lời)
//     var id = parentComment.attr('data-id');
//     var product_id = parentComment.attr('data-product-id');
//     $.ajax({
//         url: site_url + '/pro/index.php',
//         type: 'POST',
//         data: {
//             id: id,
//             product_id: product_id,
//             btn_repCmt: ''
//         }, success: function(result) {
//             if (result) {
//                 parentComment.find('.comment__rep-form').html(result);
//             }
//         }, error: function() {
//             console.log('lỗi');
//         }
//     });
// });

// khi click button rep cmt => lấy id của cmt được trả lời + id sp => trả về html form rep cmt
function repCmt(e) {
    var parentComment = e.target.closest('.info_cmt');
    // id của cmt chính (cmt được trả lời)
    var id = parentComment.getAttribute('data-id');
    var product_id = parentComment.getAttribute('data-product-id');

    $.ajax({
        url: site_url + '/product/index.php',
        type: 'POST',
        data: {
            id: id,
            product_id: product_id,
            btn_repCmt: ''
        }, success: function(result) {
            if (result) {
                parentComment.querySelector('.comment__rep-form').innerHTML = result;
            }
        }, error: function() {
            console.log('lỗi');
        }
    });
}

// khi submit form rep cmt => lấy id cmt được rep, id sp, nội dung => trả về id cmt vừa insert => render ra html
function repComment(e) {
    var formElement = e.target.closest('.comment__rep-form-wrap');
    var cmtElement = formElement.querySelector('.comment__rep-form-control');
    var id_parent = cmtElement.getAttribute('data-id');
    var product_id = cmtElement.getAttribute('data-product-id');
    var cmtContent = cmtElement.value;

    if (!cmtContent) {
        toastr.info('Vui lòng nhập nội dung');
    } else {
        $.ajax({
            url: site_url + '/product/index.php',
            type: 'POST',
            data: {
                comment_parent_id: id_parent,
                content: cmtContent,
                product_id: product_id,
                repCmt_insert: ''
            }, success: function(result) {
                if (result) {
                    cmtElement.value = '';
                    
                    render_rep_cmt(result, id_parent);
                }
            }, error: function() {
                console.log('lỗi');
            }
        });
    }
}

// render lại cmt rep
function render_rep_cmt(id, id_parent) {
    $.ajax({
        url: site_url + '/product/index.php',
        type: 'POST',
        data: {
            id: id,
            render_cmt_rep: ''
        }, success: function(html) {
            if (html) {
                $(`.info_cmt-${id_parent}`).find('.comment__rep-list').append(html);
            }
        }, error: function() {
            console.log('lỗi');
        }
    });
}

// render lại đánh giá
function render_cmt(id) {
    $.ajax({
        url: site_url + '/product/index.php',
        type: 'POST',
        data: {
            id: id,
            render_cmt: ''
        }, success: function(html) {
            if (html) {
                $('.comment__list').prepend(html);
                autoHideCmt();
            }
        }, error: function() {
            console.log('lỗi');
        }
    });
}

// xóa cmt
function deleteComment(id) {
    var isOk = confirm('Bạn có chắc muốn xóa bình luận này không?');

    if (isOk) {
        $.ajax({
            url: site_url + '/product/index.php',
            type: 'POST',
            data: {
                id: id,
                delete_cmt: ''
            }, success: function(result) {
                if (result) {
                    toastr.success('Đã xóa bình luận');
                    // xóa cmt rep
                    $(`.comment__rep-item-${id}`).remove();

                    // xóa cmt chính
                    $(`.comment-${id}`).remove();

                    autoHideCmt();
                }
            }, error: function() {
                console.log('lỗi');
            }
        });
    } else {
        return false;
    }
}

// mặc định hiện 4 cmt
function autoHideCmt() {
    $('.comment:nth-child(n+5)').hide();
    $('.comment:eq(0)').show();
    $('.comment:eq(1)').show();
    $('.comment:eq(2)').show();
    $('.comment:eq(3)').show();
}
autoHideCmt();

function seeMore() {
    var btn = $('.comment__list-button');
    if (btn.hasClass('see_all')) {
        $('.comment:nth-child(n+5)').slideDown();
        btn.text('Xem ít hơn');
        btn.removeClass('see_all');
    } else {
        $('.comment:nth-child(n+5)').slideUp();
        btn.text('Xem tất cả');
        btn.addClass('see_all');
    }
}