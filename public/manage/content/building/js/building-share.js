/**
 * Created by HUY on 12/2/2016.
 */
var tf_m_c_building_share = {
    //View
    view: function (object) {
        var shareId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-view') + '/' + shareId;
        tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
        tf_main.tf_scrollTop();
    },
}

$(document).ready(function () {
    //view share
    $('.tf_m_c_building_share').on('click', '.tf_list_object .tf_object_view', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_building_share.view(object);
    });
});
