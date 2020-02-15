/**
 * Created by HUY on 4/15/2016.
 */
var tf_m_build_project = {
    check_name: function (href) {
        $.ajax({
            type: 'GET',
            url: href,
            dataType: 'html',
            data: {},
            success: function (data) {
                return (data == 'yes') ? true : false;
            }
        });
    }
}

//========== =========== =========== ADD PROJECT ============ ============= =============
$(document).ready(function () {
    $('body').on('click', '.tf_m_build_project_add_post', function(){
        if (tf_main.tf_checkInputNull('#cbStaffManager', 'Select an manager')) {
            return false;
        }
        if (tf_main.tf_checkInputNull('#txtName', 'Enter name for project')) {
            return false;
        } else {
            if (tf_main.tf_checkInputMaxLength('#txtName', 50, 'max length of name is 50 characters.')) {
                return false;
            } else {
                var name = $('#txtName').val();
                var href = $('#txtName').data('href') + '/' + name;
                if (tf_m_build_project.check_name(href)) {
                    alert('This name already exists');
                    return false;
                }
            }
        }
        if (tf_main.tf_checkRadioNull('frmAreaOpenProject', 'radIconSample')) {
            alert('Select an icon for project');
            return false;
        }
        var areaId = $('#frmAreaOpenProject').data('area');
        var provinceId = $('#frmAreaOpenProject').data('province');
        var href = $('#frmAreaOpenProject').attr('action');
        //token = $('#frmAreaOpenProject_token').val();
        var data = $('form#frmAreaOpenProject').serialize();
        $.ajax({
            type: 'POST',
            url: href + '/' + provinceId + '/' + areaId,
            dataType: 'html',
            data: data,
            beforeSend: function () {
                tf_m_build.load_status();
            },
            success: function (data) {
                tf_m_build.contain_action_close();
                $('#tf_m_build_area_' + areaId).empty();
                $('#tf_m_build_area_' + areaId).append(data);
            },
            complete: function () {
                tf_m_build.load_status();
            }
        });
    });
});

