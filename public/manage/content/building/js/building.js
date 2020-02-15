/**
 * Created by HUY on 11/30/2016.
 */
var tf_m_c_building_building = {
    //View
    view: function(object){
        var buildingId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-view') + '/' + buildingId;
        tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
        tf_main.tf_scrollTop();
    },

    //status
    updateStatus: function (object) {
        var buildingId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-status') + '/' + buildingId;
        tf_manage_submit.ajaxHasReload(href, '', false);
    },

    //delete
    delete: function (object) {
        if(confirm('Do you to delete this record?')){
            var buildingId = $(object).data('object');
            var href = $(object).parents('.tf_list_object').data('href-del') + '/' + buildingId;
            tf_manage_submit.ajaxHasReload(href, '', false);
        }
    }
}


$(document).ready(function () {
    //view
    $('.tf_m_c_building_building').on('click', '.tf_list_object .tf_object_view', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_building_building.view(object);
    });


    //update status
    $('.tf_m_c_building_building').on('click', '.tf_list_object .tf_object_status', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_building_building.updateStatus(object);
    });

    //delete building
    $('.tf_m_c_building_building').on('click', '.tf_list_object .tf_object_delete', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_building_building.delete(object);
    });
});