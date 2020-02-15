/**
 * Created by HUY on 6/15/2016.
 */
var tf_m_c_map_rule_project_rank = {
    //View
    view: function (object) {
        var objectId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-view') + '/' + objectId;
        tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
        tf_main.tf_scrollTop();
    },
    add: {
        save: function (formObject) {
            var priceObject = $(formObject).find("input[name='txtSalePrice']");
            var monthObject = $(formObject).find("input[name='txtSaleMonth']");

            if(tf_main.tf_checkInputNull(priceObject,'Enter price')){
                return false;
            }
            if(tf_main.tf_checkInputNull(monthObject,'Enter month value')){
                return false;
            }else{
                //tf_manage_submit.ajaxFormHasReload(formObject, '', false);
            }

        }
    },
    edit: {
        get: function (href) {
            tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
            tf_main.tf_scrollTop();
        },
        post: function (formObject) {
            var containNotify = $(formObject).find('.tf_frm_notify');

            var priceObject = $(formObject).find("input[name='txtSalePrice']");
            var monthObject = $(formObject).find("input[name='txtSaleMonth']");

            if(tf_main.tf_checkInputNull(priceObject,'Enter price')){
                return false;
            }
            if(tf_main.tf_checkInputNull(monthObject,'Enter month value')){
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
    $('.tf_m_c_map_rule_project_rank').on('click', '.tf_list_object .tf_object_view', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_map_rule_project_rank.view(object);
    });

});

//---------- ---------- ---------- add new ---------- ---------- ----------
$(document).ready(function () {
    $('.tf_m_c_map_rule_project_rank').on('click', '.tf_frm_add .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_add');
        tf_m_c_map_rule_project_rank.add.save(formObject);
    });

});

//---------- ---------- ---------- edit info ---------- ---------- ----------
$(document).ready(function () {
    //get form
    $('.tf_m_c_map_rule_project_rank').on('click', '.tf_edit', function () {
        var href = $(this).data('href');
        tf_m_c_map_rule_project_rank.edit.get(href);
    });

    //post edit
    $('body').on('click', '.tf_frm_edit .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_edit');
        tf_m_c_map_rule_project_rank.edit.post(formObject);
    });

});