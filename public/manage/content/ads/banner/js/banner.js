/**
 * Created by HUY on 6/13/2016.
 */
var tf_m_c_ads_banner = {
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
        getPositionWidth: function (form, href) {
            var displayWidth = $(form).find('.tf_display_width');
            tf_manage_submit.ajaxNotReload(href, displayWidth, true);
        },
        save: function (form) {
            var pageObject = $(form).find("select[name='cbPage']");
            var positionObject = $(form).find("select[name='cbPosition']");
            var heightObject = $(form).find("select[name='cbHeight']");
            var showObject = $(form).find("select[name='cbShow']");

            if (pageObject.val() == 0) {
                alert('Select a page');
                pageObject.focus();
                return false;
            }
            if (positionObject.val() == 0) {
                alert('Select a position');
                positionObject.focus();
                return false;
            }

            if (heightObject.val() == 0) {
                alert('Select height for image');
                heightObject.focus();
                return false;
            }

            if (showObject.val() == 0) {
                alert('Select show number');
                showObject.focus();
                return false;
            }
            if (tf_main.tf_checkInputNull('#imageFile', 'Select an default icon')) {
                return false;
            }
            tf_manage_submit.ajaxFormHasReload(form, '', false);

        }
    },
    edit: {
        get: function (object) {
            var objectId = $(object).data('object');
            var href = $(object).parents('.tf_list_object').data('href-edit') + '/' + objectId;
            tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
            tf_main.tf_scrollTop();
        },
        post: function (form) {
            var containNotify = $(form).find('.tf_frm_notify');
            var showObject = $(form).find("select[name='cbShow']");
            if (showObject.val() == 0) {
                alert('Select show banner');
                showObject.focus();
                return false;
            }

            if (!tf_main.tf_checkInputNull('#imageFile', '')) {
                // check size of image upload
                var limitWidth = $('#imageFile').data('width');
                var limitHeight = $('#imageFile').data('height');
                var uploadWidth = $('#checkFileImage').outerWidth();
                var uploadHeight = $('#checkFileImage').outerHeight();
                if (uploadWidth != limitWidth || uploadHeight != limitHeight) {
                    alert('Wrong image, Request size: (' + limitWidth + ' x ' + limitHeight + ')px, Upload size: (' + uploadWidth + ' x ' + uploadHeight + ')px');
                    $('#imageFile').focus();
                    return false;
                }
            }
            tf_manage_submit.ajaxFormHasReload(form, containNotify, true);
            //tf_manage_submit.ajaxFormNotReload(form, containNotify, true);
        }
    },

}

//---------- ---------- ---------- add new ---------- ---------- ----------
$(document).ready(function () {
    $('.tf_m_c_ads_banner').on('click', '.tf_frm_add .tf_height', function () {
        var form = $(this).parents('.tf_frm_add');
        tf_m_c_ads_banner.add.selectIcon(form);
    });

    $('.tf_m_c_ads_banner').on('change', '.tf_frm_add .tf_position', function () {
        var positionId = $(this).val();
        var href = $(this).data('href') + '/' + positionId;
        var form = $(this).parents('.tf_frm_add');
        tf_m_c_ads_banner.add.getPositionWidth(form, href);
        tf_m_c_ads_banner.add.selectIcon(form);
    });

    $('.tf_m_c_ads_banner').on('click', '.tf_frm_add .tf_save', function () {
        var form = $(this).parents('.tf_frm_add');
        tf_m_c_ads_banner.add.save(form);
    });

});

//---------- ---------- ---------- Status ----------- ---------- ----------
$(document).ready(function () {
    $('.tf_m_c_ads_banner').on('click', '.tf_list_object .tf_object_status', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_ads_banner.updateStatus(object);
    });
});

//---------- ---------- ---------- View - Delete ----------- ---------- ----------
$(document).ready(function () {
    //view
    $('.tf_m_c_ads_banner').on('click', '.tf_list_object .tf_object_view', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_ads_banner.view(object);
    });

    //delete
    $('.tf_m_c_ads_banner').on('click', '.tf_list_object .tf_object_delete', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_ads_banner.delete(object);
    });
});


//---------- ---------- ---------- edit info ---------- ---------- ----------
$(document).ready(function () {
    //get form
    $('.tf_m_c_ads_banner').on('click', '.tf_list_object .tf_object_edit', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_ads_banner.edit.get(object);
    });

    //post edit
    $('body').on('click', '.tf_frm_edit .tf_save', function () {
        var form = $(this).parents('.tf_frm_edit');
        tf_m_c_ads_banner.edit.post(form);
    });

});
