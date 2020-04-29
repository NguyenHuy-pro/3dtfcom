//========== ========== ========== master page ========== ========== ==========
//----------- ----------- main ----------- -----------
var tf_master = {
    bodyObject: function () {
        return $('#tf_body');
    },
    bodyIdName: function () {
        return 'tf_body';
    },
    bodyIdNameAction: function () {
        return '#tf_body';
    },
    bodyClassName: function () {
        return 'tf_body';
    },
    bodyClassNameAction: function () {
        return '.tf_body';
    },
    accessDevice: {
        isMobile: function () {
            return (tf_master.bodyObject().data('device') == 'mobile') ? true : false;
        },
        isTablet: function () {
            return (tf_master.bodyObject().data('device') == 'tablet') ? true : false;
        },
        isHandset: function () {
            return (tf_master.accessDevice.isMobile() || tf_master.accessDevice.isTablet()) ? true : false;
        }
    },
    checkPage: {
        map: function () {
            return ($('#tf_main_view_map').length > 0) ? true : false;
        }
    },
    setLayout: function () {
        var windowWidth = window.innerWidth;
        var windowHeight = window.innerHeight;
        if ($('#tf_main_header_center').length > 0) {
            $('#tf_main_wrap').css('height', windowHeight);
            //header
            var widthHeaderLeft = $('#tf_main_header_left').outerWidth();
            var widthHeaderRight = $('#tf_main_header_right').outerWidth();
            $('#tf_main_header_center').css('width', windowWidth - widthHeaderLeft - widthHeaderRight - 20);
        }
        //main content
        var headerHeight = $('#tf_main_header_wrap').outerHeight();
        $('#tf_main_content').css({'height': windowHeight - headerHeight});
    },
    home: function () {
        tf_main.tf_url_replace('3dtf.com');
    },
    containerRemove: function () {
        $('.tf_container_remove').remove();
    },
    containerHide: function () {
        $('.tf_container_hide').hide();
    },
    mainWrapRemove: function () {
        tf_main.tf_remove('.tf_main_wrap');
    },
    mainWrapToggle: function () {
        tf_main.tf_toggle('.tf_main_wrap');
    },
    tf_main_contain_action_close: function () {
        tf_main.tf_remove('#tf_main_action_wrap');
    },

    tf_main_container_top_close: function () {
        tf_main.tf_remove('#tf_main_container_top_wrap');
    },
    // load status
    tf_main_load_status: function () {
        tf_main.tf_toggle('.tf_main_loading_status');
    },

    //----------- update header point -----------
    //increase point -----------
    tf_header_point_increase: function (point) {
        var oldPoint = $('#headerPoint').text();
        $('#headerPoint').text(parseInt(oldPoint) + point);
    },

    //decrease point
    tf_header_point_decrease: function (point) {
        var oldPoint = $('#headerPoint').text();
        $('#headerPoint').text(parseInt(oldPoint) - point);
    },
    mainHeader: {
        containActionClose: function () {

        }
    },
    mainContent: {
        containActionClose: function () {

        },
        containerClose: function () {
            $('.tf_container_close').remove();
        }
    },
    footer: {
        idName: function () {
            return 'tf_master_footer';
        },
        idNameAction: function () {
            return '#tf_master_footer';
        },
        object: function () {
            return $('#tf_master_footer');
        },
        titleIdName: function () {
            return 'tf_title';
        },
        titleIdNameAction: function () {
            return '#tf_title';
        },
        titleObject: function () {
            return $('#tf_title');
        },
        show: function () {
            $('.tf_master_footer_content').show();
            if ($('.tf_master_footer_view').hasClass('fa-chevron-down')) {
                $('.tf_master_footer_view').removeClass('fa-chevron-down');
                $('.tf_master_footer_view').addClass('fa-chevron-up');
            }
        },
        hide: function () {
            $('.tf_master_footer_content').hide();
            if ($('.tf_master_footer_view').hasClass('fa-chevron-up')) {
                $('.tf_master_footer_view').removeClass('fa-chevron-up');
                $('.tf_master_footer_view').addClass('fa-chevron-down');
            }
        }
    },
    login: {
        getStatus: function () {
            var login;
            var href = $('#tf_body').data('log');
            $.ajax({
                url: href,
                type: 'GET',
                cache: false,
                data: {},
                beforeSend: function () {
                },
                success: function (data) {
                    if (data) {
                        login = data;
                    }
                },
                complete: function () {
                    login = (login == 1) ? true : false;
                    $('#tf_body').attr('data-status', login);
                }
            });


        },
        status: function () {
            tf_master.login.getStatus();
            var loginStatus = $('#tf_body').data('status');
            return (parseInt(loginStatus) == 1) ? true : false;
        },

        //=====================

        get: function (href) {
            tf_master_submit.ajaxNotReload(href, '#tf_body', false);
        },
        checkLogin: function (form) {
            var txtAccount = $(form).find("input[name= 'txtAccount']");
            var txtPass = $(form).find("input[name= 'txtPass']");
            var token = $(form).find("input[name= '_token']");

            if (tf_main.tf_checkInputNull(txtAccount, 'Enter your account')) {
                return false;
            }
            if (tf_main.tf_checkInputNull(txtPass, 'Enter your password')) {
                return false;
            } else {
                //---temporary solution
                $.ajax({
                    url: $(form).attr('action') + '/' + txtAccount.val() + '/' + txtPass.val(),
                    type: 'GET',
                    cache: false,
                    data: {},
                    beforeSend: function () {
                        tf_master.tf_main_load_status();
                    },
                    success: function (response) {
                        if (response) {
                            tf_main.tf_empty('#tf_main_login_notify');
                            $('#tf_main_login_notify').append(response);
                        } else {
                            window.location.reload();
                        }
                    },
                    complete: function () {
                        tf_master.tf_main_load_status();
                    }
                });
                /*$(form).ajaxForm({
                 headers: {
                 'X-CSRF-TOKEN': token.val()
                 },
                 beforeSend: function () {
                 tf_master.tf_main_load_status();
                 tf_main.tf_empty('#tf_main_login_notify');
                 },
                 success: function (data) {
                 if (data) {
                 $('#tf_main_login_notify').append(data);
                 } else {
                 window.location.reload();
                 }
                 },
                 complete: function () {
                 tf_master.tf_main_load_status();
                 }
                 }).submit();*/
            }
            /*$.ajax({
             url: $(form).attr('action'),
             method: "POST",
             data: { txtAccount : txtAccount.val(), txtPass : txtPass.val(),token:token.val() },
             headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             beforeSend: function () {
             tf_master.tf_main_load_status();
             tf_main.tf_empty('#tf_main_login_notify');
             },
             success : function(response){
             if (response) {
             $('#tf_main_login_notify').append(response);
             } else {
             window.location.reload();
             }
             },
             complete: function () {
             tf_master.tf_main_load_status();
             }
             });*/
            /*var data = $(form).serialize();
             $.ajax({
             type: 'POST',
             url: $(form).attr('action'),
             dataType: 'html',
             data: data,
             headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             beforeSend: function () {
             tf_master.tf_main_load_status();
             tf_main.tf_empty('#tf_main_login_notify');
             },
             success: function (response) {
             if (response) {
             $('#tf_main_login_notify').append(response);
             } else {
             //window.location.reload();
             }
             },
             complete: function () {
             tf_master.tf_main_load_status();
             }
             });*/
        },

        //forget password
        forgetPassword: {
            get: function (href) {
                tf_master_submit.ajaxNotReload(href, '#tf_body', false);
            },
            send: function (formObject) {
                var accountObject = $(formObject).find("input[name='txtAccount']");
                var containNotify = $(formObject).find('.tf_contain_notify');
                if (tf_main.tf_checkInputNull(accountObject, 'Enter your account')) {
                    return false;
                } else {
                    var data = {
                        txtAccount: accountObject.val(),
                        _token: $(formObject).find("input[name='_token']").val(),
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
                            if (result['status'] == 'fail') {
                                containNotify.empty();
                                containNotify.append(result['content']);
                                accountObject.focus();
                                return false;
                            } else {
                                containNotify.empty();
                                containNotify.append(result['content']);
                                $(formObject).find(".tf_account_wrap").remove();
                                $(formObject).find(".tf_send").remove();
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
    guide: {
        basicBuild: function (href) {
            tf_master_submit.ajaxNotReload(href, '#tf_body', false);
        }
    },
    owned: {
        remove: function () {
            tf_main.tf_remove('#tf_owned_wrap');
        },
        getBuilding: function () {
            tf_master.containerRemove();
            var menuBuilding = $('body').find('#tf_owned_menu .tf_owned_building');
            $(menuBuilding).click();
        },
        getBanner: function () {
            tf_master.containerRemove();
            var menuBanner = $('body').find('#tf_owned_menu .tf_owned_banner');
            $(menuBanner).click();
        },
        getLand: function () {
            tf_master.containerRemove();
            var menuLand = $('body').find('#tf_owned_menu .tf_owned_land');
            $(menuLand).click();
        },
        getContent: function (href) {
            tf_master.containerRemove();
            tf_master_submit.ajaxNotReload(href, '#tf_main_content', false);
        }
    },
    notify: {
        getContent: function (href, containerObject) {
            tf_master.containerRemove();
            tf_master_submit.ajaxNotReload(href, containerObject, false);
        },

        //---------- Friend ----------
        //confirm request
        confirmRequest: function (href, notifyObject) {
            var userId = $(notifyObject).find('.tf_notify_friend_confirm').data('user');
            var href = href + '/' + userId;
            tf_master_submit.ajaxNotReloadHasRemove(href, '', false, notifyObject);
        },

        //hide friend
        hideFriendObject: function (href, notifyObject) {
            var userFriendId = $(notifyObject).data('user-friend');
            var href = href + '/' + userFriendId;
            tf_master_submit.ajaxNotReloadHasRemove(href, '', false, notifyObject);
        },

        //---------- Action ----------
        //hide notify comment of building
        hideActionObject: function (href, notifyObject) {
            tf_master_submit.ajaxNotReloadHasRemove(href, '', false, notifyObject);
        }

    },
    search: {
        small: {
            getForm: function (href) {
                tf_master_submit.ajaxNotReload(href, '#tf_main_content', false);
            },
            involvedKeyword: function (formObject) {
                var keywordObject = $(formObject).find('#tf_small_map_search_text');
                var keyword = keywordObject.val();
                if (keyword.length > 0) {
                    var href = keywordObject.data('href') + '/' + keyword;
                    tf_master_submit.ajaxNotReloadHasRemove(href, '#tf_search_small_header', false, '#tf_map_small_search_involved');
                } else {
                    //remove old result if it exists
                    $('#tf_map_small_search_involved').remove();
                }
            },
            involvedKeywordSelect: function (keyword) {
                $('#tf_small_map_search_text').val(keyword);
                this.result();
            },
            result: function () {
                var formSearch = $('#frmSearchSmall');
                var keyword = $('#tf_search_small_text').val();
                if (tf_main.tf_checkInputNull('#tf_search_small_text', 'You must enter keyword')) {
                    $('#tf_search_small_text').focus();
                    return false;
                } else {
                    var href = formSearch.attr('action') + '/' + keyword;
                    tf_master_submit.ajaxNotReloadHasRemove(href, '#tf_search_small_content', true, '#tf_search_small_involved');
                }
            },
            viewMore: function (viewMoreFromObject) {
                var formObject = $('#frmSearchSmall');
                var keywordObject = formObject.find('#tf_search_small_text');
                //more info
                var skip = parseInt($(viewMoreFromObject).find('.tf_skip').val());
                var take = parseInt($(viewMoreFromObject).find('.tf_take').val());
                if (!tf_main.tf_checkInputNull(keywordObject, 'You must enter keyword')) {
                    var href = $(viewMoreFromObject).attr('action') + '/' + keywordObject.val() + '/' + skip + '/' + take;
                    var containerObject = $('.tf_search_small_content').find('.tf_search_small_object_list');
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
                                containerObject.append(data);
                                $(viewMoreFromObject).find('.tf_skip').val(skip + take);
                            } else {
                                //turn off view more
                                $(viewMoreFromObject).remove();
                            }
                        },
                        complete: function () {
                            tf_master.tf_main_load_status();
                        }
                    });
                } else {
                    //turn off view more
                    $(viewMoreFromObject).remove();
                }
            }
        },
        involvedKeyword: function (formObject) {
            tf_master.containerRemove();
            var keywordObject = $(formObject).find('.tf_main_search_text');
            var keyword = keywordObject.val();
            if (keyword.length > 0) {
                var href = keywordObject.data('href') + '/' + keyword;
                tf_master_submit.ajaxNotReload(href, '#tf_main_search_wrap', false);
            } else {
                //remove old result if it exists
                $('#tf_map_search_involved').remove();
            }
        },
        involvedKeywordSelect: function (keyword) {
            //alert(keyword);
            $('#tf_main_search_wrap').find('.tf_main_search_text').val(keyword);
            var formObject = $('#tf_main_search_wrap');
            this.result(formObject);
        },
        result: function (formObject) {
            tf_master.containerRemove();
            var keywordObject = $(formObject).find('.tf_main_search_text');
            if (tf_main.tf_checkInputNull(keywordObject, 'You must enter keyword')) {
                $(keywordObject).focus();
                return false;
            } else {
                var businessType = $(formObject).find('.tf_business_type');
                var href = formObject.attr('action') + '/' + $(keywordObject).val();
                var businessTypeId = $(businessType).data('business-type');
                if (businessTypeId != null) href = href + '/' + businessTypeId;
                tf_main.tf_remove('#tf_map_search_content_wrap');
                tf_main.tf_remove('#tf_map_search_involved');
                tf_master_submit.ajaxNotReload(href, formObject, false);
            }
        },
        viewMore: function (viewMoreFromObject) {
            var formObject = $('#tf_main_search_wrap');
            var keywordObject = formObject.find('.tf_main_search_text');
            //more info
            var skip = parseInt($(viewMoreFromObject).find('.tf_skip').val());
            var take = parseInt($(viewMoreFromObject).find('.tf_take').val());
            if (!tf_main.tf_checkInputNull(keywordObject, 'You must enter keyword')) {
                var href = $(viewMoreFromObject).attr('action') + '/' + keywordObject.val() + '/' + skip + '/' + take;
                var containerObject = $('.tf_main_search_content').find('.tf_search_object_list');
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
                            containerObject.append(data);
                            $(viewMoreFromObject).find('.tf_skip').val(skip + take);
                        } else {
                            //turn off view more
                            $(viewMoreFromObject).remove();
                        }
                    },
                    complete: function () {
                        tf_master.tf_main_load_status();
                    }
                });
            } else {
                //turn off view more
                $(viewMoreFromObject).remove();
            }
        },
        hide: function () {
            tf_main.tf_hide('#tf_map_business_type_filter');
            tf_main.tf_hide('#tf_search_content_wrap');
            tf_main.tf_hide('#tf_search_small_content_wrap');
        },
    },
};

