/**
 * Created by HUY on 4/9/2016.
 */
var tf_ads_all_page = {
    banner: {
        mouserOver: function (bannerObject) {
            $(bannerObject).find('.tf_menu').show();
        },
        mouserOut: function (bannerObject) {
            $(bannerObject).find('.tf_menu').hide();
        }
    },
    report: {
        image: {
            getReport: function (href) {
                tf_master_submit.ajaxNotReload(href, '#tf_body', false);
            },
            sendReport: function (form) {
                var selectStatus = false;
                form.find(".tf_bad_info").each(function () {
                    if (this.checked == true) selectStatus = true;
                });
                if (!selectStatus) {
                    alert('You must select a report info');
                    return false
                } else {
                    tf_master_submit.ajaxFormNotReload(form, '#tf_body', false);
                }
            }
        }
    },
    image: {
        visit: function (href) {
            tf_master_submit.ajaxNotReload(href, '', false);
        },
        prevent: function (href) {
            tf_master_submit.ajaxHasReload(href, '', false);
        }
    }


}

$(document).ready(function () {
    //show menu
    $('body').on('mouseover', '.tf_ads_all_banner_wrap', function () {
        tf_ads_all_page.banner.mouserOver(this);
    }).on('mouseout', '.tf_ads_all_banner_wrap', function () {
        tf_ads_all_page.banner.mouserOut(this);
    });

    //show menu content
    $('body').on('mouseover', '.tf_ads_all_banner_wrap .tf_menu_icon', function () {
        var banner = $(this).parents('.tf_ads_all_banner_wrap');
        banner.find('.tf_menu_content').show();
    });

    $('body').on('mouseover', '.tf_ads_all_banner_wrap .tf_menu_content', function () {
        $(this).show();
    });

    //hide menu content
    $('body').on('mouseout', '.tf_ads_all_banner_wrap .tf_menu_content', function () {
        $(this).hide();
    });

});

//------------ ----------- Banner image ---------- -----------
//report
$(document).ready(function () {
    //show menu
    $('body').on('click', '.tf_ads_all_banner_wrap .tf_bad_info_report', function () {
        var imageName = $(this).data('name')
        var href = $(this).data('href') + '/' + imageName;
        tf_ads_all_page.report.image.getReport(href);
    });

    $('body').on('click', '#tf_ads_banner_image_report .tf_send', function () {
        var form = $(this).parents('#tf_ads_banner_image_report');
        tf_ads_all_page.report.image.sendReport(form);
    });
})

//Visit
$(document).ready(function () {
    //visit (click on image)
    $('body').on('click', '.tf_ads_all_banner_wrap .tf_visit', function () {
        var imageId = $(this).data('image')
        var href = $(this).data('visit') + '/' + imageId;
        tf_ads_all_page.image.visit(href);
    });
})

//prevent
$(document).ready(function () {
    //visit (click on image)
    $('body').on('click', '.tf_ads_all_banner_wrap .tf_prevent', function () {
        var imageId = $(this).data('image')
        var href = $(this).data('prevent') + '/' + imageId;
        tf_ads_all_page.image.prevent(href);
    });
})