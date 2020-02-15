/**
 * Created by HUY on 6/14/2016.
 */
var tf_m_c_map_about = {
    //View
    view: function (object) {
        var advisoryId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-view') + '/' + advisoryId;
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
                tf_manage_submit.normalForm(formObject);
            }
        }
    },

    //edit info
    editInfo: {
        get: function (object) {
            var aboutId = $(object).data('object');
            var href = $(object).parents('.tf_list_object').data('href-edit') + '/' + aboutId;
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
    }
}

//---------- ---------- ---------- View ----------- ---------- ----------
$(document).ready(function () {
    //view
    $('.tf_m_c_system_about').on('click', '.tf_list_object .tf_object_view', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_map_about.view(object);
    });
});


//---------- ---------- ---------- add new ---------- ---------- ----------
$(document).ready(function () {
    //---------- ---------- check add ---------- ----------
    $('.tf_m_c_system_about').on('click', '.tf_frm_add .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_add');
        tf_m_c_map_about.addNew.postAdd(formObject);
    });
});


//---------- ---------- ---------- edit info ---------- ---------- ----------
$(document).ready(function () {
    //get form
    $('.tf_m_c_system_about').on('click', '.tf_list_object .tf_object_edit', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_map_about.editInfo.get(object);
    });

    //post edit
    $('body').on('click', '.tf_frm_edit .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_edit');
        tf_m_c_map_about.editInfo.post(formObject);
    });

});
