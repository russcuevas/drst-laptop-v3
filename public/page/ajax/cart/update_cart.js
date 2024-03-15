'use strict';

(function ($) {

    /*------------------
        Preloader
    --------------------*/
    $(window).on('load', function () {
        $(".loader").fadeOut();
        $("#preloder").delay(200).fadeOut("slow");

        /*------------------
            Gallery filter
        --------------------*/
        $('.featured__controls li').on('click', function () {
            $('.featured__controls li').removeClass('active');
            $(this).addClass('active');
        });
        if ($('.featured__filter').length > 0) {
            var containerEl = document.querySelector('.featured__filter');
            var mixer = mixitup(containerEl);
        }
    });

    /*------------------
        Background Set
    --------------------*/

    //Humberger Menu
    $(".humberger__open").on('click', function () {
        $(".humberger__menu__wrapper").addClass("show__humberger__menu__wrapper");
        $(".humberger__menu__overlay").addClass("active");
        $("body").addClass("over_hid");
    });

    $(".humberger__menu__overlay").on('click', function () {
        $(".humberger__menu__wrapper").removeClass("show__humberger__menu__wrapper");
        $(".humberger__menu__overlay").removeClass("active");
        $("body").removeClass("over_hid");
    });

    /*------------------
        Navigation
    --------------------*/
    $(".mobile-menu").slicknav({
        prependTo: '#mobile-menu-wrap',
        allowParentLinks: true
    });

    /*-----------------------
        Categories Slider
    ------------------------*/
    $(".categories__slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 4,
        dots: false,
        nav: true,
        navText: ["<span class='fa fa-angle-left'><span/>", "<span class='fa fa-angle-right'><span/>"],
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        responsive: {

            0: {
                items: 1,
            },

            480: {
                items: 2,
            },

            768: {
                items: 3,
            },

            992: {
                items: 4,
            }
        }
    });


    $('.hero__categories__all').on('click', function () {
        $('.hero__categories ul').slideToggle(400);
    });

    /*--------------------------
        Latest Product Slider
    ----------------------------*/
    $(".latest-product__slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 1,
        dots: false,
        nav: true,
        navText: ["<span class='fa fa-angle-left'><span/>", "<span class='fa fa-angle-right'><span/>"],
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true
    });

    /*-----------------------------
        Product Discount Slider
    -------------------------------*/
    $(".product__discount__slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 3,
        dots: true,
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        responsive: {

            320: {
                items: 1,
            },

            480: {
                items: 2,
            },

            768: {
                items: 2,
            },

            992: {
                items: 3,
            }
        }
    });

    /*---------------------------------
        Product Details Pic Slider
    ----------------------------------*/
    $(".product__details__pic__slider").owlCarousel({
        loop: true,
        margin: 20,
        items: 4,
        dots: true,
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true
    });

    /*-----------------------
        Price Range Slider
    ------------------------ */
    var rangeSlider = $(".price-range"),
        minamount = $("#minamount"),
        maxamount = $("#maxamount"),
        minPrice = rangeSlider.data('min'),
        maxPrice = rangeSlider.data('max');
    rangeSlider.slider({
        range: true,
        min: minPrice,
        max: maxPrice,
        values: [minPrice, maxPrice],
        slide: function (event, ui) {
            minamount.val('$' + ui.values[0]);
            maxamount.val('$' + ui.values[1]);
        }
    });
    minamount.val('$' + rangeSlider.slider("values", 0));
    maxamount.val('$' + rangeSlider.slider("values", 1));

    /*--------------------------
        Select
    ----------------------------*/
    $("select").niceSelect();

    /*------------------
        Single Product
    --------------------*/
    $('.product__details__pic__slider img').on('click', function () {

        var imgurl = $(this).data('imgbigurl');
        var bigImg = $('.product__details__pic__item--large').attr('src');
        if (imgurl != bigImg) {
            $('.product__details__pic__item--large').attr({
                src: imgurl
            });
        }
    });

    /*-------------------
        Quantity change
    --------------------- */
    var proQty = $('.pro-qty');

    proQty.prepend('<span class="dec qtybtn">-</span>');
    proQty.append('<span class="inc qtybtn">+</span>');

    proQty.on('click', '.qtybtn', function () {
        var $button = $(this);
        var oldValue = $button.parent().find('input').val();
        var cartId = $button.parent().data('cart-id');
        var productId = $button.parent().data('product-id');

        var newVal = ($button.hasClass('inc')) ? parseFloat(oldValue) + 1 : (oldValue > 0) ? parseFloat(oldValue) - 1 : 0;

        $button.parent().find('input').val(newVal);
        $.ajax({
            method: 'POST',
            url: '/update-quantity',
            data: {
                cartId: cartId,
                productId: productId,
                quantity: newVal,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.status == 200) {
                    // for debugging
                    console.log(response.message);
                    localStorage.setItem('successMessage', response.message);
                    window.location.reload();
                } else if (response.status === 400) {
                    console.log(response.message);
                    localStorage.setItem('errorMessage', response.message);
                    window.location.reload();
                } else if (response.status === 401) {
                    var errorMessage = '';
                    for (var key in response.error) {
                        errorMessage += response.error[key][0];
                    }
                    localStorage.setItem('errorMessage', errorMessage);
                    window.location.reload();
                } else if (response.status === 404) {
                    window.location.reload();
                }
            },
        });
    });

    // variable for success message that is called in the response
    var successMessage = localStorage.getItem('successMessage');
    if (successMessage) {
        var alertDiv = document.querySelector('.alert.alert-success');
        if (alertDiv) {
            alertDiv.textContent = successMessage;
            alertDiv.style.display = 'block';
            localStorage.removeItem('successMessage');
        }
    }

    // variable for error message that is called in the response
    var errorMessage = localStorage.getItem('errorMessage');
    if (errorMessage) {
        var alertDiv = document.querySelector('.alert.alert-danger');
        if (alertDiv) {
            alertDiv.textContent = errorMessage;
            alertDiv.style.display = 'block';
            localStorage.removeItem('errorMessage');
        }
    }


    /*-------------------
        Total change if selected product is selecting
    --------------------- */
    $(document).ready(function () {
        function updateTotal() {
            let total = 0;
    
            $('.individualCheckbox:checked').each(function () {
                total += parseFloat($(this).data('price'));
            });
    
            $('#cartTotal').text('₱' + total.toFixed(2));
        }
    
        $('.individualCheckbox').change(function () {
            updateTotal();
        });
    
        $('.select-all-checkbox').change(function () {
            $('.individualCheckbox').prop('checked', $(this).prop('checked'));
            updateTotal();
        });
    
        updateTotal();
    });

})(jQuery);