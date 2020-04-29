/**
 * Created by HUY on 4/15/2016.
 */
//=========== =========== =========== land object =========== =========== ===========
var tf_land = {
    landId: '',
    actionHref: '',
    action_get: function () {
        tf_master_submit.ajaxNotReload(this.actionHref, tf_master.bodyIdNameAction(), false);
    },
    landIdByObject: function (landObject) {
        return $(landObject).data('land');
    },
    areaObject: function (landObject) {
        return $(landObject).parents(tf_area.classNameAction());
    },
    projectObject: function (landObject) {
        return $(landObject).parents(tf_map_project.classNameAction());
    },
    buildingObject: function (landObject) {
        return $(landObject).find(tf_map_building.classNameAction());
    },
    objectById: function (landId) {
        return $('#tf_land_' + landId);
    },
    idName: function (landId) {
        return 'tf_land_' + landId;
    },
    idNameAction: function (landId) {
        return '#tf_land_' + landId;
    },
    className: function () {
        return 'tf_land';
    },
    classNameAction: function () {
        return '.tf_land';
    },
    idProject: function (landId) {
        return tf_land.projectObject(tf_land.objectById(landId)).attr('id');
    },
    menu: {
        hideAll: function () {
            $('.tf_land_menu').hide();
        },
        hide: function (landObject) {
            $(landObject).children('.tf_land_menu').hide();
        },
        show: function (landObject) {
            //turn off menu of other lands
            this.hideAll();
            $(landObject).children('.tf_land_menu').show();
        },
        mobile: {
            getContent: function (landObject) {
                var href = $(landObject).find('.m_tf_land_menu_icon').data('href') + '/' + tf_land.landIdByObject(landObject);
                tf_master_submit.ajaxNotReload(href, tf_master.bodyIdNameAction(), false);
            }
        }
    },
    mouseOver: function (landObject) {
        //area info
        var areaObject = tf_land.areaObject(landObject);
        if (!tf_area.access.checkWatching(areaObject)) {
            //turn off watching status of other areas
            tf_area.access.removeAllWatching();
            //turn off watching status
            tf_area.access.addWatching(areaObject);
        }

        //land info
        tf_main.tf_show_top($(landObject));

        var buildingObject = tf_land.buildingObject(landObject);
        //land does not has exist building
        if (buildingObject.length == 0) {
            //show menu of land
            tf_land.menu.show(landObject);

            //turn off building info
            tf_map_building.menu.hideAll();
            tf_map_building.information.hideAll();

        }

        //turn off menu of banner
        tf_banner.image.menu.hideAll();
        tf_banner.information.hideAll();
    },
    mouseOut: function (landObject) {
        //This land does not have a building that it is accessing.
        if ($(landObject).find('.tf_building_access_focus').length == 0) {
            tf_main.tf_hide_top($(landObject));
        }

        //tf_main.tf_hide_top($(landObject));

    },
    onClick: function (landObject) {
        tf_land.show.set_center(tf_land.landIdByObject(landObject));

    },
    outClick: function () {
        //turn off building info
        tf_map_building.outClick();

        tf_land.menu.hideAll();
        tf_land.show.turnOffFocusStatus();

    },
    build: {
        addBuilding: function (form) {
            var txtName = $(form).find("input[name= 'txtName']");
            var txtDisplayName = $(form).find("input[name= 'txtDisplayName']");

            var txtShortDescription = $(form).find("input[name= 'txtShortDescription']");
            var txtEmail = $(form).find("input[name= 'txtEmail']");

            if (tf_main.tf_checkInputNull(txtName, 'Enter a building name')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength(txtName, 50, 'max length of name is 50 characters')) return false;
            }

            if (tf_main.tf_checkStringValid(txtName.val(), '<,>,~,$,&,\,/,|,*,%,#')) {
                alert('Building Name does not exist characters: <, >, ~, $,&, \, /, |, *, %, #');
                txtName.focus();
                return false;
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
            $(form).find(".frmLandAddBuilding_business").each(function () {
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
            var ownerStatus = $(form).data('owner-status');
            //submit
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
                    //turn off form build and loading status
                    tf_master.tf_main_contain_action_close();
                    tf_master.tf_main_load_status();

                    //set center for land
                    tf_land.show.set_center(landId);
                }
            }).submit();

            // user did not bought this sample
            if (ownerStatus == 0) {
                var paymentPoint = $(form).data('point');
                tf_master.tf_header_point_decrease(paymentPoint);
            }

        },
        checkName: function (object) {
            if (tf_main.tf_checkInputMaxLength(object, 50, 'max length of name is 50 characters')) return false;
        },
        checkShowName: function (object) {
            var form = $(object).parents("#frmLandAddBuilding");
            var txtPreviewName = $(form).find("#txtPreviewName");
            var checkLength = $(object).data('length');
            var showName = $(object).val();
            if (tf_main.tf_checkInputMaxLength(object, checkLength, 'max length is ' + checkLength + ' characters')) {
                return false;
            } else {
                txtPreviewName.html(showName);
            }

        },
        request: {
            get: function (href) {
                tf_master_submit.ajaxNotReload(href, tf_master.bodyIdNameAction(), false);
            },
            send: function (form) {
                var sampleImage = $(form).find("input[name= 'txtImage']");
                var sampleDescription = $(form).find("textarea[name= 'txtDesignDescription']");
                var businessType = $(form).find("select[name= 'cbBusinessType']");
                var fullName = $(form).find("input[name= 'txtFullName']");
                var displayName = $(form).find("input[name= 'txtDisplayName']");
                var buildingShortDescription = $(form).find("input[name= 'txtShortDescription']");

                if (tf_main.tf_checkInputNull(sampleImage, 'Select a sample for design')) {
                    return false;
                }
                if (!tf_main.tf_checkInputNull(sampleDescription, '')) {
                    if (tf_main.tf_checkInputMaxLength(sampleDescription, 400, 'max length of content is 50 characters')) return false;
                }
                if (tf_main.tf_checkInputNull(businessType, 'Select a business type')) {
                    return false;
                }
                if (tf_main.tf_checkInputNull(fullName, 'Your must enter name of the building')) {
                    return false;
                } else {
                    if (tf_main.tf_checkInputMaxLength(fullName, 50, 'Display name must be shorter than 50 characters.')) return false;
                    if (tf_main.tf_checkStringValid(fullName.val(), '<,>,~,$,&,\,/,|,*,%,#')) {
                        alert('Building Name does not exist characters: <, >, ~, $,&, \, /, |, *, %, #');
                        fullName.focus();
                        return false;
                    }
                }
                if (tf_main.tf_checkInputNull(displayName, 'Your must enter dispaly name of the building')) {
                    return false;
                } else {
                    var maxLength = displayName.data('length');
                    if (tf_main.tf_checkInputMaxLength(displayName, maxLength, 'Display name must be shorter than ' + maxLength + ' characters.')) return false;
                    if (tf_main.tf_checkStringValid(displayName.val(), '<,>,~,$,&,\,/,|,*,%,#')) {
                        alert('Building Name does not exist characters: <, >, ~, $,&, \, /, |, *, %, #');
                        displayName.focus();
                        return false;
                    }
                }
                if (tf_main.tf_checkInputNull(buildingShortDescription, 'Your must short description of the activity of the building')) {
                    return false;
                } else {
                    //submit
                    for (instance in CKEDITOR.instances) {
                        CKEDITOR.instances[instance].updateElement();
                    }
                    $(form).ajaxForm({
                        beforeSend: function () {
                            tf_master.tf_main_load_status();
                        },
                        success: function (data) {
                            //remove old land
                            if (data) {
                                tf_master.tf_main_contain_action_close();
                                tf_master.bodyObject().append(data);
                            }
                        },
                        complete: function () {
                            tf_master.tf_main_load_status();
                        }
                    }).submit();
                }
            },
            cancel: function (landId, href) {
                if (confirm('Do you want to cancel the build request?')) {
                    var landObject = tf_land.objectById(landId);
                    $.ajax({
                        url: href,
                        type: 'GET',
                        cache: false,
                        data: {},
                        beforeSend: function () {
                            tf_master.tf_main_load_status();
                        },
                        success: function (data) {
                            tf_master.tf_main_contain_action_close();
                            if (data) {
                                landObject.remove();
                                tf_land.projectObject(landObject).append(data);
                            }
                        },
                        complete: function () {
                            tf_master.tf_main_load_status();
                        }
                    });
                }
            }
        }
    },
    invite: {
        notifyHighlight: function (object) {
            if ($(object).hasClass('tf-link-red')) {
                $(object).removeClass('tf-link-red');
                $(object).addClass('tf-link-orange');
            }
            else if ($(object).hasClass('tf-link-orange')) {
                $(object).removeClass('tf-link-orange');
                $(object).addClass('tf-link-red');
            }
        },

        getInvite: function (href) {
            tf_master_submit.ajaxNotReload(href, tf_master.bodyIdNameAction(), false);
        },

        postInvite: function () {
            var formInvite = $('#frmMapLandInvite');
            var emailObject = formInvite.find("input[name= 'txtEmail']");
            var notifyObject = formInvite.find('.tf_container_notify');
            if (tf_main.tf_checkInputNull(emailObject, 'You must enter email')) {
                return false;
            } else {
                if (!tf_main.tf_checkEmail($(emailObject).val())) {
                    alert('Email invalid');
                    $(emailObject).focus();
                    return false;
                } else {
                    var data = formInvite.serialize();
                    $.ajax({
                        type: 'POST',
                        url: formInvite.attr('action'),
                        dataType: 'html',
                        data: data,
                        beforeSend: function () {
                            tf_master.tf_main_load_status();
                            tf_main.tf_empty(notifyObject);
                        },
                        success: function (data) {
                            if (data) {
                                notifyObject.append(data);
                            } else {
                                //close form invite
                                tf_main.tf_remove(formInvite);

                                //instead for notify invite sent successfully
                                //$('body').find('.tf_land_invite_get').click();
                            }
                        },
                        complete: function () {
                            tf_master.tf_main_load_status();
                        }
                    });

                }
            }
        },
        getConfirm: function (href) {
            tf_master_submit.ajaxNotReload(href, tf_master.bodyIdNameAction(), false);
        },
        postConfirm: function (form) {
            var notifyObject = form.find('.tf_container_notify');
            var emailObject = form.find("input[name= 'txtEmail']");
            var firstName = form.find("input[name= 'txtFirstName']");
            var lastName = form.find("input[name= 'txtLastName']");
            var password = form.find("input[name= 'txtPassword']");
            var confirmPass = form.find("input[name= 'txtPasswordConfirm']");

            if (tf_main.tf_checkInputNull(emailObject, 'You must enter email')) {
                return false;
            } else {
                if (!tf_main.tf_checkEmail($(emailObject).val())) {
                    alert('Email invalid');
                    $(emailObject).focus();
                    return false;
                }
            }
            if (tf_main.tf_checkInputNull(firstName, 'You must enter first name')) {
                $(firstName).focus();
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength(firstName, 30, 'Max length is 30 character')) {
                    $(firstName).focus();
                    return false;
                }

            }
            if (tf_main.tf_checkInputNull(lastName, 'You must enter last name')) {
                $(lastName).focus();
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength(lastName, 30, 'Max length is 30 character')) {
                    $(lastName).focus();
                    return false;
                }
            }

            if (tf_main.tf_checkInputNull(password, 'You must enter password')) {
                $(password).focus();
                return false;
            }

            if (tf_main.tf_checkInputNull(confirmPass, 'You must enter password again')) {
                $(confirmPass).focus();
                return false;
            } else {
                if ($(password).val() !== $(confirmPass).val()) {
                    alert('Wrong Confirm password');
                    $(confirmPass).focus();
                    return false;
                } else {

                    var data = {
                        txtEmail: $(emailObject).val(),
                        txtFirstName: $(firstName).val(),
                        txtLastName: $(lastName).val(),
                        txtPassword: $(password).val(),
                        _token: form.find("input[name= '_token']").val(),
                    };
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: $(form).attr('action'),
                        data: data,
                        beforeSend: function () {
                            tf_master.tf_main_load_status();
                        },
                        success: function (result) {
                            if (!result.hasOwnProperty('result')) {
                                alert('Invalid');
                                return false;
                            }
                            else if (result['result'] == 'success') {
                                // to verify account
                                tf_main.tf_url_replace(result['content']);
                            }
                            else if (result['result'] == 'fail') {
                                $(notifyObject).append(result['content'])
                            }
                        },
                        complete: function () {
                            tf_master.tf_main_load_status();
                        },
                        error: function () {
                            alert('Error');
                        }
                    });


                }
            }

        }

    },
    show: {
        setStatus: function (landObject) {
            //show top for area
            var areaObject = tf_land.areaObject(landObject);
            tf_area.show.showTop(areaObject);

            var buildingObject = tf_land.buildingObject(landObject);

            //land has a building
            if (buildingObject.length > 0) {
                //building info
                tf_map_building.show.setStatus(buildingObject);

                // turn off old focus status (other lands)
                tf_land.show.turnOffFocusStatus();

            } else {

                var landId = tf_land.landIdByObject(landObject);
                var landMenu = $(landObject).find('.tf_land_menu_icon');
                if (!landMenu.hasClass('tf_land_access_focus')) {
                    // turn off old focus status (other lands)
                    this.turnOffFocusStatus();
                    landMenu.addClass('tf_land_access_focus');
                    setInterval("tf_land.show.focusStatus('" + tf_land.idNameAction(landId) + "')", 1000);
                }
                tf_land.menu.show(landObject);
                tf_map_building.show.turnOffFocusStatus();

            }

            //turn off info of banner
            tf_banner.image.outClick();
        },
        turnOffFocusStatus: function () {
            $('.tf_province .tf_land').filter(function () {
                // turn off old focus status (other lands)
                if ($(this).hasClass('tf_land_access')) {
                    $(this).find('.tf_land_access_focus').removeClass('tf_land_access_focus');
                    $(this).removeClass('tf_land_access');
                }
            });
        },
        focusStatus: function (landObject) {
            tf_land.show.view_status(landObject);
        },
        view_status: function (landObject) {
            var focusObject = $(landObject).find('.tf_land_access_focus');
            if (focusObject.length > 0) {
                if (focusObject.length > 0) {
                    if ($(focusObject).hasClass('tf-color')) {
                        $(focusObject).removeClass('tf-color');
                        $(focusObject).addClass('tf-color-red');
                    } else if ($(focusObject).hasClass('tf-color-red')) {
                        $(focusObject).removeClass('tf-color-red');
                        $(focusObject).addClass('tf-color');
                    } else {
                        $(focusObject).addClass('tf-color');
                    }
                }
            }
        },
        set_center: function (landId) {
            //turn off view status of banner
            tf_banner.show.turnOffFocusStatus();


            var landObject = tf_land.objectById(landId);
            //exist land on map ->exist project -> exist area
            //info of land
            var landTop = landObject.position().top;
            var landLeft = landObject.position().left;
            var landWidth = landObject.outerWidth();
            var landHeight = landObject.outerHeight();
            //info of area (contain land)
            var areaObject = tf_land.areaObject(landObject);
            var areaTop = areaObject.position().top;
            var areaLeft = areaObject.position().left;
            var provinceObject = tf_area.provinceObject(areaObject);

            //get limit of view let set position
            //center
            ////var viewLimitHeight = $('#tf_main_view_map').outerHeight() / 2;
            var viewLimitWidth = tf_map.viewMap.objectAction().outerWidth() / 2;

            //set bottom - left
            var viewLimitHeight = tf_map.viewMap.objectAction().outerHeight();

            //set position
            //set bottom - left
            if (tf_master.footer.titleObject().length > 0) {
                var footerTitleHeight = tf_master.footer.titleObject().outerHeight();
            } else {
                var footerTitleHeight = 0;
            }

            var newTopPosition = areaTop + landTop + landHeight - viewLimitHeight + footerTitleHeight;
            if (tf_master.accessDevice.isHandset()) {
                var newLeftPosition = areaLeft + landLeft - 10;
            } else {
                var newLeftPosition = areaLeft + landLeft + (landWidth / 2) - viewLimitWidth;
            }

            provinceObject.animate({'top': -newTopPosition, 'left': -newLeftPosition});
            landObject.addClass('tf_land_access');
            //view status
            this.setStatus(landObject);

        },
        position: function (currentProvinceId, accessProvinceId, areaId, landId, landHref, areaHref) {
            //landHref -> go to land when land of other provinces
            //areaHref -> go to land when land of current provinces
            if (currentProvinceId !== accessProvinceId) {
                // other provinces
                if (tf_main.tf_url_replace(landHref + '/' + landId)) {
                    tf_land.show.set_center(landId);
                }
            } else {
                var landObject = tf_land.objectById(landId);
                if (landObject.length > 0) {
                    //exist land on map ->exist project -> exist area
                    tf_land.show.set_center(landId);
                } else {
                    //not exist land on map ->exist project -> exist area
                    $.ajax({
                        url: areaHref + '/' + currentProvinceId + '/' + areaId,
                        type: 'GET',
                        cache: false,
                        data: {},
                        beforeSend: function () {
                            tf_master.tf_main_load_status();
                        },
                        success: function (data) {
                            if (data) {
                                tf_map_province.object().append(data);
                            }
                        },
                        complete: function () {
                            tf_land.show.set_center(landId);
                            tf_master.tf_main_load_status();
                        }
                    });
                }
            }
        }
    },
    share: {
        getShare: function (href, LandObject) {
            var href = href + '/' + tf_land.landIdByObject(LandObject);
            tf_master_submit.ajaxNotReload(href, tf_master.bodyIdNameAction(), false);
        },
        postShare: function () {
            var formShare = $('#frmMapLandShare');
            var email = formShare.find("input[name= 'txtEmail']");
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

            formShare.find(".shareFriend").each(function () {
                if (this.checked == true) selectStatus = true;
            });
            if (selectStatus == false) {
                alert('select friend to share');
                return false;
            } else {
                tf_master_submit.ajaxFormNotReload(formShare, '', false);
            }
        },
        getLink: function (href) {
            $.ajax({
                url: href,
                type: 'GET',
                cache: false,
                data: {},
                beforeSend: function () {
                    tf_master.tf_main_load_status();
                },
                success: function (data) {
                },
                complete: function () {
                    tf_master.tf_main_load_status();
                }
            });
        },
        selectLink: function () {
            $('#tf_land_share_link').select();
        }
    },
    //----------- ----------- Transaction ----------- -----------
    transaction: {
        //----------- Payment when buy land -----------
        payment: function () {
            var form = $('#frmLandBuy');
            var point = form.data('point');
            var landId = form.data('land');
            var landObject = $('#tf_land_' + landId);
            var buildHref = form.data('build');
            //get project contain land
            var projectContain = landObject.parents('.tf_project');
            form.ajaxForm({
                beforeSend: function () {
                    tf_master.tf_main_load_status();
                },
                success: function (data) {
                    //remove old land
                    tf_main.tf_remove(landObject);
                    if (data) {
                        //add land
                        projectContain.append(data);
                    }
                },
                complete: function () {
                    tf_master.tf_main_contain_action_close();
                    tf_master.tf_main_load_status();
                    buildHref = buildHref + '/' + landId;
                    tf_master_submit.ajaxNotReload(buildHref, '#tf_body', false);
                },

            }).submit();

            tf_master.tf_header_point_decrease(point);
            tf_land.show.set_center(landId);

        },

        //----------- Confirm use free land -----------
        confirmFree: function () {
            var form = $('#frmLandFree');
            var landId = form.data('land');
            var landObject = $('#tf_land_' + landId);
            var buildHref = form.data('build');

            //get project contain land
            var projectContain = landObject.parents('.tf_project');
            form.ajaxForm({
                beforeSend: function () {
                    tf_master.tf_main_load_status();
                },
                success: function (data) {
                    //remove old land
                    tf_main.tf_remove(landObject);
                    if (data) {
                        //add land
                        projectContain.append(data);
                    }
                },
                complete: function () {
                    tf_master.tf_main_contain_action_close();
                    tf_master.tf_main_load_status();
                    buildHref = buildHref + '/' + landId;
                    tf_master_submit.ajaxNotReload(buildHref, '#tf_body', false);
                }
            }).submit();
        }
    }
}

