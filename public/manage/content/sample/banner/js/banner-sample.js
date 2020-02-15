/**
 * Created by HUY on 6/16/2016.
 */
var tf_m_c_sample_banner = {
    //View
    view: function (object) {
        var objectId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-view') + '/' + objectId;
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
        if (confirm('Do you to delete this record?')) {
            var objectId = $(object).data('object');
            var href = $(object).parents('.tf_list_object').data('href-del') + '/' + objectId;
            tf_manage_submit.ajaxHasReload(href, '', false);
        }
    },
    add: {
        save: function (formObject) {
            var borderObject = $(formObject).find("input[name='txtBorder']");
            var sizeObject = $(formObject).find("select[name='cbSize']");
            var imageObject = $(formObject).find("input[name='fileImage']");

            if (tf_main.tf_checkInputNull(borderObject, 'Enter a border')) {
                return false;
            }
            if (tf_main.tf_checkInputNull(sizeObject, 'select a standard size')) {
                return false;
            }
            if (tf_main.tf_checkInputNull(imageObject, 'Select a sample image')) {
                return false;
            } else {
                var limitWidth = $('#fileImage').data('width');
                var limitHeight = $('#fileImage').data('height');
                var checkWidth = $('#checkImgSize').outerWidth();
                var checkHeight = $('#checkImgSize').outerHeight();
                if (checkWidth != limitWidth || checkHeight != limitHeight) {
                    alert('Wrong image, Request size:(' + limitWidth + ' x ' + limitHeight + ')px, Upload size:(' + checkWidth + ' x ' + checkHeight + ')px');
                    $('#fileImage').focus();
                    return false;
                } else {
                    tf_manage_submit.ajaxFormHasReload(formObject, '', false);
                }

            }

        }
    },
    edit: {
        get: function (object) {
            var objectId = $(object).data('object');
            var href = $(object).parents('.tf_list_object').data('href-edit') + '/' + objectId;
            tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
            tf_main.tf_scrollTop();
        },
        post: function (formObject) {
            var borderObject = $(formObject).find("input[name='txtBorder']");
            var containNotify = $(formObject).find('.tf_frm_notify');
            if (tf_main.tf_checkInputNull(borderObject, 'Enter a border')) {
                return false;
            }
            if (!tf_main.tf_checkInputNull('#fileImage', '')) {
                var limitWidth = $('#fileImage').data('width');
                var limitHeight = $('#fileImage').data('height');
                var checkWidth = $('#checkImgSize').outerWidth();
                var checkHeight = $('#checkImgSize').outerHeight();
                if (checkWidth != limitWidth || checkHeight != limitHeight) {
                    alert('Wrong image, Upload size:(' + checkWidth + ' x ' + checkHeight + ')px, Request size:(' + limitWidth + ' x ' + limitHeight + ')px');
                    $('#fileImage').focus();
                    return false;
                }
            }
            tf_manage_submit.ajaxFormHasReload(formObject, containNotify, true);
        }
    },

}

//---------- ---------- ---------- Status ----------- ---------- ----------
$(document).ready(function () {
    $('.tf_m_c_sample_banner').on('click', '.tf_list_object .tf_object_status', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_sample_banner.updateStatus(object);
    });
});

//---------- ---------- ---------- View - Delete ----------- ---------- ----------
$(document).ready(function () {
    //view
    $('.tf_m_c_sample_banner').on('click', '.tf_list_object .tf_object_view', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_sample_banner.view(object);
    });

    //delete
    $('.tf_m_c_sample_banner').on('click', '.tf_list_object .tf_object_delete', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_sample_banner.delete(object);
    });
});


//---------- ---------- ---------- edit info ---------- ---------- ----------
$(document).ready(function () {
    //get form
    $('.tf_m_c_sample_banner').on('click', '.tf_list_object .tf_object_edit', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_sample_banner.edit.get(object);
    });

    //post edit
    $('body').on('click', '.tf_frm_edit .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_edit');
        tf_m_c_sample_banner.edit.post(formObject);
    });

});

//---------- ---------- ---------- add new ---------- ---------- ----------
$(document).ready(function () {
    //select size
    $('.tf_m_c_sample_banner').on('change', '.tf_frm_add .tf_select_size', function () {
        var sizeId = $(this).val();
        var contentImage = $('.tf_m_c_sample_banner').find('.tf_frm_add  .tf_select_image');
        contentImage.empty();
        if (sizeId != '') {
            var u = $(this).data('href');
            var token = $("form[name='frmBannerSampleAdd']").find("input[name='_token']").val();
            $.ajax({
                url: u + '/' + sizeId,
                type: 'GET',
                cache: false,
                data: {"_token": token, 'id': sizeId},
                success: function (data) {
                    if (data) {
                        contentImage.append(data);
                    }
                }
            });
        }
    });

    // add
    $('.tf_m_c_sample_banner').on('click', '.tf_frm_add .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_add');
        tf_m_c_sample_banner.add.save(formObject);
    });
});
