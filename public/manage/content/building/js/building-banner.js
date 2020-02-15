/**
 * Created by HUY on 12/1/2016.
 */
var tf_m_c_building_banner = {
    //View
    view: function (object) {
        var bannerId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-view') + '/' + bannerId;
        tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
        tf_main.tf_scrollTop();
    },

    delete: function (object) {
        if (confirm('Do you to delete this banner?')) {
            var bannerId = $(object).data('object');
            var href = $(object).parents('.tf_list_object').data('href-del') + '/' + bannerId;
            //tf_manage_submit.ajaxNotReloadHasRemove(href, '', false, object);
            tf_manage_submit.ajaxHasReload(href, '', false);
        }
    }
}

$(document).ready(function () {
    //delete banner
    $('.tf_m_c_building_banner').on('click', '.tf_list_object .tf_object_delete', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_building_banner.delete(object);
    });

    //view banner
    $('.tf_m_c_building_banner').on('click', '.tf_list_object .tf_object_view', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_building_banner.view(object);
    });
});