//----------- ----------- event of mouse on land ----------- -----------
//event of mouse on land
$(document).ready(function () {
    $('body').on('mouseover', tf_land.classNameAction(), function () {
        tf_land.mouseOver(this);
    }).on('mouseout', tf_land.classNameAction(), function () {
        tf_land.mouseOut(this);
    }).on('click touchend', tf_land.classNameAction(), function () {
        tf_land.onClick(this);
    });
});

//=========== =========== =========== Menu=========== =========== ===========
//on mobile
$(document).ready(function () {
    $('body').on('click', '.m_tf_land_menu_icon', function () {
        var landObject = $(this).parents('.tf_land');
        tf_land.menu.mobile.getContent(landObject);
    });
});
//=========== =========== =========== TRANSACTION=========== =========== ===========
//--------- transaction request -----------
$(document).ready(function () {
    $('body').on('click', '.tf_land_transaction_button', function () {
        var landObject = $(this).parents(tf_land.classNameAction());
        tf_land.actionHref = $(this).data('href') + '/' + tf_land.landIdByObject(landObject);
        tf_land.action_get();
        tf_master.owned.remove();
    });
});

//--------- payment -----------
$(document).ready(function () {
    $('body').on('click', '.tf_map_land_payment', function () {
        if (confirm('Do you want to pay?')) {
            tf_land.transaction.payment();
        }
    });
});

