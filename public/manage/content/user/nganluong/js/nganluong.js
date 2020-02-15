/**
 * Created by HUY on 12/8/2016.
 */
var tf_m_c_user_nganluong = {

    //View
    view: function (object) {
        var objectId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-view') + '/' + objectId;
        tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
        tf_main.tf_scrollTop();
    }
}

//---------- ---------- ---------- View ----------- ---------- ----------
$(document).ready(function () {
    $('.tf_m_c_user_nganluong').on('click', '.tf_list_object .tf_object_view', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_user_nganluong.view(object);
    });
});