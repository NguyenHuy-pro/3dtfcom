/**
 * Created by HUY on 6/15/2016.
 */
var tf_m_c_system_convert_point = {
    //View
    view: function (object) {
        var objectId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-view') + '/' + objectId;
        tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
        tf_main.tf_scrollTop();
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
            var typeObject = $(formObject).find("select[name='cbConvertType']");
            var pointObject = $(formObject).find("input[name='txtPoint']");
            var convertObject = $(formObject).find("input[name='txtConvertValue']");

            if(tf_main.tf_checkInputNull(typeObject,'Select a point type')){
                return false;
            }
            if(tf_main.tf_checkInputNull(pointObject,'Enter point ')){
                return false;
            }
            if(tf_main.tf_checkInputNull(convertObject,'Enter convert point')){
                return false;
            }else{
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
            var containNotify = $(formObject).find('.tf_frm_notify');
            var pointObject = $(formObject).find("input[name='txtPoint']");
            var convertObject = $(formObject).find("input[name='txtConvertValue']");

            if(tf_main.tf_checkInputNull(pointObject,'Enter point ')){
                return false;
            }
            if(tf_main.tf_checkInputNull(convertObject,'Enter convert point')){
                return false;
            }else{
                tf_manage_submit.ajaxFormHasReload(formObject, containNotify, true);
            }

        }
    },

}

//---------- ---------- ---------- View - Delete ----------- ---------- ----------
$(document).ready(function () {
    //view
    $('.tf_m_c_system_convert_point').on('click', '.tf_list_object .tf_object_view', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_system_convert_point.view(object);
    });

    //delete
    $('.tf_m_c_system_convert_point').on('click', '.tf_list_object .tf_object_delete', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_system_convert_point.delete(object);
    });
});


//---------- ---------- ---------- edit info ---------- ---------- ----------
$(document).ready(function () {
    //get form
    $('.tf_m_c_system_convert_point').on('click', '.tf_list_object .tf_object_edit', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_system_convert_point.edit.get(object);
    });

    //post edit
    $('body').on('click', '.tf_frm_edit .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_edit');
        tf_m_c_system_convert_point.edit.post(formObject);
    });

});

//---------- ---------- ---------- add new ---------- ---------- ----------
$(document).ready(function () {
    //check add-
    $('.tf_m_c_system_convert_point').on('click', '.tf_frm_add .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_add');
        tf_m_c_system_convert_point.add.save(formObject);
    });
});