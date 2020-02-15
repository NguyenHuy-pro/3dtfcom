/**
 * Created by HUY on 6/14/2016.
 */
var tf_m_c_system_business = {
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
            var typeObject = $(formObject).find("select[name='cbBusinessType']");
            var nameObject = $(formObject).find("input[name='txtName']");

            if (tf_main.tf_checkInputNull(typeObject, 'Select business type')) {
                return false;
            }

            if (tf_main.tf_checkInputNull(nameObject, 'Enter name')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength(nameObject, 50, 'Limit of name length 50 characters')) {
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
            var nameObject = $(formObject).find("input[name='txtName']");

            if (tf_main.tf_checkInputNull(nameObject, 'Enter name')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength(nameObject, 50, 'Limit of name length 50 characters')) {
                    return false;
                } else {
                    tf_manage_submit.ajaxFormHasReload(formObject, containNotify, true);
                }
            }
        }
    },

}

//---------- ---------- ---------- Status ----------- ---------- ----------
$(document).ready(function () {
    $('.tf_m_c_system_business').on('click', '.tf_list_object .tf_object_status', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_system_business.updateStatus(object);
    });
});

//---------- ---------- ---------- View - Delete ----------- ---------- ----------
$(document).ready(function () {
    //view
    $('.tf_m_c_system_business').on('click', '.tf_list_object .tf_object_view', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_system_business.view(object);
    });

    //delete
    $('.tf_m_c_system_business').on('click', '.tf_list_object .tf_object_delete', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_system_business.delete(object);
    });
});


//---------- ---------- ---------- edit info ---------- ---------- ----------
$(document).ready(function () {
    //get form
    $('.tf_m_c_system_business').on('click', '.tf_list_object .tf_object_edit', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_system_business.edit.get(object);
    });

    //post edit
    $('body').on('click', '.tf_frm_edit .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_edit');
        tf_m_c_system_business.edit.post(formObject);
    });

});


//---------- ---------- ---------- get info ---------- ---------- ----------
$(document).ready(function () {
    //filter
    $('.tf_m_c_system_business').on('change', '.tf_filter_business_type', function () {
        var url = $(this).data('href');
        var typeId = $(this).val();
        if (typeId != '') url = url + '/' + typeId;
        window.location.replace(url);
    });
});

//---------- ---------- ---------- add new ---------- ---------- ----------
$(document).ready(function () {
    //check add-
    $('.tf_m_c_system_business').on('click', '.tf_frm_add .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_add');
        tf_m_c_system_business.add.save(formObject);
    });
});
