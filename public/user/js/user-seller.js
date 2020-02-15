/**
 * Created by 3D on 3/26/2016.
 */
var tf_user_seller = {
    statistic: {
        view: function (href) {
            tf_master_submit.ajaxNotReload(href, $('#' + tf_master.bodyIdName()), false);
        }
    },
    payment: {
        view: function (href) {
            tf_master_submit.ajaxNotReload(href, $('#' + tf_master.bodyIdName()), false);
        },
        detailMore: function (href) {
            $.ajax({
                url: href,
                type: 'GET',
                cache: false,
                data: {},
                beforeSend: function () {
                    tf_master.tf_main_load_status();
                },
                success: function (data) {
                    if (data) {
                        $('#tf_payment_detail_more_container').empty();
                        $('#tf_payment_detail_more_container').append(data);
                    }
                },
                complete: function () {
                    tf_master.tf_main_load_status();
                }
            });
            //tf_master_submit.ajaxNotReload(href, '#tf_detail_more_container', false);
        }
    }

}

//---------- ----------- Seller ----------- -----------
$(document).ready(function () {
    //view-payment-detail
    $('.tf_user_seller_payment_wrap').on('click', '.tf_seller_payment_view', function () {
        var paymentCode = $(this).data('code');
        var href = $(this).parents('.tf_user_seller_payment_wrap').data('href-view') + '/' + paymentCode;
        tf_user_seller.payment.view(href)
    });

    //payment-detail-more
    $('body').on('click', '.tf_payment_detail_more', function () {
        var object = $(this).data('object');
        var from = $(this).parents('.tf_user_payment_view_container').data('from');
        var to = $(this).parents('.tf_user_payment_view_container').data('to');
        var href = $(this).parents('.tf_user_payment_view_container').data('href_more') + '/' + object + '/' + from + '/' + to;
        tf_user_seller.payment.detailMore(href)
    });

    //view statistic detail
    $('.tf_user_seller_statistic_wrap').on('click', '.tf_seller_statistic_view', function () {
        var object = $(this).data('object');
        var fromDate = $(this).parents('.tf_user_seller_statistic_wrap').data('from');
        var toDate = $(this).parents('.tf_user_seller_statistic_wrap').data('to');
        var href = $(this).parents('.tf_user_seller_statistic_wrap').data('href-view') + '/' + object + '/' + fromDate + '/' + toDate;
        tf_user_seller.statistic.view(href)
    });
});