/**
 * Created by 3D on 3/26/2016.
 */
var tf_user_point = {
    recharge: {
        viewMore: function (containerObject) {
            var contentObject = $(containerObject).find('.tf_list_content');
            var dateTake = contentObject.children('.tf_recharge_object:last-child').data('date');
            var moreObject = $(containerObject).find('.tf_view_more');
            var userId = $(containerObject).data('user');
            var take = moreObject.find('a').data('take');
            var href = moreObject.find('a').data('href') + '/' + userId + '/' + take + '/' + dateTake;
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
                        contentObject.append(data);
                    } else {
                        tf_main.tf_remove(moreObject);
                    }
                },
                complete: function () {
                    tf_master.tf_main_load_status();
                }
            });
        },
        detail: function (object) {
            var rechargeId = $(object).data('recharge');
            var href = $(object).parents('.tf_user_point_recharge').data('href-view');
            href = href + '/' + rechargeId;
            tf_master_submit.ajaxNotReload(href, $('#' + tf_master.bodyIdName()), false);
        }
    },
    nganluong: {
        viewMore: function (containerObject) {
            var contentObject = $(containerObject).find('.tf_list_content');
            var dateTake = contentObject.children('.tf_nganluong_object:last-child').data('date');
            var moreObject = $(containerObject).find('.tf_view_more');
            var userId = $(containerObject).data('user');
            var take = moreObject.find('a').data('take');
            var href = moreObject.find('a').data('href') + '/' + userId + '/' + take + '/' + dateTake;
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
                        contentObject.append(data);
                    } else {
                        tf_main.tf_remove(moreObject);
                    }
                },
                complete: function () {
                    tf_master.tf_main_load_status();
                }
            });
        },
        detail: function (object) {
            var objectId = $(object).data('order');
            var href = $(object).parents('.tf_user_point_nganluong').data('href-view');
            href = href + '/' + objectId;
            tf_master_submit.ajaxNotReload(href, $('#' + tf_master.bodyIdName()), false);
        }
    }

}
//recharge
$(document).ready(function () {
    // detail
    $('body').on('click', '.tf_recharge_object .tf_view', function () {
        var object = $(this).parents('.tf_recharge_object');
        tf_user_point.recharge.detail(object);
    });

    //get view more
    $('body').on('click', '.tf_user_point_recharge .tf_view_more > a', function () {
        var containerObject = $(this).parents('.tf_user_point_recharge');
        tf_user_point.recharge.viewMore(containerObject);
    });
});

//nganluong.vn
$(document).ready(function () {
    // detail
    $('body').on('click', '.tf_nganluong_object .tf_view', function () {
        var object = $(this).parents('.tf_nganluong_object');
        tf_user_point.nganluong.detail(object);
    });

    //get view more
    $('body').on('click', '.tf_user_point_nganluong .tf_view_more > a', function () {
        var containerObject = $(this).parents('.tf_user_point_nganluong');
        tf_user_point.nganluong.viewMore(containerObject);
    });
});