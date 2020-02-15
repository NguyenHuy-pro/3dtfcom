/**
 * Created by HUY on 6/16/2016.
 */

var tf_m_c_sample_size= {
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
            var widthObject = $(formObject).find("input[name='txtWidth']");
            var HeightObject = $(formObject).find("select[name='cbHeight']");
            var iconObject = $(formObject).find("input[name='txtImage']");

            if(widthObject.val() == 0){
                alert('Select a standard')
                return false;
            }
            if(HeightObject.val() == 0){
                alert('Select height')
                return false;
            }

            if(iconObject.val() == ''){
                alert('Select an icon for size')
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
            //var nameObject = $(formObject).find("input[name='txtName']");
            var containNotify = $(formObject).find('.tf_frm_notify');
            tf_manage_submit.ajaxFormHasReload(formObject, containNotify, true);
        }
    },

}

//---------- ---------- ---------- Status ----------- ---------- ----------
$(document).ready(function () {
    $('.tf_m_c_sample_size').on('click', '.tf_list_object .tf_object_status', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_sample_size.updateStatus(object);
    });
});

//---------- ---------- ---------- View - Delete ----------- ---------- ----------
$(document).ready(function () {
    //view
    $('.tf_m_c_sample_size').on('click', '.tf_list_object .tf_object_view', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_sample_size.view(object);
    });

    //delete user
    $('.tf_m_c_sample_size').on('click', '.tf_list_object .tf_object_delete', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_sample_size.delete(object);
    });
});



//---------- ---------- ---------- edit info ---------- ---------- ----------
$(document).ready(function () {
    //get form
    $('.tf_m_c_sample_size').on('click', '.tf_list_object .tf_object_edit', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_sample_size.edit.get(object);
    });

    //post edit
    $('body').on('click', '.tf_frm_edit .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_edit');
        tf_m_c_sample_size.edit.post(formObject);
    });

});


//---------- ---------- ---------- get info ---------- ---------- ----------
$(document).ready(function () {
    //---------- ---------- filter size from standard ---------- ----------
    $('.tf_m_c_sample_size').on('change', '.tf_filter_standard',function(){
        var url = $(this).data('href');
        var standardId = $(this).val();
        if(standardId != '') url = url + '/' + standardId;
        window.location.replace(url);
    });
});

//---------- ---------- ---------- add new ---------- ---------- ----------
$(document).ready(function () {
    //---------- ---------- select standard ---------- ----------
    $('.tf_m_c_sample_size').on('change', '.tf_frm_add .tf_standard', function(){
        var standard = $(this).val();
        standard = (standard == '')?0:standard;
        $('#txtWidth').val(standard*32);
    });

    //---------- ---------- check add new ---------- ----------
    $('.tf_m_c_sample_size').on('click', '.tf_frm_add .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_add');
        tf_m_c_sample_size.add.save(formObject);
    });
});