//--------- agree Select free land -----------
$(document).ready(function () {
    $('body').on('click', '.tf_map_land_free_agree', function () {
        if (confirm('Do you agree to select this land?')) {
            tf_land.transaction.confirmFree();
        }
    });
});

//=========== =========== =========== INVITE =========== =========== ===========
//notify
$(document).ready(function () {
    var notifyObject = $('.tf_province').find('#tf_land_invite_notify_icon');
    if (notifyObject.length > 0) {
        setInterval("tf_land.invite.notifyHighlight('#tf_land_invite_notify_icon')", 1000);
    }
});
//action
$(document).ready(function () {

    //get form invite
    $('body').on('click', '.tf_land_invite_get', function () {
        var licenseId = $(this).data('license');
        var href = $(this).data('href') + '/' + licenseId;
        tf_land.invite.getInvite(href);
    });

    //send
    $('body').on('click', '.tf_map_land_invite_send', function () {
        tf_land.invite.postInvite();
    });

    //view invite
    $('body').on('click', '#tf_land_invite_notify_icon', function () {
        var href = $(this).data('href');
        var inviteCode = $(this).data('code');
        tf_land.invite.getConfirm(href + '/' + inviteCode);
    });
    //confirm
    $('body').on('click', '#frmMapLandInviteConfirm .tf_save', function () {
        var form = $(this).parents('#frmMapLandInviteConfirm');
        tf_land.invite.postConfirm(form);
    });
});

