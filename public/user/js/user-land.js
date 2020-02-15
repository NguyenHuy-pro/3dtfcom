/**
 * Created by 3D on 3/26/2016.
 */
var tf_user_land = {
    invite: {
        cancel: function (href) {
            if (confirm('Do you want to cancel this invitation')) {
                tf_master_submit.ajaxHasReload(href, '', false);
            }
        }
    },
    moreLand: function (href, accessUserId, skip, take) {
        var href = href + '/' + accessUserId + '/' + skip + '/' + take;
        tf_master_submit.ajaxNotReloadHasRemove(href, '#tf_user_land', false, '#tf_user_land_more');
    }

}
//---------- ---------- land list  ---------- ----------
$(document).ready(function () {
    //get more land of user
    $('#tf_user_land').on('click', '#tf_user_land_more .tf-link', function () {
        var accessUserId = $(this).data('user');
        var href = $(this).data('href');
        var skip = $(this).data('skip');
        var take = $(this).data('take');
        tf_user_land.moreLand(href, accessUserId, skip, take);
    });

    //cancel invitation
    $('.tf_user_land_invite_object').on('click', '.tf_cancel', function () {
        var inviteId = $(this).data('invite');
        var href = $(this).data('href') + '/' + inviteId;
        tf_user_land.invite.cancel(href);
    });
});