//----------- ----------- Submit ----------- -----------
var tf_master_submit = {
    ajaxNotReload: function (href, containResponse, empty) {
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
                    if (containResponse.length > 0) {
                        if (empty) tf_main.tf_empty(containResponse);
                        $(containResponse).append(data);
                    }
                }
            },
            complete: function () {
                tf_master.tf_main_load_status();
            }
        });
    },
    ajaxNotReloadHasRemove: function (href, containResponse, empty, removeObject) {
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
                tf_main.tf_remove(removeObject);
                if (data) {
                    if (containResponse.length > 0) {
                        if (empty) tf_main.tf_empty(containResponse);
                        $(containResponse).append(data);
                    }
                }
            },
            complete: function () {
                tf_master.tf_main_load_status();
            }
        });
    },
    ajaxHasReload: function (href, containResponse, empty) {
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
                    if (containResponse.length > 0) {
                        if (empty) tf_main.tf_empty(containResponse);
                        $(containResponse).append(data);
                    } else {
                        tf_main.tf_window_reload();
                    }
                } else {
                    tf_main.tf_window_reload();
                }
            },
            complete: function () {
                tf_master.tf_main_load_status();
            }
        });
    },
    ajaxFormNotReload: function (form, containResponse, empty) {
        //var data = $(form).serialize();
        $(form).ajaxForm({
            /*
             type: 'POST',
             cache: false,
             data: data,
             */
            beforeSend: function () {
                tf_master.tf_main_load_status();
            },
            success: function (data) {
                if (data) {
                    if (containResponse.length > 0) {
                        if (empty) tf_main.tf_empty(containResponse);
                        $(containResponse).append(data);
                    }
                }
            },
            complete: function () {
                tf_master.tf_main_contain_action_close();
                tf_master.tf_main_load_status();
            }
        }).submit();
    },
    ajaxFormNotReloadHasContinue: function (form, containResponse, empty, successNotify) {
        $(form).ajaxForm({
            beforeSend: function () {
                tf_master.tf_main_load_status();
            },
            success: function (data) {
                if (containResponse.length > 0) {
                    if (empty) tf_main.tf_empty(containResponse);
                    if (data) {
                        $(containResponse).append(data)
                    } else {
                        $(containResponse).append(successNotify)
                    }
                }
            },
            complete: function () {
                tf_master.tf_main_load_status();
                $(form).find("input[type= 'reset']").click();
            }
        }).submit();
    },
    ajaxFormNotReloadHasRemove: function (form, containResponse, empty, removeObject) {
        $(form).ajaxForm({
            beforeSend: function () {
                tf_master.tf_main_load_status();
            },
            success: function (data) {
                tf_main.tf_remove(removeObject);
                if (data) {
                    if (containResponse.length > 0) {
                        if (empty) tf_main.tf_empty(containResponse);
                        $(containResponse).append(data);
                    }
                }
            },
            complete: function () {
                tf_master.tf_main_contain_action_close();
                tf_master.tf_main_load_status();
            }
        }).submit();
    },
    ajaxFormHasReload: function (form, containResponse, empty) {
        $(form).ajaxForm({
            beforeSend: function () {
                tf_master.tf_main_load_status();
            },
            success: function (data) {
                if (data) {
                    if (containResponse.length > 0) {
                        if (empty) tf_main.tf_empty(containResponse);
                        $(containResponse).append(data);
                    } else {
                        tf_main.tf_window_reload();
                    }
                } else {
                    tf_main.tf_window_reload();
                }
            },
            complete: function () {
                tf_master.tf_main_load_status();
            }
        }).submit();
    },
    normalForm: function (form) {
        $(form).submit();
    }
}

