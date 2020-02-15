/**
 * Created by HUY on 6/16/2016.
 */
var tf_m_c_sample_project_icon = {
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
            var priceObject = $(formObject).find("select[name='cbPrice']");
            var sizeObject = $(formObject).find("select[name='cbSize']");
            var imageObject = $(formObject).find("input[name='fileImage']");

            if (tf_main.tf_checkInputNull(priceObject, 'select price')) {
                return false;
            }
            if (tf_main.tf_checkInputNull(sizeObject, 'select a standard size')) {
                return false;
            }
            if (tf_main.tf_checkInputNull(imageObject, 'Select a sample image')) {
                return false;
            } else {
                var limitWidth = imageObject.data('width');
                var limitHeight = imageObject.data('height');
                var checkWidth = $('#checkImgSize').outerWidth();
                var checkHeight = $('#checkImgSize').outerHeight();
                if (checkWidth != limitWidth || checkHeight != limitHeight) {
                    alert('Wrong image, Request size:(' + limitWidth + ' x ' + limitHeight + ')px, Upload size:(' + checkWidth + ' x ' + checkHeight + ')px');
                    imageObject.focus();
                    return false;
                } else {
                    tf_manage_submit.ajaxFormHasReload(formObject, '', false);
                }
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
            if (!tf_main.tf_checkInputNull('#fileImage', '')) {
                var limitWidth = $('#fileImage').data('width');
                var limitHeight = $('#fileImage').data('height');
                var checkWidth = $('#checkImgSize').outerWidth();
                var checkHeight = $('#checkImgSize').outerHeight();
                if (checkWidth != limitWidth || checkHeight != limitHeight) {
                    alert('Wrong image, Request size:(' + checkWidth + ' x ' + checkHeight + ')px, Upload size:(' + limitWidth + ' x ' + limitHeight + ')px');
                    $('#fileImage').focus();
                    return false;
                }
            }
            tf_manage_submit.ajaxFormHasReload(formObject, containNotify, true);
        }
    },

}

//---------- ---------- ---------- Status ----------- ---------- ----------
$(document).ready(function () {
    $('.tf_m_c_sample_project_icon').on('click', '.tf_list_object .tf_object_status', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_sample_project_icon.updateStatus(object);
    });
});

//---------- ---------- ---------- View - Delete ----------- ---------- ----------
$(document).ready(function () {
    //view
    $('.tf_m_c_sample_project_icon').on('click', '.tf_list_object .tf_object_view', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_sample_project_icon.view(object);
    });

    //delete user
    $('.tf_m_c_sample_project_icon').on('click', '.tf_list_object .tf_object_delete', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_sample_project_icon.delete(object);
    });
});


//---------- ---------- ---------- edit info ---------- ---------- ----------
$(document).ready(function () {
    //get form
    $('.tf_m_c_sample_project_icon').on('click', '.tf_list_object .tf_object_edit', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_sample_project_icon.edit.get(object);
    });

    //post edit
    $('body').on('click', '.tf_frm_edit .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_edit');
        tf_m_c_sample_project_icon.edit.post(formObject);
    });

});

//---------- ---------- ---------- add new ---------- ---------- ----------
$(document).ready(function () {
    $('.tf_m_c_sample_project_icon').on('change', '.tf_frm_add .tf_select_size', function () {
        var sizeId = $(this).val();
        var containerObject = $('.tf_m_c_sample_project_icon').find('.tf_frm_add .tf_select_image')
        containerObject.empty();
        if (sizeId != '') {
            var u = $(this).data('href');
            var token = $("form[name='tf_frm_add']").find("input[name='_token']").val();
            $.ajax({
                url: u + '/' + sizeId,
                type: 'GET',
                cache: false,
                data: {"_token": token, 'id': sizeId},
                success: function (data) {
                    if (data) {
                        containerObject.append(data);
                    }
                }
            });
        }
    });

    //---------- ---------- check add new ---------- ----------
    $('.tf_m_c_sample_project_icon').on('click', '.tf_frm_add .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_add');
        tf_m_c_sample_project_icon.add.save(formObject);
    });
});


