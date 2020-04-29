/**
 * Created by HUY on 8/6/2016.
 */
var tf_map_province = {
    object: function () {
        return $('#tf_province');
    },
    idName: function () {
        return 'tf_province';
    },
    idNameAction: function () {
        return '#tf_province';
    },
    className: function () {
        return 'tf_province';
    },
    classNameAction: function () {
        return '.tf_province';
    },
    provinceIdByObject: function (provinceObject) {
        return $(provinceObject).data('province');
    },
    move: function (top, left) {
        $('#tf_province').animate({'top': top, 'left': left});
    },
    onClick: function (provinceObject) {
        tf_master.containerRemove();
        tf_map.mini_map.hide();
        tf_map.mini_map_set_xy();

        //turn off building info
        tf_map_building.menu.hideAll();
        tf_map_building.information.hideAll();

        //turn off banner info
        tf_banner.image.menu.hideAll();
        tf_banner.information.hideAll();

        //turn off footer
        tf_master.footer.hide();
    },
    show: {
        set_center: function (ev) {
            var provinceObject = tf_map_province.object();
            var top_mouse = ev.pageY;
            var left_mouse = ev.pageX;
            var height = screen.height;
            var width = screen.width;
            var top_map = provinceObject.position().top;
            var left_map = provinceObject.position().left;
            var top_center = parseInt(height / 2);
            var left_center = parseInt(width / 2);
            if (top_mouse < top_center) {
                top_map = top_map + (top_center - top_mouse);
            }
            if (top_mouse > top_center) {
                top_map = top_map - (top_mouse - top_center);
            }
            if (left_mouse < left_center) {
                left_map = left_map + (left_center - left_mouse);
            }
            if (left_mouse > left_center) {
                left_map = left_map - (left_mouse - left_center);
            }
            tf_map_province.move(top_map, left_map);
            tf_map_province.onClick(this);
        }
    }
}
//---------- ---------- default ---------- ----------
$(function () {
    //set drag
    $('#tf_province').draggable(
        // set position on mini map (file map.js)
        {
            drag: function () {
                tf_map.mini_map_set_xy();
            }
        }
    );
})

//---------- ---------- event on province ---------- ----------
$(document).ready(function () {
    tf_map_province.object().on('dblclick', function (ev) {
        tf_map_province.show.set_center(ev);
    });

    tf_map_province.object().on('click', function () {
        tf_map_province.onClick();
    });

    //process on mobile
    if (tf_master.accessDevice.isHandset()) {
        tf_map_province.object().on('touchend', function () {
            tf_map_province.onClick();
        });

        //click on <a></a>  //process on mobile
        /*tf_map_province.object().on('touchend', 'a', function () {
            $(this).click();
        });*/
        /*tf_map_province.object().on('touchstart ', 'a', function () {
            $(this).click();
        });*/
    }else{

    }
});