//========== ========== ========== Begin ========== ========== ==========

windowHeight = window.innerHeight;
windowWidth = window.innerWidth;

$(window).load(function () {
    tf_master.setLayout();
});

$(window).resize(function () {
    tf_master.setLayout();
});
//process on mobile
$(document).ready(function () {
    /*if (tf_master.accessDevice.isHandset()) {
        //click on <a></a>
        $('body').on('touchend', 'a', function () {
            alert('yesssssss');
            $(this).click();
        });
        $('body').on('touchstart ', 'a', function () {
            alert('yesssssss');
            $(this).click();
        });
    }*/
});
//----------- ----------- ON - OFF - FOOTER ----------- -----------
$(document).ready(function () {
    $('.tf_main_wrap').on('click', '.tf_master_footer .tf_title', function () {
        $('.tf_master_footer_content').toggle();
        if ($('.tf_master_footer_view').hasClass('fa-chevron-up')) {
            $('.tf_master_footer_view').removeClass('fa-chevron-up');
            $('.tf_master_footer_view').addClass('fa-chevron-down');
        } else {
            $('.tf_master_footer_view').removeClass('fa-chevron-down');
            $('.tf_master_footer_view').addClass('fa-chevron-up');
        }
    });
});
//---------- ---------- click on master ---------- ---------

