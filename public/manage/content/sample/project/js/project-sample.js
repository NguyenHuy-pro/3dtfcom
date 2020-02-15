//=========== =========== ===========  map object =========== =========== ===========
var tf_m_c_sample_project = {

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
        if (href.length > 0) {
            $.ajax({
                type: 'GET',
                url: href + '/' + projectId + '/' + objectId + '/' + topPosition + '/' + leftPosition,
                dataType: 'html',
                data: {
                    //areaID: id,loadProvID:prov
                },
                beforeSend: function () {
                    tf_manage.loadStatus();
                },
                success: function (data) {
                    if (objectName == 'build-public') {
                        $(object).append(data);
                    } else {
                        //tf_main.tf_remove('#tf_m_c_wrapper');
                        tf_manage.containActionClose();
                        $('#tf_m_c_wrapper').append(data);
                        tf_main.tf_scrollTop();
                    }
                },
                complete: function () {
                    tf_manage.loadStatus();
                }
            });
        }
    },
    //View
    view: function (object) {
        var objectId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-view') + '/' + objectId;
        tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
        tf_main.tf_scrollTop();
    },

    //status
    updateStatus: function (object) {
        var objectId = $(object).data('object');
        var href = $(object).parents('.tf_list_object').data('href-status') + '/' + objectId;
        tf_manage_submit.ajaxHasReload(href, '', false);
    },

    //delete
    delete: function (object) {
        if (confirm('Do you to delete this record?')) {
            var objectId = $(object).data('object');
            var href = $(object).parents('.tf_list_object').data('href-del') + '/' + objectId;
            tf_manage_submit.ajaxHasReload(href, '', false);
        }
    },

    add: {
        save: function (formObject) {
            var staffObject = $(formObject).find("select[name='cbStaff']");
            var imageObject = $(formObject).find("input[name='fileImage']");

            if (tf_main.tf_checkInputNull(staffObject, 'Select manager')) {
                return false;
            }

            if (tf_main.tf_checkInputNull(imageObject, 'Select a sample image')) {
                return false;
            } else {
                tf_manage_submit.ajaxFormHasReload(formObject, '', false);

            }

        }
    },
    edit: {
        get: function (object) {
            var objectId = $(object).data('object');
            var href = $(object).parents('.tf_list_object').data('href-edit') + '/' + objectId;
            tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
            tf_main.tf_scrollTop();
        },
        post: function (formObject) {
            var containNotify = $(formObject).find('.tf_frm_notify');
            tf_manage_submit.ajaxFormHasReload(formObject, containNotify, true);
        }
    },
    banner: {
        addNew: function (formObject) {
            var projectObject = $('#tf_project_sample');
            tf_manage_submit.ajaxFormHasReload(formObject, projectObject, false);
            $(formObject).find('.tf_m_c_container_close').click();
        }
    },

    land: {
        addNew: function (formObject) {
            var projectObject = $('#tf_project_sample');
            tf_manage_submit.ajaxFormHasReload(formObject, projectObject, false);
            $(formObject).find('.tf_m_c_container_close').click();
        }
    },

    build: {
        finish: function (object) {
            if (confirm('Do you to finish build?')) {
                var objectId = $(object).data('object');
                var href = $(object).parents('.tf_list_object').data('href-build-finish') + '/' + objectId;
                tf_manage_submit.ajaxHasReload(href, '', false);
            }
        }
    },
    publish: {
        agree: function (object) {
            if (confirm('Do you agree this project?')) {
                var objectId = $(object).data('object');
                var href = $(object).parents('.tf_list_object').data('href-publish-yes') + '/' + objectId;
                tf_manage_submit.ajaxHasReload(href, '', false);
            }
        },
        disagree: function (object) {
            if (confirm('Do you disagree this project?')) {
                var objectId = $(object).data('object');
                var href = $(object).parents('.tf_list_object').data('href-publish-no') + '/' + objectId;
                tf_manage_submit.ajaxHasReload(href, '', false);
            }
        }
    },
    background: {
        view: function(backgroundObject){
            var backgroundTool = $(backgroundObject).parents('.tf_background_tool');
            var backgroundId = $(backgroundObject).data('background');
            var href = backgroundTool.data('href-view') + '/' + backgroundId;
            tf_manage_submit.ajaxNotReload(href, '#tf_m_c_wrapper', false);
        },
        add: function (backgroundObject) {
            var backgroundTool = $(backgroundObject).parents('.tf_background_tool');
            var projectId = backgroundTool.data('project');
            var backgroundId = $(backgroundObject).data('background');
            var href = backgroundTool.data('href-add') + '/' + projectId + '/' + backgroundId;
            if (confirm('Do you want to select this background')) {
                tf_manage_submit.ajaxHasReload(href, '', false);
            }
        },
        drop:function(href){
            tf_manage_submit.ajaxHasReload(href, '', false);
        }
    }

}
//---------- Build -----------
$(document).ready(function () {
    $('.tf_m_c_sample_project').on('click', '.tf_list_object .tf_object_build_finish', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_sample_project.build.finish(object);
    });
});

