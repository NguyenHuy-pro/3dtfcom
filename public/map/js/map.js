var tf_map = {
    viewMap:{
        objectAction: function () {
            return $('#tf_main_view_map');
        },
        idName: function () {
            return 'tf_main_view_map';
        },
        idNameAction: function () {
            return '#tf_main_view_map';
        },
    },

    mini_map: {
        getContent: function () {

        },
        hide: function () {
            tf_main.tf_hide('#tf_mini_map');
        }
    },
    mini_map_set_xy: function () {
        var topPosition = $('#tf_province').position().top;
        var leftPosition = $('#tf_province').position().left;
        var x = parseInt(leftPosition / 896);
        var y = parseInt(topPosition / 896);
        x = (x < 0) ? -x : x;
        y = (y < 0) ? -y : y;
        $("#tf_mini_map_y").css("left", x * 2 + 25 + 2); // 1 ->middle project (2px)
        $("#tf_mini_map_x").css("top", y * 2 + 25 + 2);
    },
    move_map: {
        move_trend: function (object) {
            var viewWidth = tf_map.viewMap.objectAction().outerWidth();
            var viewHeight = tf_map.viewMap.objectAction().outerHeight();
            var yMove = parseInt(viewHeight / 2);
            var xMove = parseInt(viewWidth / 2);

            var trend = $(object).data('trend');
            var urlLoad = $(object).data('href');
            var provinceObject = $('#tf_province');
            var topPosition = provinceObject.position().top;
            var leftPosition = provinceObject.position().left;
            switch (trend) {
                case 'top':
                {
                    topPosition = topPosition + yMove;
                    tf_map.move_map.move(provinceObject, topPosition, leftPosition, urlLoad);
                    break;
                }
                case 'right':
                {
                    leftPosition = leftPosition - xMove;
                    tf_map.move_map.move(provinceObject, topPosition, leftPosition, urlLoad);
                    break;
                }
                case 'bottom':
                {
                    topPosition = topPosition - yMove;
                    tf_map.move_map.move(provinceObject, topPosition, leftPosition, urlLoad);
                    break;
                }
                case 'left':
                {
                    leftPosition = leftPosition + xMove;
                    tf_map.move_map.move(provinceObject, topPosition, leftPosition, urlLoad);
                    break;
                }
            }
            /*
             if (trend == 'top') {
             topPosition = topPosition + yMove;
             }
             else if (trend == 'right') {
             leftPosition = leftPosition - xMove;
             }
             else if (trend == 'bottom') {
             topPosition = topPosition - yMove;
             }
             else if (trend == 'left') {
             leftPosition = leftPosition + xMove;
             }
             else if (trend == 'center') {
             topPosition = -44800;
             leftPosition = -44800;
             }
             */
        },
        move: function (provinceObject, top, left, urlLoad) {
            // to new position
            $(provinceObject).animate({'top': top, 'left': left});
            var areaX = parseInt(left / 896);
            var areaY = parseInt(top / 896);

            //load new area
            var provinceId = $(provinceObject).data('province');
            tf_area.load_coordinates(urlLoad, provinceId, areaX, areaY); // (file area.js)
        }
    },
    market: {

        remove: function () {
            tf_main.tf_remove('#tf_map_market_wrap');
        },
        getContent: function (href) {
            tf_map.mini_map.hide();
            //get new content
            tf_master.containerRemove();
            tf_master_submit.ajaxNotReload(href, '#tf_main_content', false);
            //tf_master_submit.ajaxNotReloadHasRemove(href, , false, '.tf_main_wrap');
        }
    },
    filter: {
        hideBusinessTypeList: function () {
            tf_main.tf_hide('#tf_map_business_type_filter');
        },
        businessTypeList: function (href) {
            if ($('#tf_map_business_type_filter').length > 0) {
                $('#tf_map_business_type_filter').toggle();
            } else {
                var container = $('.tf_master_show_business');
                tf_master_submit.ajaxNotReload(href, container, false);
            }

        },
        businessType: function (href) {
            tf_master_submit.ajaxHasReload(href, '', false);
        }
    },

}
//========== ========== ========== begin ========== ========== ==========

window.onload = function () {
    //set position when access land
    var landAccess = $('body').find('.tf_land_access');
    if (landAccess.length > 0) {
        var landId = landAccess.data('land');
        tf_land.show.set_center(landId);
    }
    ;

    //set position when access banner
    var bannerAccess = $('body').find('.tf_banner_access');
    if (bannerAccess.length > 0) {
        var bannerId = bannerAccess.data('banner');
        tf_banner.show.set_center(bannerId);
    }
};


