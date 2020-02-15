/**
 * Created by 3D on 3/26/2016.
 */
var tf_user_share = {
    //object: banner + land + building
    viewMore: function (containerObject) {
        var contentObject = $(containerObject).find('.tf_list_content');
        var dateTake = contentObject.children('.tf_share_object:last-child').data('date');
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
    detail: function (shareObject) {
        var shareId = $(shareObject).data('share');
        var href = $(shareObject).parents('.tf_user_share_container').data('href-view');
        href = href + '/' + shareId;
        tf_master_submit.ajaxNotReload(href, $('#' + tf_master.bodyIdName()), false);
    }
}

$(document).ready(function () {
    // detail
    $('body').on('click', '.tf_share_object .tf_view', function () {
        var shareObject = $(this).parents('.tf_share_object');
        tf_user_share.detail(shareObject);
    });

    //get view more
    $('body').on('click', '.tf_user_share_container .tf_view_more > a', function () {
        var containerObject = $(this).parents('.tf_user_share_container');
        tf_user_share.viewMore(containerObject);
    });
});