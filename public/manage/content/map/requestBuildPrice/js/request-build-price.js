/**
 * Created by HUY on 6/15/2016.
 */
var tf_m_c_map_request_build_price = {
    filter: function (href) {
        tf_main.tf_url_replace(href);
    },
    view: function (object) {
        var objectId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-view') + '/' + objectId;
        tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
        tf_main.tf_scrollTop();
    },
    add: {
        post: function (form) {
            var size = $(form).find("select[name='cbSize']");
            var price = $(form).find("input[name='txtPrice']");

            if (tf_main.tf_checkInputNull(size, 'Select an size')) {
                return false;
            }
            if (tf_main.tf_checkInputNull(price, 'Enter price')) {
                return false;
            } else {
                tf_manage_submit.ajaxFormHasReload(form, '', false);
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
        post: function (form) {
            var price = $(form).find("input[name='txtPrice']");
            var containNotify = $(form).find('.tf_frm_notify');

            if (tf_main.tf_checkInputNull(price, 'Enter free month')) {
                return false;
            } else {
                tf_manage_submit.ajaxFormHasReload(form, containNotify, true);
            }
        }
    }
}
//---------- ---------- ---------- get info ----------- ---------- ----------
$(document).ready(function () {
    $('.tf_m_c_request_build_price_filter').on('change', function () {
        var href = $(this).data('href');
        var sizeId = $(this).val();
        if (sizeId != '') href = href + '/' + sizeId;
        tf_m_c_map_request_build_price.filter(href);
    });
});

//---------- ---------- ---------- add new ----------- ---------- ----------
$(document).ready(function () {
    $('.tf_m_c_map_request_build_price').on('click', '.tf_frm_add .tf_save', function () {
        var form = $(this).parents('.tf_frm_add');
        tf_m_c_map_request_build_price.add.post(form);
    });
});

//---------- ---------- ---------- edit info ---------- ---------- ----------
$(document).ready(function () {
    //get form
    $('.tf_m_c_map_request_build_price').on('click', '.tf_list_object .tf_object_edit', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_map_request_build_price.edit.get(object);
    });

    //post edit
    $('body').on('click', '.tf_frm_edit .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_edit');
        tf_m_c_map_request_build_price.edit.post(formObject);
    });

});

//---------- ---------- ---------- view ----------- ---------- ----------
$(document).ready(function () {
    //view
    $('.tf_m_c_map_request_build_price').on('click', '.tf_list_object .tf_object_view', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_map_request_build_price.view(object);
    });
});