/**
 * Created by HUY on 12/8/2016.
 */
var tf_m_c_user_recharge = {

    add: function (formObject) {
        var accountObject = $(formObject).find("input[name='txtAccount']");
        var paymentObject = $(formObject).find("input[name='txtPayment']");
        var placeObject = $(formObject).find("input[name='txtPlace']");
        var selectPlace = false;
        var selectPackage = false;
        if (tf_main.tf_checkInputNull(accountObject, 'Enter account or name card')) {
            return false;
        }

        paymentObject.each(function () {
            if ($(this).is(':checked')) selectPackage = true;
        });

        placeObject.each(function () {
            if ($(this).is(':checked')) selectPlace = true;
        });

        if (!selectPackage) {
            alert('Select a package');
            return false;
        }

        if (!selectPlace) {
            alert('Select a recharge place');
            return false;
        }

        if (selectPackage && selectPlace) {
            tf_manage_submit.normalForm(formObject);
        }
    },
    //View
    view: function (object) {
        var rechargeId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-view') + '/' + rechargeId;
        tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
        tf_main.tf_scrollTop();
    }
}

//---------- ---------- ---------- View ----------- ---------- ----------
$(document).ready(function () {
    $('.tf_m_c_user_recharge').on('click', '.tf_list_object .tf_object_view', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_user_recharge.view(object);
    });
});

//---------- ---------- ---------- Add ----------- ---------- ----------
$(document).ready(function () {

    //view
    $('.tf_m_c_user_recharge').on('click', '.tf_frm_add .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_add');
        tf_m_c_user_recharge.add(formObject);
    });
});