/**
 * Created by HUY on 12/8/2016.
 */
var tf_m_c_user_access = {
    //View
    view: function (object) {
        var userId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-view') + '/' + userId;
        tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
        tf_main.tf_scrollTop();
    }
}

//---------- ---------- ---------- View ----------- ---------- ----------
$(document).ready(function () {
    //view
    /*
    $('.tf_m_c_user_access').on('click', '.tf_list_object .tf_object_view', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_user_access.view(object);
    });
    */
});