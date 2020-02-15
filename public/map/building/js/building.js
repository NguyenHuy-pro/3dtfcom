/**
 * Created by 3D on 3/19/2016.
 */
var tf_map_building = {
    buildingId: '',
    buildingIdByObject: function (buildingObject) {
        return $(buildingObject).data('building');
    },
    objectById: function (buildingId) {
        return $('#tf_building_' + buildingId);
    },
    idName: function (buildingId) {
        return 'tf_building_' + buildingId;
    },
    idNameAction: function (buildingId) {
        return '#tf_building_' + buildingId;
    },
    className: function () {
        return 'tf_building';
    },
    classNameAction: function () {
        return '.tf_building';
    },
    landObject: function (buildingObject) {
        return $(buildingObject).parents(tf_land.classNameAction());
    },
    projectObject: function (buildingObject) {
        return $(buildingObject).parents(tf_map_project.classNameAction());
    },
    actionHref: '',
    access: {
        addWatching: function (buildingObject) {
            $(buildingObject).addClass('tf_map_building_watching');
        },
        removeWatching: function (buildingObject) {
            $(buildingObject).removeClass('tf_map_building_watching');
        },
        removeAllWatching: function () {
            $('.tf_province .tf_building').filter(function () {
                if (tf_map_building.access.checkWatching(this)) {
                    tf_map_building.access.removeWatching(this);
                }
            });
        },
        checkWatching: function (buildingObject) {
            if ($(buildingObject).hasClass('tf_map_building_watching')) {
                return true;
            } else {
                return false;
            }
        }

    },
    information: {
        setContainer: function (containerObject) {
            //var windowWidth = window.innerWidth;
            //$(containerObject).css('width', parseInt(windowWidth/3));
        },
        show: function (buildingObject) {
            this.hideAll();
            var containerObject = $(buildingObject).find('.tf_map_building_information');
            containerObject.show();
            tf_map_building.access.addWatching(buildingObject);

        },
        hideAll: function () {
            $('.tf_map_building_information').hide();
            tf_map_building.access.removeAllWatching();
        },
        //=========== ========== edit info =========== ==========
        getEdit: function (href) {
            tf_master_submit.ajaxNotReload(href, tf_master.bodyIdNameAction(), false);
        },
        checkShowName: function (object) {
            var formObject = $(object).parents("#frmMapBuildingEdit");
            var txtPreviewName = $(formObject).find("#txtPreviewName");
            var checkLength = $(object).data('length');
            var showName = $(object).val();
            if (tf_main.tf_checkInputMaxLength(object, checkLength, 'max length is ' + checkLength + ' characters')) {
                return false;
            } else {
                txtPreviewName.html(showName);
            }

        },
        postEdit: function (form) {
            var txtName = $(form).find("input[name= 'txtName']");
            var txtDisplayName = $(form).find("input[name= 'txtDisplayName']");
            var txtShortDescription = $(form).find("input[name= 'txtShortDescription']");
            var txtEmail = $(form).find("input[name= 'txtEmail']");
            var txtPhone = $(form).find("input[name= 'txtPhone']");
            var txtWebsite = $(form).find("input[name= 'txtWebsite']");
            var txtAddress = $(form).find("input[name= 'txtAddress']");

            if (tf_main.tf_checkInputNull(txtName, 'Enter a building name')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength(txtName, 50, 'max length of name is 50 characters')) {
                    return false;
                } else {
                    if (tf_main.tf_checkStringValid(txtName.val(), '<,>,~,$,&,\,/,|,*,%,#')) {
                        alert('Building Name does not exist characters: <, >, ~, $,&, \, /, |, *, %, #');
                        txtName.focus();
                        return false;
                    }
                }
            }

            if (tf_main.tf_checkInputNull(txtDisplayName, 'Enter a display name for building')) {
                return false;
            } else {
                if (tf_main.tf_checkStringValid(txtDisplayName.val(), '<,>,~,$,&,\,/,|,*,%,#')) {
                    alert('Display Name does not exist characters: <, >, ~, $,&, \, /, |, *, %, #');
                    txtDisplayName.focus();
                    return false;
                } else {
                    var length = txtDisplayName.data('length');
                    if (tf_main.tf_checkInputMaxLength(txtDisplayName, length, 'max length of name is ' + length + ' characters')) return false;
                }

            }

            //check select business
            var selectBusiness = false;
            $(form).find(".buildingBusiness").each(function () {
                if (this.checked == true) selectBusiness = true;
            });
            if (selectBusiness === false) {
                alert('You must select at least a business for building');
                return false;
            }
            if (tf_main.tf_checkInputNull(txtShortDescription, 'Enter short description for building')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength(txtShortDescription, 300, 'max length of short description is 300 characters')) return false;
            }
            if (txtEmail.val().length > 0) {
                if (!tf_main.tf_checkEmail(txtEmail.val())) {
                    alert('email invalid');
                    txtEmail.focus();
                    return false;
                }
            }
            var landId = $(form).data('land');
            var landObject = tf_land.objectById(landId);
            var projectObject = tf_land.projectObject(landObject);
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }

            $(form).ajaxForm({
                beforeSend: function () {
                    tf_master.tf_main_load_status();
                },
                success: function (data) {
                    //remove old land
                    tf_main.tf_remove(landObject);
                    if (data) {
                        projectObject.append(data);
                    }
                },
                complete: function () {
                    tf_master.tf_main_contain_action_close();
                    tf_master.tf_main_load_status();
                    tf_land.show.set_center(landId);
                }
            }).submit();
        },

        //============ ============ edit sample =========== ==========
        getSample: function (href) {
            tf_master_submit.ajaxNotReload(href, tf_master.bodyIdNameAction(), false);
        },
        changeSample: function (hrefCheckPoint, href, buildingId, sampleId, privateStatus, price) {
            var hrefCheckPoint = hrefCheckPoint + '/' + sampleId;
            var href = href + '/' + buildingId + '/' + sampleId;
            if (privateStatus == 1) {
                // building object
                var buildingObject = tf_map_building.objectById(buildingId);
                var landObject = tf_map_building.landObject(buildingObject);
                tf_master_submit.ajaxNotReload(href, landObject, true);
            } else {
                $.ajax({
                    url: hrefCheckPoint,
                    type: 'GET',
                    cache: false,
                    data: {},
                    beforeSend: function () {
                        tf_master.tf_main_load_status();
                    },
                    success: function (data) {
                        tf_master.tf_main_contain_action_close();
                        if (data) {
                            tf_master.bodyObject().append(data);
                        } else {
                            // using new sample
                            tf_master.tf_header_point_decrease(price);
                            // building object
                            var buildingObject = tf_map_building.objectById(buildingId);
                            var landObject = tf_map_building.landObject(buildingObject);
                            tf_master_submit.ajaxNotReload(href, landObject, true);
                        }
                    },
                    complete: function () {
                        tf_master.tf_main_load_status();
                    }
                });
            }

        }
    },
    menu: {
        hideAll: function () {
            $('.tf_building_menu_wrap').hide();
        },
        hide: function (buildingObject) {
            //hide menu of building
            $(buildingObject).find('.tf_building_menu_wrap').hide();
        },
        show: function (buildingObject) {
            //turn off menu of other buildings
            tf_map_building.menu.hideAll();

            $(buildingObject).find('.tf_building_menu_wrap').show();
        },
        getMobileMenu: function (href) {
            tf_master_submit.ajaxNotReload(href, tf_master.bodyIdNameAction(), false);
        }
    },
    mouseOver: function (buildingObject) {
        //building info
        $(buildingObject).children('.tf_building_name_wrap').addClass('tf-bg-white');
        tf_map_building.menu.show(buildingObject);
        tf_map_building.information.show(buildingObject);

        //land info
        tf_land.menu.hideAll();

    },
    mouseOut: function (buildingObject) {
        $(buildingObject).children('.tf_building_name_wrap').removeClass('tf-bg-white');

    },
    onClick: function (buildingObject) {

    },
    outClick: function () {
        tf_map_building.menu.hideAll();
        tf_map_building.show.turnOffFocusStatus();
    },
    show: {
        setStatus: function (buildingObject) {
            var buildingId = tf_map_building.buildingIdByObject(buildingObject);
            var buildingName = $(buildingObject).find('.tf_building_name_wrap');
            if (!buildingName.hasClass('tf_building_access_focus')) {
                // turn off old focus status (other lands)
                this.turnOffFocusStatus();
                buildingName.addClass('tf_building_access_focus');
                setInterval("tf_map_building.show.focusStatus('#tf_building_" + buildingId + "')", 1000);
            }

            //show menu
            tf_map_building.menu.show(buildingObject);
            //show info
            tf_map_building.information.show(buildingObject);

        },
        turnOffFocusStatus: function () {
            $('.tf_province .tf_building_name_wrap').filter(function () {
                // turn off old focus status (other building)
                if ($(this).hasClass('tf_building_access_focus')) {
                    $(this).removeClass('tf_building_access_focus');
                    $(this).removeClass('tf-bg-white');
                    $(this).removeClass('tf-bg-red');
                }
            });
            //hide menu
            tf_map_building.menu.hideAll();
            //hide information
            tf_map_building.information.hideAll();
        },
        focusStatus: function (buildingObject) {
            var focusObject = $(buildingObject).children('.tf_building_access_focus');
            if (focusObject.length > 0) {
                if ($(focusObject).hasClass('tf-bg-white')) {
                    $(focusObject).removeClass('tf-bg-white');
                    $(focusObject).addClass('tf-bg-red');
                } else if ($(focusObject).hasClass('tf-bg-red')) {
                    $(focusObject).removeClass('tf-bg-red');
                    $(focusObject).addClass('tf-bg-white');
                } else {
                    $(focusObject).addClass('tf-bg-white');
                }
            }

        },
    },
    comment: {
        getContent: function (commentObject) {
            var commentId = $(commentObject).data('comment');
            var href = $(commentObject).find('.tf_view_more').data('href') + '/' + commentId;
            var container = $(commentObject).find('.tf_comment_object_content_wrap');
            $.ajax({
                url: href,
                type: 'GET',
                cache: false,
                data: {},
                beforeSend: function () {
                    tf_master.tf_main_load_status();
                },
                success: function (data) {
                    if (data) {
                        container.empty();
                        container.append(data);
                    }
                },
                complete: function () {
                    tf_master.tf_main_load_status();
                }
            });
        },
        getIndex: function (href, buildingObject) {
            var buildingId = $(buildingObject).data('building');
            var href = href + '/' + buildingId;
            tf_master_submit.ajaxNotReload(href, tf_master.bodyIdNameAction(), false);
        },

        //view more comment
        moreComment: function (href, buildingId, take) {
            var dateTake = $('#tfMapBuildingCommentList').children('.tf_map_building_comment_object:last-child').data('date');
            var href = href + '/' + buildingId + '/' + take + '/' + dateTake;
            $.ajax({
                url: href,
                type: 'GET',
                cache: false,
                data: {},
                beforeSend: function () {
                    tf_master.tf_main_load_status();
                },
                success: function (data) {
                    if (data) {
                        $('#tfMapBuildingCommentList').append(data);
                    } else {
                        tf_main.tf_remove('#tfMapBuildingCommentViewMore');
                    }
                },
                complete: function () {
                    tf_master.tf_main_load_status();
                }
            });
        },

        addComment: function (formObject) {
            var contentObject = $(formObject).find('textarea[name="txtComment"]');
            var content = contentObject.val();
            if (content.length == 0) {
                alert('You must enter content');
                contentObject.focus();
                return false;
            } else {
                $(formObject).ajaxForm({
                    beforeSend: function () {
                        tf_master.tf_main_load_status();
                    },
                    success: function (data) {
                        if (data) {
                            if ($('#tfMapBuildingCommentList .tf_map_building_comment_object').length > 0) {
                                $('#tfMapBuildingCommentList .tf_map_building_comment_object:first').before(data);
                            } else {
                                $('#tfMapBuildingCommentList').append(data);
                            }
                        }
                    },
                    complete: function () {
                        // return default of action
                        contentObject.val('');
                        tf_master.tf_main_load_status();
                    }
                }).submit();
            }
        },

        //edit comment
        getEdit: function (href, commentObject) {
            var commentId = $(commentObject).data('comment');
            var contentObject = $(commentObject).find('.tf_comment_object_content_wrap');
            $.ajax({
                url: href + '/' + commentId,
                type: 'GET',
                cache: false,
                data: {},
                beforeSend: function () {
                    tf_master.tf_main_load_status();
                },
                success: function (data) {
                    if (data) {
                        tf_main.tf_empty(contentObject);
                        $(contentObject).append(data);
                    }
                },
                complete: function () {
                    tf_master.tf_main_load_status();
                }
            });
        },

        postEdit: function (formObject) {
            var container = $(formObject).parents('.tf_comment_object_content_wrap');
            var contentObject = $(formObject).find('textarea[name="txtComment"]');
            var content = contentObject.val();
            if (content.length == 0) {
                alert('You must enter content');
                contentObject.focus();
                return false;
            } else {
                $(formObject).ajaxForm({
                    beforeSend: function () {
                        tf_master.tf_main_load_status();
                    },
                    success: function (data) {
                        if (data) {
                            tf_main.tf_empty(container);
                            container.append(data);
                        }
                    },
                    complete: function () {
                        tf_master.tf_main_load_status();
                    }
                }).submit();
            }
        },

        //delete comment
        delete: function (href, commentObject) {
            var commentId = $(commentObject).data('comment');
            var href = href + '/' + commentId;
            $.ajax({
                url: href,
                type: 'GET',
                cache: false,
                data: {},
                beforeSend: function () {
                    tf_master.tf_main_load_status();
                },
                success: function (data) {
                    tf_main.tf_remove(commentObject);
                },
                complete: function () {
                    tf_master.tf_main_load_status();
                }
            });
        },
        setWidthCommentWrap: function (commentId) {
            var wrapObject = $('#tfMapBuildingCommentList').outerWidth();
            var contentObject = $('#tf_map_building_comment_object_' + commentId);
            var avatar = contentObject.find('.tf_avatar');
            var content = contentObject.find('.tf_comment_object_content');
            var widthAvatar = parseInt(avatar.outerWidth());
            content.css({'width': 'auto', 'max-width': wrapObject - widthAvatar - 40});

        }

    },
    follow: function (href, buildingObject) {
        var loginStatus = tf_master.login.status();
        var buildingId = tf_map_building.buildingIdByObject(buildingObject);
        var href = href + '/' + buildingId;
        var informationObject = $(buildingObject).find('.tf_map_building_information');
        $.ajax({
            url: href,
            type: 'GET',
            cache: false,
            data: {},
            beforeSend: function () {
                tf_master.tf_main_load_status();
            },
            success: function (data) {
                if (data) {
                    //logged
                    if (loginStatus) {
                        //remove old information
                        tf_main.tf_remove(informationObject);
                        $(buildingObject).append(data);
                    } else {
                        tf_master.bodyObject().append(data);
                    }
                }
            },
            complete: function () {
                tf_master.tf_main_load_status();
                //logged
                if (loginStatus) {
                    //show new information
                    $(buildingObject).find('.tf_map_building_information').show();
                }
            }
        });

    },
    love: function (href, buildingObject) {
        var loginStatus = tf_master.login.status();
        var buildingId = tf_map_building.buildingIdByObject(buildingObject);
        var href = href + '/' + buildingId;
        var informationObject = $(buildingObject).find('.tf_map_building_information');
        $.ajax({
            url: href,
            type: 'GET',
            cache: false,
            data: {},
            beforeSend: function () {
                tf_master.tf_main_load_status();
            },
            success: function (data) {
                if (data) {
                    //logged
                    if (loginStatus) {
                        //remove old information
                        tf_main.tf_remove(informationObject);
                        $(buildingObject).append(data);
                    } else {
                        tf_master.bodyIdName().append(data);
                    }

                }
            },
            complete: function () {
                tf_master.tf_main_load_status();

                //logged
                if (loginStatus) {
                    //show new information
                    $(buildingObject).find('.tf_map_building_information').show();
                }

            }
        });

        //tf_master_submit.ajaxNotReload(href, container, false);
    },
    share: {
        getShare: function (href, buildingObject) {
            var buildingId = tf_map_building.buildingIdByObject(buildingObject);
            var href = href + '/' + buildingId;
            tf_master_submit.ajaxNotReload(href, tf_master.bodyIdNameAction(), false);
        },
        postShare: function (form) {
            var email = $(form).find("input[name= 'txtEmail']");
            var selectStatus = false;
            if ($(email).val() != '') {
                if (!tf_main.tf_checkEmail($(email).val())) {
                    alert('Email invalid');
                    $(email).focus();
                    return false;
                } else {
                    selectStatus = true;
                }
            }
            $(form).find(".shareFriend").each(function () {
                if (this.checked == true) selectStatus = true;
            });
            if (selectStatus == false) {
                alert('select friend or email to share');
                return false;
            } else {
                //tf_master_submit.ajaxFormNotReload(formShare, '', false);
                var buildingId = $(form).data('building');
                var buildingObject = tf_map_building.objectById(buildingId);
                var informationObject = $(buildingObject).find('.tf_map_building_information');
                $(form).ajaxForm({
                    beforeSend: function () {
                        tf_master.tf_main_load_status();
                    },
                    success: function (data) {
                        if (data) {
                            if (data) {
                                //remove old information
                                tf_main.tf_remove(informationObject);
                                $(buildingObject).append(data);
                            }
                        }
                    },
                    complete: function () {
                        tf_master.tf_main_contain_action_close();
                        tf_master.tf_main_load_status();
                        //show new information
                        $(buildingObject).find('.tf_map_building_information').show();
                    }
                }).submit();
            }
        },
        getLink: function (href, buildingId) {
            var buildingObject = tf_map_building.objectById(buildingId);
            var informationObject = $(buildingObject).find('.tf_map_building_information');
            $.ajax({
                url: href,
                type: 'GET',
                cache: false,
                data: {},
                beforeSend: function () {
                    tf_master.tf_main_load_status();
                },
                success: function (data) {
                    if (data) {
                        //remove old information
                        tf_main.tf_remove(informationObject);
                        $(buildingObject).append(data);
                    }
                },
                complete: function () {
                    tf_master.tf_main_load_status();
                    //show new information
                    $(buildingObject).find('.tf_map_building_information').show();
                }
            });
        },
        selectLink: function () {
            $('#tf_building_share_link').select();
        }
    },
    visit: function (href, buildingId) {
        var href = href + '/' + buildingId;
        tf_master_submit.ajaxNotReload(href, '', false);
    },
    action_get: function () {
        var href = this.actionHref;
        tf_master_submit.ajaxNotReload(href, tf_master.bodyIdNameAction(), false);
    },
    delete: function (href, buildingObject) {
        var buildingId = tf_map_building.buildingIdByObject(buildingObject);
        var landObject = tf_map_building.landObject(buildingObject);
        var projectObject = tf_land.projectObject(landObject);
        var href = href + '/' + buildingId;
        tf_master_submit.ajaxNotReloadHasRemove(href, projectObject, false, landObject);
        tf_master.owned.getLand();
    }
}

