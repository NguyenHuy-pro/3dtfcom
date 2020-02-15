/**
 * Created by HUY on 7/9/2016.
 */
var tf_m_c_map_transaction_status = {
    //View
    view: function (object) {
        var transactionStatusId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-view') + '/' + transactionStatusId;
        tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
        tf_main.tf_scrollTop();
    },

    //status
    updateStatus: function (object) {
        var transactionStatusId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-status') + '/' + transactionStatusId;
        tf_manage_submit.ajaxHasReload(href, '', false);
    },

    //add
    addNew: {
        post: function (formObject) {
            var nameObject = $(formObject).find("input[name= 'txtName']");
            var containNotify = $(formObject).find('.tf_frm_notify');
            if (tf_main.tf_checkInputNull(nameObject, 'Enter name')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength(nameObject, 30, 'Max length of name is 30 characters')) {
                    return false;
                } else {
                    tf_manage_submit.ajaxFormHasReload(formObject, containNotify, false);

                }
            }
        }
    },

    //edit
    editInfo: {
        get: function (object) {
            var transactionStatusId = $(object).data('object');
            var href = $(object).parents('.tf_list_object').data('href-edit') + '/' + transactionStatusId;
            tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
            tf_main.tf_scrollTop();
        },

        post: function (formObject) {
            var nameObject = $(formObject).find("input[name= 'txtName']");
            var containNotify = $(formObject).find('.tf_frm_notify');
            if (tf_main.tf_checkInputNull(nameObject, 'Enter name')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength(nameObject, 30, 'Max length of name is 30 characters')) {
                    return false;
                } else {
                    tf_manage_submit.ajaxFormHasReload(formObject, containNotify, true);

                }
            }
        }
    }
}

//---------- ---------- ---------- Status ----------- ---------- ----------
$(document).ready(function () {
    //update status
    $('.tf_m_c_map_transaction_status').on('click', '.tf_list_object .tf_object_status', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_map_transaction_status.updateStatus(object);
    });
});


//---------- ---------- ---------- add new ----------- ---------- ----------
$(document).ready(function () {
    //post edit
    $('.tf_m_c_map_transaction_status').on('click', '.tf_frm_add .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_add');
        tf_m_c_map_transaction_status.addNew.post(formObject);
    });
});

//---------- ---------- ---------- edit info ----------- ---------- ----------
$(document).ready(function () {
    // get form edit
    $('.tf_m_c_map_transaction_status').on('click', '.tf_list_object .tf_object_edit', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_map_transaction_status.editInfo.get(object);
    });

    //post edit
    $('body').on('click', '.tf_frm_edit .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_edit');
        tf_m_c_map_transaction_status.editInfo.post(formObject);
    });
});

//---------- ---------- ---------- update status ----------- ---------- ----------
$(document).ready(function () {
    $('.tf-m-c-transaction-status-status-a').on('click', function () {
        var url = $(this).data('href');
        var transactionStatusID = $(this).data('transaction');
        var status = $(this).data('status');
        window.location.replace(url + '/' + transactionStatusID + '/' + status);
    });
});