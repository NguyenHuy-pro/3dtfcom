/**
 * Created by HUY on 6/13/2016.
 */

var tf_m_c_system_province = {
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
            var countryObject = $(formObject).find("select[name='cbCountry']");
            var typeObject = $(formObject).find("select[name='cbProvinceType']");
            var nameObject = $(formObject).find("select[name='txtName']");

            if (tf_main.tf_checkInputNull(countryObject, 'Select a country')) {
                return false;
            }
            if (tf_main.tf_checkInputNull(typeObject, 'Select a province type')) {
                return false;
            }
            if (tf_main.tf_checkInputNull(nameObject, 'Enter name')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength('#txtName', 50, 'Limit of name length 50 characters')) {
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
            var countryObject = $(formObject).find("select[name='cbCountry']");
            var typeObject = $(formObject).find("select[name='cbProvinceType']");
            var nameObject = $(formObject).find("select[name='txtName']");

            if (tf_main.tf_checkInputNull(countryObject, 'Select a country')) {
                return false;
            }
            if (tf_main.tf_checkInputNull(typeObject, 'Select a province type')) {
                return false;
            }
            if (tf_main.tf_checkInputNull(nameObject, 'Enter name')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength('#txtName', 50, 'Limit of name length 50 characters')) {
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
            if (tf_main.tf_checkInputNull(staffObject, 'Select a manager')) {
                return false;
            } else {
                tf_manage_submit.ajaxFormHasReload(formObject, containNotify, true);
            }
        }
    }

}

//---------- ---------- ---------- Status ----------- ---------- ----------
$(document).ready(function () {
    $('.tf_m_c_system_province').on('click', '.tf_list_object .tf_object_status', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_system_province.updateStatus(object);
    });
});

//---------- ---------- ---------- View - Delete ----------- ---------- ----------
$(document).ready(function () {
    //view
    $('.tf_m_c_system_province').on('click', '.tf_list_object .tf_object_view', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_system_province.view(object);
    });

    //delete
    $('.tf_m_c_system_province').on('click', '.tf_list_object .tf_object_delete', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_system_province.delete(object);
    });
});


//---------- ---------- ---------- edit info ---------- ---------- ----------
$(document).ready(function () {
    //get form
    $('.tf_m_c_system_province').on('click', '.tf_list_object .tf_object_edit', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_system_province.edit.get(object);
    });

    //post edit
    $('body').on('click', '.tf_frm_edit .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_edit');
        tf_m_c_system_province.edit.post(formObject);
    });

});


//---------- ---------- ---------- get info ---------- ---------- ----------
$(document).ready(function () {
    //filter size from standard
    $('.tf_m_c_system_province').on('change', '.tf_filter_country', function () {
        var url = $(this).data('href');
        var countryId = $(this).val();
        if (countryId != '') url = url + '/' + countryId;
        window.location.replace(url);
    });
});

//---------- ---------- ---------- add new ---------- ---------- ----------
$(document).ready(function () {
    //check add-
    $('.tf_m_c_system_province').on('click', '.tf_frm_add .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_add');
        tf_m_c_system_province.add.save(formObject);
    });
});

//---------- ---------- ---------- build 3d ---------- ---------- ----------
$(document).ready(function () {
    // get form build 3d
    $('.tf_m_c_system_province').on('click', '.tf_list_object .tf_build3d', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_system_province.build3d.get(object);
    });

    //build
    $('body').on('click', '.tf_frm_build3d .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_build3d');
        tf_m_c_system_province.build3d.save(formObject);
    });

});

