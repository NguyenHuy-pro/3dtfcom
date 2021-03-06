/**
 * Created by HUY on 6/30/2016.
 */
var tf_m_c_system_link_run = {
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
            var nameObject = $(formObject).find("input[name='txtName']");
            var descriptionObject = $(formObject).find("textarea[name='txtDescription']");

            if (tf_main.tf_checkInputNull(descriptionObject, 'Enter description')) {
                return false;
            }

            if (tf_main.tf_checkInputNull(nameObject, 'Enter name')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength(nameObject, 100, 'Max length of first name is 30 characters')) return false;
            }
            tf_manage_submit.ajaxFormHasReload(formObject, '', false);

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
            var nameObject = $(formObject).find("input[name='txtName']");
            var descriptionObject = $(formObject).find("textarea[name='txtDescription']");
            var descriptionObject = $(formObject).find("textarea[name='txtDescription']");

            if (tf_main.tf_checkInputNull(descriptionObject, 'Enter description')) {
                return false;
            }

            if (tf_main.tf_checkInputNull(nameObject, 'Enter name')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength(nameObject, 100, 'Max length of first name is 30 characters')) {
                    return false;
                } else {
                    tf_manage_submit.ajaxFormHasReload(formObject, containNotify, true);
                }
            }
        }
    },

}

//---------- ---------- ---------- add new ---------- ---------- ----------
$(document).ready(function () {
    $('.tf_m_c_system_link_run').on('click', '.tf_frm_add .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_add');
        tf_m_c_system_link_run.add.save(formObject);
    });

});

//---------- ---------- ---------- Status ----------- ---------- ----------
$(document).ready(function () {
    $('.tf_m_c_system_link_run').on('click', '.tf_list_object .tf_object_status', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_system_link_run.updateStatus(object);
    });
});

//---------- ---------- ---------- View - Delete ----------- ---------- ----------
$(document).ready(function () {
    //view
    $('.tf_m_c_system_link_run').on('click', '.tf_list_object .tf_object_view', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_system_link_run.view(object);
    });

    //delete
    $('.tf_m_c_system_link_run').on('click', '.tf_list_object .tf_object_delete', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_system_link_run.delete(object);
    });
});


//---------- ---------- ---------- edit info ---------- ---------- ----------
$(document).ready(function () {
    //get form
    $('.tf_m_c_system_link_run').on('click', '.tf_list_object .tf_object_edit', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_system_link_run.edit.get(object);
    });

    //post edit
    $('body').on('click', '.tf_frm_edit .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_edit');
        tf_m_c_system_link_run.edit.post(formObject);
    });

});
