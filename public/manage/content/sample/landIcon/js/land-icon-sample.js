/**
 * Created by HUY on 7/9/2016.
 */
var tf_m_c_sample_land_icon = {
    //View
    view: function (object) {
        var objectId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-view') + '/' + objectId;
        tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
        tf_main.tf_scrollTop();
    },
    add: {
        save: function (formObject) {
            var imageObject = $(formObject).find("input[name='fileImage']");
            var sizeObject = $(formObject).find("select[name='cbSize']");
            if (tf_main.tf_checkInputNull(sizeObject, 'select a standard size')) {
                return false;
            }

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
            var imageObject = $(formObject).find("input[name='fileImage']");
            var containNotify = $(formObject).find('.tf_frm_notify');
            if (!tf_main.tf_checkInputNull(imageObject, '')) {
                var limitWidth = imageObject.data('width');
                var limitHeight = imageObject.data('height');
                var checkWidth = $('#checkImgSize').outerWidth();
                var checkHeight = $('#checkImgSize').outerHeight();
                if (checkWidth != limitWidth || checkHeight != limitHeight) {
                    alert('Wrong image, Upload size:(' + checkWidth + ' x ' + checkHeight + ')px, Request size:(' + limitWidth + ' x ' + limitHeight + ')px');
                    imageObject.focus();
                    return false;
                }
            }
            tf_manage_submit.ajaxFormHasReload(formObject, containNotify, true);
        }
    },

}

//---------- ---------- ---------- View ----------- ---------- ----------
$(document).ready(function () {
    //view
    $('.tf_m_c_sample_land_icon').on('click', '.tf_list_object .tf_object_view', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_sample_land_icon.view(object);
    });
});


//---------- ---------- ---------- edit info ---------- ---------- ----------
$(document).ready(function () {
    //get form
    $('.tf_m_c_sample_land_icon').on('click', '.tf_list_object .tf_object_edit', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_sample_land_icon.edit.get(object);
    });

    //post edit
    $('body').on('click', '.tf_frm_edit .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_edit');
        tf_m_c_sample_land_icon.edit.post(formObject);
    });

});

//---------- ---------- ---------- add new ---------- ---------- ----------
$(document).ready(function () {
    //select size
    $('.tf_m_c_sample_land_icon').on('change', '.tf_frm_add .tf_select_size', function () {
        var sizeId = $(this).val();
        var contentImage = $('.tf_m_c_sample_land_icon').find('.tf_frm_add  .tf_select_image');
        contentImage.empty();
        if (sizeId != '') {
            var u = $(this).data('href');
            var token = $("form[name='tf_frm_add']").find("input[name='_token']").val();
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
    $('.tf_m_c_sample_land_icon').on('click', '.tf_frm_add .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_add');
        tf_m_c_sample_land_icon.add.save(formObject);
    });
});

//===============================================
//---------- ---------- ---------- add new ---------- ---------- ----------
$(document).ready(function () {
    // select size
    $('.tf-m-c-land-icon-sample-select-size-a').on('change', function () {
        var sizeID = $(this).val();
        $('#tf_m_c_land_icon_sample_select_image').empty();
        if (sizeID != '') {
            var u = $(this).data('href');
            var token = $("form[name='frmLandIconSampleAdd']").find("input[name='_token']").val();
            $.ajax({
                url: u + '/' + sizeID,
                type: 'GET',
                cache: false,
                data: {"_token": token, 'id': sizeID},
                success: function (data) {
                    if (data) {
                        $('#tf_m_c_land_icon_sample_select_image').append(data);
                    }
                }
            });
        }
    });

    // check add
    $('.tf-m-c-land-icon-sample-add-a').on('click', function () {
        if (tf_main.tf_checkInputNull('#cbSize', 'select a standard size')) {
            return false;
        }
        if (tf_main.tf_checkInputNull('#fileImage', 'Select a sample image')) {
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
            }
        }
        if (tf_main.tf_checkInputNull('#cbTransactionStatus', 'select a transaction status')) {
            return false;
        }
        if (tf_main.tf_checkInputNull('#cbOwnStatus', 'select an own status')) {
            return false;
        }
    });
});
