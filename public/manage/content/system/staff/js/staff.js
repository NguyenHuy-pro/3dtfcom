/**
 * Created by HUY on 6/14/2016.
 */
var tf_m_c_system_staff = {
    //View
    view: function (object) {
        var staffId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-view') + '/' + staffId;
        tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
        tf_main.tf_scrollTop();
    },

    //status
    updateStatus: function (object) {
        var staffId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-status') + '/' + staffId;
        tf_manage_submit.ajaxHasReload(href, '', false);
    },

    //delete
    delete: function (object) {
        if (confirm('Do you to delete this staff?')) {
            var staffId = $(object).data('object');
            var href = $(object).parents('.tf_list_object').data('href-del') + '/' + staffId;
            tf_manage_submit.ajaxHasReload(href, '', false);
        }
    },
    add: {
        save: function (formObject) {
            var firstNameObject = $(formObject).find("input[name='txtFirstName']");
            var lastNameObject = $(formObject).find("input[name='txtLastName']");
            var birthdayObject = $(formObject).find("input[name='txtBirthday']");
            var genderObject = $(formObject).find("select[name='cbGender']");
            //var imageObject = $(formObject).find("input[name='txtImage']");
            var levelObject = $(formObject).find("select[name='cbLevel']");
            var departmentObject = $(formObject).find("select[name='cbDepartment']");
            var accountObject = $(formObject).find("input[name='txtAccount']");
            var confirmObject = $(formObject).find("input[name='txtConfirmAccount']");
            var countryObject = $(formObject).find("select[name='cbCountry']");
            var provinceObject = $(formObject).find("select[name='cbProvince']");

            if (tf_main.tf_checkInputNull(firstNameObject, 'Enter first name')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength(firstNameObject, 30, 'Max length of first name is 30 characters')) return false;
            }
            if (tf_main.tf_checkInputNull(lastNameObject, 'Enter last name')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength(lastNameObject, 20, 'Max length of last name is 20 characters')) return false;
            }
            if (tf_main.tf_checkInputNull(birthdayObject, 'Enter birthday')) {
                return false;
            } else {
                var birthDay = birthdayObject.val();
                var now = new Date();
                var newDate = new Date(now.getFullYear() - 15, now.getMonth(), now.getDate());
                var yy = newDate.getFullYear();
                var mm = newDate.getMonth();
                var dd = newDate.getDate();
                var maxDate = yy + '-' + mm + '-' + dd;
                if (birthDay > maxDate) {
                    alert(' date invalid, the staff must be greater than 15 years old.');
                    birthdayObject.focus();
                    return false;
                }
            }
            if (tf_main.tf_checkInputNull(genderObject, 'Select gender')) {
                return false;
            }
            if (tf_main.tf_checkInputNull(genderObject, 'Select an image for staff')) {
                return false;
            }
            if (tf_main.tf_checkInputNull(levelObject, 'Select level for staff')) {
                return false;
            }
            if (tf_main.tf_checkInputNull(departmentObject, 'Select a department for staff')) {
                return false;
            }
            if (levelObject.val() > 1) {
                var manageObject = $(formObject).find("select[name='cbManageStaff']");
                if (tf_main.tf_checkInputNull(manageObject, 'Select a manager')) {
                    return false;
                }
            }
            if (tf_main.tf_checkInputNull(accountObject, 'Enter account')) {
                return false;
            } else {
                var email = accountObject.val();
                if (!tf_main.tf_checkEmail(email)) {
                    alert('Your email invalid');
                    accountObject.focus();
                    return false;
                }
            }
            if (tf_main.tf_checkInputNull(confirmObject, 'Enter confirm account')) {
                return false;
            } else {
                if (accountObject.val() !== confirmObject.val()) {
                    alert('Wrong confirm account');
                    confirmObject.focus();
                    return false;
                }
            }
            if (tf_main.tf_checkInputNull(countryObject, 'Select a country')) {
                return false;
            }
            if (tf_main.tf_checkInputNull(provinceObject, 'Select a province')) {
                return false;
            } else {
                tf_manage_submit.ajaxFormHasReload(formObject, '', false);
            }

        }
    },
    edit: {
        get:function(object){
            var staffId = $(object).data('object');
            var href = $(object).parents('.tf_list_object').data('href-edit') + '/' + staffId;
            tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
            tf_main.tf_scrollTop();
        }
    },
    verification: function (formObject) {
        var accountObject = $(formObject).find("input[name='txtAccount']")
        var codeObject = $(formObject).find("input[name='txtVerificationCode']")
        var passwordObject = $(formObject).find("input[name='txtPassword']")
        var confirmObject = $(formObject).find("input[name='txtConfirmPassword']")

        if (tf_main.tf_checkInputNull(accountObject, 'Enter your account')) {
            return false;
        }

        if (tf_main.tf_checkInputNull(codeObject, 'Enter your verification code')) {
            return false;
        }

        if (tf_main.tf_checkInputNull(passwordObject, 'Enter password')) {
            return false;
        } else {
            if (tf_main.tf_checkInputMinLength(passwordObject, 6, 'password at least 6 characters.')) return false;
        }

        if (tf_main.tf_checkInputNull(confirmObject, 'Enter confirm password')) {
            return false;
        } else {
            if (passwordObject.val() !== confirmObject.val()) {
                alert('Wrong confirm password');
                confirmObject.focus();
                return false;
            }else{
                tf_manage_submit.normalForm(formObject);
            }
        }
    }
}