//=========== =========== =========== SHARE =========== =========== ==========
//---------- get form share ----------
$(document).ready(function () {
    $('body').on('click', '.tf_land_share_get', function () {
        var landId = $(this).data('land');
        tf_land.share.getShare($(this).data('href'), tf_land.objectById(landId));
    });
});

//---------- select all friend ----------
$(document).ready(function () {
    $("body").on('click', '#tf_land_share_select_all', function () {
        var checkedStatus = this.checked;
        $("#frmMapLandShare").find(".shareFriend").each(function () {
            $(this).prop("checked", checkedStatus);
        });

    });

    $("body").on('click', '.shareFriend', function () {
        var allStatus = true;
        $("#frmMapLandShare").find(".shareFriend").each(function () {
            if (this.checked == false) allStatus = false;
        });
        $("#tf_land_share_select_all").prop("checked", allStatus);
    });
});

//----------- get link ------------
$(document).ready(function () {
    //select link share
    $('body').on('click', '#frmMapLandShare .tf_share_link', function () {
        tf_land.share.selectLink();
    });

    //when click button to copy
    $('body').on('click', '#frmMapLandShare .tf_copy', function () {
        tf_land.share.selectLink();
        document.execCommand('copy');
    });

    $('body').on('copy', '#frmMapLandShare .tf_share_link', function () {
        var href = $(this).data('href');
        tf_land.share.getLink(href);
    });
});

