/**
 * Created by HUY on 12/3/2016.
 */
var tf_m_c_map_project = {
    //View
    view: function (object) {
        var projectId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-view') + '/' + projectId;
        tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
        tf_main.tf_scrollTop();
    },

    //status
    updateStatus: function (object) {
        var objectId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-status') + '/' + objectId;
        tf_manage_submit.ajaxHasReload(href, '', false);
    },

    //delete
    delete: function (object) {
        if(confirm('Do you to delete this project?')){
            var projectId = $(object).data('object');
            var href = $(object).parents('.tf_list_object').data('href-del') + '/' + projectId;
            tf_manage_submit.ajaxHasReload(href, '', false);
        }
    }
}

//---------- ---------- ---------- Status ----------- ---------- ----------
$(document).ready(function () {
    $('.tf_m_c_map_project').on('click', '.tf_list_object .tf_object_status', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_map_project.updateStatus(object);
    });
});

$(document).ready(function () {
    //view
    $('.tf_m_c_map_project').on('click', '.tf_list_object .tf_object_view', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_map_project.view(object);
    });

    //delete
    $('.tf_m_c_map_project').on('click', '.tf_list_object .tf_object_delete', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_map_project.delete(object);
    });
});