//---------- click on header ----------
$(document).ready(function () {
    //click anywhere on header
    $('#tf_main_header_wrap').on('click', function () {
        tf_master.mainHeader.containActionClose();
        //map page
        if ($('#tf_main_view_map').length > 0) {
            tf_map.market.remove();
        }

    });

    //click extend icon
    $('#tf_main_header_wrap').on('click', '.tf_main_header_extend_icon', function () {
        tf_master.containerRemove();
    });

    //click user icon
    $('#tf_main_header_wrap').on('click', '.tf_main_header_user_avatar', function () {
        tf_master.containerRemove();
    });
});
//---------- click on main content ----------
$(document).ready(function () {
    $('#tf_main_content').on('click', function () {
        tf_master.mainContent.containActionClose();
        tf_master.mainContent.containerClose();
    });
});


//---------- ---------- CLose contain action ---------- ---------
$(document).ready(function () {
    //---------- remove wrap ----------
    $('body').on('click', '.tf_main_wrap_remove', function () {
        tf_master.containerRemove();
    });
    $('body').on('click', '.tf_remove_container', function () {
        tf_master.containerRemove();
    });
    $('body').on('click', '.tf_hide_container', function () {
        tf_master.containerHide();
    });


    //---------- toggle ----------
    $('body').on('click', '.tf_main_wrap_toggle', function () {
        tf_master.mainWrapToggle();
    });


    //---------- contain action ----------
    $('body').on('click', '.tf_main_contain_action_close', function () {
        tf_master.tf_main_contain_action_close();
    });
    $('body').on('click', '.tf_main_container_top_close', function () {
        tf_master.tf_main_container_top_close();
    });
    //reload page
    $('body').on('click', '.tf_mater_reload', function () {
        tf_main.tf_window_reload();
    });
});

