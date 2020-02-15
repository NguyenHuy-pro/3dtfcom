/**
 * Created by 3D on 3/22/2016.
 */
/**
 * Created by 3D on 3/19/2016.
 */
var tf_map_project = {
    objectById: function (areaId) {
        return $('#tf_project_' + areaId);
    },
    idName: function (areaId) {
        return 'tf_project_' + areaId;
    },
    idNameAction: function (areaId) {
        return '#tf_project_' + areaId;
    },
    className:function(){
        return 'tf_project';
    },
    classNameAction:function(){
        return '.tf_project';
    },
}
$(document).ready(function () {
    /* edit avatar */
    $('.project-avatar-edit-a').on('click', function () {
        var u = $(this).data('url');
        var id = $(this).data('id');
        $.ajax({
            url: u + '/' + id,
            type: 'GET',
            cache: false,
            data: {'id': id},
            success: function (data) {
                $('#containAction').append(data);
                $('#containAction').show();
            }
        });
    });
    /* end edit avatar */
});