//----------- share -----------
$(document).ready(function () {
    $('body').on('click', '.tf_map_land_share_send', function () {
        tf_land.share.postShare();
    });
});

//=========== =========== =========== BUILD =========== =========== ===========
$(document).ready(function () {
    //---------- ---------- get build ---------- ----------
    $('body').on('click', '.tf_land_build_building_sample_get', function () {
        tf_land.actionHref = $(this).data('href') + '/' + $(this).data('land');
        tf_land.action_get();
        tf_master.owned.remove();
    });

    //---------- ---------- request build ---------- ----------
    $('body').on('click', '.tf_land_request_build', function () {
        var licenseId = $(this).data('license');
        var href = $(this).data('href');
        tf_land.build.request.get(href + '/' + licenseId);
    });

    $('body').on('click', '#frmLandRequestBuild .tf_send', function () {
        var form = $(this).parents('#frmLandRequestBuild');
        tf_land.build.request.send(form);
    });
    //canvel the build request
    $('body').on('click', '.tf_land_request_build_cancel', function () {
        var landId = $(this).parents('.tf_land_menu').data('land');
        var requestId = $(this).data('request');
        var href = $(this).data('href') + '/' + requestId;
        tf_land.build.request.cancel(landId, href);
    });


});

//---------- ---------- select building sample ---------- ----------
$(document).ready(function () {
    //---------- filter sample by private status -----------
    $('body').on('click', '.tf_select_building_sample_private_filter', function () {
        var landId = $(this).parents('#tf_select_building_sample').data('land');
        var href = $(this).parents('#tf_select_building_sample').data('href-filter');
        var privateStatus = $(this).data('private');
        var businessTypeId = $('#tf_select_building_sample_business').val();
        tf_land.actionHref = href + '/' + landId + '/' + privateStatus + '/' + businessTypeId;
        tf_land.action_get();
    });

    //---------- filter sample by business type -----------
    $("body").on('change', '#tf_select_building_sample_business', function () {
        var businessTypeId = $(this).val();
        var landId = $(this).parents('#tf_select_building_sample').data('land');
        var privateStatus = $(this).parents('#tf_select_building_sample').data('private-status');
        var href = $(this).parents('#tf_select_building_sample').data('href-filter');
        tf_land.actionHref = href + '/' + landId + '/' + privateStatus + '/' + businessTypeId;
        tf_land.action_get();
    });

});