//========== ========== ========== Search ========== ========== ==========
//----------- small------------
$(document).ready(function () {
    //get form search
    $('#tf_main_search_small_get').on('click', function () {
        if (tf_master.checkPage.map()) tf_map.mini_map.hide();
        if ($('#tf_search_small_content_wrap').length > 0) {
            $('#tf_search_small_content_wrap').toggle();
        } else {
            var href = $(this).data('href');
            tf_master.search.small.getForm(href);
        }
    });

    //search
    $('body').on('click', '#tf_search_small_content_wrap .tf_search', function () {
        tf_master.search.small.result();
    });

    //view more
    $('body').on('click', '.tf_search_small_content .tf_small_frm_view_more .tf_get', function () {
        var viewMoreForm = $(this).parents('.tf_small_frm_view_more');
        tf_master.search.small.viewMore(viewMoreForm);
    });

    $('body').on('keyup', '#tf_search_small_text', function () {
        var formObject = $(this).parents('#frmSearchSmallText');
        tf_master.search.small.involvedKeyword(formObject);
    });

    //user press 'enter' in search input
    $('body').on('keypress', '#tf_search_small_text', function (event) {
        var keyCode = (event.keyCode ? event.keyCode : event.which);
        if (keyCode == '13') {
            tf_master.search.small.result();
            return false;
        }
    });

    //select keyword in suggestion
    $('body').on('click', '.tf_search_small_involved_name', function () {
        var keyword = $(this).text();
        tf_master.search.small.involvedKeywordSelect(keyword);
    });

    // to building
    $('body').on('click', '#tf_search_small_content_wrap .tf_search_small_result_object .tf_name', function () {
        var searchObject = $(this).parents('.tf_search_small_result_object');
        var landId = searchObject.data('land');
        var areaId = searchObject.data('area');
        var accessProvinceId = searchObject.data('province'); // province contain land
        var currentProvinceId = $('#tf_province').data('province');
        var landHref = searchObject.parents('#tf_search_small_content_wrap').data('href-land');
        var areaHref = searchObject.parents('#tf_search_small_content_wrap').data('href-area');
        if (tf_master.checkPage.map()) {
            tf_land.show.position(currentProvinceId, accessProvinceId, areaId, landId, landHref, areaHref);
            $('#tf_search_small_content_wrap').remove();
        } else {
            window.location.assign(landHref + '/' + landId);
        }
    });

    // visit website of building
    $('body').on('click', '#tf_search_small_content_wrap .tf_search_small_result_object .tf_website', function () {
        //var href = $(this).data('visit-href');
        //var buildingId = $(this).parents('.tf_search_small_result_object').data('building');
        //tf_map_building.visit(href, buildingId);
    });
});

