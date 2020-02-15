/**
 * Created by HUY on 7/2/2016.
 */
var tf_m_c_user_user = {
    //View
    view: function (object) {
        var userId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-view') + '/' + userId;
        tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
        tf_main.tf_scrollTop();
    },

    //status
    updateStatus: function (object) {
        var userId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-status') + '/' + userId;
        tf_manage_submit.ajaxHasReload(href, '', false);
    },

    //delete
    delete: function (object) {
        if(confirm('Do you to delete this user?')){
            var userId = $(object).data('object');
            var href = $(object).parents('.tf_list_object').data('href-del') + '/' + userId;
            tf_manage_submit.ajaxHasReload(href, '', false);
        }
    }
}

//---------- ---------- ---------- View - Delete ----------- ---------- ----------
$(document).ready(function () {
    //view
    $('.tf_m_c_user_user').on('click', '.tf_list_object .tf_object_view', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_user_user.view(object);
    });

    //delete user
    $('.tf_m_c_user_user').on('click', '.tf_list_object .tf_object_delete', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_user_user.delete(object);
    });
});

//---------- ---------- ---------- Status ----------- ---------- ----------
$(document).ready(function () {
    //update status
    $('.tf_m_c_user_user').on('click', '.tf_list_object .tf_object_status', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_user_user.updateStatus(object);
    });
});

