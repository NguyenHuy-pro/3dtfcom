//=========== =========== ===========  map object =========== =========== ===========
var tf_m_c_sample_project_background = {
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
        //tf_manage_submit.ajaxNotReload(href, '', false);
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
            var imageObject = $(formObject).find("input[name='fileImage']");
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
            var containNotify = $(formObject).find('.tf_frm_notify');
            var imageObject = $(formObject).find("input[name='fileImage']");
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
                    tf_manage_submit.ajaxFormHasReload(formObject, containNotify, true);
                }
            }

        }
    }

}

//----------  Status -----------
$(document).ready(function () {
    $('.tf_m_c_sample_project_background').on('click', '.tf_list_object .tf_object_status', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_sample_project_background.updateStatus(object);
    });
});

//---------- View - Delete -----------
$(document).ready(function () {
    //view
    $('.tf_m_c_sample_project_background').on('click', '.tf_list_object .tf_object_view', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_sample_project_background.view(object);
    });

    //delete
    $('.tf_m_c_sample_project_background').on('click', '.tf_list_object .tf_object_delete', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_sample_project_background.delete(object);
    });
});


//----------  edit info ----------
$(document).ready(function () {
    //get form
    $('.tf_m_c_sample_project_background').on('click', '.tf_list_object .tf_object_edit', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_sample_project_background.edit.get(object);
    });

    //post edit
    $('body').on('click', '.tf_frm_edit .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_edit');
        tf_m_c_sample_project_background.edit.post(formObject);
    });

});

//-----------Add project ----------
$(document).ready(function () {
    // add
    $('.tf_m_c_sample_project_background').on('click', '.tf_frm_add .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_add');
        tf_m_c_sample_project_background.add.save(formObject);
    });

});

