/**
 * Created by HUY on 7/9/2016.
 */
var tf_m_c_helpContent = {
    add: function (formAdd) {
        var helpDetail = $(formAdd).find("select[name = 'cbDetail']");
        var nameObject = $(formAdd).find("input[name = 'txtName']");
        var contentObject = $(formAdd).find("textarea[name = 'txtContent']");

        if(tf_main.tf_checkInputNull(helpDetail, 'You must select a help description')){
            return false;
        }

        if (tf_main.tf_checkInputNull(nameObject, 'You must enter name')) {
            return false;
        }
        var contentValue = CKEDITOR.instances[$(contentObject).attr('id')].getData();
        if (contentValue.length > 0) {
            $(formAdd).submit();

        }else {
            alert('Enter content');
            $(contentObject).focus();
            return false;
        }
    },

    edit: function (formUpdate) {
        var nameObject = $(formUpdate).find("input[name = 'txtName']");
        var contentObject = $(formUpdate).find("textarea[name = 'txtContent']");
        if (tf_main.tf_checkInputNull(nameObject, 'You must enter name')) {
            return false;
        }
        var contentValue = CKEDITOR.instances[$(contentObject).attr('id')].getData();
        if (contentValue.length > 0) {
            $(formUpdate).submit();

        }else {
            alert('Enter content');
            $(contentObject).focus();
            return false;
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
    $('.tf_m_c_help_content_add').on('click', '.tf_object_add', function () {
        var formObject = $(this).parents('.frm_object_add');
        tf_m_c_helpContent.add(formObject);
    });
});

//========== ========== edit ========== ==========
$(document).ready(function () {
    //update info
    $('.tf_m_c_help_content_update').on('click', '.tf_object_update', function () {
        var formUpdate = $(this).parents('.frm_object_update');
        tf_m_c_helpContent.edit(formUpdate);
    });
});

//========== ========== delete ========== ==========
$(document).ready(function () {
    $('.tf_object').on('click', '.tf_object_delete', function () {
        var href = $(this).data('href');
        var objectId = $(this).parents('.tf_object').data('object');
        tf_m_c_helpContent.delete(href, objectId);
    });
});
