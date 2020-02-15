/**
 * Created by HUY on 4/9/2016.
 */
var tf_seller = {
    register: {
        send: function (form) {
            var bank = $(form).find("select[name='cbBank']");
            var name = $(form).find("input[name='txtName']");
            var code = $(form).find("input[name='txtPaymentCode']");
            var password = $(form).find("input[name='txtConfirm']");
            if (tf_main.tf_checkInputNull(bank, 'You must select a bank')) {
                return false;
            }

            if (tf_main.tf_checkInputNull(name, 'You must enter payment name')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength(name, 50, 'max length of name is 50 characters.')) return false;
            }

            if (tf_main.tf_checkInputNull(code, 'You must enter payment code')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength(name, 30, 'max length of name is 30 characters.')) return false;
            }
            if (tf_main.tf_checkInputNull(password, 'You must enter confirm password')) {
                return false;
            }
            $(form).ajaxForm({
                beforeSend: function () {
                    tf_master.tf_main_load_status();
                },
                success: function (data) {
                    tf_master.tf_main_load_status();
                    if (data) {
                        alert(data);
                    } else {
                        window.location.reload();
                    }
                },
                complete: function () {
                    //tf_master.tf_main_load_status();
                }
            }).submit();
        }
    }
}

//========== ========== ========== REGISTER ========== ========== ==========
$(document).ready(function () {
    $('#tf_seller_sing_up').on('click', '.tf_seller_sing_up_send', function () {
        var form = $(this).parents('#tf_seller_sing_up');
        tf_seller.register.send(form);
    })
});