//----------- ----------- event of mouse on building ----------- -----------
$(document).ready(function () {
    $('body').on('mouseover', tf_map_building.classNameAction(), function () {
        tf_map_building.mouseOver(this);
    }).on('mouseout', tf_map_building.classNameAction(), function () {
        tf_map_building.mouseOut(this);
    }).on('click touchend', tf_map_building.classNameAction(), function () {
        tf_map_building.onClick(this);
    });
});

//-----------  -----------  Notify -----------  -----------
$(document).ready(function () {
    //$('body').on('click', '.tf_building_notify_login', function () {
    //$('.tf_main_login_get').click();
    //});
});

//=========== =========== =========== Menu ============ ============= =========
$(document).ready(function () {
    $('body').on('click', '.tf_building_menu_m_get', function () {
        var buildingId = $(this).parents('.tf_building_menu_wrap').data('building');
        var href = $(this).data('href') + '/' + buildingId;
        tf_map_building.menu.getMobileMenu(href);

    });
});
//=========== =========== =========== Comment =========== =========== ===========
$(document).ready(function () {
    //get content
    $('body').on('click', '.tf_map_building_comment_object .tf_view_more', function () {
        var commentObject = $(this).parents('.tf_map_building_comment_object');
        tf_map_building.comment.getContent(commentObject);
    });

    //get comment from information
    $('body').on('click', '.tf_map_building_information .tf_comment', function () {
        var buildingObject = $(this).parents(tf_map_building.classNameAction());
        tf_map_building.comment.getIndex($(this).data('href'), buildingObject);
    });

    //enter content
    $('body').on('keyup', '#tfMapBuildingCommentForm .txt_content', function () {
        tf_main.tf_textareaAutoHeight(this, 1);
    });
    //get comment from  notify
    $('body').on('click', '.tf_building .tf_comment_notify', function () {
        var href = $(this).data('href');
        var buildingObject = $(this).parents(tf_map_building.classNameAction());
        tf_map_building.comment.getIndex(href, buildingObject);
        tf_main.tf_remove(this);
    });

    //view more comment
    $('body').on('click', '#tfMapBuildingCommentViewMore .tf-link', function () {
        var buildingId = $('#tf_map_building_comment_wrap').data('building');
        tf_map_building.comment.moreComment($(this).data('href'), buildingId, $(this).data('take'));
    });

    //add comment
    $('body').on('click', '#tfMapBuildingCommentForm .tf_comment_publish', function () {
        var formObject = $('#tfMapBuildingCommentForm');
        tf_map_building.comment.addComment(formObject);
    });

    // edit comment
    $('body').on('click', '.tf_map_building_comment_object .tf_comment_content_action .tf_edit', function () {
        var commentObject = $(this).parents('.tf_map_building_comment_object');
        tf_map_building.comment.getEdit($(this).data('href'), commentObject);
    });

    $('body').on('click', '.tf_map_building_comment_edit .tf_comment_edit', function () {
        var formObject = $(this).parents('.tf_map_building_comment_edit');
        tf_map_building.comment.postEdit(formObject);
    });


    //delete
    $('body').on('click', '.tf_map_building_comment_object .tf_comment_content_action .tf_delete', function () {
        var commentObject = $(this).parents('.tf_map_building_comment_object');
        if (confirm('Do you want to delete this comment?')) {
            tf_map_building.comment.delete($(this).data('href'), commentObject);
        }
    });

});

