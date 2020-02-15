/**
 * Created by 3D on 3/26/2016.
 */
var tf_user_building = {
    moreBuilding: function (href, accessUserId, skip, take) {
        var href = href + '/' + accessUserId + '/' + skip + '/' + take;
        tf_master_submit.ajaxNotReloadHasRemove(href, '#tf_user_building', false, '#tf_user_building_more');
    }

}
//---------- ---------- building list  ---------- ----------
$(document).ready(function () {
    //get more building of user
    $('#tf_user_building').on('click', '#tf_user_building_more .tf-link', function () {
        var accessUserId = $(this).data('user');
        var href = $(this).data('href');
        var skip = $(this).data('skip');
        var take = $(this).data('take');
        tf_user_building.moreBuilding(href, accessUserId, skip, take);
    });
});