//----------- Normal------------
$(document).ready(function () {
    //suggest
    $('body').on('keyup', '#tf_main_search_wrap .tf_main_search_text', function (event) {
        var keyCode = (event.keyCode ? event.keyCode : event.which);
        if (keyCode != '13') {
            var formObject = $(this).parents('#tf_main_search_wrap');
            tf_master.search.involvedKeyword(formObject);
        }

    });

    //select keyword in suggestion
    $('body').on('click', '.tf_search_involved_name', function () {
        var keyword = $(this).text();
        tf_master.search.involvedKeywordSelect(keyword);
    });

    //search
    $('body').on('click', '#tf_main_search_wrap .tf_search', function () {
        var formObject = $(this).parents('#tf_main_search_wrap');
        tf_master.search.result(formObject);
    });

    //user press 'enter' in search input
    $('body').on('keypress', '#tf_main_search_text', function (event) {
        var keyCode = (event.keyCode ? event.keyCode : event.which);
        if (keyCode == '13') {
            var formObject = $(this).parents('#tf_main_search_wrap');
            tf_master.search.result(formObject);
            return false;
        }
    });

    //view more
    $('body').on('click', '.tf_main_search_content .tf_frm_view_more .tf_get', function () {
        var viewMoreForm = $(this).parents('.tf_frm_view_more');
        tf_master.search.viewMore(viewMoreForm);
    });

    // to building
    $('body').on('click', '#tf_main_search_content_wrap .tf_main_search_result_object .tf_name', function () {
        var searchObject = $(this).parents('.tf_main_search_result_object');
        var landId = searchObject.data('land');
        var areaId = searchObject.data('area');
        var accessProvinceId = searchObject.data('province'); // province contain land
        var currentProvinceId = $('#tf_province').data('province');
        var landHref = searchObject.parents('#tf_main_search_content_wrap').data('href-land');
        var areaHref = searchObject.parents('#tf_main_search_content_wrap').data('href-area');
        if (tf_master.checkPage.map()) {
            tf_land.show.position(currentProvinceId, accessProvinceId, areaId, landId, landHref, areaHref);
            $('#tf_main_search_content_wrap').remove();
        } else {
            window.location.assign(landHref + '/' + landId);
        }

    });

    // visit website of building
    $('body').on('click', '#tf_main_search_content_wrap .tf_map_search_result_object .tf_website', function () {
        var href = $(this).data('visit-href');
        var buildingId = $(this).parents('.tf_map_search_result_object').data('building');
        //tf_map_building.visit(href, buildingId);
    });

});

