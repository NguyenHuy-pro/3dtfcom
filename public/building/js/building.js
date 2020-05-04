var tf_building = {
    about: {
        editContent: function (href) {
            tf_master_submit.ajaxNotReload(href, $('#' + tf_master.bodyIdName()), false);
        },
        save: function (form) {
            var txtShortDescription = $(form).find("input[name='txtShortDescription']");
            var content = $(form).find("textarea[name='txtBuildingDescription']");
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
            if (tf_main.tf_checkInputNull(txtShortDescription, 'Enter  short description')) {
                return false;
            }
            if (tf_main.tf_checkInputNull(content, 'Enter content')) {
                return false;
            } else {
                tf_master_submit.ajaxFormNotReload(form, '#tf_building_about_content', true);
            }
        }
    },
    info: {
        getEdit: function (href) {
            tf_master_submit.ajaxNotReload(href, $('#' + tf_master.bodyIdName()), false);
        },
        sample: {
            getSampleStatus: function (href) {
                tf_master_submit.ajaxNotReload(href, $('#' + tf_master.bodyIdName()), false);
            },
            changeSample: function (href) {
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
                            $('#' + tf_master.bodyIdName()).append(data);
                        } else {
                            tf_main.tf_window_reload();
                        }
                    },
                    complete: function () {
                        tf_master.tf_main_load_status();
                    }
                });
            }
        },
        name: {
            postEdit: function (form) {
                var txtName = $(form).find("input[name='txtName']");
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
                        } else {
                            $(form).ajaxForm({
                                beforeSend: function () {
                                    tf_master.tf_main_load_status();
                                },
                                success: function (data) {
                                    if (data) {
                                        tf_main.tf_url_replace(data);
                                    }
                                },
                                complete: function () {
                                    tf_master.tf_main_load_status();
                                }
                            }).submit();
                        }
                    }
                }
            }
        },
        phone: {
            postEdit: function (form) {
                var txtPhone = $(form).find("input[name='txtPhone']");
                if (!tf_main.tf_checkInputNull(txtPhone, '')) {
                    if (tf_main.tf_checkInputMaxLength(txtPhone, 50, 'max length of phone is 50 characters')) {
                        return false;
                    }
                }
                tf_master_submit.ajaxFormHasReload(form, '', false);
            }
        },
        website: {
            postEdit: function (form) {
                var txtWebsite = $(form).find("input[name='txtWebsite']");
                if (!tf_main.tf_checkInputNull(txtWebsite, '')) {
                    if (tf_main.tf_checkInputMaxLength(txtWebsite, 200, 'max length of phone is 200 characters')) {
                        return false;
                    }
                }
                tf_master_submit.ajaxFormHasReload(form, '', false);
            }
        },
        email: {
            postEdit: function (form) {
                var txtEmail = $(form).find("input[name='txtEmail']");
                var containerNotify = $(form).find('.tf_container_notify');
                if (txtEmail.val().length > 0) {
                    if (!tf_main.tf_checkEmail(txtEmail.val())) {
                        alert('Your email invalid');
                        txtEmail.focus();
                        return false;
                    }
                }
                $(form).ajaxForm({
                    beforeSend: function () {
                        tf_master.tf_main_load_status();
                    },
                    success: function (data) {
                        if (data) {
                            containerNotify.empty();
                            containerNotify.append(data);
                        } else {
                            tf_main.tf_window_reload();
                        }
                    },
                    complete: function () {
                        tf_master.tf_main_load_status();
                    }
                }).submit();
                //tf_master_submit.ajaxFormHasReload(form, '', false);
            }
        },
        address: {
            postEdit: function (form) {
                var txtAddress = $(form).find("input[name='txtAddress']");
                if (!tf_main.tf_checkInputNull(txtAddress, '')) {
                    if (tf_main.tf_checkInputMaxLength(txtAddress, 150, 'max length of phone is 150 characters')) {
                        return false;
                    }
                }
                tf_master_submit.ajaxFormHasReload(form, '', false);
            }
        },
        shortDescription: {
            postEdit: function (form) {
                var txtShortDescription = $(form).find("input[name='txtShortDescription']");
                if (!tf_main.tf_checkInputNull(txtShortDescription, '')) {
                    if (tf_main.tf_checkInputMaxLength(txtShortDescription, 300, 'max length of phone is 300 characters')) {
                        return false;
                    }
                }
                tf_master_submit.ajaxFormHasReload(form, '', false);
            }
        },
        description: {
            postEdit: function (form) {
                for (instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }
                $(form).ajaxForm({
                    beforeSend: function () {
                        tf_master.tf_main_load_status();
                    },
                    success: function (data) {
                    },
                    complete: function () {
                        tf_master.tf_main_load_status();
                        tf_main.tf_window_reload();
                    }
                }).submit();
            }
        }
    },
    banner: {
        getUploadForm: function (href, buildingId) {
            var href = href + '/' + buildingId;
            tf_master_submit.ajaxNotReload(href, $('#' + tf_master.bodyIdName()), false);
        },
        checkAdd: function () {
            if (tf_main.tf_checkInputNull('#fileImage', 'You must select an image')) {
                return false;
            } else {
                tf_master_submit.ajaxFormHasReload('#frmBuildingBannerAdd', '', false);
            }
        },
        viewFullImage: function (bannerObject) {
            var bannerId = $(bannerObject).data('banner');
            var href = $(bannerObject).data('href') + '/' + bannerId;
            tf_master_submit.ajaxNotReload(href, $('#' + tf_master.bodyIdName()), false);
        },
        delete: function (href, bannerId) {
            var href = href + '/' + bannerId;
            tf_master_submit.ajaxHasReload(href, '', false);
        }
    },
    love: function (href, buildingId) {
        var href = href + '/' + buildingId;
        tf_master_submit.ajaxHasReload(href, '', false);
    },
    visit: function (href, buildingId) {
        var href = href + '/' + buildingId;
        tf_master_submit.ajaxNotReload(href, '', false);
    },
    follow: function (href, buildingId) {
        var href = href + '/' + buildingId;
        tf_master_submit.ajaxHasReload(href, '', false);
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
    },
}

