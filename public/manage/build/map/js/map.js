//=========== =========== ===========  map object =========== =========== ===========
var tf_m_build_map = {
    tool_content_close: function () {
        tf_main.tf_remove('#tf_m_build_tool_build_wrap');
        tf_main.tf_remove('#tf_m_build_tool_manage_wrap');
    },
    tool_build_menu: function (href) {
        this.tool_content_close();
        tf_m_build_submit.ajaxNotReload(href, '#tf_m_build_control_map', false);
    },
    tool_build: {
        sampleProject: {
            view: function (href) {
                var container = $('#tf_m_build_wrapper');
                //alert(href);
                tf_m_build_submit.ajaxNotReload(href, container, false);
            },
            select: function (href) {
                var projectSetup = $('.tf_m_build_province').find('.tf_m_build_project_setup');
                var emptyStatus = true;
                if (projectSetup.find('.tf_m_build_public').length > 0) emptyStatus = false;
                if (projectSetup.find('.tf_m_build_banner').length > 0) emptyStatus = false;
                if (projectSetup.find('.tf_m_build_land').length > 0) emptyStatus = false;

                //check empty project
                if (emptyStatus) {
                    if (confirm('Do you use this sample project?')) {
                        //var area = projectSetup.parents('.tf_m_build_area');
                        var projectSetupId = projectSetup.data('project');
                        href = href + '/' + projectSetupId;
                        tf_m_build_submit.ajaxHasReload(href, '', false);
                    }
                } else {
                    alert('This project must empty');
                    return false;
                }

            }
        },
        background: {
            view: function (href) {
                var container = $('#tf_m_build_wrapper');
                //alert(href);
                tf_m_build_submit.ajaxNotReload(href, container, false);
            },
            select: function (href) {
                var projectSetup = $('.tf_m_build_province').find('.tf_m_build_project_setup');
                if (confirm('Do you use this background?')) {
                    var projectSetupId = projectSetup.data('project');
                    href = href + '/' + projectSetupId;
                    tf_m_build_submit.ajaxHasReload(href, '', false);
                }

            },
            drop: function (href) {
                tf_m_build_submit.ajaxHasReload(href, '', false);
            }
        }
    },
    tool_manage_menu: function (href) {
        this.tool_content_close(); // (this file)
        tf_m_build_submit.ajaxNotReload(href, '#tf_m_build_control_map', false);
    },

    //========== ========== drag ========== =========
    drag: function (evt) {
        evt.dataTransfer.setData('id', evt.target.id);
    },
    allow_drop: function (evt) {
        evt.preventDefault();
    },
    drop: function (evt, object) {       //xay dung public
        evt.preventDefault();
        var projectId = $(object).data('project');
        var data = evt.dataTransfer.getData('id');
        //get build object name
        var objectName = data.substr(0, data.lastIndexOf('-'));
        // get build object ID
        var objectId = parseInt(data.substr(data.lastIndexOf('-') + 1, data.length));
        //get href to process
        var href = '';
        if (objectName == 'build-land') {
            href = $(object).data('href-land');
        }
        if (objectName == 'build-banner') {
            href = $(object).data('href-banner');
        }
        if (objectName == 'build-public') {
            href = $(object).data('href-public');
        }
        // get position of new object
        var topPosition = evt.pageY - $(object).offset().top;
        var leftPosition = evt.pageX - $(object).offset().left;
        topPosition = parseInt(topPosition);
        leftPosition = parseInt(leftPosition);
        if (href.length > 0) {
            $.ajax({
                type: 'GET',
                url: href + '/' + projectId + '/' + objectId + '/' + topPosition + '/' + leftPosition,
                dataType: 'html',
                data: {
                    //areaID: id,loadProvID:prov
                },
                beforeSend: function () {
                    tf_m_build.load_status();
                },
                success: function (data) {
                    if (objectName == 'build-public') {
                        $(object).append(data);
                    } else {
                        tf_main.tf_remove('#tf_m_build_action_wrap');
                        $('#tf_m_build_wrapper').append(data);
                    }
                },
                complete: function () {
                    tf_m_build.load_status();
                }
            });
        }
    },
    move_trend: function (object) {
        var trend = $(object).data('trend');
        var provinceObject = $('#tf_m_build_province');
        var topPosition = provinceObject.position().top;
        var leftPosition = provinceObject.position().left;
        topPosition = parseInt(topPosition);
        leftPosition = parseInt(leftPosition);
        if (trend == 'top') {
            topPosition = topPosition + 896;
        }
        else if (trend == 'right') {
            leftPosition = leftPosition - 896;
        }
        else if (trend == 'bottom') {
            topPosition = topPosition - 896;
        }
        else if (trend == 'left') {
            leftPosition = leftPosition + 896;
        }
        else if (trend == 'center') {
            topPosition = -44800;
            leftPosition = -44800;
        }
        // to new position
        provinceObject.animate({'top': topPosition, 'left': leftPosition});
        var areaX = parseInt(leftPosition / 896);
        var areaY = parseInt(topPosition / 896);

        //load new area
        var urlLoad = $('#tf_m_build_move_map').data('href');
        var provinceID = provinceObject.data('province');
        tf_m_build_area.load_coordinates(urlLoad, provinceID, areaX, areaY); // (file area.js)
        //set coordinates on header (file building.js)
        tf_m_build.coordinate_set_xy(areaX, areaY);

        //set position on mini map (file building.js)
        tf_m_build.mini_map_set_xy();
    }
}

//=========== =========== =========== move trend (control) ============ ========== ===========
$(document).ready(function () {
    //drag move control
    $('#tf_m_build_move_map').draggable();
    //move by move control
    $('#tf_m_build_move_map').on('click', '.move_icon', function () {
        tf_m_build_map.move_trend(this);
    });
});


