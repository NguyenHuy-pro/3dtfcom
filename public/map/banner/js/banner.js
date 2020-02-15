/**
 * Created by 3D on 3/22/2016.
 */
var tf_banner = {
    bannerId: '',
    actionHref: '',
    tf_banner_action_get: function () {
        var href = this.actionHref;
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
                tf_master.bodyObject().append(data);
            },
            complete: function () {
                tf_master.tf_main_load_status();
            }
        });
    },
    bannerIdByObject: function (bannerObject) {
        return $(bannerObject).data('banner');
    },
    areaObject: function (bannerObject) {
        return $(bannerObject).parents(tf_area.classNameAction());
    },
    projectObject: function (bannerObject) {
        return $(bannerObject).parents(tf_map_project.classNameAction());
    },
    objectById: function (bannerId) {
        return $('#tf_banner_' + bannerId);
    },
    idName: function (bannerId) {
        return 'tf_banner_' + bannerId;
    },
    idNameAction: function (bannerId) {
        return '#tf_banner_' + bannerId;
    },
    className: function () {
        return 'tf_banner';
    },
    classNameAction: function () {
        return '.tf_banner';
    },
    information: {
        setContainer: function (containerObject) {
            //var windowWidth = window.innerWidth;
            //$(containerObject).css('width', parseInt(windowWidth/4));
        },
        show: function (imageContainer) {
            this.hideAll();
            var containerObject = $(imageContainer).find('.tf_banner_information');
            this.setContainer(containerObject);
            containerObject.show();
        },
        hideAll: function () {
            $('.tf_banner_information').hide();
        },
        mobile: {
            getInfo: function (bannerObject) {
                var bannerId = tf_banner.bannerIdByObject(bannerObject);
                var href = $(bannerObject).find('.m_tf_banner_menu_icon').data('href') + '/' + bannerId;
                tf_master_submit.ajaxNotReload(href, $('#' + tf_master.bodyIdName()), false);
            }
        }
    },
    //--------- ------------ Set position to view ------------ ------------
    show: {
        setStatus: function (bannerObject) {
            var bannerId = tf_banner.bannerIdByObject(bannerObject);
            //show top for area
            var areaObject = tf_banner.areaObject(bannerObject);
            tf_area.show.showTop(areaObject);

            $('.tf_province .tf_banner').filter(function () {
                // turnoff old focus status (other banners)
                if (!$(this).hasClass('tf_banner_access')) {
                    $(this).addClass('tf_banner_access');
                }
            });
            var bannerImageWrap = $(bannerObject).find('.tf_banner_image_wrap');
            tf_banner.image.menu.show(bannerImageWrap);
            var m_landMenuIcon = $(bannerObject).find('.m_tf_banner_menu_icon');
            //on mobile
            if (m_landMenuIcon.length > 0) {
                if (!m_landMenuIcon.hasClass('m_tf_banner_access_focus')) {
                    // turn off old focus status (other lands)
                    this.turnOffFocusStatus();
                    m_landMenuIcon.addClass('m_tf_banner_access_focus');
                    setInterval("tf_banner.show.focusStatus('#tf_banner_" + bannerId + "')", 1000);
                }
            } else {
                tf_banner.information.show(bannerImageWrap);
            }
        },
        turnOffFocusStatus: function () {
            $('.tf_province .tf_banner').filter(function () {
                // turnoff old focus status (other banners)
                if ($(this).hasClass('tf_banner_access')) {
                    $(this).find('.m_tf_banner_access_focus').removeClass('m_tf_banner_access_focus');
                    $(this).removeClass('tf_banner_access');
                }
            });
        },
        focusStatus: function (bannerObject) {
            tf_banner.show.view_status(bannerObject);
        },
        view_status: function (bannerObject) {
            var focusObject = $(bannerObject).find('.m_tf_banner_access_focus');
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
        set_center: function (bannerId) {
            //turn off view status of land
            tf_land.show.turnOffFocusStatus();
            //turn off view status of building
            tf_map_building.outClick();

            var bannerObject = tf_banner.objectById(bannerId);
            //exist banner on map ->exist project -> exist area
            //info of banner
            var bannerTop = bannerObject.position().top;
            var bannerLeft = bannerObject.position().left;
            var bannerWidth = bannerObject.outerWidth();
            var bannerHeight = bannerObject.outerHeight();
            //info of area (contain banner)
            var areaObject = tf_banner.areaObject(bannerObject);
            var areaTop = areaObject.position().top;
            var areaLeft = areaObject.position().left;
            var provinceObject = tf_area.provinceObject(areaObject);
            //get limit of view let set position

            //set center
            // var viewLimitHeight = $('#tf_main_view_map').outerHeight() / 2;
            var viewLimitWidth = tf_map.viewMap.objectAction().outerWidth() / 2;

            //set bottom - left
            var viewLimitHeight = tf_map.viewMap.objectAction().outerHeight();

            //position
            //set bottom - left
            if(tf_master.footer.titleObject().length > 0){
                var footerTitleHeight = tf_master.footer.titleObject().outerHeight();
            }else{
                var footerTitleHeight = 0;
            }

            var newTopPosition = areaTop - viewLimitHeight + bannerTop + bannerHeight + footerTitleHeight;
            if (tf_master.accessDevice.isHandset()) {
                var newLeftPosition = areaLeft + bannerLeft - 10;
            } else {
                var newLeftPosition = areaLeft + bannerLeft + (bannerWidth / 2) - viewLimitWidth;
            }

            provinceObject.animate({'top': -newTopPosition, 'left': -newLeftPosition});
            bannerObject.addClass('tf_banner_access');

            this.setStatus(bannerObject);
        },
        position: function (currentProvinceId, accessProvinceId, areaId, bannerId, bannerHref, areaHref) {
            //landHref -> go to land when land of other provinces
            //areaHref -> go to land when land of current provinces
            if (currentProvinceId !== accessProvinceId) {
                // other province
                if (tf_main.tf_url_replace(bannerHref + '/' + bannerId)) {
                    tf_banner.show.set_center(bannerId);
                }
            } else {
                var bannerObject = tf_banner.objectById(bannerId);
                if (bannerObject.length > 0) {
                    //exist banner on map ->exist project -> exist area
                    tf_banner.show.set_center(bannerId);
                } else {
                    //not exist banner on map ->exist project -> exist area
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
                            tf_banner.show.set_center(bannerId);
                            tf_master.tf_main_load_status();
                        }
                    });
                }
            }
        }
    },
    share: {
        getShare: function (href, bannerObject) {
            var href = href + '/' + tf_banner.bannerIdByObject(bannerObject);
            tf_master_submit.ajaxNotReload(href, tf_master.bodyIdNameAction(), false);
        },
        postShare: function () {
            var formShare = $('#frmMapBannerShare');
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
                alert('select friend or email to share');
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
            $('#tf_banner_share_link').select();
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

        getInvite: function (href, bannerObject) {
            var href = href + '/' + tf_banner.bannerIdByObject(bannerObject);
            tf_master_submit.ajaxNotReload(href, tf_master.bodyObject(), false);
        },

        postInvite: function () {
            var formInvite = $('#frmMapBannerInvite');
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
                                $('body').find('.tf_banner_invite_get').click();
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
            tf_master_submit.ajaxNotReload(href, tf_master.bodyObject(), false);
        },
        postConfirm: function (formObject) {
            var notifyObject = formObject.find('.tf_container_notify');
            var emailObject = formObject.find("input[name= 'txtEmail']");
            var firstName = formObject.find("input[name= 'txtFirstName']");
            var lastName = formObject.find("input[name= 'txtLastName']");
            var password = formObject.find("input[name= 'txtPassword']");
            var confirmPass = formObject.find("input[name= 'txtPasswordConfirm']");

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
                        _token: formObject.find("input[name= '_token']").val(),
                    };
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: $(formObject).attr('action'),
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

    //--------- ------------ Transaction ------------ ------------
    transaction: {
        //--------- payment when buy banner  ------------
        payment: function () {
            var form = $('#frmBannerBuy');
            var href = form.attr('action');
            var bannerId = form.data('banner');
            var hrefAddImage = form.data('image-add');
            var data = form.serialize();
            $.ajax({
                url: href + '/' + bannerId,
                type: 'POST',
                cache: false,
                data: data,
                beforeSend: function () {
                    tf_master.tf_main_load_status();
                },
                success: function (data) {
                    // drop old banner image
                    $('#tf_banner_image_wrap_' + bannerId).remove();
                    // add new banner image
                    tf_banner.objectById(bannerId).append(data);
                },
                complete: function () {
                    tf_master.tf_main_contain_action_close();
                    tf_master.tf_main_load_status();
                    tf_banner.show.set_center(bannerId);
                    //show add image
                    hrefAddImage = hrefAddImage + '/' + bannerId;
                    tf_master_submit.ajaxNotReload(hrefAddImage, tf_master.bodyObject(), false);
                }
            });
        },

        //--------- agree select free banner -----------
        confirmFree: function () {
            var form = $('#frmBannerFree');
            var href = form.attr('action');
            var bannerId = form.data('banner');
            var hrefAddImage = form.data('image-add');
            var data = form.serialize();
            $.ajax({
                url: href + '/' + bannerId,
                type: 'POST',
                cache: false,
                data: data,
                beforeSend: function () {
                    tf_master.tf_main_load_status();
                },
                success: function (data) {
                    // drop old banner image
                    $('#tf_banner_image_wrap_' + bannerId).remove();
                    // add new banner image
                    tf_banner.objectById(bannerId).append(data);
                },
                complete: function () {
                    tf_master.tf_main_contain_action_close();
                    tf_master.tf_main_load_status();
                    tf_banner.show.set_center(bannerId);
                    //show add image
                    hrefAddImage = hrefAddImage + '/' + bannerId;
                    tf_master_submit.ajaxNotReload(hrefAddImage, $('#' + tf_master.bodyIdName()), false);
                }
            });
        }
    },

    //--------- ------------ Image ------------ ------------
    image: {
        menu: {
            hideAll: function () {
                $('.tf_banner_menu').hide();
            },
            hide: function (imageContainer) {
                $(imageContainer).children('.tf_banner_menu').hide();
            },
            show: function (imageContainer) {
                //turn off menu of other lands
                this.hideAll();
                //show menu
                $(imageContainer).children('.tf_banner_menu').toggle();
            }
        },
        mouseOver: function (imageContainer) {
            //area info
            var areaObject = $(imageContainer).parents('.tf_area');
            if (!tf_area.access.checkWatching(areaObject)) {
                //turn off watching status of other areas
                tf_area.access.removeAllWatching();
                //turn off watching status
                tf_area.access.addWatching(areaObject);
            }

            //banner info
            tf_main.tf_show_top($(imageContainer).parents('.tf_banner'));

            //show menu
            tf_banner.image.menu.show(imageContainer);
            //show information
            tf_banner.information.show(imageContainer);

            //turn off info of building
            tf_map_building.menu.hideAll();
            tf_map_building.information.hideAll();

            //turn off menu of land
            tf_land.menu.hideAll();
        },
        mouseOut: function (imageContainer) {

            tf_main.tf_hide_top($(imageContainer).parents('.tf_banner'));

        },
        onClick: function (imageContainer) {
            //turn off view status of land
            tf_land.outClick();
            //turn off view status of building
            tf_map_building.outClick();
            //this.mouseOver(imageContainer);

            var bannerObject = $(imageContainer).parents('.tf_banner');
            var bannerId = bannerObject.data('banner');
            tf_banner.show.set_center(bannerId);
        },
        outClick: function () {
            //hide menu
            tf_banner.image.menu.hideAll();
            //hide information
            tf_banner.information.hideAll();
        },
        //--------- check new image -----------
        postAdd: function (form) {
            if (tf_main.tf_checkInputNull('#imageFile', 'Select an image')) {
                return false;
            }
            /*check size before upload
             else {
             // check size of image upload
             var limitWidth = $('#imageFile').data('width');
             var limitHeight = $('#imageFile').data('height');
             var uploadWidth = $('#checkFileImage').outerWidth();
             var uploadHeight = $('#checkFileImage').outerHeight();
             if (uploadWidth != limitWidth || uploadHeight != limitHeight) {
             alert('Wrong image, Request size: (' + limitWidth + ' x ' + limitHeight + ')px, Upload size: (' + uploadWidth + ' x ' + uploadHeight + ')px');
             $('#imageFile').focus();
             return false;
             }
             }
             */
            var bannerId = $(form).find("input[name= 'txtBanner']").val();
            $(form).ajaxForm({
                beforeSend: function () {
                    tf_master.tf_main_load_status();
                },
                success: function (data) {
                    // drop old banner image
                    $('#tf_banner_image_wrap_' + bannerId).remove();
                    // add new banner image
                    $('#tf_banner_' + bannerId).append(data);
                },
                complete: function () {
                    tf_master.tf_main_contain_action_close();
                    tf_master.tf_main_load_status();
                }
            }).submit();
        },

        //---------- check edit info ----------
        postEditInfo: function (form) {
            /* check size before upload
             if (!tf_main.tf_checkInputNull('#imageFile', '')) {
             // check size of image upload
             var limitWidth = $('#imageFile').data('width');
             var limitHeight = $('#imageFile').data('height');
             var uploadWidth = $('#checkFileImage').outerWidth();
             var uploadHeight = $('#checkFileImage').outerHeight();
             if (uploadWidth != limitWidth || uploadHeight != limitHeight) {
             alert('Wrong image, Request size: (' + limitWidth + ' x ' + limitHeight + ')px, Upload size: (' + uploadWidth + ' x ' + uploadHeight + ')px');
             $('#imageFile').focus();
             return false;
             }
             }
             */
            var bannerId = $(form).find("input[name= 'txtBanner']").val();
            var bannerImageId = $(form).find("input[name= 'txtBannerImage']").val();
            $(form).ajaxForm({
                beforeSend: function () {
                    tf_master.tf_main_load_status();
                },
                success: function (data) {
                    // drop old image
                    $('#tf_banner_image_' + bannerImageId).remove();
                    // add new image
                    $('#tf_banner_image_wrap_' + bannerId).append(data);
                },
                complete: function () {
                    tf_master.tf_main_contain_action_close();
                    tf_master.tf_main_load_status();
                }
            }).submit();
        },

        detail: function (imageObject) {
            var bannerImageId = $(imageObject).data('image');
            var href = $(imageObject).data('href-detail') + '/' + bannerImageId;
            tf_master_submit.ajaxNotReload(href, $('#' + tf_master.bodyIdName()), false);
        },
        //---------- visit website ----------
        visitWebsite: function (imageObject) {
            var bannerImageId = $(imageObject).data('image');
            var href = $(imageObject).data('href-visit') + '/' + bannerImageId;
            tf_master_submit.ajaxNotReload(href, '', false);
        },
        delete: function (bannerImageWrapObject, href) {
            if (confirm('Do you delete this banner image?')) {
                // get image id  of banner
                var bannerImageId = $(bannerImageWrapObject).find('.tf_banner_image').data('image');
                var href = href + '/' + bannerImageId;
                var bannerObject = $(bannerImageWrapObject).parents('.tf_banner');
                tf_master_submit.ajaxNotReloadHasRemove(href, bannerObject, false, bannerImageWrapObject);
            }
        },
        report: {
            get: function (href) {
                tf_master_submit.ajaxNotReload(href, $('#' + tf_master.bodyIdName()), false);
            },
            send: function (form) {
                var selectStatus = false;
                form.find(".tf_bad_info").each(function () {
                    if (this.checked == true) selectStatus = true;
                });
                if (!selectStatus) {
                    alert('You must select a report info');
                    return false
                } else {
                    tf_master_submit.ajaxFormNotReload(form, '', false);
                }
            }
        }
    },
    visit: function (bannerObject) {
        var href = $(bannerObject).data('href-visit') + '/' + tf_banner.bannerIdByObject(bannerObject);
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
    }
}

//=========== =========== =========== EVENT ON BANNER =========== =========== ===========
$(document).ready(function () {
    $('body').on('mouseover', '.tf_banner_image_wrap', function () {
        tf_banner.image.mouseOver(this);
    }).on('mouseout', '.tf_banner_image_wrap', function () {
        tf_banner.image.mouseOut(this);
    }).on('click touchend', '.tf_banner_image_wrap', function () {
        tf_banner.image.onClick(this);
        var bannerObject = $(this).parents('.tf_banner');
        tf_banner.visit(bannerObject);
    });

    $('body').on('click', '.tf_banner_image', function () {
        // get full image of banner
        tf_banner.image.detail(this);
    });
});

//=========== =========== =========== Information=========== =========== ===========
//on mobile
$(document).ready(function () {
    $('body').on('click', '.m_tf_banner_menu_icon', function () {
        var bannerObject = $(this).parents('.tf_banner');
        tf_banner.information.mobile.getInfo(bannerObject)
    });
});

//=========== =========== =========== Report ============ ============= ============
$(document).ready(function () {
    //get
    $('body').on('click', '.tf_banner_image_report_get', function () {
        var imageId = $(this).data('image');
        var href = $(this).data('href') + '/' + imageId;
        tf_banner.image.report.get(href);
    })

    //send
    $('body').on('click', '#tf_map_banner_image_report .tf_send', function () {
        var formObject = $(this).parents('#tf_map_banner_image_report');
        tf_banner.image.report.send(formObject);
    });
});
//=========== =========== =========== TRANSACTION=========== =========== ===========
//--------- transaction request -----------
$(document).ready(function () {
    $('body').on('click', '.tf_banner_transaction_button', function () {
        var objectBanner = $(this).parents('.tf_banner');
        var bannerId = objectBanner.data('banner');
        tf_banner.actionHref = $(this).data('href') + '/' + bannerId;
        tf_banner.tf_banner_action_get();
        tf_master.owned.remove();
    });
});

//--------- Payment -----------
$(document).ready(function () {
    $('body').on('click', '.tf_map_banner_payment', function () {
        if (confirm('Do you want to pay?')) {
            tf_banner.transaction.payment();
        }
    });
});

//--------- agree select free banner -----------
$(document).ready(function () {
    $('body').on('click', '.tf_map_banner_free_agree', function () {
        if (confirm('do you agree to select this banner??')) {
            tf_banner.transaction.confirmFree();
        }
    });
});


//=========== =========== =========== IMAGE =========== =========== ===========
/* ---------- ---------- add image ---------- ---------- */
$(document).ready(function () {
    // -------- get form add ---------
    $('body').on('click', '.tf_banner_image_add_get', function () {
        var bannerId = $(this).data('banner');
        tf_banner.actionHref = $(this).data('href') + '/' + bannerId;
        tf_banner.tf_banner_action_get();
        tf_master.owned.remove();
    });

    //---------- check add -----------
    $('body').on('click', '.tf_banner_image_add_post', function () {
        var form = $(this).parents('#frm_banner_image_add');
        tf_banner.image.postAdd(form);
    });
});

/* ---------- ---------- edit info ---------- ---------- */
$(document).ready(function () {
    //----------- get form edit -----------
    $('body').on('click', '.tf_banner_image_edit_get', function () {
        //banner object
        var bannerId = $(this).data('banner');
        // get image id  of banner
        var bannerImageId = $('#tf_banner_' + bannerId).find('.tf_banner_image').data('image');
        var href = $(this).data('href') + '/' + bannerImageId;
        tf_banner.actionHref = href;
        tf_banner.tf_banner_action_get();
        tf_master.owned.remove();
    });

    //---------- check edit info  ----------
    $('body').on('click', '.tf_banner_image_edit_post', function () {
        var form = $(this).parents('#frm_banner_image_edit');
        tf_banner.image.postEditInfo(form);
    });
});

/*----------- ---------- Get detail ------------ ----------- */
$(document).ready(function () {
    $('body').on('click', '.tf_banner_information .tf_detail', function () {
        //banner object
        var bannerId = $(this).parents('.tf_banner_information').data('banner');
        var bannerObject = tf_banner.objectById(bannerId);
        // get image of banner
        var imageObject = bannerObject.find('.tf_banner_image');

        tf_banner.image.detail(imageObject);
    });
});
/* ---------- ---------- visit website ---------- ---------- */
$(document).ready(function () {
    $('body').on('click', '.tf_banner_information .tf_website', function () {
        //banner object
        var bannerId = $(this).parents('.tf_banner_information').data('banner');
        var bannerObject = tf_banner.objectById(bannerId);
        // get image of banner
        var imageObject = bannerObject.find('.tf_banner_image');
        tf_banner.image.visitWebsite(imageObject);
    });
});

//=========== =========== =========== INVITE =========== =========== ===========
//notify
$(document).ready(function () {
    var notifyObject = tf_map_province.object().find('.tf_banner_invite_notify');
    if (notifyObject.length > 0) {
        setInterval("tf_banner.invite.notifyHighlight('#tf_banner_invite_notify_icon')", 1000);
    }
});
//action
$(document).ready(function () {

    //get form invite
    $('body').on('click', '.tf_banner_invite_get', function () {
        tf_banner.invite.getInvite($(this).data('href'), tf_banner.idNameAction($(this).data('banner')));
    });

    //send
    $('body').on('click', '.tf_map_banner_invite_send', function () {
        tf_banner.invite.postInvite();
    });

    //view invite
    $('body').on('click', '.tf_banner_invite_notify .tf_view', function () {
        var href = $(this).data('href');
        var inviteId = $(this).parents('.tf_banner_invite_notify').data('invite');
        tf_banner.invite.getConfirm(href + '/' + inviteId);
    });
    //confirm
    $('body').on('click', '#frmMapBannerInviteConfirm .tf_save', function () {
        var formObject = $(this).parents('#frmMapBannerInviteConfirm');
        tf_banner.invite.postConfirm(formObject);
    });
});

//=========== =========== =========== SHARE =========== =========== ===========
//---------- get form share ----------
$(document).ready(function () {
    $('body').on('click', '.tf_banner_share_get', function () {
        tf_banner.share.getShare($(this).data('href'), tf_banner.idNameAction($(this).data('banner')));
    });
});

//---------- select all friend ----------
$(document).ready(function () {
    $("body").on('click', '#tf_banner_share_select_all', function () {
        var checkedStatus = this.checked;
        $("#frmMapBannerShare").find(".shareFriend").each(function () {
            $(this).prop("checked", checkedStatus);
        });

    });

    $("body").on('click', '.shareFriend', function () {
        var allStatus = true;
        $("#frmMapBannerShare").find(".shareFriend").each(function () {
            if (this.checked == false) allStatus = false;
        });
        $("#tf_banner_share_select_all").prop("checked", allStatus);
    });
});

//----------- get link ------------
$(document).ready(function () {
    //select link
    $('body').on('click', '#frmMapBannerShare .tf_share_link', function () {
        tf_banner.share.selectLink();
    });
    //when click button to copy
    $('body').on('click', '#frmMapBannerShare .tf_copy', function () {
        tf_banner.share.selectLink();
        document.execCommand('copy');
    });

    $('body').on('copy', '#frmMapBannerShare .tf_share_link', function () {
        var href = $(this).data('href');
        tf_banner.share.getLink(href);
    });
});

//----------- share -----------
$(document).ready(function () {
    $('body').on('click', '.tf_map_banner_share_send', function () {
        tf_banner.share.postShare();
    });
});

/* ---------- Delete ---------- */
$(document).ready(function () {
    $('body').on('click', '.tf_banner_image_delete', function () {
        //banner object
        var bannerId = $(this).data('banner');
        var bannerImageWrap = '#tf_banner_image_wrap_' + bannerId;
        tf_banner.image.delete(bannerImageWrap, $(this).data('href'));
    });
});