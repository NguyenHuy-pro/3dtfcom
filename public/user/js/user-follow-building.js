/**
 * Created by 3D on 3/26/2016.
 */
var tf_user_follow_building = {
    viewMore: function (containFollowObject) {
        var userId = $(containFollowObject).data('user');
        var containerObject = $(containFollowObject).find('.tf_list_content');
        var dateTake = containerObject.children('.tf_follow_object:last-child').data('date');

        var moreObject = $(containFollowObject).find('.tf_view_more');
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
                    containerObject.append(data);
                } else {
                    tf_main.tf_remove(moreObject);
                }
            },
            complete: function () {
                tf_master.tf_main_load_status();
            }
        });
    },
    //delete image
    deleteFollow: function (followObject) {
        var buildingId = $(followObject).data('building');
        var href = $(followObject).parents('.tf_list_content').data('href-del') + '/' + buildingId;
        if (confirm('Do you want to delete this follow?')) {
            tf_master_submit.ajaxNotReloadHasRemove(href, '', false, followObject);
        }
    }

}
$(document).ready(function () {
    //get more
    $('#tfUserFollow').on('click', '.tf_user_follow_container .tf_view_more > a', function () {
        var containFollowObject = $(this).parents('.tf_user_follow_container');
        tf_user_follow_building.viewMore(containFollowObject);

    });

    //delete follow
    $('#tfUserFollow').on('click', '.tf_follow_object .tf_delete', function () {
        var followObject = $(this).parents('.tf_follow_object');
        tf_user_follow_building.deleteFollow(followObject);
    })

});