//============ ========== =========== mini map =========== =========== ===========
$(document).ready(function () {
    // show\hide map content
    $('#tf_m_build_mini_map').mouseover(function () {
        $('#tf_m_build_mini_content').show();

        //load mini map content
        var containMap = $('#tf_m_build_mini_wrap');
        if (!$(this).hasClass('loaded')) {
            var provinceId = $('#tf_m_build_province').data('province');
            var href = containMap.data('href-load-content') + '/' + provinceId;
            tf_m_build_submit.ajaxNotReload(href, containMap, false);
            $(this).addClass('loaded');
        }
    }).mouseout(function () {
        $('#tf_m_build_mini_content').hide();
    });

    // move on map
    $('#tf_m_build_mini_map').on('click', '#tf_m_build_mini_wrap', function (e) {
        var topPosition = e.pageY - $(this).offset().top;
        var leftPosition = e.pageX - $(this).offset().left;
        $("#tf_m_build_mini_y").css("left", leftPosition + 50);
        $("#tf_m_build_mini_x").css("top", topPosition + 50);
        var y = parseInt(topPosition / 2);
        var x = parseInt(leftPosition / 2);

        //load new area on province
        var href = $(this).data('href-load-area');
        var provinceID = $('#tf_m_build_province').data('province');
        tf_m_build_area.load_coordinates(href, provinceID, x, y); // (file area.js)
        // set new position for province
        var provinceTopPosition = y * 896;
        var provinceLeftPosition = x * 896;
        $('#tf_m_build_province').animate({'top': -provinceTopPosition, 'left': -provinceLeftPosition});
    });
});

//============ ========== =========== manage content =========== =========== ===========
$(document).ready(function () {
    //select manage object
    $('#tf_m_build_control_map').on('click', '.tf_m_build_tool_manage_icon', function () {
        var provinceId = $('#tf_m_build_province').data('province');
        var href = $(this).data('href') + '/' + provinceId;
        tf_m_build_map.tool_manage_menu(href);
    });

    //show project menu on province
    $('body').on('change', '.tf_m_build_manage_project_province', function () {
        var provinceId = $(this).val();
        var href = $('#tf_m_build_tool_manage_project').data('href') + '/' + provinceId;
        tf_m_build_map.tool_manage_menu(href);
    });

    //---------- ---------- project publish ---------- ----------
    //show project publish on province
    $('body').on('change', '.tf_m_build_manage_project_publish_province', function () {
        var provinceId = $(this).val();
        var href = $('#tf_m_build_tool_manage_project_publish').data('href');
        href = href + '/' + provinceId;
        tf_m_build_map.tool_manage_menu(href);
    });

    // go to project in login province
    $('body').on('click', '.tf_m_build_tool_manage_project_name', function () {
        var urlLoad = $(this).data('href');
        var provinceId = $(this).data('province');
        var areaX = $(this).data('area-x');
        var areaY = $(this).data('area-y');
        var leftPosition = areaX * 896;
        leftPosition = (leftPosition > 0) ? -leftPosition : leftPosition;
        var topPosition = areaY * 896;
        topPosition = (topPosition > 0) ? -topPosition : topPosition;
        $('#tf_m_build_province').animate({top: topPosition, left: leftPosition});
        //call function load coordinates in file area.js
        tf_m_build_area.load_coordinates(urlLoad, provinceId, areaX, areaY);
    });
});

//=========== ========= ========== build tool ========== ========== ==========
//----------- ---------- select sample type ----------- ------------
$(document).ready(function () {
    //select menu tool
    $('.tf_m_build_tool_menu').on('click', '.tf_m_build_tool_build_icon', function () {
        var href = $(this).data('href');
        tf_m_build_map.tool_build_menu(href);
    });

    //select public
    $('.tf_m_build_tool_menu').on('change', '.tf_m_build_tool_build_public', function () {
        var href = $(this).data('href') + '/' + $(this).val();
        tf_m_build_map.tool_build_menu(href);
    });

    //-------------- sample  project ------------
    $('body').on('click', '.tf_m_build_tool_build_project_object .tf_view', function () {
        var projectSampleId = $(this).parents('.tf_m_build_tool_build_project_object').data('project');
        var href = $(this).data('href') + '/' + projectSampleId;
        tf_m_build_map.tool_build.sampleProject.view(href);
    });

    // select sample project
    $('body').on('click', '.tf_m_build_tool_build_project_object .tf_select', function () {
        var projectSampleId = $(this).parents('.tf_m_build_tool_build_project_object').data('project');
        var href = $(this).data('href') + '/' + projectSampleId;
        tf_m_build_map.tool_build.sampleProject.select(href);
    });

    //-------------- Background ------------
    $('body').on('click', '.tf_m_build_tool_build_background_object .tf_view', function () {
        var backgroundId = $(this).parents('.tf_m_build_tool_build_background_object').data('background');
        var href = $(this).data('href') + '/' + backgroundId;
        tf_m_build_map.tool_build.background.view(href);
    });

    // select sample project
    $('body').on('click', '.tf_m_build_tool_build_background_object .tf_select', function () {
        var backgroundId = $(this).parents('.tf_m_build_tool_build_background_object').data('background');
        var href = $(this).data('href') + '/' + backgroundId;
        tf_m_build_map.tool_build.background.select(href);
    });

    //drop
    $('body').on('click', '.tf_m_build_project_drop_background', function () {
        var projectId = $(this).parents('.tf_m_build_project_menu').data('project');
        var href = $(this).data('href') + '/' + projectId;
        tf_m_build_map.tool_build.background.drop(href);
    });
});