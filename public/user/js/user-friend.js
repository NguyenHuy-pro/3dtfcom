/**
 * Created by 3D on 3/26/2016.
 */
var tf_user_friend = {
    friend: {
        moreFriend: function (href, accessUserId, skip, take) {
            var href = href + '/' + accessUserId + '/' + skip + '/' + take;
            tf_master_submit.ajaxNotReloadHasRemove(href, '#tf_user_friend', false, '#tf_user_friend_more');
        },
        delete: function (friendObject) {
            var userId = $(friendObject).data('user');
            var href = $(friendObject).parents('#tf_user_friend').data('href-delete') + '/' + userId;
            tf_master_submit.ajaxNotReloadHasRemove(href, '', false, friendObject);
        }
    },
    friendRequest: {
        //send friend request
        sendRequest: function (href, userId) {
            var href = href + '/' + userId
            tf_master_submit.ajaxHasReload(href, '', false);
        },
        //cancel friend request
        cancelRequest: function (href, userId) {
            if (confirm('Do you want to cancel This request')) {
                tf_master_submit.ajaxHasReload(href + '/' + userId, '', false);
            }
        },
        // get list request of user received
        moreReceiveRequest: function (href, skip, take) {
            var href = href + '/' + skip + '/' + take;
            tf_master_submit.ajaxNotReloadHasRemove(href, '#tf_user_friend_request_receive', false, '#tf_user_friend_request_receive_more');
        },
        //confirm friend request
        confirm: function (href, userId) {
            var href = href + '/' + userId;
            tf_master_submit.ajaxHasReload(href, '', false);
        },
        // get list request of user sent
        moreSentRequest: function (href, skip, take) {
            var href = href + '/' + skip + '/' + take;
            tf_master_submit.ajaxNotReloadHasRemove(href, '#tf_user_friend_request_sent', false, '#tf_user_friend_request_sent_more');
        }
    }

}

//---------- ----------- Friend ----------- -----------
$(document).ready(function () {
    //get more friend of user
    $('#tf_user_friend').on('click', '#tf_user_friend_more .tf-link', function () {
        var accessUserId = $(this).data('user');
        var href = $(this).data('href');
        var skip = $(this).data('skip');
        var take = $(this).data('take');
        tf_user_friend.friend.moreFriend(href, accessUserId, skip, take);
    });

    //---------- confirm request -----------
    $('#tf_user_friend').on('click', '.tf_user_friend_delete', function () {
        var friendObject = $(this).parents('.tf_user_friend_object');
        if (confirm('Do you want to delete?')) {
            tf_user_friend.friend.delete(friendObject);
        }
    });
});

//---------- ----------- request ----------- -----------
$(document).ready(function () {
    //get more request
    $('#tf_user_friend_request_sent').on('click', '#tf_user_friend_request_sent_more .tf-link', function () {
        var href = $(this).data('href');
        var skip = $(this).data('skip');
        var take = $(this).data('take');
        tf_user_friend.friendRequest.moreSentRequest(href, skip, take);
    });
    //cancel request
    $('#tf_user_friend_request_sent').on('click', '.tf_user_friend_request_cancel', function () {
        var href = $(this).data('href');
        var userId = $(this).parents('.tf_user_friend_request_sent_object').data('user');
        tf_user_friend.friendRequest.cancelRequest(href, userId);

    });
});

//---------- ----------- receive ----------- -----------
$(document).ready(function () {
    //confirm (yes)
    $('#tf_user_friend_request_receive').on('click', '.tf_user_friend_confirm_yes', function () {
        var userId = $(this).parents('#tf_user_friend_request_receive_object').data('user');
        var href = $(this).parents('tf_user_friend_request_receive').data('href-yes');
        tf_user_friend.friendRequest.confirm(href, userId);
    });

    //confirm (no)
    $('#tf_user_friend_request_receive').on('click', '.tf_user_friend_confirm_no', function () {
        var userId = $(this).parents('#tf_user_friend_request_receive_object').data('user');
        var href = $(this).parents('tf_user_friend_request_receive').data('href-no');
        tf_user_friend.friendRequest.confirm(href, userId);
    });


    //get more request
    $('#tf_user_friend_request_receive').on('click', '#tf_user_friend_request_receive_more .tf-link', function () {
        var href = $(this).data('href');
        var skip = $(this).data('skip');
        var take = $(this).data('take');
        tf_user_friend.friendRequest.moreReceiveRequest(href, skip, take);
    });
});