//---------- Publish -----------
$(document).ready(function () {
    //agree publish
    $('.tf_m_c_sample_project').on('click', '.tf_list_object .tf_object_publish_yes', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_sample_project.publish.agree(object);
    });

    //disagree publish
    $('.tf_m_c_sample_project').on('click', '.tf_list_object .tf_object_publish_no', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_sample_project.publish.disagree(object);
    });
});


//----------  Status -----------
$(document).ready(function () {
    $('.tf_m_c_sample_project').on('click', '.tf_list_object .tf_object_status', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_sample_project.updateStatus(object);
    });
});

//---------- View - Delete -----------
$(document).ready(function () {
    //view
    $('.tf_m_c_sample_project').on('click', '.tf_list_object .tf_object_view', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_sample_project.view(object);
    });

    //delete
    $('.tf_m_c_sample_project').on('click', '.tf_list_object .tf_object_delete', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_sample_project.delete(object);
    });
});


//----------  edit info ----------
$(document).ready(function () {
    //get form
    $('.tf_m_c_sample_project').on('click', '.tf_list_object .tf_object_edit', function () {
        var object = $(this).parents('.tf_object');
        tf_m_c_sample_project.edit.get(object);
    });

    //post edit
    $('body').on('click', '.tf_frm_edit .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_edit');
        tf_m_c_sample_project.edit.post(formObject);
    });

});

//-----------Add project ----------
$(document).ready(function () {
    // add
    $('.tf_m_c_sample_project').on('click', '.tf_frm_add .tf_save', function () {
        var formObject = $(this).parents('.tf_frm_add');
        tf_m_c_sample_project.add.save(formObject);
    });

});

//========== ========== ========== TOOL ========== ========== ==========

//show menu
$(document).ready(function () {
    $('body').on('change', '.tf_project_sample_public_type', function () {
        var typeId = $(this).val();
        var href = $(this).data('href');
        tf_main.tf_url_replace(href + '/' + typeId);
    });
});

//========== ========== ========== BACKGROUND ========== ========== ==========
$(document).ready(function () {
    //add
    $('body').on('click', '.tf_background_tool .tf_view', function () {
        var backgroundObject = $(this).parents('.tf_background_object');
        tf_m_c_sample_project.background.view(backgroundObject);
    });

    //add
    $('body').on('click', '.tf_background_tool .tf_select', function () {
        var backgroundObject = $(this).parents('.tf_background_object');
        tf_m_c_sample_project.background.add(backgroundObject);
    });

    //drop
    $('body').on('click', '.tf_background_drop', function () {
        var projectId = $('#tf_project_sample').data('project');
        var href = $(this).data('href') + '/' + projectId;
        tf_m_c_sample_project.background.drop(href);
    });
});

//========== ========== ========== PUBLIC ========== ========== ==========
//show menu
$(document).ready(function () {
    $('body').on('mouseover', '.tf_m_c_project_sample_public', function () {
        tf_main.tf_show($(this).children('.tf_m_c_project_sample_public_menu'));
    }).on('mouseout', '.tf_m_c_project_sample_public', function () {
        tf_main.tf_hide($(this).children('.tf_m_c_project_sample_public_menu'));
    });
});

