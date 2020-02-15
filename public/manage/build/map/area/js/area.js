/**
 * Created by HUY on 4/15/2016.
 */
var tf_m_build_area = {

    actionHref: '',
    //set position
    set_position: function (object) {
        var areaId = $(object).data('area');
        if (!$(object).hasClass('set-position')) // first mouseup on area
        {
            $('.tf_m_build_area').removeClass('set-position'); // remove set history
            var urlSetPosition = $(object).data('href-position');
            $(object).addClass('loaded');
            $.ajax({
                type: 'GET',
                url: urlSetPosition + '/' + areaId,
                dataType: 'html',
                data: {}
            });
            $(object).addClass('set-position');
        }
    },

    // load area when mouser move
    load_move: function (object) {
        if (!$(object).hasClass('loaded')) { // not yet loaded around area
            var areaID = $(object).data('area');
            var provinceID = $('#tf_m_build_province').data('province');
            var href = $(object).data('href') + '/' + provinceID + '/' + areaID;
            $(object).addClass('loaded');
            tf_m_build_submit.ajaxNotReload(href,'#tf_m_build_province',false);
        }
    },


    //load when select coordinates
    load_coordinates: function (urlLoad, provinceID, areaX, areaY) {
        var x = (areaX < 0) ? -areaX : areaX;
        var y = (areaY < 0) ? -areaY : areaY;
        var href = urlLoad + '/' + provinceID + '/' + x + '/' + y;
        tf_m_build_submit.ajaxNotReload(href,'#tf_m_build_province',false);
    },

};

//=========== =========== =========== get form add project =========== =========== ===========
$(document).ready(function () {
    $('body').on('click', '.tf_m_build_area_open_get', function () {
        var areaObject = $(this).parents('.tf_m_build_area');
        var areaId = areaObject.data('area');
        var provinceId = areaObject.parents('.tf_m_build_province').data('province');
        var href = $(this).data('href');
        $.ajax({
            type: 'GET',
            url: href + '/' + provinceId + '/' + areaId,
            dataType: 'html',
            data: {
                //data
            },
            beforeSend: function () {
                tf_m_build.load_status();
            },
            success: function (data) {
                tf_m_build.contain_action_close();
                areaObject.append(data);
            },
            complete: function () {
                tf_m_build.load_status();
            }
        });
    });
});

$(document).ready(function () {
    $('.tf_m_build_province').on('mousemove', '.tf_m_build_area', function () {
        tf_m_build_area.load_move(this);
    }).on('mouseup', '.tf_m_build_area', function () {
        tf_m_build_area.set_position(this);
        var provinceObject = $(this).parents('#tf_m_build_province');
        var topPosition = provinceObject.position().top;
        var leftPosition = provinceObject.position().left;
        var x = parseInt(leftPosition / 896);
        var y = parseInt(topPosition / 896);
        // set x , y on header (file building.js)
        tf_m_build.coordinate_set_xy(x, y);
        // set position on mini map ( file building.js)
        tf_m_build.mini_map_set_xy();
    });
});
