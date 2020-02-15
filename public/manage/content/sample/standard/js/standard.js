/**
 * Created by HUY on 6/16/2016.
 */
var tf_m_c_sample_standard = {

    //status
    updateStatus: function (object) {
        var typeId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-status') + '/' + typeId;
        tf_manage_submit.ajaxHasReload(href, '', false);
    },
};


//---------- ---------- ---------- Status ----------- ---------- ----------
$(document).ready(function () {
    $('.tf_m_c_sample_standard').on('click', '.tf_list_object .tf_object_status', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_sample_standard.updateStatus(object);
    });
});
