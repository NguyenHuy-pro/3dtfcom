/**
 * Created by HUY on 10/14/2016.
 */
var tf_help = {}

//========== ========== ========== Begin ========== ========== ==========
$(document).ready(function () {
    $('body').on('click', '#tf_help_wrap', function () {
        tf_master.containerRemove();
    })

    //on top
    if ($(".tf_help_on_top").length > 0) {
        $('#tf_help_wrap').scroll(function () {
            var e = $('#tf_help_wrap').scrollTop();
            if (e > 300) {
                $(".tf_help_on_top").show()
            } else {
                $(".tf_help_on_top").hide()
            }
        });
        $(".tf_help_on_top").on('click', '.tf_action', function () {
            $('#tf_help_wrap').animate({
                scrollTop: 0
            })
        })
    }
});

$(document).ready(function () {
    // view menu
    $('.tf_help_menu_wrap').on('click', '.tf_help_menu_object', function () {
        var icon = $(this).children('span');
        if (icon.hasClass('glyphicon-minus')) {
            icon.removeClass('glyphicon-minus');
            icon.addClass('glyphicon-plus');
        } else {
            icon.removeClass('glyphicon-plus');
            icon.addClass('glyphicon-minus');
        }
        var helpAction = $(this).children('.tf_help_menu_action');
        tf_main.tf_toggle(helpAction);
    });

    //view content
    $('.tf_help_content_wrap').on('click', '.tf_content_name', function () {
        var icon = $(this).children('span');
        if (icon.hasClass('glyphicon-chevron-right')) {
            icon.removeClass('glyphicon-chevron-right');
            icon.addClass('glyphicon-chevron-down');
        } else {
            icon.removeClass('glyphicon-chevron-down');
            icon.addClass('glyphicon-chevron-right');
        }
        var helpContent = $(this).next('.panel-body');
        tf_main.tf_toggle(helpContent);
    });
});