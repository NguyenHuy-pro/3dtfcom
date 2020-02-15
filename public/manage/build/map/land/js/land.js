/**
 * Created by HUY on 4/15/2016.
 */
//=========== =========== =========== OVER \ OUT ON LAND =========== =========== ===========
$(document).ready(function () {
    $('body').on('mouseover', '.tf_m_build_land', function () {
        //open Priority display
        tf_main.tf_show_top($(this));

        tf_main.tf_show($(this).children('.tf_m_build_land_menu'));
    }).on('mouseout', '.tf_m_build_land', function () {
        //off Priority display
        tf_main.tf_hide_top($(this));

        tf_main.tf_hide($(this).children('.tf_m_build_land_menu'));
    });
});

//=========== =========== =========== MOVE LAND =========== =========== ===========
//---------- ----------- turn on move ----------- ----------
$(document).ready(function () {
    $('body').on('click', '.tf_m_build_land_move_status', function () {
        var landObject = $(this).parents('.tf_m_build_land');
        if (!landObject.hasClass('moving')) {
            landObject.addClass('moving');
            $(this).removeClass('glyphicon-move');
            $(this).addClass('glyphicon-saved');
            landObject.draggable();
            landObject.draggable('enable');
        } else {
            landObject.removeClass('moving');
            $(this).removeClass('glyphicon-saved');
            $(this).addClass('glyphicon-move');
            landObject.draggable('disable');
        }
    });
});

//---------- -----------  move ----------- ----------
$(document).ready(function () {
    $('body').on('mousemove', '.tf_m_build_land', function () {
        if ($(this).hasClass('moving')) {
            landId = $(this).data('land');
            project_contain = $(this).parents('.tf_m_build_project');
            //size of drag object
            objectWidth = $(this).outerWidth();
            objectHeight = $(this).outerHeight();
            // limit move area (size of contain)
            limitWidht = project_contain.outerWidth();
            limitHeight = project_contain.outerHeight();
            $(this).draggable(
                {zIndex: 9999999999},
                {cursor: 'pointer'}, {
                    start: function () {
                        //open project grid when drag
                        tf_main.tf_show('.tf_m_build_project_grid');
                    },
                    drag: function () {
                        topPosition = $(this).position().top;
                        leftPosition = $(this).position().left;
                        //overflow
                        if (leftPosition < 0 || leftPosition > (limitWidht - objectWidth) || topPosition < 0 || topPosition > (limitHeight - objectHeight)) {
                            $(this).addClass('tf-m-build-project-overflow-mask');
                        }
                        else {
                            $(this).removeClass('tf-m-build-project-overflow-mask');
                        }
                    },
                    stop: function () {
                        //close project grid when stop
                        tf_main.tf_hide('.tf_m_build_project_grid');
                        urlSetPosition = $(this).data('href-position');
                        topPosition = $(this).position().top;
                        leftPosition = $(this).position().left;
                        if (topPosition < 0) topPosition = 0;
                        if (topPosition > (limitHeight - objectHeight )) topPosition = limitHeight - objectHeight + 4;
                        if (leftPosition < 0) leftPosition = 0;
                        if (leftPosition > (limitWidht - objectWidth )) leftPosition = limitWidht - objectWidth + 4;

                        //apply to cases overflow
                        if ($(this).hasClass('tf-m-build-project-overflow-mask')) $(this).removeClass('tf-m-build-project-overflow-mask');
                        topPosition = parseInt(topPosition / 16) * 16;
                        leftPosition = parseInt(leftPosition / 16) * 16;

                        //create zindex
                        defualtZindex = 802817;
                        topZindex = topPosition + objectHeight; //top position for create z-index
                        leftZindex = leftPosition + objectWidth; //top position for create z-index
                        for (y = 0; y <= limitHeight; y++) {    // he
                            for (x = 0; x <= limitWidht; x++) {
                                if (y == topZindex && x == leftZindex) newZindex = defualtZindex; // each land has a different z-index
                                defualtZindex = defualtZindex + 1;
                            }
                        }
                        if (typeof newZindex == 'undefined') newZindex = defualtZindex;
                        $(this).css({'top': topPosition, 'left': leftPosition, 'z-index': newZindex});
                        $.ajax({
                            type: 'GET',
                            url: urlSetPosition + '/' + landId + '/' + topPosition + '/' + leftPosition + '/' + newZindex,
                            dataType: 'html',
                            data: {},
                            beforeSend: function () {
                                tf_m_build.load_status();
                            },
                            success: function (data) {
                                //process after submit
                            },
                            complete: function () {
                                tf_m_build.load_status();
                            }
                        });
                    }
                });
        } else {
            return false;
        }
    });
});

//========== ========== ========== DELETE ========== ========== ==========
$(document).ready(function () {
    $('body').on('click', '.tf_m_build_land_delete', function () {
        if (confirm('Do you want delete?')) {
            var landObject = $(this).parents('.tf_m_build_land');
            var landID = landObject.data('land');
            var href = $(this).data('href');
            $.ajax({
                type: 'GET',
                url: href + '/' + landID,
                dataType: 'html',
                data: {},
                beforeSend: function () {
                    tf_m_build.load_status();
                },
                success: function (data) {
                    tf_main.tf_remove(landObject);
                },
                complete: function () {
                    tf_m_build.load_status();
                }
            });
        }
    });
});

//========== ========== ========== ADD LAND ========== ========== ==========
$(document).ready(function () {
    $('body').on('click', '.tf_m_build_land_add_post', function () {
        var href = $('#frmBuildLandAdd').attr('action');
        var projectId = $('#txtProject').val();
        var data = $('#frmBuildLandAdd').serialize();
        $.ajax({
            type: 'POST',
            url: href ,
            dataType: 'html',
            data: data,
            beforeSend: function () {
                tf_m_build.load_status();
            },
            success: function (data) {
                tf_m_build.contain_action_close();
                $('#tf_m_build_project_' + projectId).append(data);
            },
            complete: function () {
                tf_m_build.load_status();
            }
        });
    });
});
