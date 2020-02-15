/**
 * Created by HUY on 6/14/2016.
 */
var tf_m_c_seller_seller = {
    //View
    view: function (object) {
        var objectId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-view') + '/' + objectId;
        tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
        tf_main.tf_scrollTop();
    },
    //delete
    delete: function (object) {
        if (confirm('Do you want to delete this guide?')) {
            var objectId = $(object).data('object');
            var href = $(object).parents('.tf_list_object').data('href-del') + '/' + objectId;
            tf_manage_submit.ajaxHasReload(href, '#tf_m_c_wrapper', false);
        }
    },

    //update status
    status: function (object) {
        var objectId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-status') + '/' + objectId;
        tf_manage_submit.ajaxHasReload(href, '', false);
    },
}

//---------- ---------- ---------- View ----------- ---------- ----------
$(document).ready(function () {
    //view
    $('.tf_m_c_seller_seller').on('click', '.tf_list_object .tf_object_view', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_seller_seller.view(object);
    });
});

//---------- ---------- ---------- Update status ----------- ---------- ----------
$(document).ready(function () {
    //view
    $('.tf_m_c_seller_seller').on('click', '.tf_list_object .tf_object_status', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_seller_seller.status(object);
    });
});

//---------- ---------- ---------- delete ----------- ---------- ----------
$(document).ready(function () {
    //view
    $('.tf_m_c_seller_seller').on('click', '.tf_list_object .tf_object_delete', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_seller_seller.delete(object);
    });
});
