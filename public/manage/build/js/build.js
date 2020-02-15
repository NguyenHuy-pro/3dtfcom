//=========== =========== =========== object =========== =========== ===========
var tf_m_build = {
    load_status: function () {
        $('#tf_m_build_load_status').toggle();
    },

    //set x, y position on mini map
    mini_map_set_xy: function () {
        var topPosition = $('#tf_m_build_province').position().top;
        var leftPosition = $('#tf_m_build_province').position().left;
        var x = parseInt(leftPosition / 896);
        var y = parseInt(topPosition / 896);
        x = (x < 0) ? -x : x;
        y = (y < 0) ? -y : y;
        $("#tf_m_build_mini_y").css("left", x * 2 + 50); // 1 ->middle project (2px)
        $("#tf_m_build_mini_x").css("top", y * 2 + 50);
    },
    // set x,y position on header
    coordinate_set_xy: function (x, y) {
        var x = (x < 0) ? -x : x;
        var y = (y < 0) ? -y : y;
        $("select#cbAreaX option").filter(function () {
            if ($(this).val() == x) $(this).attr('selected', true);

        });
        $("select#cbAreaY option").filter(function () {
            if ($(this).val() == y) $(this).attr('selected', true);
        });
    },


    // access map
    // coordinate of area login
    log_coordinates: function () {
        var areaX = $('#cbAreaX').val();
        var areaY = $('#cbAreaY').val();
        //get province login
        var provinceID = $('#frm_m_build_log_province').children('#cbProvince').val();
        //get url load area on header
        var urlLoad = $('#frm_m_build_log_coordinates').attr('action');
        //set new position for province
        var topPosition = areaY * 896;
        topPosition = (topPosition > 0) ? -topPosition : topPosition;
        var leftPosition = areaX * 896;
        leftPosition = (leftPosition > 0) ? -leftPosition : leftPosition;
        $('#tf_m_build_province').animate({top: topPosition, left: leftPosition});
        //call function load coordinates (file area.js)
        tf_m_build_area.load_coordinates(urlLoad, provinceID, areaX, areaY);
    },
    contain_action_close: function () {
        tf_main.tf_remove('#tf_m_build_action_wrap');
    }
};

//Submit
var tf_m_build_submit = {
    ajaxNotReload: function (href, containResponse, empty) {
        $.ajax({
            url: href,
            type: 'GET',
            cache: false,
            data: {},
            beforeSend: function () {
                tf_m_build.load_status();
            },
            success: function (data) {
                tf_m_build.contain_action_close();
                if (data) {
                    if (containResponse.length > 0) {
                        if (empty) tf_main.tf_empty(containResponse);
                        $(containResponse).append(data);
                    } else {
                        alert(data);
                    }
                }
            },
            complete: function () {
                tf_m_build.load_status();
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
                tf_m_build.load_status();
            },
            success: function (data) {
                tf_m_build.contain_action_close();
                tf_main.tf_remove(removeObject);
                if (data) {
                    if (containResponse.length > 0) {
                        if (empty) tf_main.tf_empty(containResponse);
                        $(containResponse).append(data);
                    } else {
                        alert(data);
                    }
                }
            },
            complete: function () {
                tf_m_build.load_status();
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
                tf_m_build.load_status();
            },
            success: function (data) {
                if (data) {
                    if (containResponse.length > 0) {
                        if (empty) tf_main.tf_empty(containResponse);
                        $(containResponse).append(data);
                    } else {
                        alert(data);
                    }
                } else {
                    tf_main.tf_window_reload();
                }
            },
            complete: function () {
                tf_m_build.load_status();
            }
        });
    },
    ajaxFormNotReload: function (form, containResponse, empty) {
        $(form).ajaxForm({
            beforeSend: function () {
                tf_m_build.load_status();
            },
            success: function (data) {
                if (data) {
                    if (containResponse.length > 0) {
                        if (empty) tf_main.tf_empty(containResponse);
                        $(containResponse).append(data);
                    } else {
                        alert(data);
                    }
                }
            },
            complete: function () {
                tf_m_build.contain_action_close();
                tf_m_build.load_status();
            }
        }).submit();
    },
    ajaxFormNotReloadHasRemove: function (form, containResponse, empty, removeObject) {
        $(form).ajaxForm({
            beforeSend: function () {
                tf_m_build.load_status();
            },
            success: function (data) {
                tf_main.tf_remove(removeObject);
                if (data) {
                    if (containResponse.length > 0) {
                        if (empty) tf_main.tf_empty(containResponse);
                        $(containResponse).append(data);
                    } else {
                        alert(data);
                    }
                }
            },
            complete: function () {
                tf_m_build.contain_action_close();
                tf_m_build.load_status();
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
                        alert(data);
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

//=========== =========== =========== action =========== =========== ===========
$(document).ready(function () {
    var hWindow = window.innerHeight;//screen.height;
    var wWindow = window.innerWidth;//screen.height;
    $('#tf_m_build_main').css('height', hWindow - 36);

    //to area when select x or y
    $('#frm_m_build_log_coordinates').children('#cbAreaX').on('change', function () {
        tf_m_build.log_coordinates();
    });
    $('#frm_m_build_log_coordinates').children('#cbAreaY').on('change', function () {
        tf_m_build.log_coordinates();
    });

    //select country

    $('#cbCountry').on('change', function () {
        var countryId = $(this).val();
        var href = $(this).data('href') + '/' + countryId;
        tf_main.tf_url_replace(href);
    });


    //select province login
    $('#cbProvince').on('change', function () {
        var href = $(this).data('href');
        var provinceId = $(this).val();
        href = href + '/' + provinceId;
        tf_main.tf_url_replace(href);
    });

    //close contain action
    $('body').on('click', '.tf_m_build_contain_action_close', function () {
        tf_m_build.contain_action_close();
    });
});