//========== ========== ========== Login ========== ========== ==========
//login
$(document).ready(function () {
    //----------- ----------- get from login ----------- -----------
    $('body').on('click', '.tf_main_login_get', function () {
        var href = $(this).data('href');
        tf_master.login.get(href);
    });

    //----------- ----------- user press 'enter' in login inputs ----------- -----------
    $('body ').on('keypress', '#frm_main_login #txtAccount', function (event) {
        var keyCode = (event.keyCode ? event.keyCode : event.which);
        if (keyCode == '13') {
            tf_master.login.checkLogin('#frm_main_login');
            return false;
        }
    });
    $('body ').on('keypress', '#frm_main_login #txtPass', function (event) {
        var keyCode = (event.keyCode ? event.keyCode : event.which);
        if (keyCode == '13') {
            tf_master.login.checkLogin('#frm_main_login');
            return false;
        }
    });

    //----------- ----------- check login ----------- -----------
    $('body').on('click', '.tf_main_login_post', function () {
        var formObject = $(this).parents('#frm_main_login');
        tf_master.login.checkLogin(formObject);
    });
});

//forget password
$(document).ready(function () {
    //get form
    $('body').on('click', '#frm_main_login .tf_forget_pass', function () {
        var href = $(this).data('href');
        tf_master.login.forgetPassword.get(href);
    });

    //send
    $('body').on('click', '#tf_frm_forget_pass .tf_send', function () {
        var formObject = $(this).parents('#tf_frm_forget_pass');
        tf_master.login.forgetPassword.send(formObject);
    })
});

//========== ========== ========== Guide build ========== ========== ==========
//login
$(document).ready(function () {
    // basic build
    $('body').on('click', '.tf_guide_basic_build', function () {
        var href = $(this).data('href');
        tf_master.guide.basicBuild(href);
    });
});

//========== ========== ========== Owned tool ========== ========== ==========
$(document).ready(function () {
    //get owned on header
    $('body').on('click', '.tf_owned_get', function () {
        var href = $(this).data('href');
        tf_master.owned.getContent(href);
    });

    //get owned on tool
    $('body').on('click', '.tf_owned_menu_object', function () {
        var href = $(this).data('href');
        tf_master.owned.getContent(href);
    });

    //go to position of land on map
    $('body').on('click', '.tf_owned_land_name', function () {
        var landId = $(this).data('land');
        var areaId = $(this).data('area');
        var accessProvinceId = $(this).data('province'); // province contain land
        var landHref = $(this).parents('.tf_owned_land_container').data('href-land');
        var areaHref = $(this).parents('.tf_owned_land_container').data('href-area');

        var currentProvinceId = 0;
        if ($('#tf_province').length > 0) {  //current page is the map
            currentProvinceId = $('#tf_province').data('province');
            tf_land.show.position(currentProvinceId, accessProvinceId, areaId, landId, landHref, areaHref);
        } else {
            window.location.assign(landHref + '/' + landId);
        }
    });

    // go to building
    $('body').on('click', '.tf_owned_building_object .tf_on_map', function () {
        var buildingObject = $(this).parents('.tf_owned_building_object');
        var landId = buildingObject.data('land');
        var areaId = buildingObject.data('area');
        var accessProvinceId = buildingObject.data('province'); // province container land

        var landHref = buildingObject.parents('.tf_owned_building_container').data('href-land');
        var areaHref = buildingObject.parents('.tf_owned_building_container').data('href-area');
        var currentProvinceId = 0;
        if ($('#tf_province').length > 0) {  //current page is the map
            currentProvinceId = $('#tf_province').data('province');
            tf_land.show.position(currentProvinceId, accessProvinceId, areaId, landId, landHref, areaHref);
        } else {
            window.location.assign(landHref + '/' + landId);
        }
    });

    //go to position of banner on map
    $('body').on('click', '.tf_owned_banner_name', function () {
        var bannerId = $(this).data('banner');
        var areaId = $(this).data('area');
        var accessProvinceId = $(this).data('province'); // province contain land
        var bannerHref = $(this).parents('.tf_owned_banner_container').data('href-banner');
        var areaHref = $(this).parents('.tf_owned_banner_container').data('href-area');

        var currentProvinceId = 0;
        if ($('#tf_province').length > 0) {  //current page is the map
            currentProvinceId = $('#tf_province').data('province');
            tf_banner.show.position(currentProvinceId, accessProvinceId, areaId, bannerId, bannerHref, areaHref);
        } else {
            window.location.assign(bannerHref + '/' + bannerId);
        }

    });
});

