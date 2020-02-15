/**
 * Created by HUY on 8/8/2016.
 */
var tf_m_c_user_image_type = {

    add: function (formObject) {
        var nameObject = $(formObject).find("input[name='txtName']");
        if (tf_main.tf_checkInputNull(nameObject, 'Enter name')) {
            return false;
        }else{
            if(tf_main.tf_checkInputMaxLength(nameObject, 30, 'Max length of name is 30 character')){
                return false;
            }else{
                tf_manage_submit.ajaxFormHasReload(formObject, '', false);
            }
        }
    },
    //View
    view: function (object) {
        var typeId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-view') + '/' + typeId;
        tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
        tf_main.tf_scrollTop();
    },
    //edit info
    editInfo: {
        get: function (object) {
            var typeId = $(object).data('object');
            var href = $(object).parents('.tf_list_object').data('href-edit') + '/' + typeId;
            tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
            tf_main.tf_scrollTop();
        },

        post: function (formObject) {
            var nameObject = $(formObject).find("input[name='txtName']");
            var containNotify = $(formObject).find('.tf_frm_notify');
            if (tf_main.tf_checkInputNull(nameObject, 'Enter name')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength(nameObject, 30, 'max length of name is 100 characters.')){
                    return false;
                }else{
                    tf_manage_submit.ajaxFormHasReload(formObject, containNotify, true);
                }
            }
        }
    },
    //delete
    delete: function (object) {
        if(confirm('Do you to delete this type?')){
            var typeId = $(object).data('object');
            var href = $(object).parents('.tf_list_object').data('href-del') + '/' + typeId;
            tf_manage_submit.ajaxHasReload(href, '', false);
        }
    }
}

//---------- ---------- ---------- View - Delete----------- ---------- ----------
$(document).ready(function () {
    //view
    $('.tf_m_c_user_image_type').on('click', '.tf_list_object .tf_object_view', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_user_image_type.view(object);
    });

    //delete
    $('.tf_m_c_user_image_type').on('click', '.tf_list_object .tf_object_delete', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_user_image_type.delete(object);
    });
});

//---------- ---------- ---------- Add ----------- ---------- ----------
$(document).ready(function () {

    //view
    $('.tf_m_c_user_image_type').on('click', '.tf_frm_add .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_add');
        tf_m_c_user_image_type.add(formObject);
    });
});

//---------- ---------- ---------- edit info ---------- ---------- ----------
$(document).ready(function () {
    //get form
    $('.tf_m_c_user_image_type').on('click', '.tf_list_object .tf_object_edit', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_user_image_type.editInfo.get(object);
    });

    //post edit
    $('body').on('click', '.tf_frm_edit .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_edit');
        tf_m_c_user_image_type.editInfo.post(formObject);
    });

});