//=========== =========== =========== Invite =========== =========== ===========
$(document).ready(function () {
    $('body').on('click', '.tf_map_building_invite_get', function () {
        var landLicenseId = $(this).data('license');
        var href = $(this).data('href') + '/' + landLicenseId;
        tf_land.invite.getInvite(href);
    });
});

//=========== =========== =========== follow =========== =========== ===========
$(document).ready(function () {
    $('body').on('click', '.tf_map_building_information .tf_follow', function () {
        var href = $(this).data('href');
        var buildingObject = $(this).parents(tf_map_building.classNameAction());
        tf_map_building.follow(href, buildingObject);
    });
});

//=========== =========== =========== love =========== =========== ===========
$(document).ready(function () {
    $('body').on('click', '.tf_map_building_information .tf_love', function () {
        var buildingObject = $(this).parents(tf_map_building.classNameAction());
        tf_map_building.love($(this).data('href'), buildingObject);
    });
});

//=========== =========== =========== Visit =========== =========== ===========
$(document).ready(function () {
    // visit website
    $('body').on('click', '.tf_map_building_information .tf_map_building_website', function () {
        var href = $(this).data('visit-href');
        var buildingId = $(this).parents('.tf_map_building_information').data('building');
        tf_map_building.visit(href, buildingId);
    });

});

