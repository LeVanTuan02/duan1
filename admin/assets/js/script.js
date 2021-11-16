// đóng mở menu
$('.sidebar__btn-toggle').on('click', () => {
    $('.container').toggleClass('isMenuClosed');

    if ($('.container').hasClass('isMenuClosed')) {
        $('.aside_menu-session-icon').removeClass('hide');
    } else {
        $('.aside_menu-session-icon').addClass('hide');
    }
});

$('.header__top-bar').on('click', () => {
    $('.container').removeClass('isMenuHide');
    $('.container').toggleClass('isMenuClosed');

    if ($('.container').hasClass('isMenuClosed')) {
        $('.aside_menu-session-icon').removeClass('hide');
    } else {
        $('.aside_menu-session-icon').addClass('hide');
    }
});

// đóng mở user panel
$('.header__toolbar').on('click', () => {
    openUserPanel();
});

$('.user__panel-heading-icon').on('click', () => {
    $('.user__panel').toggleClass('active');
});

$('.user__panel-overlay').on('click', () => {
    openUserPanel();
});

function openUserPanel() {
    $('.user__panel').toggleClass('active');
}

// ẩn menu khi resize
$(window).on('resize', () => {
    handleResize();
});

$(window).on('load', () => {
    handleResize();
});

function handleResize() {
    var widthScreen = $(window).width();
    if (widthScreen < 1023) {
        $('.container').addClass('isMenuHide');
    } else {
        $('.container').removeClass('isMenuHide');
    }
}

// xem trước ảnh
function preImage(e) {
    $('.form-image-box').html('<img src="' + URL.createObjectURL(e.target.files[0]) + '" alt="">');

    if (e.target.files.length >= 0) {
        $('.form-image-box').closest('.form__group').removeClass('hide');
    } else {
        $('.form-image-box').closest('.form__group').addClass('hide');
    }
}

// chọn tất cả
$('.content__header-item-btn-select-all').on('click', () => {
    $('.content__table-table input:checkbox').prop('checked', true);
});

$('.content__header-item-btn-unselect-all').on('click', () => {
    $('.content__table-table input:checkbox').prop('checked', false);
});

$('.select_all').on('change', () => {
    $('.content__table-table input:checkbox').prop('checked', $('.select_all').prop('checked'));
});

// xóa tất cả
$('.content__header-item-btn-del-all').on('click', () => {
    var isConfirmed = confirm('Bạn có chắc chắn muốn xóa mục đã chọn không?');
    if (isConfirmed) {
        var checkboxElement = $('.content__table-body input:checkbox:checked');
        var ids = [];
        $.each(checkboxElement, function(index) {
            ids[index] = $(this).attr('data-id');
        });
        
        if (!ids.length) {
            alert('Vui lòng chọn ít nhất 1 mục');
        } else {
            $.ajax({
                url: 'index.php',
                type: 'POST',
                data: {
                    btn_delete: '',
                    id: ids
                },
                success: function(data) {
                    $('.error-message').html(data);
                    location.reload();
                },
                error: function() {
                    alert('Có lỗi xảy ra, vui lòng thử lại');
                }
            });
        }
    }
});

// reset form
$('.content__header-item-btn-reset').on('click', () => {
    $('.content__form')[0].reset();
});