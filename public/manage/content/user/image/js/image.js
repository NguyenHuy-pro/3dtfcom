/**
 * Created by HUY on 7/2/2016.
 */
var tf_m_c_user_image= {
    //View
    view: function (object) {
        var imageId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-view') + '/' + imageId;
        tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
        tf_main.tf_scrollTop();
    },
    //delete
    delete: function (object) {
        if(confirm('Do you to delete this image?')){
            var imageId = $(object).data('object');
            var href = $(object).parents('.tf_list_object').data('href-del') + '/' + imageId;
            tf_manage_submit.ajaxHasReload(href, '', false);
        }
    }
}

//---------- ---------- ---------- View - Delete ----------- ---------- ----------
$(document).ready(function () {
    //view
    $('.tf_m_c_user_image').on('click', '.tf_list_object .tf_object_view', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_user_image.view(object);
    });

    //delete user
    $('.tf_m_c_user_image').on('click', '.tf_list_object .tf_object_delete', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_user_image.delete(object);
    });
});