//=========== =========== =========== Share =========== =========== ===========
//---------- get share ----------
$(document).ready(function () {
    $('body').on('click', '.tf_map_building_information .tf_share', function () {
        var buildingObject = $(this).parents(tf_map_building.classNameAction());
        tf_map_building.share.getShare($(this).data('href'), buildingObject);
    });
});

//---------- select all friend ----------
$(document).ready(function () {
    $("body").on('click', '#tf_building_share_select_all', function () {
        var checkedStatus = this.checked;
        $("#frm_map_building_share").find(".shareFriend").each(function () {
            $(this).prop("checked", checkedStatus);
        });

    });

    $("body").on('click', '.shareFriend', function () {
        var allStatus = true;
        $("#frm_map_building_share").find(".shareFriend").each(function () {
            if (this.checked == false) allStatus = false;
        });
        $("#tf_building_share_select_all").prop("checked", allStatus);
    });
});

//---------- post share ----------
$(document).ready(function () {
    $('body').on('click', '.tf_map_building_share_send', function () {
        var formObject = $(this).parents('#frm_map_building_share');
        tf_map_building.share.postShare(formObject);
    });
});

//----------- get link ------------
$(document).ready(function () {
    //select link
    $('body').on('click', '#frm_map_building_share .tf_share_link', function () {
        tf_map_building.share.selectLink();
    });

    //when click button to copy
    $('body').on('click', '#frm_map_building_share .tf_copy', function () {
        tf_map_building.share.selectLink();
        document.execCommand('copy');
    });

    $('body').on('copy', '#frm_map_building_share .tf_share_link', function () {
        var href = $(this).data('href');
        var buildingId = $(this).parents('#frm_map_building_share').data('building');
        tf_map_building.share.getLink(href, buildingId);
    });
});

