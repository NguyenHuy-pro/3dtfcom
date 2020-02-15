/**
 * Created by HUY on 7/9/2016.
 */
var tf_m_c_helpAction = {
    add: function (formAdd) {
        var nameObject = $(formAdd).find("input[name = 'txtName']");
        if (tf_main.tf_checkInputNull(nameObject, 'You must enter name')) {
            return false;
        } else {
            $(formAdd).submit();
        }
    },

    edit: function (formUpdate) {
        var nameObject = $(formUpdate).find("input[name = 'txtName']");
        if (tf_main.tf_checkInputNull(nameObject, 'You must enter name')) {
            return false;
        } else {
            $(formUpdate).submit();
        }
    },

    delete: function (href, objectId) {
        if(confirm('Do you want to delete?')){
            var href = href + '/' + objectId;
            tf_manage_submit.ajaxHasReload(href, '', false);
        }
    }
}

//========== ========== add new ========== ==========
$(document).ready(function () {
    $('.tf_m_c_help_action_add').on('click', '.tf_object_add', function () {
        var formObject = $(this).parents('.frm_object_add');
        tf_m_c_helpAction.add(formObject);
    });
});

//========== ========== edit ========== ==========
$(document).ready(function () {
    //update info
    $('.tf_m_c_help_action_edit').on('click', '.tf_object_update', function () {
        var formObject = $(this).parents('.frm_object_update');
        tf_m_c_helpAction.edit(formObject);
    });
});

//========== ========== delete ========== ==========
$(document).ready(function () {
    $('.tf_object').on('click', '.tf_object_delete', function () {
        var href = $(this).data('href');
        var objectId = $(this).parents('.tf_object').data('object');
        tf_m_c_helpAction.delete(href, objectId);
    });
});