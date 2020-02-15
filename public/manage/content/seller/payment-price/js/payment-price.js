/**
 * Created by HUY on 6/13/2016.
 */
var tf_m_c_seller_payment_price = {
    //View
    view: function (object) {
        var objectId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-view') + '/' + objectId;
        tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
        tf_main.tf_scrollTop();
    },

    add: {
        save: function (form) {
            var accessNumber = $(form).find("input[name='txtAccess']");
            var registerNumber = $(form).find("input[name='txtRegister']");

            if (tf_main.tf_checkInputNull(accessNumber, 'Enter access number')) {
                return false;
            }

            if (tf_main.tf_checkInputNull(registerNumber, 'Enter access number')) {
                return false;
            }
            tf_manage_submit.ajaxFormHasReload(form, '', false);

        }
    }

}

//---------- ---------- ---------- add new ---------- ---------- ----------
$(document).ready(function () {
    $('.tf_m_c_seller_payment_price').on('click', '.tf_frm_add .tf_save', function () {
        var form = $(this).parents('.tf_frm_add');
        tf_m_c_seller_payment_price.add.save(form);
    });

});