//=========== =========== =========== Edit =========== =========== ===========
//---------- edit info ----------
$(document).ready(function () {
    $('body').on('click', '.tf_building_menu .tf_edit_info', function () {
        tf_map_building.information.getEdit($(this).data('href'));
    });

    //---------- select business ----------
    $('body').on('click', '#frmMapBuildingEdit_check_all', function () {
        var checkedStatus = this.checked;
        $("#frmMapBuildingEdit").find('.buildingBusiness').each(function () {
            $(this).prop("checked", checkedStatus);
        });

    });
    $('body').on('click', '#frmMapBuildingEdit .buildingBusiness', function () {
        var allStatus = true;
        $('#frmMapBuildingEdit').find('.buildingBusiness').each(function () {
            if (this.checked == false) allStatus = false;
        });
        $('#frmMapBuildingEdit_check_all').prop("checked", allStatus);
    });

    //check name
    $('body').on('keyup', "#frmMapBuildingEdit input[name='txtDisplayName']", function (event) {
        var keyCode = (event.keyCode ? event.keyCode : event.which);
        if (keyCode != '13') {
            tf_map_building.information.checkShowName(this);
        }
    });

    //edit info
    $('body').on('click', '#frmMapBuildingEdit .tf_save', function () {
        var formEdit = $(this).parents('#frmMapBuildingEdit');
        tf_map_building.information.postEdit(formEdit);
    });
});

