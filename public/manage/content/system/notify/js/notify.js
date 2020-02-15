/**
 * Created by HUY on 6/14/2016.
 */
var tf_m_c_system_notify = {
    //View
    view: function (object) {
        var objectId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-view') + '/' + objectId;
        tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
        tf_main.tf_scrollTop();
    },

    //add new
    addNew: {
        postAdd: function (formObject) {
            var nameObject = $(formObject).find("input[name='txtName']");
            var contentObject = $(formObject).find("textarea[name='txtContent']");
            if (tf_main.tf_checkInputNull(nameObject, 'Enter name')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength(nameObject, 100, 'max length of name is 100 characters.')) return false;
            }
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
            var content = contentObject.val();
            if (content.length == 0) {
                alert('Enter content');
                contentObject.focus();
                return false;
            } else {
                tf_manage_submit.ajaxFormHasReload(formObject, '', false);
            }
        }
    },

    //edit info
    editInfo: {
        get: function (object) {
            var objectId = $(object).data('object');
            var href = $(object).parents('.tf_list_object').data('href-edit') + '/' + objectId;
            tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
            tf_main.tf_scrollTop();
        },

        post: function (formObject) {
            var nameObject = $(formObject).find("input[name='txtName']");
            var contentObject = $(formObject).find("textarea[name='txtContent']");
            var containNotify = $(formObject).find('.tf_frm_notify');
            if (tf_main.tf_checkInputNull(nameObject, 'Enter name')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength(nameObject, 100, 'max length of name is 100 characters.')) return false;
            }
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
            var content = contentObject.val();
            if (content.length == 0) {
                alert('Enter content');
                contentObject.focus();
                return false;
            } else {
                tf_manage_submit.ajaxFormHasReload(formObject, containNotify, true);
            }
        }
    },
    //delete
    delete: function (object) {
        if (confirm('Do you to delete this record?')) {
            var objectId = $(object).data('object');
            var href = $(object).parents('.tf_list_object').data('href-del') + '/' + objectId;
            tf_manage_submit.ajaxHasReload(href, '', false);
        }
    },
}

//---------- ---------- ---------- View - Delete ----------- ---------- ----------
$(document).ready(function () {
    //view
    $('.tf_m_c_system_notify').on('click', '.tf_list_object .tf_object_view', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_system_notify.view(object);
    });

    //delete
    $('.tf_m_c_system_notify').on('click', '.tf_list_object .tf_object_delete', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_system_notify.delete(object);
    });
});


//---------- ---------- ---------- add new ---------- ---------- ----------
$(document).ready(function () {
    //---------- ---------- check add ---------- ----------
    $('.tf_m_c_system_notify').on('click', '.tf_frm_add .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_add');
        tf_m_c_system_notify.addNew.postAdd(formObject);
    });
});


//---------- ---------- ---------- edit info ---------- ---------- ----------
$(document).ready(function () {
    //get form
    $('.tf_m_c_system_notify').on('click', '.tf_list_object .tf_object_edit', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_system_notify.editInfo.get(object);
    });

    //post edit
    $('body').on('click', '.tf_frm_edit .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_edit');
        tf_m_c_system_notify.editInfo.post(formObject);
    });

});
