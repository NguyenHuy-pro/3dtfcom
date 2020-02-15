/**
 * Created by HUY on 12/8/2016.
 */
var tf_m_c_system_advisory = {
    //View
    view: function (object) {
        var advisoryId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-view') + '/' + advisoryId;
        tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
        tf_main.tf_scrollTop();
    },

    //delete
    delete: function (object) {
        if(confirm('Do you to delete this advisory?')){
            var advisoryId = $(object).data('object');
            var href = $(object).parents('.tf_list_object').data('href-del') + '/' + advisoryId;
            tf_manage_submit.ajaxHasReload(href, '', false);
        }
    }
}

//---------- ---------- ---------- Action ----------- ---------- ----------
$(document).ready(function () {
    //view
    $('.tf_m_c_system_advisory').on('click', '.tf_list_object .tf_object_view', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_system_advisory.view(object);
    });

    //delete
    $('.tf_m_c_system_advisory').on('click', '.tf_list_object .tf_object_delete', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_system_advisory.delete(object);
    });
});