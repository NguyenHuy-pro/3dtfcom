/**
 * Created by HUY on 8/9/2016.
 */

var tf_register = {
    post: function (formObject) {
        var firstNameObject = $(formObject).find("input[name='txtFirstName']");
        var lastNameObject = $(formObject).find("input[name='txtLastName']");
        var accountObject = $(formObject).find("input[name='txtAccount']");
        var passwordObject = $(formObject).find("input[name='txtPassword']");
        var confirmPasswordObject = $(formObject).find("input[name='txtPasswordConfirm']");
        var birthdayObject = $(formObject).find("input[name='txtBirthday']");
        var readRuleObject = $(formObject).find("input[name='confirmReadRule']");

        if (tf_main.tf_checkInputNull(firstNameObject, 'Enter first name')) {
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

        if (tf_main.tf_checkInputNull(lastNameObject, 'Enter last name')) {
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

        // check birthday
        if (tf_main.tf_checkInputNull(birthdayObject, 'You must enter birthday')) {
            return false;
        } else {
            var birthDay = birthdayObject.val();
            var now = new Date();
            var newdate = new Date(now.getFullYear() - 15, now.getMonth(), now.getDate());
            var yy = newdate.getFullYear();
            var mm = newdate.getMonth();
            var dd = newdate.getDate();
            var maxDate = yy + '-' + mm + '-' + dd;
            if (birthDay > maxDate) {
                alert(' Sorry!, You must be greater than 15 years old.');
                birthdayObject.focus();
                return false;
            }
        }

        //account
        if (tf_main.tf_checkInputNull(accountObject, 'Enter a account')) {
            return false;
        } else {
            var email = accountObject.val();
            if (!tf_main.tf_checkEmail(email)) {
                alert('Your email invalid');
                accountObject.focus();
                return false;
            }
        }

        // password
        if (tf_main.tf_checkInputNull(passwordObject, 'Enter a password')) {
            return false;
        } else {
            if (tf_main.tf_checkInputMinLength(passwordObject, 6, 'min length of password is 6 character')) {
                return false;
            }
        }
        if (tf_main.tf_checkInputNull(confirmPasswordObject, 'Enter a confirm password')) {
            return false;
        } else {
            if (confirmPasswordObject.val() !== passwordObject.val()) {
                alert('Confirm password is incorrect');
                confirmPasswordObject.focus();
                return false;
            }
        }


        //check have read the terms 3dtf.com
        if (!tf_main.tf_checkCheckboxChecked('frmMainRegister', 'confirmReadRule')) {
            alert('You must confirm have read the terms 3dtf.com');
            readRuleObject.focus();
            return false;
        } else {
            tf_master_submit.normalForm(formObject);
        }
    },

    facebook: {
        connect: function (formObject) {
            var firstNameObject = $(formObject).find("input[name='txtFirstName']");
            var lastNameObject = $(formObject).find("input[name='txtLastName']");
            var accountObject = $(formObject).find("input[name='txtAccount']");
            var passwordObject = $(formObject).find("input[name='txtPassword']");
            if (tf_main.tf_checkInputNull(firstNameObject, 'Enter first name')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength(firstNameObject, 30, 'max length of first name is 30 character')) {
                    return false;
                }
            }

            if (tf_main.tf_checkInputNull(lastNameObject, 'Enter last name')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength(lastNameObject, 30, 'max length of last name is 30 character')) {
                    return false;
                }
            }

            //account
            if (tf_main.tf_checkInputNull(accountObject, 'Enter a account')) {
                return false;
            } else {
                var email = accountObject.val();
                if (!tf_main.tf_checkEmail(email)) {
                    alert('Your email invalid');
                    accountObject.focus();
                    return false;
                }
            }

            // password
            if (tf_main.tf_checkInputNull(passwordObject, 'Enter a password')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMinLength(passwordObject, 6, 'min length of password is 6 character')) {
                    return false;
                } else {
                    var data = $(formObject).serialize();
                    $.ajax({
                        type: 'POST',
                        url: $(formObject).attr('action'),
                        dataType: 'html',
                        data: data,
                        beforeSend: function () {
                            tf_master.tf_main_load_status();
                        },
                        success: function (data) {
                            if (data) {
                                $('#tf_fb_register_notify').empty();
                                $('#tf_fb_register_notify').append(data);
                            } else {
                                window.location.reload();
                            }
                        },
                        complete: function () {
                            tf_master.tf_main_load_status();
                        }
                    });
                }
            }
        }
    },

    google: {
        connect: function (formObject) {
            var firstNameObject = $(formObject).find("input[name='txtFirstName']");
            var lastNameObject = $(formObject).find("input[name='txtLastName']");
            var accountObject = $(formObject).find("input[name='txtAccount']");
            var passwordObject = $(formObject).find("input[name='txtPassword']");
            if (tf_main.tf_checkInputNull(firstNameObject, 'Enter first name')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength(firstNameObject, 30, 'max length of first name is 30 character')) {
                    return false;
                }
            }

            if (tf_main.tf_checkInputNull(lastNameObject, 'Enter last name')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength(lastNameObject, 30, 'max length of last name is 30 character')) {
                    return false;
                }
            }

            //account
            if (tf_main.tf_checkInputNull(accountObject, 'Enter a account')) {
                return false;
            } else {
                var email = accountObject.val();
                if (!tf_main.tf_checkEmail(email)) {
                    alert('Your email invalid');
                    accountObject.focus();
                    return false;
                }
            }

            // password
            if (tf_main.tf_checkInputNull(passwordObject, 'Enter a password')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMinLength(passwordObject, 6, 'min length of password is 6 character')) {
                    return false;
                } else {
                    var data = $(formObject).serialize();
                    $.ajax({
                        type: 'POST',
                        url: $(formObject).attr('action'),
                        dataType: 'html',
                        data: data,
                        beforeSend: function () {
                            tf_master.tf_main_load_status();
                        },
                        success: function (data) {
                            if (data) {
                                $('#tf_g_register_notify').empty();
                                $('#tf_g_register_notify').append(data);
                            } else {
                                window.location.reload();
                            }
                        },
                        complete: function () {
                            tf_master.tf_main_load_status();
                        }
                    });
                }
            }
        }
    }
}

//=============== new register ==================
//normal
$(document).ready(function () {
    $('#frmMainRegister').on('click', '.tf_save', function () {
        var formObject = $(this).parents('#frmMainRegister');
        tf_register.post(formObject);
    });
});

//facebook
$(document).ready(function () {
    $('#frmFacebookRegister').on('click', '.tf_accept', function () {
        var formObject = $(this).parents('#frmFacebookRegister');
        tf_register.facebook.connect(formObject);
    });
});

//google
$(document).ready(function () {
    $('#frmGoogleRegister').on('click', '.tf_accept', function () {
        var formObject = $(this).parents('#frmGoogleRegister');
        tf_register.google.connect(formObject);
    });
});