/**
 * Created by HUY on 12/3/2016.
 */
var tf_m_c_map_banner_license = {
    //View
    view: function (object) {
        var licenseId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-view') + '/' + licenseId;
        tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
        tf_main.tf_scrollTop();
    },
}

$(document).ready(function () {
    //view share
    $('.tf_m_c_map_banner_license').on('click', '.tf_list_object .tf_object_view', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_map_banner_license.view(object);
    });
});