//---------- ---------- add building ---------- ----------
$(document).ready(function () {
    //---------- get form ----------
    $('body').on('click', '.tf_select_building_sample_image', function () {
        var sampleId = $(this).data('sample');
        var href = $(this).parents('.tf_select_building_sample').data('href-add');
        var landId = $(this).parents('.tf_select_building_sample').data('land');
        tf_land.actionHref = href + '/' + landId + '/' + sampleId;
        tf_land.action_get();
    });

    //---------- select business ----------
    $("body").on('click', '#frmLandAddBuilding_check_all', function () {
        var checkedStatus = this.checked;
        $("#frmLandAddBuilding").find('.frmLandAddBuilding_business').each(function () {
            $(this).prop("checked", checkedStatus);
        });

    });
    $("body").on('click', '.frmLandAddBuilding_business', function () {
        var allStatus = true;
        $("#frmLandAddBuilding").find(".frmLandAddBuilding_business").each(function () {
            if (this.checked == false) allStatus = false;
        });
        $("#frmLandAddBuilding_check_all").prop("checked", allStatus);
    });

    //check name
    $('body').on('keyup', "#frmLandAddBuilding input[name='txtDisplayName']", function () {
        tf_land.build.checkShowName(this);
    });

    $('body').on('keyup', "#frmLandAddBuilding input[name='txtName']", function () {
        tf_land.build.checkName(this);
    });
    //---------- check add ----------
    $('body').on('click', '#frmLandAddBuilding .tf_save', function () {
        var form = $(this).parents("#frmLandAddBuilding");
        tf_land.build.addBuilding(form);
    });
});