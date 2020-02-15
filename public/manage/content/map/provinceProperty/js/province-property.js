/**
 * Created by HUY on 12/3/2016.
 */
var tf_m_c_map_province_property = {
    //View
    view: function (object) {
        var propertyId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-view') + '/' + propertyId;
        tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
        tf_main.tf_scrollTop();
    },
}

$(document).ready(function () {
    //view share
    $('.tf_m_c_map_province_property').on('click', '.tf_list_object .tf_object_view', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_map_province_property.view(object);
    });
});