//====================================

/*
 //---------- ---------- ---------- add new ---------- ---------- ----------
 $(document).ready(function () {
 //---------- ---------- select size ---------- ----------
 $('.tf-m-c-project-icon-sample-select-size-a').on('change',function(){
 var sizeID = $(this).val();
 $('#tf_m_c_project_icon_sample_select_image').empty();
 if(sizeID != ''){
 var u = $(this).data('href');
 var token = $("form[name='frmProjectIconSampleAdd']").find("input[name='_token']").val();
 $.ajax({
 url: u + '/' + sizeID,
 type: 'GET',
 cache: false,
 data:{"_token":token,'id':sizeID},
 success:function(data){
 if(data){
 $('#tf_m_c_project_icon_sample_select_image').append(data);
 }
 }
 });
 }
 });

 //---------- ---------- check add new ---------- ----------
 $('.tf-m-c-project-icon-sample-add-a').on('click', function(){
 if(tf_main.tf_checkInputNull('#cbPrice','select a price for sample')){
 return false;
 }
 if(tf_main.tf_checkInputNull('#cbSize','select a standard size')){
 return false;
 }
 if(tf_main.tf_checkInputNull('#fileImage','Select a sample image')){
 return false;
 }else{
 var limitWidth = $('#fileImage').data('width');
 var limitHeight = $('#fileImage').data('height');
 var checkWidth = $('#checkImgSize').outerWidth();
 var checkHeight = $('#checkImgSize').outerHeight();
 if(checkWidth != limitWidth || checkHeight != limitHeight){
 alert('Wrong image, Request size:(' + limitWidth + ' x ' + limitHeight + ')px, Upload size:(' + checkWidth + ' x ' + checkHeight + ')px');
 $('#fileImage').focus();
 return false;
 }
 }
 });
 });

 //---------- ---------- ---------- edit info ---------- ---------- ----------
 $(document).ready(function () {
 //---------- ---------- get form edit ---------- ----------
 $('.tf-m-c-project-icon-sample-edit-get-a').on('click', function(){
 var url = $(this).data('href');
 var sampleID = $(this).data('sample');
 window.location.replace(url + '/' + sampleID);
 });

 //---------- ---------- check edit info ---------- ----------
 $('.tf-m-c-project-icon-sample-edit-a').on('click', function(){
 if(!tf_main.tf_checkInputNull('#fileImage','')){
 var limitWidth = $('#fileImage').data('width');
 var limitHeight = $('#fileImage').data('height');
 var checkWidth = $('#checkImgSize').outerWidth();
 var checkHeight = $('#checkImgSize').outerHeight();
 if(checkWidth != limitWidth || checkHeight != limitHeight){
 alert('Wrong image, Request size:(' + checkWidth + ' x ' + checkHeight + ')px, Upload size:(' + limitWidth + ' x ' + limitHeight + ')px');
 $('#fileImage').focus();
 return false;
 }
 }
 });

 });

 //---------- ---------- ---------- general ---------- ---------- ----------
 $(document).ready(function(){
 //---------- ---------- update status ---------- ----------
 $('.tf-m-c-project-icon-sample-status-a').on('click', function(){
 var url = $(this).data('href');
 var sampleID = $(this).data('sample');
 var status = $(this).data('status');
 window.location.replace(url + '/' + sampleID + '/' + status);
 });

 //---------- ---------- delete ---------- ----------
 $('.tf-m-c-project-icon-sample-del-a').on('click', function(){
 var url = $(this).data('href');
 var sampleID = $(this).data('sample');
 if(window.confirm('Do you want to delete?')){
 window.location.replace(url + '/' + sampleID);
 }else{
 return false
 }
 });
 });
 */