/**
 * Created by HUY on 4/15/2016.
 */
var tf_m_build_building = {
    landID: '',
    actionHref: '',
    action_get: function () {
        var href = this.actionHref;
        tf_m_build_submit.ajaxNotReload(href, '#tf_m_build_wrapper', false);
    }
}

//----------- ----------- event of mouse on building ----------- -----------
$(document).ready(function () {
    $('body').on('mouseover', '.tf_m_build_building', function () {
        $(this).children('.tf_m_build_building_name_wrap').addClass('tf-bg-white');
        //show menu of building
        tf_main.tf_show($(this).children('.tf_m_build_building_menu'));

    }).on('mouseout', '.tf_m_build_building', function () {
        $(this).children('.tf_m_build_building_name_wrap').removeClass('tf-bg-white');
        //hide menu of building
        tf_main.tf_hide($(this).children('.tf_m_build_building_menu'));
    });
});
