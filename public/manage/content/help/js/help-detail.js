/**
 * Created by HUY on 7/9/2016.
 */
var tf_m_c_helpDetail = {
    add: function (formAdd) {
        var helpObject = $(formAdd).find("select[name = 'cbObject']");
        var helpAction = $(formAdd).find("select[name = 'cbAction']");
        var nameObject = $(formAdd).find("input[name = 'txtName']");
        var descriptionObject = $(formAdd).find("textarea[name = 'txtDescription']");

        if(tf_main.tf_checkInputNull(helpObject, 'You must select a help object')){
            return false;
        }
        if(tf_main.tf_checkInputNull(helpAction, 'You must select a help action')){
            return false;
        }

        if (tf_main.tf_checkInputNull(nameObject, 'You must enter name')) {
            return false;
        }
        var descriptionValue = CKEDITOR.instances[$(descriptionObject).attr('id')].getData();
        if (descriptionValue.length > 0) {
            $(formAdd).submit();

        }else {
            alert('Enter content of description');
            $(descriptionObject).focus();
            return false;
        }
    },

    edit: function (formUpdate) {
        var nameObject = $(formUpdate).find("input[name = 'txtName']");
        var descriptionObject = $(formUpdate).find("textarea[name = 'txtDescription']");
        if (tf_main.tf_checkInputNull(nameObject, 'You must enter name')) {
            return false;
        }
        var descriptionValue = CKEDITOR.instances[$(descriptionObject).attr('id')].getData();
        if (descriptionValue.length > 0) {
            $(formUpdate).submit();

        }else {
            alert('Enter content of description');
            $(descriptionObject).focus();
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
    $('.tf_m_c_help_detail_add').on('click', '.tf_object_add', function () {
        var formObject = $(this).parents('.frm_object_add');
        tf_m_c_helpDetail.add(formObject);
    });
});

//========== ========== edit ========== ==========
$(document).ready(function () {
    //update info
    $('.tf_m_c_help_detail_update').on('click', '.tf_object_update', function () {
        var formUpdate = $(this).parents('.frm_object_update');
        tf_m_c_helpDetail.edit(formUpdate);
    });
});

//========== ========== delete ========== ==========
$(document).ready(function () {
    $('.tf_object').on('click', '.tf_object_delete', function () {
        var href = $(this).data('href');
        var objectId = $(this).parents('.tf_object').data('object');
        tf_m_c_helpDetail.delete(href, objectId);
    });
});