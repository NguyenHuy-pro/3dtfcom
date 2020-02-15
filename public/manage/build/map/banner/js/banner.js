/**
 * Created by HUY on 4/15/2016.
 */
// banner object
var tf_m_build_banner = {};

//========== ========== ========== EVENT ON BANNER ========== ========== ==========
$(document).ready(function () {
    $('body').on('mouseover', '.tf_m_build_banner', function () {
        tf_main.tf_show($(this).children('.tf_m_build_banner_menu'));
    }).on('mouseout', '.tf_m_build_banner', function () {
        tf_main.tf_hide($(this).children('.tf_m_build_banner_menu'));
    });
});

//========== ========== ========== MOVE BANNER ========== ========== ==========
//---------- ----------- turn on move ----------- ----------
$(document).ready(function () {
    $('body').on('click', '.tf_m_build_banner_move_status', function () {
        var bannerObject = $(this).parents('.tf_m_build_banner');
        if (!bannerObject.hasClass('moving')) {
            bannerObject.addClass('moving');
            $(this).removeClass('glyphicon-move');
            $(this).addClass('glyphicon-saved');
            bannerObject.draggable();
            bannerObject.draggable('enable');
        } else {
            bannerObject.removeClass('moving');
            $(this).removeClass('glyphicon-saved');
            $(this).addClass('glyphicon-move');
            bannerObject.draggable('disable');
        }
    });
});

//---------- -----------  move ----------- ----------
$(document).ready(function () {
    $('body').on('mousemove', '.tf_m_build_banner', function () {
        if ($(this).hasClass('moving')) {
            bannerID = $(this).data('banner');
            project_contain = $(this).parents('.tf_m_build_project');
            //width = $(dragObject).outerWidth();
            //height = $(dragObject).outerHeight();
            //size of drag object
            objectWidth = $(this).outerWidth();
            objectHeight = $(this).outerHeight();
            // limit move area (size of contain)
            limitWidht = project_contain.outerWidth();
            limitHeight = project_contain.outerHeight();
            $(this).draggable(
                {zIndex: 9000000},
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
                        defaultZindex = 802817;
                        topZindex = topPosition + objectHeight; //top position for create z-index
                        leftZindex = leftPosition + objectWidth; //top position for create z-index
                        for (y = 0; y <= limitHeight; y++) {    // he
                            for (x = 0; x <= limitWidht; x++) {
                                if (y == topZindex && x == leftZindex) newZindex = defaultZindex; // each land has a different z-index
                                defaultZindex = defaultZindex + 1;
                            }
                        }
                        if (typeof newZindex == 'undefined') newZindex = defaultZindex;
                        $(this).css({'top': topPosition, 'left': leftPosition, 'z-index': newZindex});
                        $.ajax({
                            type: 'GET',
                            url: urlSetPosition + '/' + bannerID + '/' + topPosition + '/' + leftPosition + '/' + newZindex,
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
    $('body').on('click', '.tf_m_build_banner_delete', function () {
        if (confirm('Do you want delete?')) {
            var bannerObject = $(this).parents('.tf_m_build_banner');
            var bannerID = bannerObject.data('banner');
            var href = $(this).data('href');
            $.ajax({
                type: 'GET',
                url: href + '/' + bannerID,
                dataType: 'html',
                data: {},
                beforeSend: function () {
                    tf_m_build.load_status();
                },
                success: function (data) {
                    tf_main.tf_remove(bannerObject);
                },
                complete: function () {
                    tf_m_build.load_status();
                }
            });
        }
    });
});

//========== ========== ========== ADD BANNER ========== ========== ==========
$(document).ready(function () {
    $('body').on('click', '.tf_m_build_banner_add_post', function () {
        var href = $('#frmBuildBannerAdd').attr('action');
        var projectId = $('#txtProject').val();
        var data = $('#frmBuildBannerAdd').serialize();
        $.ajax({
            type: 'POST',
            url: href,
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
