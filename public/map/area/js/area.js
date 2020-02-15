/**
 * Created by 3D on 3/22/2016.
 */
var tf_area = {
    objectById: function (areaId) {
        return $('#tf_area_' + areaId);
    },
    idName: function (areaId) {
        return 'tf_area_' + areaId;
    },
    idNameAction: function (areaId) {
        return '#tf_area_' + areaId;
    },
    className: function () {
        return 'tf_area';
    },
    classNameAction: function () {
        return '.tf_area';
    },
    areaIdByObject: function (areaObject) {
        return $(areaObject).data('area');
    },
    access: {
        addWatching: function (areaWatching) {
            $(areaWatching).addClass('tf_map_area_watching');
        },
        removeWatching: function (areaWatching) {
            $(areaWatching).removeClass('tf_map_area_watching');
        },
        removeAllWatching: function () {
            $('.tf_province .tf_area').filter(function () {
                if (tf_area.access.checkWatching(this)) {
                    tf_area.access.removeWatching(this);
                }
            });
        },
        checkWatching: function (areaWatching) {
            if ($(areaWatching).hasClass('tf_map_area_watching')) {
                return true;
            } else {
                return false;
            }
        }

    },
    provinceObject: function (areaObject) {
        return $(areaObject).parents(tf_map_province.classNameAction());
    },
    show: {
        checkTop: function (areaObject) {
            if ($(areaObject).hasClass('tf-area-top')) {
                return true;
            } else {
                return false;
            }
        },
        showTop: function (areaObject) {
            //turn off top status of other areas
            tf_area.show.hideAllTop();
            $(areaObject).addClass('tf-area-top');
        },
        hideTop: function (areaObject) {
            $(areaObject).removeClass('tf-area-top');
        },
        hideAllTop: function () {
            $('.tf_province .tf_area').filter(function () {
                if (tf_area.show.checkTop(this)) {
                    tf_area.show.hideTop(this);
                }
            });
        },
        mouseMove: function (areaObject) {

        },
        mouseOver: function (areaObject) {
            //'tf_area_watching' have to insert where visit land or banner
            if (tf_area.access.checkWatching(areaObject)) {
                //turn on watching status
                tf_area.show.showTop(areaObject);
            } else {
                /*
                 tf_area.access.removeAllWatching();
                 tf_area.show.hideAllTop();

                 tf_area.access.addWatching();
                 tf_area.show.showTop(areaObject);
                 */

            }

        },
        mouseOut: function (areaObject) {

        }
    },
    //set position
    set_position: function (object) {
        var areaId = $(object).data('area');
        if (!$(object).hasClass('set-position')) // first mouseup on area
        {
            $('.tf_area').removeClass('set-position'); // remove set history
            var href = $(object).data('href-position');
            $(object).addClass('loaded');
            $.ajax({
                type: 'GET',
                url: href + '/' + areaId,
                dataType: 'html',
                data: {}
            });
            $(object).addClass('set-position');
        }
    },

    // load area when mouse move
    load_move: function (object) {
        if (!$(object).hasClass('loaded')) { // not yet loaded around area
            var areaId = $(object).data('area');
            var provinceObject = $(object).parents('.tf_province');
            var provinceId = provinceObject.data('province');
            var urlLoad = $(object).data('href-load');
            $(object).addClass('loaded');
            $.ajax({
                type: 'GET',
                url: urlLoad + '/' + provinceId + '/' + areaId,
                dataType: 'html',
                data: {},
                beforeSend: function () {
                    tf_master.tf_main_load_status();
                },
                success: function (data) {
                    provinceObject.append(data);
                },
                complete: function () {
                    tf_master.tf_main_load_status();
                }
            });
        }
    },

    //load when select coordinates
    load_coordinates: function (urlLoad, provinceId, areaX, areaY) {
        var x = (areaX < 0) ? -areaX : areaX;
        var y = (areaY < 0) ? -areaY : areaY;
        var href = urlLoad + '/' + provinceId + '/' + x + '/' + y;
        tf_master_submit.ajaxNotReload(href, tf_map_province.idNameAction(), false);
    },
    zoom: {
        get: function (href) {
            var provinceObject = tf_map_province.object();//// $('#tf_province');
            var provinceId = tf_map_province.provinceIdByObject(provinceObject);//// provinceObject.data('province');
            var provinceTop = provinceObject.position().top;
            var provinceLeft = provinceObject.position().left;
            var areaId = $('.tf_area_watching').data('area');
            var href = href + '/' + provinceId + '/' + areaId + '/' + provinceTop + '/' + provinceLeft;
            tf_master_submit.ajaxNotReload(href, tf_master.bodyObject(), false);
        },
        province: {
            onCLick: function (e, areaObject) {
                var areaTop = $(areaObject).position().top;
                var areaLeft = $(areaObject).position().left;

                var provinceZoom = $(areaObject).parents('#tf_map_area_zoom_province');
                //load if not exist
                var provinceId = provinceZoom.data('province');
                var href = provinceZoom.data('href');
                var zoom = provinceZoom.data('zoom');

                //position of mouse when click on view
                var mouseX = e.pageX;
                var mouseY = e.pageY;

                //position of area on view
                var areaViewTop = parseInt($(areaObject).offset().top);
                var areaViewLeft = parseInt($(areaObject).offset().left);

                //get position of mouse on area
                if (areaViewTop < 0) {
                    positionOnAreaTop = mouseY + (-areaViewTop);
                } else if (areaViewTop == 0) {
                    positionOnAreaTop = mouseY;
                } else {
                    positionOnAreaTop = mouseY - areaViewTop;
                }

                if (areaViewLeft < 0) {
                    positionOnAreaLeft = mouseX + (-areaViewLeft);
                } else if (areaViewLeft == 0) {
                    positionOnAreaLeft = mouseX;
                } else {
                    positionOnAreaLeft = mouseX - areaViewLeft;
                }

                //set position of province on big map
                positionTopOnAreaOfBigMap = positionOnAreaTop * zoom;
                positionLeftOnAreaOfBigMap = positionOnAreaLeft * zoom;

                areaTop = areaTop * zoom;
                areaLeft = areaLeft * zoom;

                //set center
                var viewLimitHeight = tf_map.viewMap.objectAction().outerHeight() / 2;
                var viewLimitWidth = tf_map.viewMap.objectAction().outerWidth() / 2;

                if (positionTopOnAreaOfBigMap < viewLimitHeight) {
                    var newTopPosition = parseInt(areaTop - (viewLimitHeight - positionTopOnAreaOfBigMap) - 32);
                } else if (positionTopOnAreaOfBigMap > viewLimitHeight) {
                    var newTopPosition = parseInt(areaTop + (positionTopOnAreaOfBigMap - viewLimitHeight) + 32);
                } else {
                    var newTopPosition = parseInt(areaTop + 32);
                }
                if (positionLeftOnAreaOfBigMap < viewLimitWidth) {
                    var newLeftPosition = parseInt(areaLeft - (viewLimitWidth - positionLeftOnAreaOfBigMap));
                } else if (positionLeftOnAreaOfBigMap > viewLimitWidth) {
                    var newLeftPosition = parseInt(areaLeft + (positionLeftOnAreaOfBigMap - viewLimitWidth));
                } else {
                    var newLeftPosition = parseInt(areaLeft);
                }

                tf_master.tf_main_contain_action_close();
                $('#tf_province').animate({'top': -newTopPosition, 'left': -newLeftPosition});
                tf_area.load_move(areaObject);
            }
        }
    }
};

//----------- ----------- load ----------- -----------
$(document).ready(function () {
    $('#tf_province').on('mousemove', tf_area.classNameAction(), function () {
        tf_area.load_move(this);
        tf_area.show.mouseMove(this);
    }).on('mouseup', tf_area.classNameAction(), function () {
        tf_area.set_position(this);
    });
});

//----------- ----------- show ----------- -----------
$(document).ready(function () {
    $('body').on('mouseover', tf_area.classNameAction(), function () {
        tf_area.show.mouseOver(this);
    }).on('mouseout', tf_area.classNameAction(), function () {
        tf_area.show.mouseOut(this);
    });
});

//----------- ----------- zoom ---------- ------------
$(document).ready(function () {
    //get zoom
    $('body').on('click', '#tf_map_area_zoom_icon', function () {
        tf_area.zoom.get($(this).data('href'));
    });
    //go to project
    $('body').on('click', '#tf_map_area_zoom_province .tf_map_area_zoom_project', function (e) {
        var areaObject = $(this).parents('.tf_map_area_zoom_object');
        tf_area.zoom.province.onCLick(e, areaObject);
    });
});
