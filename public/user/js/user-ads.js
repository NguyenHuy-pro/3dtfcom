/**
 * Created by 3D on 3/26/2016.
 */
var tf_user_ads = {
    moreLand: function (href, accessUserId, skip, take) {
        var href = href + '/' + accessUserId + '/' + skip + '/' + take;
        tf_master_submit.ajaxNotReloadHasRemove(href, '#tf_user_ads', false, '#tf_user_ads_more');
    },
    image: {
        form: function (object, href) {
            var licenseName = $(object).data('name');
            var href = href + '/' + licenseName;
            tf_master_submit.ajaxNotReload(href, $('#' + tf_master.bodyIdName()), false);
        },
        save: function (form) {
            var businessType = $(form).find('.tf_business_type');
            if (tf_main.tf_checkInputNull('#imageFile', 'Select an image')) {
                return false;
            }
            //check size before upload
            else {
                // check size of image upload
                var limitWidth = $('#imageFile').data('width');
                var limitHeight = $('#imageFile').data('height');
                var uploadWidth = $('#checkFileImage').outerWidth();
                var uploadHeight = $('#checkFileImage').outerHeight();
                if (uploadWidth != limitWidth || uploadHeight != limitHeight) {
                    alert('Wrong image, Request size: (' + limitWidth + ' x ' + limitHeight + ')px, Upload size: (' + uploadWidth + ' x ' + uploadHeight + ')px');
                    $('#imageFile').focus();
                    return false;
                }
            }
            if (tf_main.tf_checkInputNull(businessType, 'Select an business type')) {
                return false;
            }

            $(form).ajaxForm({
                beforeSend: function () {
                    tf_master.tf_main_load_status();
                },
                success: function (data) {
                    if (data) {

                    } else {
                        tf_main.tf_window_reload();
                    }
                },
                complete: function () {
                    tf_master.tf_main_load_status();
                }
            }).submit();

        }
    }

}

$(document).ready(function () {
    //get more info
    $('#tf_user_ads').on('click', '#tf_user_ads_more .tf-link', function () {
        var accessUserId = $(this).data('user');
        var href = $(this).data('href');
        var skip = $(this).data('skip');
        var take = $(this).data('take');
        tf_user_ads.moreLand(href, accessUserId, skip, take);
    });

    $('#tf_user_ads_wrap').on('click', '.tf_user_ads .tf_ads_banner_set_img', function () {
        var href = $(this).data('href');
        var object = $(this).parents('.tf_user_ads_object');
        tf_user_ads.image.form(object, href);
    });

    //save
    $('body').on('click', '#tf_frm_ads_set_image_add .tf_save', function () {
        var form = $(this).parents('#tf_frm_ads_set_image_add');
        tf_user_ads.image.save(form);
    });
});
