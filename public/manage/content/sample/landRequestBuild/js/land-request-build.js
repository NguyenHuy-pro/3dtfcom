/**
 * Created by HUY on 7/9/2016.
 */
var tf_m_c_sample_land_request_build = {
    //View
    view: function (object) {
        var objectId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-view') + '/' + objectId;
        tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
        tf_main.tf_scrollTop();
    },
    assignment: {
        get: function (object) {
            var objectId = $(object).data('object');
            var href = $(object).parents('.tf_list_object').data('href-assignment') + '/' + objectId;
            tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
            tf_main.tf_scrollTop();
        },
        post: function (form) {
            var designer = $(form).find("select[name= 'cbDesigner']");
            var size = $(form).find("select[name= 'cbSize']");

            if (tf_main.tf_checkInputNull(designer, 'Select a designer')) {
                return false;
            }
            if (tf_main.tf_checkInputNull(size, 'Select a standard size')) {
                return false;
            }else{
                tf_manage_submit.ajaxFormHasReload(form,'', false);
            }
        }
    }

}

//---------- ---------- ---------- View ----------- ---------- ----------
$(document).ready(function () {
    //view
    $('.tf_m_c_sample_land_request_build').on('click', '.tf_list_object .tf_object_view', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_sample_land_request_build.view(object);
    });
});

//---------- ---------- ---------- design assignment ----------- ---------- ----------
$(document).ready(function () {
    //get
    $('.tf_m_c_sample_land_request_build').on('click', '.tf_list_object .tf_design_assignment', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_sample_land_request_build.assignment.get(object);
    });
    //save
    $('body').on('click', '.tf_frm_design_assignment .tf_save', function () {
        var form = $(this).parents('.tf_frm_design_assignment');
        tf_m_c_sample_land_request_build.assignment.post(form);
    });
});
