/**
 * Created by HUY on 7/9/2016.
 */
var tf_m_c_sample_land_request_build_design = {
    //View
    view: function (object) {
        var objectId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-view') + '/' + objectId;
        tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
        tf_main.tf_scrollTop();
    },
    design: {
        get: function (object) {
            var objectId = $(object).data('object');
            var href = $(object).parents('.tf_list_object').data('href-upload') + '/' + objectId;
            //alert(href);
            tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
            tf_main.tf_scrollTop();
        },
        post: function (form) {
            //var size = $(form).find("select[name= 'cbSize']");
            var imageObject = $(form).find("input[name='fileImage']");
            if (tf_main.tf_checkInputNull(imageObject, 'Select a sample image')) {
                return false;
            } else {
                var limitWidth = imageObject.data('width');
                var limitHeight = imageObject.data('height');
                var checkWidth = $('#checkImgSize').outerWidth();
                var checkHeight = $('#checkImgSize').outerHeight();
                if (checkWidth != limitWidth || checkHeight != limitHeight) {
                    alert('Wrong image, Request size:(' + limitWidth + ' x ' + limitHeight + ')px, Upload size:(' + checkWidth + ' x ' + checkHeight + ')px');
                    imageObject.focus();
                    return false;
                } else {
                    tf_manage_submit.ajaxFormHasReload(form, '', false);
                }

            }
        }
    },
    publish: function (object, confirmStatus) {
        var objectId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-publish') + '/' + objectId + '/' + confirmStatus;
        //var notifyContent = '';
        if (confirmStatus == 'y') notifyContent = 'Do you agree publish this design';
        if (confirmStatus == 'n') notifyContent = 'Do you not agree publish this design';
        if (confirm(notifyContent)) {
            //tf_manage_submit.ajaxHasReload(href, '', false);
            tf_manage_submit.ajaxNotReload(href, '', false);
        }
    }

}

//---------- ---------- ---------- View ----------- ---------- ----------
$(document).ready(function () {
    //view
    $('.tf_m_c_sample_land_request_build_design').on('click', '.tf_list_object .tf_object_view', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_sample_land_request_build_design.view(object);
    });
});

//---------- ---------- ---------- design assignment ----------- ---------- ----------
$(document).ready(function () {
    //get
    $('.tf_m_c_sample_land_request_build_design').on('click', '.tf_list_object .tf_design_upload', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_sample_land_request_build_design.design.get(object);
    });

    //save
    $('body').on('click', '.tf_frm_build_design_upload .tf_save', function () {
        var form = $(this).parents('.tf_frm_build_design_upload');
        tf_m_c_sample_land_request_build_design.design.post(form);
    });
});

//---------- ---------- ---------- publish ----------- ---------- ----------
$(document).ready(function () {
    $('.tf_m_c_sample_land_request_build_design').on('click', '.tf_list_object .tf_design_publish', function () {
        var object = $(this).parents('.tf_object');
        var confirmStatus = $(this).data('publish');
        tf_m_c_sample_land_request_build_design.publish(object, confirmStatus);
    });
});