//========== ========== ========== Begin ========== ========== ==========
$(document).ready(function () {
    $('body').on('click', '#tf_building_about .tf_test_mobi', function(){
        alert('yesssssss');
    });
});


$(document).ready(function () {
    autosize(document.querySelectorAll('textarea'));
    $('body').on('click', '#tf_building_wrapper', function () {
        tf_master.containerRemove();
    });

    //on top
    if ($(".tf_building_on_top").length > 0) {
        $('#tf_building_wrapper').scroll(function () {
            var e = $('#tf_building_wrapper').scrollTop();
            if (e > 300) {
                $(".tf_building_on_top").show()
            } else {
                $(".tf_building_on_top").hide()
            }
        });
        $(".tf_building_on_top").on('click', '.tf_action', function () {
            $('#tf_building_wrapper').animate({
                scrollTop: 0
            })
        });
    }
});

//========== ========== ========== about ========== ========== ==========
$(document).ready(function () {
    //edit description
    $('#tf_building_about').on('click', '.tf_building_about_content_edit', function () {
        tf_building.about.editContent($(this).data('href') + '/' + $(this).data('building'));
    });

    //save description
    $('body').on('click', '#tf_building_about_description_edit .tf_save', function () {
        tf_building.about.save($(this).parents('#tf_building_about_description_edit'));
    });

});

//========== ========== ========== about - information ========== ========== ==========
$(document).ready(function () {
    //show full short description
    $('.tf_building_short_description').on('click', '.tf_view_more', function () {
        $(this).hide();
        $('.tf_building_short_description').find('.tf_view_more_hide').show();
        $('.tf_building_short_description').find('.tf_content_show').hide();
        $('.tf_building_short_description').find('.tf_content_full').show();
    });
    //hide full short description
    $('.tf_building_short_description').on('click', '.tf_view_more_hide', function () {
        $(this).hide();
        $('.tf_building_short_description').find('.tf_view_more').show();
        $('.tf_building_short_description').find('.tf_content_show').show();
        $('.tf_building_short_description').find('.tf_content_full').hide();
    });
});

