/**
 * Created by 3D on 3/26/2016.
 */
var tf_user_information = {
    getInfoEdit: function (href) {
        tf_master_submit.ajaxNotReload(href, $('#' + tf_master.bodyIdName()), false);
    },

    //---------- basic info ---------
    postBasicEdit: function (formObject) {
        var firstNameObject = $(formObject).find("input[name= 'txtFirstName']");
        var lastNameObject = $(formObject).find("input[name='txtLastName']");
        if (tf_main.tf_checkInputNull(firstNameObject, 'You must input first name')) {
            return false;
        } else {
            if (tf_main.tf_checkInputMaxLength(firstNameObject, 30, 'max length of first name is 30 character')) {
                return false;
            } else {
                if (tf_main.tf_checkStringValid(firstNameObject.val(), '<,>,~,$,&,\,/,|,*,%,#')) {
                    alert('First Name does not exist characters: <, >, ~, $,&, \, /, |, *, %, #');
                    firstNameObject.focus();
                    return false;
                }
            }
        }
        if (tf_main.tf_checkInputNull(lastNameObject, 'You must input last name')) {
            return false;
        } else {
            if (tf_main.tf_checkInputMaxLength(lastNameObject, 30, 'max length of last name is 30 character')) {
                return false;
            } else {
                if (tf_main.tf_checkStringValid(lastNameObject.val(), '<,>,~,$,&,\,/,|,*,%,#')) {
                    alert('Last Name does not exist characters: <, >, ~, $,&, \, /, |, *, %, #');
                    lastNameObject.focus();
                    return false;
                }
            }
        }
        tf_master_submit.ajaxFormHasReload(formObject, '', false);
    },

    //---------- contact info ----------
    contactGetProvince: function (href) {
        var container = $('#tf_user_contact_province_wrap');
        $.ajax({
            url: href,
            type: 'GET',
            cache: false,
            data: {},
            beforeSend: function () {
                tf_master.tf_main_load_status();
            },
            success: function (data) {
                if (data) {
                    if (container.length > 0) {
                        tf_main.tf_empty(container);
                        container.append(data);
                    }
                }
            },
            complete: function () {
                tf_master.tf_main_load_status();
            }
        });
    },
    postContactEdit: function (formObject) {
        tf_master_submit.ajaxFormHasReload(formObject, '', false);
    },

    //change password
    postChangePassword: function (formObject) {
        var oldPasswordObject = $(formObject).find("input[name='txtOldPassword']");
        var newPasswordObject = $(formObject).find("input[name='txtNewPassword']");
        var confirmPasswordObject = $(formObject).find("input[name='txtConfirmPassword']");

        if (tf_main.tf_checkInputNull(oldPasswordObject, 'You must enter password')) {
            return false;
        }
        if (tf_main.tf_checkInputNull(newPasswordObject, 'You must enter new password')) {
            return false;
        }
        if (tf_main.tf_checkInputNull(confirmPasswordObject, 'You must enter confirm password')) {
            return false;
        }

        if (newPasswordObject.val() != confirmPasswordObject.val()) {
            alert('Wrong confirm password');
            confirmPasswordObject.focus();
            return false;
        }
        var data = {
            txtOldPassword: oldPasswordObject.val(),
            txtNewPassword: newPasswordObject.val(),
            _token: $(formObject).find("input[name='_token']").val(),
        };
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: $(formObject).attr('action'),
            data: data,
            beforeSend: function () {
                tf_master.tf_main_load_status();
            },
            success: function (result) {
                if (result['status'] == 'fail') {
                    alert(result['content']);
                    oldPasswordObject.focus();
                    return false;
                } else {
                    alert(result['content']);
                    window.location.reload();
                }
            },
            complete: function () {
                tf_master.tf_main_load_status();
            },
            error: function () {
                alert('Error');
            }
        });
    }

}

$(document).ready(function () {
    //---------- ---------- basic info  ---------- ----------
    //get form edit
    $('.tf_user_information').on('click', '.tf_info_edit', function () {
        var href = $(this).data('href');
        tf_user_information.getInfoEdit(href);
    });

    //update basic info
    $('body').on('click', '.tf_user_frm_basic_edit .tf_basic_save', function () {
        var formObject = $(this).parents('.tf_user_frm_basic_edit');
        tf_user_information.postBasicEdit(formObject);
    });

    //---------- ---------- contact info  ---------- ----------
    //update contact info
    $('body').on('change', '.tf_user_frm_contact_edit #tf_user_contact_country', function () {
        var countryId = $(this).val();
        var href = $(this).data('href') + '/' + countryId;
        tf_user_information.contactGetProvince(href);
    });

    $('body').on('click', '.tf_user_frm_contact_edit .tf_contact_save', function () {
        var formObject = $(this).parents('.tf_user_frm_contact_edit');
        tf_user_information.postContactEdit(formObject);
    });

    //---------- ---------- account info  ---------- ----------
    //change password
    $('body').on('click', '.tf_user_frm_pass_edit .tf_pass_save', function () {
        var formObject = $(this).parents('.tf_user_frm_pass_edit');
        tf_user_information.postChangePassword(formObject);
    });
});