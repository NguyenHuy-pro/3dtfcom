/**
 * Created by HUY on 6/14/2016.
 */
var tf_m_c_seller_guide = {
    //View
    view: function (object) {
        var objectId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-view') + '/' + objectId;
        tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
        tf_main.tf_scrollTop();
    },
    //delete
    delete: function (object) {
        if (confirm('Do you want to delete this guide?')) {
            var objectId = $(object).data('object');
            var href = $(object).parents('.tf_list_object').data('href-del') + '/' + objectId;
            tf_manage_submit.ajaxHasReload(href, '#tf_m_c_wrapper', false);
        }
    },

    //update status
    status: function (object) {
        var objectId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-status') + '/' + objectId;
        tf_manage_submit.ajaxHasReload(href, '', false);
    },

    //add new
    addNew: {
        postAdd: function (form) {
            var object = $(form).find("select[name='cbObject']");
            var nameObject = $(form).find("input[name='txtName']");
            var contentObject = $(form).find("textarea[name='txtContent']");

            if (tf_main.tf_checkInputNull(object, 'You must select a object')) {
                return false;
            }

            if (tf_main.tf_checkInputNull(nameObject, 'Enter name')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength(nameObject, 255, 'max length of name is 255 characters.')) return false;
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
                tf_manage_submit.ajaxFormHasReload(form, '', false);
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

        post: function (form) {
            var object = $(form).find("select[name='cbObject']");
            var nameObject = $(form).find("input[name='txtName']");
            var contentObject = $(form).find("textarea[name='txtContent']");
            var containNotify = $(form).find('.tf_frm_notify');

            if (tf_main.tf_checkInputNull(nameObject, 'Enter name')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength(nameObject, 255, 'max length of name is 255 characters.')) return false;
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
                tf_manage_submit.ajaxFormHasReload(form, containNotify, true);
            }
        }
    }
}

//---------- ---------- ---------- View ----------- ---------- ----------
$(document).ready(function () {
    //view
    $('.tf_m_c_seller_guide').on('click', '.tf_list_object .tf_object_view', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_seller_guide.view(object);
    });
});

//---------- ---------- ---------- Update status ----------- ---------- ----------
$(document).ready(function () {
    //view
    $('.tf_m_c_seller_guide').on('click', '.tf_list_object .tf_object_status', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_seller_guide.status(object);
    });
});

//---------- ---------- ---------- add new ---------- ---------- ----------
$(document).ready(function () {
    //---------- ---------- check add ---------- ----------
    $('.tf_m_c_seller_guide').on('click', '.tf_frm_add .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_add');
        tf_m_c_seller_guide.addNew.postAdd(formObject);
    });
});


//---------- ---------- ---------- edit info ---------- ---------- ----------
$(document).ready(function () {
    //get form
    $('.tf_m_c_seller_guide').on('click', '.tf_list_object .tf_object_edit', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_seller_guide.editInfo.get(object);
    });

    //post edit
    $('body').on('click', '.tf_frm_edit .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_edit');
        tf_m_c_seller_guide.editInfo.post(formObject);
    });

});

//---------- ---------- ---------- delete ----------- ---------- ----------
$(document).ready(function () {
    //view
    $('.tf_m_c_seller_guide').on('click', '.tf_list_object .tf_object_delete', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_seller_guide.delete(object);
    });
});
