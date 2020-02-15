/**
 * Created by HUY on 6/8/2016.
 */
$(document).ready(function () {
    windowHeight = window.innerHeight;//screen.height;
    windowWidth = window.innerWidth;//screen.height;
    $('#tf_m_panel').css('height', windowHeight);
});

var tf_manage = {
    mainWrapRemove: function () {
        // tf_main.tf_remove('.tf_main_wrap');
    },
    mainWrapToggle: function () {
        //tf_main.tf_toggle('.tf_main_wrap');
    },
    containActionClose: function () {
        //tf_main.tf_remove('#tf_main_action_wrap');
    },
    // load status
    loadStatus: function () {
        tf_main.tf_toggle('.tf_loading_status');
    }
};

var tf_manage_submit = {
    ajaxNotReload: function (href, containResponse, empty) {
        $.ajax({
            url: href,
            type: 'GET',
            cache: false,
            data: {},
            beforeSend: function () {
                tf_manage.loadStatus();
            },
            success: function (data) {
                tf_manage.containActionClose();
                if (data) {
                    if (containResponse.length > 0) {
                        if (empty) tf_main.tf_empty(containResponse);
                        $(containResponse).append(data);
                    }
                }
            },
            complete: function () {
                tf_manage.loadStatus();
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
                tf_manage.loadStatus();
            },
            success: function (data) {
                tf_manage.containActionClose();
                tf_main.tf_remove(removeObject);
                if (data) {
                    if (containResponse.length > 0) {
                        if (empty) tf_main.tf_empty(containResponse);
                        $(containResponse).append(data);
                    }
                }
            },
            complete: function () {
                tf_manage.loadStatus();
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
                tf_manage.loadStatus();
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
                tf_manage.loadStatus();
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
                tf_manage.loadStatus();
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
                tf_manage.containActionClose();
                tf_manage.loadStatus();
            }
        }).submit();
    },
    ajaxFormNotReloadHasContinue: function (form, containResponse, empty, successNotify) {
        $(form).ajaxForm({
            beforeSend: function () {
                tf_manage.loadStatus();
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
                tf_manage.loadStatus();
                $(form).find("input[type= 'reset']").click();
            }
        }).submit();
    },
    ajaxFormNotReloadHasRemove: function (form, containResponse, empty, removeObject) {
        $(form).ajaxForm({
            beforeSend: function () {
                tf_manage.loadStatus();
            },
            success: function (data) {
                tf_main.tf_remove(removeObject);
                if (data) {
                    if (containResponse.length > 0) {
                        if (empty) tf_main.tf_empty(containResponse);
                        $(containResponse).append(data);
                    }
                }else{
                    tf_main.tf_page_back();
                }
            },
            complete: function () {
                tf_manage.containActionClose();
                tf_manage.loadStatus();
            }
        }).submit();
    },
    ajaxFormHasReload: function (form, containResponse, empty) {
        $(form).ajaxForm({
            beforeSend: function () {
                tf_manage.loadStatus();
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
                tf_manage.loadStatus();
            }
        }).submit();
    },
    normalForm: function (form) {
        $(form).submit();
    }
}