//---------- ---------- ---------- View - Delete ----------- ---------- ----------
$(document).ready(function () {
    //view
    $('.tf_m_c_system_staff').on('click', '.tf_list_object .tf_object_view', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_system_staff.view(object);
    });

    //delete user
    $('.tf_m_c_system_staff').on('click', '.tf_list_object .tf_object_delete', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_system_staff.delete(object);
    });
});

//---------- ---------- ---------- Status ----------- ---------- ----------
$(document).ready(function () {
    $('.tf_m_c_system_staff').on('click', '.tf_list_object .tf_object_status', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_system_staff.updateStatus(object);
    });
});


//---------- ---------- ---------- add new ---------- ---------- ----------
$(document).ready(function () {
    $('.tf_m_c_system_staff').on('click', '.tf_frm_add .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_add');
        tf_m_c_system_staff.add.save(formObject);
    });

});

//---------- ---------- ---------- Edit info ---------- ---------- ----------
$(document).ready(function () {
    $('.tf_m_c_system_staff').on('click', '.tf_list_object .tf_object_edit', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_system_staff.edit.get(object);
    });

});

//---------- ---------- ---------- Select ---------- ---------- ------------
$(document).ready(function () {
    //---------- ---------- select level ---------- ----------
    $('body #cbLevel').on('change', function () {
        var level = $(this).val();
        $('#cbDepartment option').filter(function () {
            if ($(this).val() == '') $(this).attr('selected', true);
        });
        tf_main.tf_empty('#tf_m_c_staff_select_manage');
    });

    //---------- ---------- select department ---------- ----------
    $('body #cbDepartment').on('change', function () {
        if (tf_main.tf_checkInputNull('#cbLevel', 'Select level for staff')) {
            $('#cbDepartment option').filter(function () {
                if ($(this).val() == '') $(this).attr('selected', true);
            });
            return false;
        }
        var departmentId = $(this).val();
        $('#tf_m_c_staff_select_manage').empty();
        if (departmentId != '') {
            var level = $('#cbLevel').val();
            if (level > 1) { // not root
                $('#tf_m_c_staff_select_manage').empty();
                var url = $(this).data('href');
                var token = $("form[name='frmStaffAdd']").find("input[name='_token']").val();
                $.ajax({
                    url: url + '/' + departmentId,
                    type: 'GET',
                    cache: false,
                    data: {"_token": token, 'id': departmentId},
                    success: function (data) {
                        if (data) {
                            $('#tf_m_c_staff_select_manage').append(data);
                        }
                    }
                });
            }
        }
    });

    //---------- ---------- select country ---------- ----------
    $('body #cbCountry').on('change', function () {
        var countryId = $(this).val();
        $('#tf_m_c_staff_select_province').empty();
        if (countryId != '') {
            var url = $(this).data('href');
            var token = $("form[name='frmStaffAdd']").find("input[name='_token']").val();
            $.ajax({
                url: url + '/' + countryId,
                type: 'GET',
                cache: false,
                data: {"_token": token, 'id': countryId},
                success: function (data) {
                    if (data) {
                        $('#tf_m_c_staff_select_province').append(data);
                    }
                }
            });
        }
    });
});

//---------- ---------- ------------ verification ---------- ---------- -----------
$(document).ready(function () {
    // verification account
    $('body').on('click','.tf_frm_system_staff_confirm .tf_send',  function () {
        var formObject = $(this).parents('.tf_frm_system_staff_confirm');
        tf_m_c_system_staff.verification(formObject);
    });
});











//---------- ---------- ---------- edit info ---------- ---------- ----------
$(document).ready(function () {
    //---------- ---------- get form edit ---------- ----------
    $('.tf-m-c-staff-edit-get-a').on('click', function () {
        var url = $(this).data('href');
        var staffID = $(this).data('staff');
        window.location.replace(url + '/' + staffID);
    });

    //---------- ---------- check edit info ---------- ----------
    $('.tf-m-c-staff-edit-a').on('click', function () {
        if (tf_main.tf_checkInputNull('#txtFirstName', 'Enter first name')) {
            return false;
        } else {
            if (tf_main.tf_checkInputMaxLength('#txtFirstName', 30, 'Limit of name is 30 characters')) return false;
        }
        if (tf_main.tf_checkInputNull('#txtLastName', 'Enter last name')) {
            return false;
        } else {
            if (tf_main.tf_checkInputMaxLength('#txtLastName', 20, 'Limit of name is 20 characters')) return false;
        }
        if (tf_main.tf_checkInputNull('#txtBirthday', 'Enter birthday')) {
            return false;
        } else {
            var birthDay = $('#txtBirthday').val();
            var now = new Date();
            var newdate = new Date(now.getFullYear() - 15, now.getMonth(), now.getDate());
            var yy = newdate.getFullYear();
            var mm = newdate.getMonth();
            var dd = newdate.getDate();
            var maxDate = yy + '-' + mm + '-' + dd;
            if (birthDay > maxDate) {
                alert(' date invalid, the staff must be greater than 15 years old.');
                $('#txtBirthday').focus();
                return false;
            }
        }
        if (tf_main.tf_checkInputNull('#cbGender', 'Select gender')) {
            return false;
        }
    });

});