//========== =========== =========== PROJECT ICON ============ ============= =============
$(document).ready(function () {
    $('.tf_m_build_project').on('mousemove', '.tf_m_build_project_icon', function () {
        if ($(this).hasClass('moving')) {
            iconId = $(this).data('icon');
            project_contain = $(this).parent();
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
                        urlSet = $(this).data('set-position');
                        topPosition = $(this).position().top;
                        leftPosition = $(this).position().left;
                        //process overflow when drag
                        if (topPosition < 0) topPosition = 0;
                        if (topPosition > (limitHeight - objectHeight )) topPosition = limitHeight - objectHeight + 4;
                        if (leftPosition < 0) leftPosition = 0;
                        if (leftPosition > (limitWidht - objectWidth )) leftPosition = limitWidht - objectWidth + 4;
                        // overflow cases
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
                            url: urlSet + '/' + iconId + '/' + topPosition + '/' + leftPosition + '/' + newZindex,
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
    }).on('mouseover', '.tf_m_build_project_icon', function () {
        //show top
        $(this).addClass('tf-zindex-top');
        //show menu
        $(this).children('.tf_m_build_project_menu').show();
    }).on('mouseout', '.tf_m_build_project_icon', function () {
        // return back
        $(this).removeClass('tf-zindex-top');
        //hide menu
        $(this).children('.tf_m_build_project_menu').hide();
    });

    //turn on or turn off  move status
    $('.tf_m_build_project').on('click', '.tf_m_build_project_icon_move', function () {
        var iconObject = $(this).parents('.tf_m_build_project_icon');
        if (!iconObject.hasClass('moving')) {
            iconObject.addClass('moving');
            $(this).removeClass('glyphicon-move');
            $(this).addClass('glyphicon-saved');
            iconObject.draggable();
            iconObject.draggable('enable');
        } else {
            iconObject.removeClass('moving');
            $(this).removeClass('glyphicon-saved');
            $(this).addClass('glyphicon-move');
            iconObject.draggable('disable');
        }
    });

    //edit icon project
    $('.tf_m_build_project').on('click', '.tf_m_build_project_icon_edit', function () {
        var sampleID = $(this).parents('.tf_m_build_project_icon').data('sample');
        var iconID = $(this).parents('.tf_m_build_project_icon').data('icon');
        var urlGet = $(this).data('href');
        $.ajax({
            type: 'GET',
            url: urlGet + '/' + iconID + '/' + sampleID,
            dataType: 'html',
            data: {
                //areaID: id,loadProvID:prov
            },
            beforeSend: function () {
                tf_m_build.load_status();
            },
            success: function (data) {
                tf_m_build.contain_action_close();
                $('#tf_m_build_wrapper').append(data);
                //$('#tf_m_build_wrapper').append(data);
            },
            complete: function () {
                tf_m_build.load_status();
            }
        });
    });

});

// add project icon
$(document).ready(function(){
    $('body').on('click', '.tf_m_build_project_icon_edit_sample', function(){
        var urlAdd = $('form#frmProjectIconEdit').attr('action');
        var iconID = $('form#frmProjectIconEdit').data('icon');
        var sampleID = $(this).data('sample');
        var data = $('form#frmProjectIconEdit').serialize();
        $.ajax({
            type: 'POST',
            url: urlAdd + '/' + iconID + '/' + sampleID,
            dataType: 'html',
            data: data,
            beforeSend: function () {
                tf_m_build.load_status();
            },
            success: function (data) {
                if (data) {
                    tf_main.tf_remove('#tf_m_build_action_wrap');
                    $('#tf_m_build_project_icon_' + iconID).children('.tf_m_build_project_icon_image').remove();
                    $('#tf_m_build_project_icon_' + iconID).append(data);
                }
            },
            complete: function () {
                tf_m_build.load_status();
            }
        });
    });
});

//========== ========== ========== BUILD PROJECT ========== ========== ==========
//----------- ----------- setup status ----------- -----------
$(document).ready(function () {
    $('body').on('click', '.tf_m_build_project_setup_status', function () {
        var projectID = $(this).parents('.tf_m_build_project').data('project');
        var href = $(this).data('href') + '/' + projectID;
        tf_main.tf_url_replace(href);
    });
});

//----------- ----------- finish build ----------- -----------
$(document).ready(function () {
    $('body').on('click', '.tf_m_build_project_build_finish', function () {
        if (confirm('Do you want to finish build?')) {
            var buildId = $(this).data('build');
            var projectId = $(this).parents('.tf_m_build_project').data('project');
            var href = $(this).data('href') + '/' + projectId + '/' + buildId;
            tf_main.tf_url_replace(href);
        } else {
            return false;
        }
    });
});

//========== ========== ========== PUBLISH PROJECT ========== ========== ==========
//----------- ----------- publish ----------- -----------
$(document).ready(function () {
    $('body').on('click', '.tf_m_build_project_publish_confirm', function () {
        var confirmStatus = $(this).data('confirm');
        var projectId = $(this).parents('.tf_m_build_project').data('project');
        var buildId = $(this).data('build');
        var href = $(this).data('href') + '/' + projectId + '/' + buildId;
        if (confirmStatus == 'yes') {
            $.ajax({
                type: 'GET',
                url: href,
                dataType: 'html',
                data: {
                    //data
                },
                beforeSend: function () {
                    tf_m_build.load_status();
                },
                success: function (data) {
                    if (data) {
                        $('#tf_m_build_wrapper').append(data);
                    }
                },
                complete: function () {
                    tf_m_build.load_status();
                }
            });
            /*
            var firstPublish = $(this).data('first-publish'); //  check first publish
            href = href + '/' + firstPublish;
            // first publish
            if (firstPublish == 1) {

            } else { // publish once more
                if (confirm('Do you not agree publish this project?')) {
                    // get area contain
                    var areaObject = $(this).parents('.tf_m_build_area');
                    $.ajax({
                        type: 'GET',
                        url: href,
                        dataType: 'html',
                        data: {
                            //data
                        },
                        beforeSend: function () {
                            tf_m_build.load_status();
                        },
                        success: function (data) {
                            if (data) {
                                areaObject.empty();
                                areaObject.append(data);
                            }
                            //$('#tf_m_build_wrapper').append(data);
                        },
                        complete: function () {
                            tf_m_build.load_status();
                        }
                    });
                }
            }*/

        } else if (confirmStatus == 'no') {
            if (confirm('Do you not agree publish this project?')) {
                // get area contain
                areaObject = $(this).parents('.tf_m_build_area');
                $.ajax({
                    type: 'GET',
                    url: href,
                    dataType: 'html',
                    data: {
                        //data
                    },
                    beforeSend: function () {
                        tf_m_build.load_status();
                    },
                    success: function (data) {
                        if (data) {
                            areaObject.empty();
                            areaObject.append(data);
                        }
                        //$('#tf_m_build_wrapper').append(data);
                    },
                    complete: function () {
                        tf_m_build.load_status();
                    }
                });
            } else {
                return false;
            }
        }
    });
});

//----------- ----------- first agree publish ----------- -----------
$(document).ready(function () {
    $('body').on('click', '.tf-m-build-project-publish-yes-a', function () {
        var day = $('#cbPublishDay').val();
        if (confirm('Did you published this project after ' + day + ' days? ')) {
            var href = $('form#frmProjectPublish').attr('action');
            var projectID = $('#txtProjectPublish').val();
            var areaContain = $('#tf_m_build_project_' + projectID).parents('.tf_m_build_area');
            var data = $('form#frmProjectPublish').serialize();
            $.ajax({
                type: 'POST',
                url: href,
                dataType: 'html',
                data: data,
                beforeSend: function () {
                    tf_m_build.load_status();
                },
                success: function (data) {
                    tf_main.tf_remove('#tf_m_build_action_wrap');
                    if (data) {
                        areaContain.empty();
                        areaContain.append(data);
                    }
                },
                complete: function () {
                    tf_m_build.load_status();
                }
            });
        }
    });
});
