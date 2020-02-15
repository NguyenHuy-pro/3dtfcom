/**
 * Created by 3D on 3/26/2016.
 */
var tf_user_image = {
    //get view more
    viewMore: function (containImageObject) {
        var containerObject = $(containImageObject).find('.tf_list_content');
        var dateTake = containerObject.children('.tf_image_object:last-child').data('date');
        var moreObject = $(containImageObject).find('.tf_view_more');
        var userId = $(containImageObject).data('user');
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

    // view image
    viewImage: function (href) {
        tf_master_submit.ajaxNotReload(href, $('#' + tf_master.bodyIdName()), false);
    },

    //delete image
    deleteImage: function (imageObject) {
        var userId = $(imageObject).data('image');
        var href = $(imageObject).parents('.tf_list_content').data('href-del') + '/' + userId;
        if (confirm('Do you want to delete this image?')) {
            tf_master_submit.ajaxNotReloadHasRemove(href, '', false, imageObject);
        }
    }

}
$(document).ready(function () {
    // all image
    $('#tfUserImage').on('click', '.tf_user_image_container .tf_view_more > a', function () {
        var containImageObject = $(this).parents('.tf_user_image_container');
        tf_user_image.viewMore(containImageObject);

    });

    //view image
    $('#tfUserImage').on('click', '.tf_image_object .tf_view', function () {
        var imageId = $(this).parents('.tf_image_object').data('image');
        var href = $(this).parents('.tf_list_content').data('href-view') + '/' + imageId;
        tf_user_image.viewImage(href);

    });

    //delete image
    $('#tfUserImage').on('mouseover', '.tf_image_object', function () {
        $(this).find('.tf_delete').show();
    }).on('mouseout', '.tf_image_object', function () {
        $(this).find('.tf_delete').hide();
    });

    $('#tfUserImage').on('click', '.tf_image_object .tf_delete', function () {
        var imageObject = $(this).parents('.tf_image_object');
        tf_user_image.deleteImage(imageObject);
    })

})

