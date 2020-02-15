/**
 * Created by HUY on 6/13/2016.
 */
var tf_m_c_system_country = {
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
            var codeObject = $(formObject).find("input[name='txtCode']");
            var moneyObject = $(formObject).find("input[name='txtMoney']");
            var flagObject = $(formObject).find("input[name='txtFlag']");

            if (tf_main.tf_checkInputNull(nameObject, 'Enter name')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength(nameObject, 30, 'Limit of name length 30 characters')) return false;
            }
            if (tf_main.tf_checkInputNull(codeObject, 'Enter Code of country')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength(codeObject, 10, 'Limit of code length 10 characters')) return false;
            }
            if (tf_main.tf_checkInputNull(moneyObject, 'Enter money unit of country')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength(moneyObject, 20, 'Limit of code length 20 characters')) return false;
            }
            if (tf_main.tf_checkInputNull(flagObject, 'Select flag of country')) {
                return false;
            } else {
                tf_manage_submit.ajaxFormHasReload(formObject, '', false);
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
            var nameObject = $(formObject).find("input[name='txtName']");
            var codeObject = $(formObject).find("input[name='txtCode']");
            var moneyObject = $(formObject).find("input[name='txtMoney']");
            var containNotify = $(formObject).find('.tf_frm_notify');

            if (tf_main.tf_checkInputNull(nameObject, 'Enter name')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength(nameObject, 30, 'Limit of name length 30 characters')) return false;
            }
            if (tf_main.tf_checkInputNull(codeObject, 'Enter Code of country')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength(codeObject, 10, 'Limit of code length 10 characters')) return false;
            }
            if (tf_main.tf_checkInputNull(moneyObject, 'Enter money unit of country')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength(moneyObject, 20, 'Limit of code length 20 characters')) {
                    return false;
                } else {
                    tf_manage_submit.ajaxFormHasReload(formObject, containNotify, true);
                }
            }
        }
    },
    build3d: {
        get: function (object) {
            var objectId = $(object).data('object');
            var href = $(object).parents('.tf_list_object').data('href-build3d') + '/' + objectId;
            tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
            tf_main.tf_scrollTop();
        },
        save: function (formObject) {
            var containNotify = $(formObject).find('.tf_frm_notify');
            var staffObject = $(formObject).find("select[name='cbManager']");
            var provinceObject = $(formObject).find("select[name='cbProvince']");

            if (tf_main.tf_checkInputNull(provinceObject, 'Select a default province')) {
                return false;
            }
            if (tf_main.tf_checkInputNull(staffObject, 'Select a manager')) {
                return false;
            } else {
                tf_manage_submit.ajaxFormHasReload(formObject, containNotify, true);
            }
        }
    }

}

//---------- ---------- ---------- add new ---------- ---------- ----------
$(document).ready(function () {
    $('.tf_m_c_system_country').on('click', '.tf_frm_add .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_add');
        tf_m_c_system_country.add.save(formObject);
    });

});

//---------- ---------- ---------- Status ----------- ---------- ----------
$(document).ready(function () {
    $('.tf_m_c_system_country').on('click', '.tf_list_object .tf_object_status', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_system_country.updateStatus(object);
    });
});

//---------- ---------- ---------- View - Delete ----------- ---------- ----------
$(document).ready(function () {
    //view
    $('.tf_m_c_system_country').on('click', '.tf_list_object .tf_object_view', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_system_country.view(object);
    });

    //delete
    $('.tf_m_c_system_country').on('click', '.tf_list_object .tf_object_delete', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_system_country.delete(object);
    });
});


//---------- ---------- ---------- edit info ---------- ---------- ----------
$(document).ready(function () {
    //get form
    $('.tf_m_c_system_country').on('click', '.tf_list_object .tf_object_edit', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_system_country.edit.get(object);
    });

    //post edit
    $('body').on('click', '.tf_frm_edit .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_edit');
        tf_m_c_system_country.edit.post(formObject);
    });

});

//---------- ---------- ---------- build 3d ---------- ---------- ----------
$(document).ready(function () {
    // get form build 3d
    $('.tf_m_c_system_country').on('click', '.tf_list_object .tf_build3d', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_system_country.build3d.get(object);
    });

    //build
    $('body').on('click', '#frmCountryBuild3d .tf_save', function () {
        var formObject = $(this).parents('#frmCountryBuild3d');
        tf_m_c_system_country.build3d.save(formObject);
    });

});