//========== ========== ========= Mini map ========= ========= =========
$(document).ready(function () {
    //show mini map
    $('#tf_main_header_mini_map').on('click', function () {
        tf_master.containerRemove();
        var provinceId = $(this).data('province');
        var href = $(this).data('href');
        href = href + '/' + provinceId;
        if ($('#tf_mini_map').length > 0) {
            $('#tf_mini_map').toggle();
        } else {
            tf_master_submit.ajaxNotReload(href, '#tf_main_content', false);
        }
    });

    // move in on the map.
    $('body').on('click', '#tf_mini_map_content', function (e) {
        var topPosition = e.pageY - $(this).offset().top;
        var leftPosition = e.pageX - $(this).offset().left;
        $("#tf_mini_map_y").css("left", leftPosition + 25);
        $("#tf_mini_map_x").css("top", topPosition + 25);

        //load new area on province
        var y = parseInt(topPosition / 2);
        var x = parseInt(leftPosition / 2);
        var href = $(this).data('href-load-area');
        var provinceId = $('#tf_province').data('province');
        tf_area.load_coordinates(href, provinceId, x, y);

        // set new position for province
        var provinceTopPosition = (y - 1) * 896;
        var provinceLeftPosition = (x - 1) * 896;
        $('#tf_province').animate({'top': -provinceTopPosition, 'left': -provinceLeftPosition});

    });

    //select country
    $('body').on('change', '#tf_mini_map #miniMapCountry', function () {
        var countryId = $(this).val();
        var href = $(this).data('href') + '/' + countryId;
        tf_main.tf_url_replace(href);
    });

    //select province
    $('body').on('change', '#tf_mini_map #miniMapProvince', function () {
        var provinceId = $(this).val();
        var href = $(this).data('href') + '/' + provinceId;
        tf_main.tf_url_replace(href);
    });
});

//=========== =========== =========== Move trend (control) ============ ========== ===========
$(document).ready(function () {
    $('body').on('click', '.tf_map_move_trend', function () {
        tf_map.move_map.move_trend(this);
    });
});

//========== ========== ========== Market ========== ========== ==========
$(document).ready(function () {
    //get market on header
    $('#tf_map_market_get').on('click', function () {
        var countryId = $(this).data('country');
        var provinceId = $(this).data('province');
        var href = $(this).data('href') + '/' + countryId + '/' + provinceId;
        tf_map.market.getContent(href);
    });

    //get free land
    $('body').on('change', '.tf_map_market_menu_object', function () {
        var countryId = $('#tf_map_market_country').val();
        var provinceId = $('#tf_map_market_province').val();
        var href = $(this).val() + '/' + countryId + '/' + provinceId;
        tf_map.market.getContent(href);
    });

    //get content follow country
    $('body').on('change', '#tf_map_market_country', function () {
        var countryId = $(this).val();
        //get href of current object
        var href = $('.tf_map_market_menu_object').val();
        if (href != '') tf_map.market.getContent(href + '/' + countryId);
    });

    //get content follow province
    $('body').on('change', '#tf_map_market_province', function () {
        var provinceId = $(this).val();
        var countryId = $('#tf_map_market_country').val();
        var href = $('.tf_map_market_menu_object').val();
        if (href != '') tf_map.market.getContent(href + '/' + countryId + '/' + provinceId);
    });

    //go to position of land on map
    $('body').on('click', '.tf_market_land_name', function () {
        var landId = $(this).data('land');
        var areaId = $(this).data('area');
        var accessProvinceId = $(this).data('province'); // province contain land
        var currentProvinceId = $('#tf_province').data('province');
        var landHref = $(this).parents('.tf_market_land_contain').data('href-land');
        var areaHref = $(this).parents('.tf_market_land_contain').data('href-area');
        tf_land.show.position(currentProvinceId, accessProvinceId, areaId, landId, landHref, areaHref);
    });

    //go to position of banner on map
    $('body').on('click', '.tf_market_banner_name', function () {
        var bannerId = $(this).data('banner');
        var areaId = $(this).data('area');
        var accessProvinceId = $(this).data('province');
        var currentProvinceId = $('#tf_province').data('province');
        var bannerHref = $(this).parents('.tf_market_banner_contain').data('href-banner');
        var areaHref = $(this).parents('.tf_market_banner_contain').data('href-area');
        tf_banner.show.position(currentProvinceId, accessProvinceId, areaId, bannerId, bannerHref, areaHref);
    });

});

//========== =========== ========== Filter ============ ========== =========
$(document).ready(function () {
    //business type
    $('body').on('click', '.tf_master_show_business .tf_business_type', function () {
        var href = $(this).data('href');
        tf_map.mini_map.hide();
        tf_master.search.hide();
        tf_map.filter.businessTypeList(href);
    });

    //show business
    $('body').on('mouseover', '#tf_map_business_type_filter .tf-map-business-type-object', function () {
        $(this).find('.tf_map_business_object_wrap').show();
    }).on('mouseout', '', function () {
        $(this).find('.tf_map_business_object_wrap').hide();
    });

    $('body').on('click', '.tf_map_business_type_object .tf_name', function () {
        tf_master.search.hide();
        tf_map.mini_map.hide();
        var businessTypeId = $(this).data('business-type');
        var href = $(this).parents('.tf_map_business_type_object_wrap').data('href');
        href = href + '/' + businessTypeId;
        tf_map.filter.businessType(href);
    });
});