//---------- edit Sample ----------
$(document).ready(function () {
    // get sample
    $('body').on('click', '.tf_building_menu .tf_edit_sample', function () {
        tf_map_building.information.getSample($(this).data('href'));
    });

    $('body').on('click', '#tf_building_select_sample .tf_select_sample_menu', function () {
        tf_map_building.information.getSample($(this).data('href'));
    });

    // select sample
    $('body').on('click', '#tf_building_select_sample .tf_building_select_sample_img', function () {
        var hrefCheckPoint = $(this).parents('.tf_building_select_sample').data('href-check');
        var href = $(this).parents('.tf_building_select_sample').data('href-select');
        var buildingId = $(this).parents('.tf_building_select_sample').data('building');
        var sampleId = $(this).data('sample');
        var privateStatus = $(this).data('private-status');
        var price = $(this).data('price');
        tf_map_building.information.changeSample(hrefCheckPoint, href, buildingId, sampleId, privateStatus, price);
    });

});

//=========== =========== =========== Delete =========== =========== ===========
$(document).ready(function () {
    $('body').on('click', '.tf_building_menu .tf_delete_building', function () {
        var buildingObject = $(this).parents(tf_map_building.classNameAction());
        if (confirm('Do you want delete this building?')) {
            tf_map_building.delete($(this).data('href'), buildingObject);
        }
    });
});

