/**
 * Created by 3D on 3/26/2016.
 */
var tf_users = {
    //avatar and banner
    title: {
        //banner
        banner: {
            viewDetail: function (href) {
                tf_master_submit.ajaxNotReload(href, $('#' + tf_master.bodyIdName()), false);
            },
            getEdit: function (href) {
                tf_master_submit.ajaxNotReload(href, $('#' + tf_master.bodyIdName()), false);
            },
            postEdit: function (formObject) {
                var imageObject = $(formObject).find("input[name='bannerImage']");
                if (tf_main.tf_checkInputNull(imageObject, 'You must select an image')) {
                    return false;
                } else {
                    tf_master_submit.ajaxFormHasReload(formObject, '', false);
                }
            },
            delete: function (href) {
                tf_master_submit.ajaxHasReload(href, '', false);
            },
        },
        //Avatar
        avatar: {
            viewDetail: function (href) {
                tf_master_submit.ajaxNotReload(href, $('#' + tf_master.bodyIdName()), false);
            },
            getEdit: function (href) {
                tf_master_submit.ajaxNotReload(href, $('#' + tf_master.bodyIdName()), false);
            },
            postEdit: function (formObject) {
                var imageObject = $(formObject).find("input[name='avatarImage']");
                if (tf_main.tf_checkInputNull(imageObject, 'You must select an image')) {
                    return false;
                } else {
                    tf_master_submit.ajaxFormHasReload(formObject, '', false);
                }
            },
            delete: function (href) {
                tf_master_submit.ajaxHasReload(href, '', false);
            }
        },
        friend:{
            //send friend request
            sendRequest: function (href, userId) {
                var href = href + '/' + userId
                tf_master_submit.ajaxHasReload(href, '', false);
            },
            //cancel friend request
            cancelRequest: function (href, userId) {
                var href = href + '/' + userId
                tf_master_submit.ajaxHasReload(href, '', false);
            },

            //confirm friend request
            confirm: function (href, userId) {
                var href = href + '/' + userId;
                tf_master_submit.ajaxHasReload(href, '', false);
            },
            delete: function (href, userId) {
                if(confirm('Do you to delete friend?')){
                    tf_master_submit.ajaxHasReload(href + '/' + userId, '', false);
                }
            }
        }

    },
    love: function (href, loveUserId) {
        tf_master_submit.ajaxHasReload(href + '/' + loveUserId, '', false);
    }
}

//========== ========== ========== Begin ========== ========== ==========
$(document).ready(function () {
    $('body').on('click', '#tf_user_wrapper', function () {
        tf_master.containerRemove();
    })

    //on top
    if ($(".tf_user_on_top").length > 0) {
        $('#tf_user_wrapper').scroll(function () {
            var e = $('#tf_user_wrapper').scrollTop();
            if (e > 300) {
                $(".tf_user_on_top").show()
            } else {
                $(".tf_user_on_top").hide()
            }
        });
        $(".tf_user_on_top").on('click', '.tf_action', function () {
            $('#tf_user_wrapper').animate({
                scrollTop: 0
            })
        })
    }
});

//========== ========== ========== Title ========== ========== ==========

//---------- ----------- Banner ----------- -----------
$(document).ready(function () {
    //view detail
    $('.tf_user_title_banner').on('click', '.tf_banner_view', function () {
        var imageId = $(this).data('image');
        var href = $(this).data('href') + '/' + imageId;
        tf_users.title.banner.viewDetail(href)
    });

    //get form
    $('.tf_user_title_banner').on('click', '.tf_banner_edit_get', function () {
        var href = $(this).data('href');
        tf_users.title.banner.getEdit(href);
    });

    //submit form
    $('body').on('click', '#frmUserBannerEdit .tf_banner_edit_post', function () {
        tf_users.title.banner.postEdit('#frmUserBannerEdit');
    });

    //delete banner
    $('.tf_user_title_banner').on('click', '.tf_banner_delete', function () {
        var imageId = $(this).data('image');
        var href = $(this).data('href') + '/' + imageId;
        tf_users.title.banner.delete(href);
    });
});

//---------- ----------- Avatar ----------- -----------
$(document).ready(function () {
    //view detail
    $('.tf_user_title_avatar').on('click', '.tf_avatar', function () {
        var imageId = $(this).data('image');
        var href = $(this).data('href') + '/' + imageId;
        tf_users.title.avatar.viewDetail(href);
    });

    //get form
    $('.tf_user_title_avatar').on('click', '.tf_avatar_edit_get', function () {
        var href = $(this).data('href');
        tf_users.title.avatar.getEdit(href);
    });

    //submit form
    $('body').on('click', '#frmUserAvatarEdit .tf_avatar_edit_post', function () {
        tf_users.title.avatar.postEdit('#frmUserAvatarEdit');
    });

    //delete avatar
    $('.tf_user_title_avatar').on('click', '.tf_avatar_delete', function () {
        var imageId = $(this).data('image');
        var href = $(this).data('href') + '/' + imageId;
        tf_users.title.avatar.delete(href);
    });
});
//---------- ----------- friend ----------- -----------
$(document).ready(function(){
    $('#tf_user_title_friend').on('click', '.tf_friend_request', function () {
        var href = $(this).data('href');
        var userId = $('#tf_user_title_friend').data('user');
        tf_users.title.friend.sendRequest(href, userId);
    });

    //cancel request
    $('#tf_user_title_friend').on('click', '.tf_friend_request_cancel', function () {
        var href = $(this).data('href');
        var userId = $('#tf_user_title_friend').data('user');
        tf_users.title.friend.cancelRequest(href, userId);
    });

    //agree (yes)
    $('#tf_user_title_friend').on('click', '.tf_user_friend_confirm_yes', function () {
        // get user id sent request
        var userId = $(this).parents('#tf_user_title_friend').data('user');
        var href = $(this).data('href');
        tf_users.title.friend.confirm(href, userId);
    });

    //don't agree (no)
    $('#tf_user_title_friend').on('click', '.tf_user_friend_confirm_no', function () {
        var userId = $(this).parents('#tf_user_title_friend').data('user');
        var href = $(this).data('href');
        tf_users.title.friend.confirm(href, userId);
    });

    //delete friend
    $('body').on('click', '#tf_user_title_friend .tf_friend_delete', function () {
        var href = $(this).data('href');
        var userId = $('#tf_user_title_friend').data('user');
        tf_users.title.friend.delete(href, userId);
    });
})

//========== ========== ========== Menu =========== ======== ========
$(document).ready(function () {
    $('body').on('click', '.tf_m_user_menu_icon', function () {
        $('.tf_user_menu').toggle();
    })
});

//========== ========== ========== LOVE USER ========== ========== ==========
$(document).ready(function () {
    $('#tf_user_wrapper').on('click', '.tf_user_love', function () {
        var href = $(this).data('href');
        var userId = $(this).data('user');
        tf_users.love(href, userId);
    });

});