//========== =========== ========== Notify ============ ========== =========
$(document).ready(function () {

    $('body').on('click', '.tf_notify_get', function () {
        var href = $(this).data('href');
        var containerObject = $('#tf_main_content');
        $(this).next('.tf_main_header_notify_new').remove();
        tf_master.notify.getContent(href, containerObject);

    });

    //---------- ----------- Friend ----------- -----------
    // confirm friend request
    $('body').on('click', '.tf_notify_friend_confirm > a', function () {
        var href = $(this).data('href');
        var notifyObject = $(this).parents('.tf_notify_friend_object');
        tf_master.notify.confirmRequest(href, notifyObject);
    });

    //hide friend
    $('body').on('click', '.tf_notify_friend_hide > a', function () {
        var href = $(this).data('href');
        var notifyObject = $(this).parents('.tf_notify_friend_object');
        tf_master.notify.hideFriendObject(href, notifyObject);
    });

    //---------- ----------- Action  ----------- -----------
    // go to building
    $('body').on('click', '.tf_notify_action_object .tf_notify_to_building', function () {
        var landId = $(this).data('land');
        var areaId = $(this).data('area');
        var accessProvinceId = $(this).data('province'); // province container land
        var landHref = $(this).data('href-land');
        var areaHref = $(this).data('href-area');

        var currentProvinceId = 0;
        if ($('#tf_province').length > 0) {  //current page is the map
            currentProvinceId = $('#tf_province').data('province');
            tf_land.show.position(currentProvinceId, accessProvinceId, areaId, landId, landHref, areaHref);
            tf_master.containerRemove();
        } else {
            window.location.assign(landHref + '/' + landId);
        }
    });

    //go to position of banner on map
    $('body').on('click', '.tf_notify_action_object .tf_notify_to_banner', function () {
        var bannerId = $(this).data('banner');
        var areaId = $(this).data('area');
        var accessProvinceId = $(this).data('province'); // province contain land
        var bannerHref = $(this).data('href-banner');
        var areaHref = $(this).data('href-area');

        var currentProvinceId = 0;
        if ($('#tf_province').length > 0) {  //current page is the map
            currentProvinceId = $('#tf_province').data('province');
            tf_banner.show.position(currentProvinceId, accessProvinceId, areaId, bannerId, bannerHref, areaHref);
            tf_master.containerRemove();
        } else {
            window.location.assign(bannerHref + '/' + bannerId);
        }
    });

    //go to position of land on map
    $('body').on('click', '.tf_notify_action_object .tf_notify_to_land', function () {
        var landId = $(this).data('land');
        var areaId = $(this).data('area');
        var accessProvinceId = $(this).data('province'); // province contain land
        var currentProvinceId = $('#tf_province').data('province');
        var landHref = $(this).data('href-land');
        var areaHref = $(this).data('href-area');

        var currentProvinceId = 0;
        if ($('#tf_province').length > 0) {  //current page is the map
            currentProvinceId = $('#tf_province').data('province');
            tf_land.show.position(currentProvinceId, accessProvinceId, areaId, landId, landHref, areaHref);
            tf_master.containerRemove();
        } else {
            window.location.assign(landHref + '/' + landId);
        }
    });

    //hide building comment
    $('body').on('click', '.tf_notify_action_object .tf_notify_hide_object ', function () {
        var href = $(this).data('href');
        var notifyObject = $(this).parents('.tf_notify_action_object');
        tf_master.notify.hideActionObject(href, notifyObject);
    });

});