// turn on move
$(document).ready(function () {
    $('body').on('click', '.tf_m_c_project_sample_public_move_status', function () {
        var publicObject = $(this).parents('.tf_m_c_project_sample_public');
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

// move
$(document).ready(function () {
    $('body').on('mousemove', '.tf_m_c_project_sample_public', function () {
        if ($(this).hasClass('moving')) {
            publicId = $(this).data('public');
            publicTypeId = $(this).data('type');
            project_contain = $(this).parents('.tf_project_sample');
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
                        tf_main.tf_show('.tf_project_sample_grid');
                    },
                    drag: function () {
                        topPosition = $(this).position().top;
                        leftPosition = $(this).position().left;
                    },
                    stop: function () {
                        //close project grid when stop
                        tf_main.tf_hide('.tf_project_sample_grid');
                        urlSetPosition = $(this).data('href-position');
                        topPosition = $(this).position().top;
                        leftPosition = $(this).position().left;
                        //process overflow when drag
                        if (topPosition < 0) topPosition = 0;
                        if (topPosition > (limitHeight - objectHeight )) topPosition = limitHeight - objectHeight + 4;
                        if (leftPosition < 0) leftPosition = 0;
                        if (leftPosition > (limitWidht - objectWidth )) leftPosition = limitWidht - objectWidth + 4;

                        //apply to cases overflow
                        topPosition = parseInt(topPosition / 16) * 16;
                        leftPosition = parseInt(leftPosition / 16) * 16;

                        //create zindex
                        if (publicTypeId == 1) { //zIndex of ways
                            defaultZindex = 1;
                        } else {
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
                                tf_manage.loadStatus();
                            },
                            success: function (data) {
                                //process after submit
                            },
                            complete: function () {
                                tf_manage.loadStatus();
                            }
                        });
                    }
                });
        } else {
            return false;
        }
    });
});

//delete
$(document).ready(function () {
    $('body').on('click', '.tf_m_c_project_sample_public_delete', function () {
        if (confirm('Do you want delete?')) {
            var publicObject = $(this).parents('.tf_m_c_project_sample_public');
            var publicId = publicObject.data('public');
            var href = $(this).data('href');
            $.ajax({
                type: 'GET',
                url: href + '/' + publicId,
                dataType: 'html',
                data: {},
                beforeSend: function () {
                    tf_manage.loadStatus();
                },
                success: function (data) {
                    tf_main.tf_remove(publicObject);
                },
                complete: function () {
                    tf_manage.loadStatus();
                }
            });
        }
    });
});

//========== ========== ========== BANNER ========== ========== ==========
//add
$(document).ready(function () {
    $('body').on('click', '#frmProjectSampleBannerAdd .tf_save', function () {
        var formObject = $(this).parents('#frmProjectSampleBannerAdd');
        tf_m_c_sample_project.banner.addNew(formObject);
    });
});

//show menu
$(document).ready(function () {
    $('body').on('mouseover', '.tf_m_c_project_sample_banner', function () {
        tf_main.tf_show($(this).children('.tf_m_c_project_sample_banner_menu'));
    }).on('mouseout', '.tf_m_c_project_sample_banner', function () {
        tf_main.tf_hide($(this).children('.tf_m_c_project_sample_banner_menu'));
    });
});

// turn on move
$(document).ready(function () {
    $('body').on('click', '.tf_m_c_project_sample_banner_move_status', function () {
        var publicObject = $(this).parents('.tf_m_c_project_sample_banner');
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

//move
$(document).ready(function () {
    $('body').on('mousemove', '.tf_m_c_project_sample_banner', function () {
        if ($(this).hasClass('moving')) {
            bannerId = $(this).data('banner');
            project_contain = $(this).parents('.tf_project_sample');
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
                        tf_main.tf_show('.tf_project_sample_grid');
                    },
                    drag: function () {
                        topPosition = $(this).position().top;
                        leftPosition = $(this).position().left;
                        //overflow
                        /*
                         if (leftPosition < 0 || leftPosition > (limitWidht - objectWidth) || topPosition < 0 || topPosition > (limitHeight - objectHeight)) {
                         $(this).addClass('tf-m-build-project-overflow-mask');
                         }
                         else {
                         $(this).removeClass('tf-m-build-project-overflow-mask');
                         }
                         */
                    },
                    stop: function () {
                        //close project grid when stop
                        tf_main.tf_hide('.tf_project_sample_grid');
                        urlSetPosition = $(this).data('href-position');
                        topPosition = $(this).position().top;
                        leftPosition = $(this).position().left;
                        if (topPosition < 0) topPosition = 0;
                        if (topPosition > (limitHeight - objectHeight )) topPosition = limitHeight - objectHeight + 4;
                        if (leftPosition < 0) leftPosition = 0;
                        if (leftPosition > (limitWidht - objectWidth )) leftPosition = limitWidht - objectWidth + 4;

                        //apply to cases overflow
                        ////if ($(this).hasClass('tf-m-build-project-overflow-mask')) $(this).removeClass('tf-m-build-project-overflow-mask');
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
                            url: urlSetPosition + '/' + bannerId + '/' + topPosition + '/' + leftPosition + '/' + newZindex,
                            dataType: 'html',
                            data: {},
                            beforeSend: function () {
                                tf_manage.loadStatus();
                            },
                            success: function (data) {
                                //process after submit
                            },
                            complete: function () {
                                tf_manage.loadStatus();
                            }
                        });
                    }
                });
        } else {
            return false;
        }
    });
});

