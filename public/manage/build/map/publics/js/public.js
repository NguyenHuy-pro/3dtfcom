/**
 * Created by HUY on 4/15/2016.
 */
// banner object
var tf_m_build_banner = {};

//========== ========== ========== EVENT ON PUBLIC ========== ========== ==========
$(document).ready(function () {
    $('body').on('mouseover', '.tf_m_build_public', function () {
        tf_main.tf_show($(this).children('.tf_m_build_public_menu'));
    }).on('mouseout', '.tf_m_build_public', function () {
        tf_main.tf_hide($(this).children('.tf_m_build_public_menu'));
    });
});

//========== ========== ========== MOVE ========== ========== ==========
//---------- ----------- turn on move ----------- ----------
$(document).ready(function () {
    $('body').on('click', '.tf_m_build_public_move_status', function () {
        var publicObject = $(this).parents('.tf_m_build_public');
        if (!publicObject.hasClass('moving')) {
            publicObject.addClass('moving');
            $(this).removeClass('glyphicon-move');
            $(this).addClass('glyphicon-saved');
            publicObject.draggable();
            publicObject.draggable('enable');
        } else {
            publicObject.removeClass('moving');
            $(this).removeClass('glyphicon-saved');
            $(this).addClass('glyphicon-move');
            publicObject.draggable('disable');
        }
    });
});

//---------- -----------  move ----------- ----------
$(document).ready(function () {
    $('body').on('mousemove', '.tf_m_build_public', function () {
        if ($(this).hasClass('moving')) {
            publicId = $(this).data('public');
            publicTypeId = $(this).data('type');
            project_contain = $(this).parents('.tf_m_build_project');
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
                        //process overflow when drag
                        if (topPosition < 0) topPosition = 0;
                        if (topPosition > (limitHeight - objectHeight )) topPosition = limitHeight - objectHeight + 4;
                        if (leftPosition < 0) leftPosition = 0;
                        if (leftPosition > (limitWidht - objectWidth )) leftPosition = limitWidht - objectWidth + 4;

                        //apply to cases overflow
                        if ($(this).hasClass('tf-m-build-project-overflow-mask')) $(this).removeClass('tf-m-build-project-overflow-mask');
                        topPosition = parseInt(topPosition / 16) * 16;
                        leftPosition = parseInt(leftPosition / 16) * 16;

                        //create zindex
                        if(publicTypeId == 1){ //zIndex of ways
                            defaultZindex = 1;
                        }else{
                            defaultZindex = 802817; //do not ways
                        }
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
                            url: urlSetPosition + '/' + publicId + '/' + topPosition + '/' + leftPosition + '/' + newZindex,
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
    $('body').on('click', '.tf_m_build_public_delete', function () {
        if (confirm('Do you want delete?')) {
            var publicObject = $(this).parents('.tf_m_build_public');
            var publicID = publicObject.data('public');
            var href = $(this).data('href');
            $.ajax({
                type: 'GET',
                url: href + '/' + publicID,
                dataType: 'html',
                data: {},
                beforeSend: function () {
                    tf_m_build.load_status();
                },
                success: function (data) {
                    tf_main.tf_remove(publicObject);
                },
                complete: function () {
                    tf_m_build.load_status();
                }
            });
        }
    });
});


