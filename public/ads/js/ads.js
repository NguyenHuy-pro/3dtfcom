/**
 * Created by HUY on 4/9/2016.
 */
var tf_ads = {
    banner: {
        viewPlace: function (href) {
            tf_master_submit.ajaxNotReload(href, '#tf_body', false);
        },
        order: {
            selectDay: function (showObject) {
                var form = $('#tf_ads_banner_order');
                var view = $(showObject).val();
                var price = form.find('.tf_price').val();
                form.find('.tf_total_pay').val(view / price);

            },
            pay: function (form) {
                //tf_master_submit.ajaxFormNotReload(form, '#tf_body', false);
                var showObject = $(form).find('.tf_show');
                if (showObject.val() == 0) {
                    alert('You must select view number for ads');
                    showObject.focus();
                    return false;
                } else {
                    if (confirm('Do you set this ads?')) {
                        $(form).ajaxForm({
                            beforeSend: function () {
                                tf_master.tf_main_load_status();
                            },
                            success: function (data) {
                                if (data) {
                                    $('#tf_body').append(data);
                                }
                            },
                            complete: function () {
                                tf_master.tf_main_load_status();
                            }
                        }).submit();
                    }
                }
            }
        }
    }
}

$(document).ready(function () {

    //view banner place
    $('.tf_ads_banner').on('click', '.tf_banner_view_place', function () {
        var href = $(this).data('href');
        var bannerObject = $(this).parents('.tf_ads_banner_object');
        href = href + '/' + bannerObject.data('banner');
        tf_ads.banner.viewPlace(href);
    })

    //select day
    $('.tf_ads_banner_order').on('change', '.tf_show', function () {
        tf_ads.banner.order.selectDay(this);
    });

    //select day
    $('.tf_ads_banner_order').on('click', '.tf_pay', function () {
        var form = $(this).parents('.tf_ads_banner_order');
        tf_ads.banner.order.pay(form);
    });
});