$(document).ready(function () {
    //------------ name ------------
    //get edit form
    $('#tf_building_information').on('click', '.tf_info_edit', function () {
        var buildingId = $(this).parents('#tf_building_information').data('building');
        var href = $(this).data('href') + '/' + buildingId;
        tf_building.info.getEdit(href);
    });

    //sample
    $('body').on('click', '#tf_building_sample_edit .tf_select_sample_menu', function () {
        var href = $(this).data('href');
        tf_building.info.sample.getSampleStatus(href);
    });
    $('body').on('click', '#tf_building_sample_edit .tf_sample_img', function () {
        var sampleId = $(this).data('sample');
        var buildingId = $(this).parents('.tf_building_sample_edit').data('building')
        var href = $(this).parents('.tf_building_sample_edit').data('href-select') + '/' + buildingId + '/' + sampleId;
        tf_building.info.sample.changeSample(href);
    });

    //name
    $('body').on('click', '#tf_building_info_name_frm_edit .tf_save', function () {
        var form = $(this).parents('#tf_building_info_name_frm_edit');
        tf_building.info.name.postEdit(form);
    });

    //phone
    $('body').on('click', '#tf_building_info_phone_frm_edit .tf_save', function () {
        var form = $(this).parents('#tf_building_info_phone_frm_edit');
        tf_building.info.phone.postEdit(form);
    });

    //website
    $('body').on('click', '#tf_building_info_website_frm_edit .tf_save', function () {
        var form = $(this).parents('#tf_building_info_website_frm_edit');
        tf_building.info.website.postEdit(form);
    })

    //email
    $('body').on('click', '#tf_building_info_email_frm_edit .tf_save', function () {
        var form = $(this).parents('#tf_building_info_email_frm_edit');
        tf_building.info.email.postEdit(form);
    })
    //address
    $('body').on('click', '#tf_building_info_address_frm_edit .tf_save', function () {
        var form = $(this).parents('#tf_building_info_address_frm_edit');
        tf_building.info.address.postEdit(form);
    });
    //short description
    $('body').on('click', '#tf_building_info_short_description_frm_edit .tf_save', function () {
        var form = $(this).parents('#tf_building_info_short_description_frm_edit');
        tf_building.info.shortDescription.postEdit(form);
    });
    //description
    $('body').on('click', '#tf_building_info_description_frm_edit .tf_save', function () {
        var form = $(this).parents('#tf_building_info_description_frm_edit');
        tf_building.info.description.postEdit(form);
    });

});

//========== ========== ========== Highlight ========== ========== ==========
$(document).ready(function () {
    //turn on highlight
    $('body').on('click', '.tf_building_posts_object .tf_highlight_on', function () {
        var postObject = $(this).parents('.tf_building_posts_object');
        tf_building.posts.highlight.on(postObject);
    });

    //turn off highlight
    $('body').on('click', '.tf_building_posts_object .tf_highlight_off', function () {
        var postObject = $(this).parents('.tf_building_posts_object');
        tf_building.posts.highlight.off(postObject);
    });
});

//========== ========== ========== Report ========== ========== ==========
//building info
$(document).ready(function () {
    //get
    $('body').on('click', '.tf_building_report_info', function () {
        var buildingId = $(this).data('building');
        var href = $(this).data('href') + '/' + buildingId;
        tf_building.report.get(href);
    });

    //send
    $('body').on('click', '#tf_building_report_info .tf_send', function () {
        var form = $(this).parents('#tf_building_report_info');
        tf_building.report.send(form);
    });
});


//on post
$(document).ready(function () {
    //get
    $('body').on('click', '.tf_building_posts_object .tf_report', function () {
        var postObject = $(this).parents('.tf_building_posts_object');
        tf_building.posts.report.get(postObject);
    });

    //send
    $('body').on('click', '#tf_building_post_report .tf_send', function () {
        var form = $(this).parents('#tf_building_post_report');
        tf_building.posts.report.send(form);
    });
});
//========== ========== ========== Banner ========== ========== ==========
$(document).ready(function () {
    //get form upload
    $('#tf_building_title_banner').on('click', '#tf_building_banner_menu .tf_banner_add_get', function () {
        var href = $(this).data('href');
        var buildingId = $('#tf_building_title_banner').data('building');
        tf_building.banner.getUploadForm(href, buildingId);
    });

    //check add
    $('body').on('click', '#frmBuildingBannerAdd .tf_banner_add_post', function () {
        tf_building.banner.checkAdd();
    });

    //check add
    $('body').on('click', '#tf_building_banner_menu .tf_banner_delete', function () {
        var href = $(this).data('href');
        var bannerId = $(this).data('banner');
        tf_building.banner.delete(href, bannerId);
    });

    //view full image
    $('body').on('click', '#tf_building_title_banner .tf_building_banner_view', function () {
        tf_building.banner.viewFullImage(this);
    });
});

//========== ========== ========== Love ========== ========== ==========
$(document).ready(function () {
    $('#tf_building_menu_statistic').on('click', '.tf_building_love', function () {
        var href = $(this).data('href');
        var buildingId = $(this).parents('#tf_building_title').data('building');
        tf_building.love(href, buildingId);
    });
});

//========== ========== ========== Visit ========== ========== ==========
$(document).ready(function () {
    $('#tf_building_wrapper').on('click', '.tf_building_contact_website', function () {
        var href = $(this).data('visit-href');
        var buildingId = $(this).data('building');
        tf_building.visit(href, buildingId);
    });
});

//========== ========== ========== Follow ========== ========== ==========
$(document).ready(function () {
    $('#tf_building_title').on('click', '.tf_building_follow', function () {
        var href = $(this).data('href');
        var buildingId = $('#tf_building_title').data('building');
        tf_building.follow(href, buildingId);
    });
});