//delete
$(document).ready(function () {
    $('body').on('click', '.tf_m_c_project_sample_banner_delete', function () {
        if (confirm('Do you want delete?')) {
            var bannerObject = $(this).parents('.tf_m_c_project_sample_banner');
            var bannerId = bannerObject.data('banner');
            var href = $(this).data('href');
            $.ajax({
                type: 'GET',
                url: href + '/' + bannerId,
                dataType: 'html',
                data: {},
                beforeSend: function () {
                    tf_manage.loadStatus();
                },
                success: function (data) {
                    tf_main.tf_remove(bannerObject);
                },
                complete: function () {
                    tf_manage.loadStatus();
                }
            });
        }
    });
});


//========== ========== ========== LAND ========== ========== ==========
//add
$(document).ready(function () {
    $('body').on('click', '#frmProjectSampleLandAdd .tf_save', function () {
        var formObject = $(this).parents('#frmProjectSampleLandAdd');
        tf_m_c_sample_project.land.addNew(formObject);
    });
});

//show menu
$(document).ready(function () {
    $('body').on('mouseover', '.tf_m_c_project_sample_land', function () {
        tf_main.tf_show($(this).children('.tf_m_c_project_sample_land_menu'));
    }).on('mouseout', '.tf_m_c_project_sample_land', function () {
        tf_main.tf_hide($(this).children('.tf_m_c_project_sample_land_menu'));
    });
});

// turn on move
$(document).ready(function () {
    $('body').on('click', '.tf_m_c_project_sample_land_move_status', function () {
        var publicObject = $(this).parents('.tf_m_c_project_sample_land');
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

//move
$(document).ready(function () {
    $('body').on('mousemove', '.tf_m_c_project_sample_land', function () {
        if ($(this).hasClass('moving')) {
            landId = $(this).data('land');
            project_contain = $(this).parents('.tf_project_sample');
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
                        tf_main.tf_show('.tf_project_sample_grid');
                    },
                    drag: function () {
                        topPosition = $(this).position().top;
                        leftPosition = $(this).position().left;
                        //overflow
                        /*
                         if (leftPosition < 0 || leftPosition > (limitWidht - objectWidth) || topPosition < 0 || topPosition > (limitHeight - objectHeight)) {
                         $(this).addClass('tf-m-build-project-overflow-mask');
                         }
                         else {
                         $(this).removeClass('tf-m-build-project-overflow-mask');
                         }
                         */
                    },
                    stop: function () {
                        //close project grid when stop
                        tf_main.tf_hide('.tf_project_sample_grid');
                        urlSetPosition = $(this).data('href-position');
                        topPosition = $(this).position().top;
                        leftPosition = $(this).position().left;
                        if (topPosition < 0) topPosition = 0;
                        if (topPosition > (limitHeight - objectHeight )) topPosition = limitHeight - objectHeight + 4;
                        if (leftPosition < 0) leftPosition = 0;
                        if (leftPosition > (limitWidht - objectWidth )) leftPosition = limitWidht - objectWidth + 4;

                        //apply to cases overflow
                        ////if ($(this).hasClass('tf-m-build-project-overflow-mask')) $(this).removeClass('tf-m-build-project-overflow-mask');
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
                            url: urlSetPosition + '/' + landId + '/' + topPosition + '/' + leftPosition + '/' + newZindex,
                            dataType: 'html',
                            data: {},
                            beforeSend: function () {
                                tf_manage.loadStatus();
                            },
                            success: function (data) {
                                //process after submit
                            },
                            complete: function () {
                                tf_manage.loadStatus();
                            }
                        });
                    }
                });
        } else {
            return false;
        }
    });
});

//delete
$(document).ready(function () {
    $('body').on('click', '.tf_m_c_project_sample_land_delete', function () {
        if (confirm('Do you want delete?')) {
            var landObject = $(this).parents('.tf_m_c_project_sample_land');
            var landId = landObject.data('land');
            var href = $(this).data('href');
            $.ajax({
                type: 'GET',
                url: href + '/' + landId,
                dataType: 'html',
                data: {},
                beforeSend: function () {
                    tf_manage.loadStatus();
                },
                success: function (data) {
                    tf_main.tf_remove(landObject);
                },
                complete: function () {
                    tf_manage.loadStatus();
                }
            });
        }
    });
});