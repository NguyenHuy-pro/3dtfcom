/**
 * Created by HUY on 6/14/2016.
 */

var tf_m_c_system_department_contact = {
    //View
    view: function (object) {
        var contactId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-view') + '/' + contactId;
        tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
        tf_main.tf_scrollTop();
    },

    //delete
    delete: function (object) {
        if (confirm('Do you to delete this record?')) {
            var contactId = $(object).data('object');
            var href = $(object).parents('.tf_list_object').data('href-del') + '/' + contactId;
            tf_manage_submit.ajaxHasReload(href, '', false);
        }
    },
    add: {
        save: function (formObject) {
            var departmentObject = $(formObject).find("select[name='cbDepartment']")
            var emailObject = $(formObject).find("input[name='txtEmail']");
            var phoneObject = $(formObject).find("input[name='txtPhone']");

            if (tf_main.tf_checkInputNull(departmentObject, 'Select a department')) {
                return false;
            }

            if (tf_main.tf_checkInputNull(emailObject, 'Enter email')) {
                return false;
            } else {
                if (!tf_main.tf_checkEmail(emailObject.val())) {
                    alert('Email invalid')
                    emailObject.focus();
                    return false;
                }
            }
            if (tf_main.tf_checkInputNull(phoneObject, 'Enter phone number')) {
                return false;
            } else {
                tf_manage_submit.ajaxFormHasReload(formObject, '', false);
            }

        }
    },
    edit: {
        get: function (object) {
            var contactId = $(object).data('object');
            var href = $(object).parents('.tf_list_object').data('href-edit') + '/' + contactId;
            tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
            tf_main.tf_scrollTop();
        },
        post: function (formObject) {
            var departmentObject = $(formObject).find("select[name='cbDepartment']")
            var emailObject = $(formObject).find("input[name='txtEmail']");
            var phoneObject = $(formObject).find("input[name='txtPhone']");
            var containNotify = $(formObject).find('.tf_frm_notify');
            if (tf_main.tf_checkInputNull(departmentObject, 'Select a department')) {
                return false;
            }

            if (tf_main.tf_checkInputNull(emailObject, 'Enter email')) {
                return false;
            } else {
                if (!tf_main.tf_checkEmail(emailObject.val())) {
                    alert('Email invalid')
                    emailObject.focus();
                    return false;
                }
            }
            if (tf_main.tf_checkInputNull(phoneObject, 'Enter phone number')) {
                return false;
            } else {
                tf_manage_submit.ajaxFormHasReload(formObject, containNotify, true);
            }
        }
    },

}

//---------- ---------- ---------- add new ---------- ---------- ----------
$(document).ready(function () {
    $('.tf_m_c_system_department_contact').on('click', '.tf_frm_add .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_add');
        tf_m_c_system_department_contact.add.save(formObject);
    });

});


//---------- ---------- ---------- View - Delete ----------- ---------- ----------
$(document).ready(function () {
    //view
    $('.tf_m_c_system_department_contact').on('click', '.tf_list_object .tf_object_view', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_system_department_contact.view(object);
    });

    //delete user
    $('.tf_m_c_system_department_contact').on('click', '.tf_list_object .tf_object_delete', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_system_department_contact.delete(object);
    });
});


//---------- ---------- ---------- edit info ---------- ---------- ----------
$(document).ready(function () {
    //get form
    $('.tf_m_c_system_department_contact').on('click', '.tf_list_object .tf_object_edit', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_system_department_contact.edit.get(object);
    });

    //post edit
    $('body').on('click', '.tf_frm_edit .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_edit');
        tf_m_c_system_department_contact.edit.post(formObject);
    });

});
