/**
 * Created by HUY on 6/14/2016.
 */
var tf_m_c_seller_payment = {
    //View
    filter: function (href) {
        var payStatus = $('#tf_seller_payment_filter_pay_status').val();
        var code = $('#tf_seller_payment_filter_code').val();
        tf_main.tf_url_replace(href + '/' + payStatus + '/' + code);
    },

    //View
    view: function (object) {
        var objectId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-view') + '/' + objectId;
        tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
        tf_main.tf_scrollTop();
    },

    //confirm
    confirm: function (object) {
        var objectId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-confirm') + '/' + objectId;
        if (confirm('Do you want to confirm this payment?')) {
            tf_manage_submit.ajaxHasReload(href, '', false);
        }
    }
}

//---------- ---------- ---------- Filter ----------- ---------- ----------
$(document).ready(function () {
    //pay status
    $('.tf_m_c_seller_payment').on('change', '#tf_seller_payment_filter_pay_status', function () {
        var href = $(this).parents('.tf_seller_payment_filter').data('filter');
        tf_m_c_seller_payment.filter(href);
    });
    // seller code or payment code
    $('.tf_m_c_seller_payment').on('click', '#tf_seller_payment_filter_code_go', function () {
        var href = $(this).parents('.tf_seller_payment_filter').data('filter');
        tf_m_c_seller_payment.filter(href);
    });
});


//---------- ---------- ---------- View ----------- ---------- ----------
$(document).ready(function () {
    //view
    $('.tf_m_c_seller_payment').on('click', '.tf_list_object .tf_object_view', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_seller_payment.view(object);
    });
});

//---------- ---------- ---------- Confirm ----------- ---------- ----------
$(document).ready(function () {
    //view
    $('.tf_m_c_seller_payment').on('click', '.tf_list_object .tf_confirm', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_seller_payment.confirm(object);
    });
});

