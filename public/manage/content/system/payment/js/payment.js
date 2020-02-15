/**
 * Created by HUY on 6/15/2016.
 */
var tf_m_c_system_payment = {
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
            var typeObject = $(formObject).find("select[name='cbPaymentType']");
            var bankObject = $(formObject).find("select[name='cbBank']");
            var paymentNameObject = $(formObject).find("input[name='txtPaymentName']");
            var paymentCodeObject = $(formObject).find("input[name='txtPaymentCode']");
            var contactObject = $(formObject).find("input[name='txtContactName']");

            var paymentTypeId = typeObject.val();
            if (tf_main.tf_checkInputNull(typeObject, 'Select q payment type')) {
                return false;
            } else {
                if (paymentTypeId == 2) {
                    if (tf_main.tf_checkInputNull(bankObject, 'Select q bank'))  return false;
                }
            }
            if (tf_main.tf_checkInputNull(paymentNameObject, 'Enter payment name')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength(paymentNameObject, 50, 'Limit of payment name is 50 characters')) return false;
            }

            if (tf_main.tf_checkInputNull(paymentCodeObject, 'Enter payment code')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength(paymentCodeObject, 20, 'Limit of payment code is 20 characters')) return false;
            }

            if (paymentTypeId != 2) { // not bank transfer
                if (tf_main.tf_checkInputNull(contactObject, 'Enter contact name')) {
                    return false;
                } else {
                    if (tf_main.tf_checkInputMaxLength(contactObject, 50, 'Limit of contact name is 50 characters')) return false;
                }
            }

            tf_manage_submit.ajaxFormHasReload(formObject, '', false);

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
            var nameObject = $(formObject).find("input[name='txtName']");

            if (tf_main.tf_checkInputNull(nameObject, 'Enter name')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength(nameObject, 50, 'Limit of name length 50 characters')) {
                    return false;
                } else {
                    tf_manage_submit.ajaxFormHasReload(formObject, containNotify, true);
                }
            }
        }
    },

}

//---------- ---------- ---------- Status ----------- ---------- ----------
$(document).ready(function () {
    $('.tf_m_c_system_payment').on('click', '.tf_list_object .tf_object_status', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_system_payment.updateStatus(object);
    });
});

//---------- ---------- ---------- View - Delete ----------- ---------- ----------
$(document).ready(function () {
    //view
    $('.tf_m_c_system_payment').on('click', '.tf_list_object .tf_object_view', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_system_payment.view(object);
    });

    //delete
    $('.tf_m_c_system_payment').on('click', '.tf_list_object .tf_object_delete', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_system_payment.delete(object);
    });
});


//---------- ---------- ---------- edit info ---------- ---------- ----------
$(document).ready(function () {
    //get form
    $('.tf_m_c_system_payment').on('click', '.tf_list_object .tf_object_edit', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_system_payment.edit.get(object);
    });

    // select payment type
    $('body').on('change', '.tf_frm_edit .tf_payment_type', function () {
        var typeId = $(this).val();
        var containerBank = $('body').find('.tf_container_bank');
        if (typeId == 2) { // bank transfer
            containerBank.show();
        } else {
            $("body .tf_bank option").filter(function () {
                if ($(this).val() == '') $(this).attr('selected', true);
            });
            containerBank.hide();
        }
    });

    //post edit
    $('body').on('click', '.tf_frm_edit .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_edit');
        tf_m_c_system_payment.edit.post(formObject);
    });

});

//---------- ---------- ---------- add new ---------- ---------- ----------
$(document).ready(function () {
    //check add
    $('.tf_m_c_system_payment').on('click', '.tf_frm_add .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_add');
        tf_m_c_system_payment.add.save(formObject);
    });

    // select payment type
    $('.tf_m_c_system_payment').on('change', '.tf_frm_add .tf_payment_type', function () {
        var typeId = $(this).val();
        var containerBank = $('.tf_frm_add').find('.tf_container_bank');
        if (typeId == 2) { // bank transfer
            containerBank.show();
        } else {
            $(".tf_frm_add .tf_bank option").filter(function () {
                if ($(this).val() == '') $(this).attr('selected', true);
            });
            containerBank.hide();
        }
    });

});




//===================================


//---------- ---------- ---------- edit info ---------- ---------- ----------
$(document).ready(function () {


    //---------- ---------- check edit ---------- ----------
    $('.tf-m-c-payment-edit-a').on('click', function () {
        var paymentTypeID = $('#cbPaymentType').val();
        if (tf_main.tf_checkInputNull('#cbPaymentType', 'Select q payment type')) {
            return false;
        } else {
            if (paymentTypeID == 2) {
                if (tf_main.tf_checkInputNull('#cbBank', 'Select q bank'))  return false;
            }
        }
        if (tf_main.tf_checkInputNull('#txtPaymentName', 'Enter payment name')) {
            return false;
        } else {
            if (tf_main.tf_checkInputMaxLength('#txtPaymentName', 50, 'Limit of payment name is 50 characters')) return false;
        }
        if (tf_main.tf_checkInputNull('#txtPaymentCode', 'Enter payment code')) {
            return false;
        } else {
            if (tf_main.tf_checkInputMaxLength('#txtPaymentCode', 20, 'Limit of payment code is 20 characters')) return false;
        }
        if (paymentTypeID != 2) { // not bank transfer
            if (tf_main.tf_checkInputNull('#txtContactName', 'Enter contact name')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength('#txtContactName', 50, 'Limit of contact name is 50 characters')) return false;
            }
        }
    });
});

//---------- ---------- ---------- general ---------- ---------- ----------
$(document).ready(function () {
    //---------- ---------- update status ---------- ----------
    $('.tf-m-c-payment-status-a').on('click', function () {
        var url = $(this).data('href');
        var paymentID = $(this).data('payment');
        var status = $(this).data('status');
        window.location.replace(url + '/' + paymentID + '/' + status);
    });

    //---------- ---------- delete ---------- ----------
    $('.tf-m-c-payment-del-a').on('click', function () {
        var url = $(this).data('href');
        var paymentID = $(this).data('payment');
        if (window.confirm('Do you want to delete?')) {
            window.location.replace(url + '/' + paymentID);
        } else {
            return false
        }
    });

});