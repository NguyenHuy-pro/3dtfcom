/**
 * Created by HUY on 10/3/2018.
 */
var tf_building_service = {
    tool: {
        addArticles: function (form) {
            var buildingId = $(form).data('building');
            var serviceType = $(form).find("select[name = 'cbServiceType']");
            var title = $(form).find("input[name='txtTitle']");
            var avatar = $(form).find("input[name='txtAvatar']");
            var shortDescription = $(form).find("input[name='txtShortDescription']");
            var keyWord = $(form).find("input[name='txtKeyWord']");
            var content = $(form).find("textarea[name='txtContent']");
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
            if (tf_main.tf_checkInputNull(serviceType, 'Select a service type')) {
                return false;
            }
            if (tf_main.tf_checkInputNull(title, 'Enter a articles title')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength(title, 200, 'max length of name is 200 characters')) {
                    return false;
                }
            }
            if (!tf_main.tf_checkInputNull(avatar, '')) {
                if ($(form).find('.tf_preview_image').length > 0) {
                    if (!tf_main.tf_checkInputFileValid(avatar.val(), 'jpg', 'File is an image type')) {
                        return false;
                    }
                } else {
                    avatar.val('');
                }
            }
            if (tf_main.tf_checkInputNull(shortDescription, 'Enter short description')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength(title, 250, 'max length of name is 250 characters')) {
                    return false;
                }
            }
            if (!tf_main.tf_checkInputNull(keyWord, '')) {
                if (tf_main.tf_checkInputMaxLength(keyWord, 250, 'max length of name is 250 characters')) {
                    return false;
                }
            }
            if (tf_main.tf_checkInputNull(content, 'Enter content')) {
                return false;
            } else {
                tf_master_submit.normalForm(form);
                //tf_master_submit.ajaxFormHasReload(form, '', true);
            }
        },
        edit: {
            editArticles: function (articlesObject, href) {
                tf_master_submit.ajaxNotReload(href + '/' + $(articlesObject).data('articles'), $('#' + tf_master.bodyIdName()), false);
            },
            save: function (form) {
                var articlesId = $(form).data('articles');
                var serviceType = $(form).find("select[name = 'cbServiceType']");
                var title = $(form).find("input[name='txtTitle']");
                var avatar = $(form).find("input[name='txtAvatar']");
                var shortDescription = $(form).find("input[name='txtShortDescription']");
                var keyWord = $(form).find("input[name='txtKeyWord']");
                var content = $(form).find("textarea[name='txtContent']");
                for (instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }
                if (tf_main.tf_checkInputNull(serviceType, 'Select a service type')) {
                    return false;
                }
                if (tf_main.tf_checkInputNull(title, 'Enter a articles title')) {
                    return false;
                } else {
                    if (tf_main.tf_checkInputMaxLength(title, 200, 'max length of name is 200 characters')) {
                        return false;
                    }
                }
                if (!tf_main.tf_checkInputNull(avatar, '')) {
                    if ($(form).find('.tf_preview_image').length > 0) {
                        if (!tf_main.tf_checkInputFileValid(avatar.val(), 'jpg', 'File is an image type')) {
                            return false;
                        }
                    } else {
                        avatar.val('');
                    }
                }
                if (tf_main.tf_checkInputNull(shortDescription, 'Enter short description')) {
                    return false;
                } else {
                    if (tf_main.tf_checkInputMaxLength(title, 250, 'max length of name is 250 characters')) {
                        return false;
                    }
                }
                if (!tf_main.tf_checkInputNull(keyWord, '')) {
                    if (tf_main.tf_checkInputMaxLength(keyWord, 250, 'max length of name is 250 characters')) {
                        return false;
                    }
                }
                if (tf_main.tf_checkInputNull(content, 'Enter content')) {
                    return false;
                } else {
                    tf_master_submit.ajaxFormNotReload(form, '#tf_building_service_tool_articles_object_' + articlesId, true);
                }
            }
        },
        articlesViewMore: function (href) {
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
                        $('#tf_building_service_tool_list').append(data);
                    } else {
                        tf_main.tf_remove('#tf_building_service_tool_more');
                    }
                },
                complete: function () {
                    tf_master.tf_main_load_status();
                }
            });
        },
        manageFilter: function (href) {
            tf_main.tf_url_replace(href);
        },
        deleteArticles: function (articlesObject, href) {
            tf_master_submit.ajaxNotReloadHasRemove(href + '/' + $(articlesObject).data('articles'), '', false, articlesObject);
        }
    },
    articlesDetail: {
        love: function (href, articlesId) {
            var href = href + '/' + articlesId;
            tf_master_submit.ajaxHasReload(href, '', false);
        },
        comment: {
            addComment: function (form) {
                var txtContent = $(form).find("textarea[name='txtCommentContent']");
                for (instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }
                if (!tf_main.tf_checkInputNull(txtContent, '')) {
                    $(form).ajaxForm({
                        beforeSend: function () {
                            tf_master.tf_main_load_status();
                        },
                        success: function (data) {
                            if (data) {
                                if ($('#tf_building_service_article_detail_comment_list .tf_article_detail_comment_object_wrap').length > 0) {
                                    $('#tf_building_service_article_detail_comment_list .tf_article_detail_comment_object_wrap:first').before(data);
                                } else {
                                    $('#tf_building_service_article_detail_comment_list').append(data);
                                }
                            }
                        },
                        complete: function () {
                            $(form).find('.tf_cancel').click();
                            tf_master.tf_main_load_status();
                        }
                    }).submit();
                }
            },
            edit: {
                editComment: function (commentObject, href) {
                    tf_master_submit.ajaxNotReload(href + '/' + $(commentObject).data('comment'), $('#' + tf_master.bodyIdName()), false);
                },
                save: function (form) {
                    var commentId = $(form).find("input[name='txtComment']").val();
                    var txtCommentContent = $(form).find("textarea[name='txtCommentContent']");
                    for (instance in CKEDITOR.instances) {
                        CKEDITOR.instances[instance].updateElement();
                    }
                    if (tf_main.tf_checkInputNull(txtCommentContent, 'Enter content')) {
                        return false;
                    } else {
                        tf_master_submit.ajaxFormNotReload(form, '#tf_article_detail_comment_object_' + commentId, true);
                    }
                }
            },
            viewMoreComment: function (href) {
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
                            $('#tf_building_service_article_detail_comment_list').append(data);
                        } else {
                            tf_main.tf_remove('#tf_building_service_article_detail_comment_more');
                        }
                    },
                    complete: function () {
                        tf_master.tf_main_load_status();
                    }
                });
            },
            deleteComment: function (commentObject, href) {
                tf_master_submit.ajaxNotReloadHasRemove(href + '/' + $(commentObject).data('comment'), '', false, $(commentObject).parents('.tf_article_detail_comment_object_wrap'));
            },
            setWidthCommentWrap: function (commentId) {
                var wrapObject = $('#tf_building_service_article_detail_comment_list').outerWidth();
                var contentObject = $('#tf_article_detail_comment_content_' + commentId);
                var avatar = contentObject.find('.tf_avatar');
                var content = contentObject.find('.tf_content_content');
                var widthAvatar = parseInt(avatar.outerWidth());
                content.css({'width': 'auto', 'max-width': wrapObject - widthAvatar - 40});

            }
        },
        share: {
            embedArticles: function (href) {
                tf_master_submit.ajaxNotReload(href, $('#' + tf_master.bodyIdName()), false);
            }
        }
    },
    articlesFilter: function (href) {
        tf_main.tf_url_replace(href);
    },
    articlesComment: {
        addComment: function (form) {
            var txtContent = $(form).find("textarea[name='txtCommentContent']");
            var articlesId = $(form).find("input[name='txtArticles']").val();
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
            if (!tf_main.tf_checkInputNull(txtContent, '')) {
                $(form).ajaxForm({
                    beforeSend: function () {
                        tf_master.tf_main_load_status();
                    },
                    success: function (data) {
                        if (data) {
                            if ($('#tf_building_service_article_comment_list_' + articlesId + ' .tf_service_article_comment_object_wrap').length > 0) {
                                $('#tf_building_service_article_comment_list_' + articlesId + ' .tf_service_article_comment_object_wrap:first').before(data);
                            } else {
                                $('#tf_building_service_article_comment_list_' + articlesId).append(data);
                            }
                        }
                    },
                    complete: function () {
                        $(form).find('.tf_cancel').click();
                        tf_master.tf_main_load_status();
                    }
                }).submit();
            }
        },
        edit: {
            editComment: function (commentObject, href) {
                tf_master_submit.ajaxNotReload(href + '/' + $(commentObject).data('comment'), $('#' + tf_master.bodyIdName()), false);
            },
            save: function (form) {
                var commentId = $(form).find("input[name='txtComment']").val();
                var txtCommentContent = $(form).find("textarea[name='txtCommentContent']");
                for (instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }
                if (tf_main.tf_checkInputNull(txtCommentContent, 'Enter content')) {
                    return false;
                } else {
                    tf_master_submit.ajaxFormNotReload(form, '#tf_service_article_comment_object_' + commentId, true);
                }
            }
        },
        viewMoreComment: function (href, articlesId) {
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
                        $('#tf_building_service_article_comment_list_' + articlesId).append(data);
                    } else {
                        tf_main.tf_remove('#tf_building_service_article_comment_more_' + articlesId);
                    }
                },
                complete: function () {
                    tf_master.tf_main_load_status();
                }
            });
        },
        deleteComment: function (commentObject, href) {
            tf_master_submit.ajaxNotReloadHasRemove(href + '/' + $(commentObject).data('comment'), '', false, $(commentObject).parents('.tf_service_article_comment_object_wrap'));
        },
        setWidthCommentWrap: function (commentId) {
            var wrapObject = $('#tf_building_service_list').outerWidth();
            var contentObject = $('#tf_article_comment_content_' + commentId);
            var avatar = contentObject.find('.tf_avatar');
            var content = contentObject.find('.tf_content_content');
            var widthAvatar = parseInt(avatar.outerWidth());
            content.css('max-width', wrapObject - widthAvatar - 100);

        }
    },
    moreService: function (href) {
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
                    $('#tf_building_service_list').append(data);
                } else {
                    tf_main.tf_remove('#tf_building_service_more');
                }
            },
            complete: function () {
                tf_master.tf_main_load_status();
            }
        });

    },
    edit: {
        editArticles: function (articlesObject, href) {
            tf_master_submit.ajaxNotReload(href + '/' + $(articlesObject).data('articles'), $('#' + tf_master.bodyIdName()), false);
        },
        save: function (form) {
            var articlesId = $(form).find("input[name='txtArticles']").val();
            var serviceType = $(form).find("select[name = 'cbServiceType']");
            var title = $(form).find("input[name='txtTitle']");
            var avatar = $(form).find("input[name='txtAvatar']");
            var shortDescription = $(form).find("input[name='txtShortDescription']");
            var keyWord = $(form).find("input[name='txtKeyWord']");
            var content = $(form).find("textarea[name='txtContent']");
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
            if (tf_main.tf_checkInputNull(serviceType, 'Select a service type')) {
                return false;
            }
            if (tf_main.tf_checkInputNull(title, 'Enter a articles title')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength(title, 200, 'max length of name is 200 characters')) {
                    return false;
                }
            }
            if (!tf_main.tf_checkInputNull(avatar, '')) {
                if ($(form).find('.tf_preview_image').length > 0) {
                    if (!tf_main.tf_checkInputFileValid(avatar.val(), 'jpg', 'File is an image type')) {
                        return false;
                    }
                } else {
                    avatar.val('');
                }
            }
            if (tf_main.tf_checkInputNull(shortDescription, 'Enter short description')) {
                return false;
            } else {
                if (tf_main.tf_checkInputMaxLength(title, 250, 'max length of name is 250 characters')) {
                    return false;
                }
            }
            if (!tf_main.tf_checkInputNull(keyWord, '')) {
                if (tf_main.tf_checkInputMaxLength(keyWord, 250, 'max length of name is 250 characters')) {
                    return false;
                }
            }
            if (tf_main.tf_checkInputNull(content, 'Enter content')) {
                return false;
            } else {
                tf_master_submit.ajaxFormNotReload(form, '#tf_building_service_articles_content_wrap_' + articlesId, true);
            }
        }
    },
    deleteService: function (articlesObject, href) {
        tf_master_submit.ajaxNotReloadHasRemove(href + '/' + $(articlesObject).data('articles'), '', false, articlesObject);
    }
}
//========= ======================Service -activity ============================
//-------- activity -------
$(document).ready(function () {
    //filter follow service type
    $('#tf_building_services').on('change', '.tf_building_articles_filter .tf_filter_service_type', function () {
        var objectFilter = $(this).parents('.tf_building_articles_filter');
        var keyword = objectFilter.find('.tf_filter_keyword').val();
        if (keyword.length > 0) {
            var href = objectFilter.data('href') + '/' + objectFilter.parents('#tf_building_services').data('alias') + '/' + $(this).val() + '/' + keyword;
        } else {
            var href = objectFilter.data('href') + '/' + objectFilter.parents('#tf_building_services').data('alias') + '/' + $(this).val();
        }
        tf_building_service.articlesFilter(href);
    });
    //filter - keyword
    $('#tf_building_services').on('click', '.tf_building_articles_filter .tf_filter_keyword_search', function () {
        var objectFilter = $(this).parents('.tf_building_articles_filter');
        var typeId = objectFilter.find('.tf_filter_service_type').val();
        var keyword = objectFilter.find('.tf_filter_keyword').val();
        if (keyword.length > 0) {
            var href = objectFilter.data('href') + '/' + objectFilter.parents('#tf_building_services').data('alias') + '/' + typeId + '/' + keyword;
            tf_building_service.articlesFilter(href);
        }
    });

    //view more morePost
    $('body').on('click', '#tf_building_services #tf_building_service_more > a', function () {
        var buildingId = $('#tf_building_services').data('building');
        var serviceTypeId = $('#tf_building_services').find('.tf_filter_service_type').val();
        var keyword = $('#tf_building_services').find('.tf_filter_keyword').val();
        var take = $(this).data('take');
        var dateTake = $('.tf_building_service_list .tf_building_service_articles_object:last').data('date');
        var href = $(this).data('href') + '/' + buildingId + '/' + take + '/' + dateTake + '/' + serviceTypeId;
        if (keyword.length > 0) {
            var href = href + '/' + keyword;
        }
        tf_building_service.moreService(href);
    });
    //delete
    $('body').on('click', '.tf_building_service_articles_object .tf_delete', function () {
        tf_building_service.deleteService($(this).parents('.tf_building_service_articles_object'), $(this).data('href'));
    });
});
//-------- Edit ---------
$(document).ready(function () {
    //edit articles
    $('body').on('click', '.tf_building_service_articles_object .tf_edit', function () {
        tf_building_service.edit.editArticles($(this).parents('.tf_building_service_articles_object'), $(this).data('href'));
    });
    $('body').on('click', '.tf_building_service_articles_edit .tf_select_image', function () {
        $('.tf_building_service_articles_edit').find('.tf_txtAvatar').click();
    });

    $('body').on('change', '.tf_building_service_articles_edit .tf_txtAvatar', function () {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('.tf_avatar_preview').append("<div class='tf_preview_image tf-preview-image'><i class='tf_delete tf-delete tf-link glyphicon glyphicon-remove'></i><img class='tf-img' src='" + e.target.result + "'></div>");
            $(".tf_building_service_articles_edit .tf_preview_image .tf_delete").click(function () {
                $('.tf_avatar_preview').empty();
                $('.tf_building_service_articles_edit').find('.tf_txtAvatar').val('');
            });
        }
        reader.readAsDataURL(this.files[0]);
    });

    $('body').on('click', '.tf_building_service_articles_edit .tf_save', function () {
        tf_building_service.edit.save($(this).parents('.tf_building_service_articles_edit'));
    });
});
//------------ activity- Comment - articles -------------
$(document).ready(function () {
    $('.tf_building_service_article_comment').on('click', '.tf_form_comment .txt_comment_content', function () {
        $(this).parents('.tf_form_comment').find('.tf_action').show();
    });
    $('.tf_building_service_article_comment').on('click', '.tf_form_comment .tf_cancel', function () {
        $(this).parents('.tf_action').hide();
        $(this).parents('.tf_form_comment').find('.txt_comment_content').val('');
    });
    //add comment
    $('body').on('click', '.tf_building_service_article_comment .tf_form_comment .tf_save', function () {
        tf_building_service.articlesComment.addComment($(this).parents('.tf_form_comment'));
    });
    //view more comment
    $('body').on('click', '.tf_building_service_article_comment_more > a', function () {
        var serviceArticlesComment = $(this).parents('.tf_building_service_article_comment');
        var articlesId = $(this).data('articles');
        var dateTake = serviceArticlesComment.find('.tf_building_service_article_comment_list').children('.tf_service_article_comment_object_wrap:last-child').data('date');
        tf_building_service.articlesComment.viewMoreComment($(this).data('href') + '/' + articlesId + '/' + $(this).data('take') + '/' + dateTake, articlesId);
    });

    //edit
    $('body').on('click', '.tf_building_service_article_comment_list .tf_article_comment_content_action .tf_edit_comment', function () {
        tf_building_service.articlesComment.edit.editComment($(this).parents('.tf_service_article_comment_object'), $(this).parents('.tf_building_service_article_comment_list').data('href-edit'));
    });
    $('body').on('click', '.tf_building_service_articles_comment_edit .tf_save', function () {
        tf_building_service.articlesComment.edit.save($(this).parents('.tf_building_service_articles_comment_edit'));
    });

    //delete
    $('body').on('click', '.tf_building_service_article_comment_list .tf_article_comment_content_action .tf_delete_comment', function () {
        tf_building_service.articlesComment.deleteComment($(this).parents('.tf_service_article_comment_object'), $(this).parents('.tf_building_service_article_comment_list').data('href-del'));
    });
});
//========== ========== ========== service - tool ========== ========== ==========
//--------- manage articles ------
$(document).ready(function () {
    //================= ADD ARTICLES ======================
    $('.tf_building_service_articles_add').on('click', '.tf_save', function () {
        tf_building_service.tool.addArticles($(this).parents('.tf_building_service_articles_add'));
    });
    $('.tf_building_service_articles_add').on('click', '.tf_select_image', function () {
        $('.tf_building_service_articles_add').find('.tf_txtAvatar').click();
    });

    $('.tf_building_service_articles_add').on('change', '.tf_txtAvatar', function () {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('.tf_avatar_preview').append("<div class='tf_preview_image tf-preview-image'><i class='tf_delete tf-delete tf-link glyphicon glyphicon-remove'></i><img class='tf-img' src='" + e.target.result + "'></div>");
            $(".tf_building_service_articles_add .tf_preview_image .tf_delete").click(function () {
                $('.tf_avatar_preview').empty();
                $('.tf_building_service_articles_add').find('.tf_txtAvatar').val('');
            });
        }
        reader.readAsDataURL(this.files[0]);
    });

    //================= filter ARTICLES ======================
    //filter follow service type
    $('#tf_building_service_tool').on('change', '.tf_building_tool_articles_filter .tf_filter_service_type', function () {
        var objectFilter = $(this).parents('.tf_building_tool_articles_filter');
        var keyword = objectFilter.find('.tf_filter_keyword').val();
        if (keyword.length > 0) {
            var href = objectFilter.data('href') + '/' + objectFilter.parents('#tf_building_service_tool').data('building') + '/' + $(this).val() + '/' + keyword;
        } else {
            var href = objectFilter.data('href') + '/' + objectFilter.parents('#tf_building_service_tool').data('building') + '/' + $(this).val();
        }
        tf_building_service.tool.manageFilter(href);
    });

    //filter - keyword
    $('#tf_building_service_tool').on('click', '.tf_building_tool_articles_filter .tf_filter_keyword_search', function () {
        var objectFilter = $(this).parents('.tf_building_tool_articles_filter');
        var typeId = objectFilter.find('.tf_filter_service_type').val();
        var keyword = objectFilter.find('.tf_filter_keyword').val();
        if (keyword.length > 0) {
            var href = objectFilter.data('href') + '/' + objectFilter.parents('#tf_building_service_tool').data('building') + '/' + typeId + '/' + keyword;
            tf_building_service.tool.manageFilter(href);
        }
    });

    //view more morePost
    $('body').on('click', '#tf_building_service_tool #tf_building_service_tool_more > a', function () {
        var buildingId = $('#tf_building_service_tool').data('building');
        var serviceTypeId = $('#tf_building_service_tool').find('.tf_filter_service_type').val();
        var keyword = $('#tf_building_service_tool').find('.tf_filter_keyword').val();
        var take = $(this).data('take');
        var dateTake = $('.tf_building_service_tool_list .tf_building_service_tool_articles_object:last').data('date');
        var href = $(this).data('href') + '/' + buildingId + '/' + take + '/' + dateTake + '/' + serviceTypeId;
        if (keyword.length > 0) {
            var href = href + '/' + keyword;
        }
        tf_building_service.tool.articlesViewMore(href);
    });

    //delete
    $('body').on('click', '.tf_building_service_tool_articles_object .tf_delete', function () {
        tf_building_service.tool.deleteArticles($(this).parents('.tf_building_service_tool_articles_object'), $(this).data('href'));
    });
});
//---------- Edit articles -------------
$(document).ready(function () {
    //edit articles
    $('body').on('click', '.tf_building_service_tool_articles_object .tf_edit', function () {
        tf_building_service.tool.edit.editArticles($(this).parents('.tf_building_service_tool_articles_object'), $(this).data('href'));
    });
    $('body').on('click', '.tf_building_service_tool_articles_edit .tf_select_image', function () {
        $('.tf_building_service_tool_articles_edit').find('.tf_txtAvatar').click();
    });

    $('body').on('change', '.tf_building_service_tool_articles_edit .tf_txtAvatar', function () {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('.tf_avatar_preview').append("<div class='tf_preview_image tf-preview-image'><i class='tf_delete tf-delete tf-link glyphicon glyphicon-remove'></i><img class='tf-img' src='" + e.target.result + "'></div>");
            $(".tf_building_service_tool_articles_edit .tf_preview_image .tf_delete").click(function () {
                $('.tf_avatar_preview').empty();
                $('.tf_building_service_tool_articles_edit').find('.tf_txtAvatar').val('');
            });
        }
        reader.readAsDataURL(this.files[0]);
    });

    $('body').on('click', '.tf_building_service_tool_articles_edit .tf_save', function () {
        tf_building_service.tool.edit.save($(this).parents('.tf_building_service_tool_articles_edit'));
    });
});

//--------  Love --------------
$(document).ready(function () {
    $('.tf_building_service_article_detail').on('click', '.tf_building_articles_love', function () {
        var href = $(this).data('href');
        var articlesId = $(this).parents('.tf_building_service_article_detail').data('articles');
        tf_building_service.articlesDetail.love(href, articlesId);
    });
});

//------------Share ---------
$(document).ready(function () {
    //share
    $('.tf_building_service_article_detail').on('click', '.tf_building_articles_share', function () {
        tf_main.tf_toggle('#tf_building_service_article_detail_share');
    });

    //get embed
    $('body').on('click', '#tf_building_service_article_detail_share .tf_articles_embed', function () {
        tf_building_service.articlesDetail.share.embedArticles($(this).data('href'));
    });

    $('body').on('click', '#tf_building_service_article_detail_share_embed .tf_article_embed_get_link', function () {
        $('#tf_building_service_article_detail_share_embed .tf_article_embed_get_link_copy').select();
        document.execCommand('copy');
    });

    //get link
    $('body').on('click', '#tf_building_service_article_detail_share .tf_get_link', function () {
        $('#tf_building_service_article_detail_share .tf_link_copy').select();
        document.execCommand('copy');
    });
});
//---------------- Comment articles -------------
$(document).ready(function () {
    $('#tf_building_service_article_detail_comment').on('click', '.tf_form_comment .txt_comment_content', function () {
        $('.tf_form_comment').find('.tf_action').show();
    });
    $('#tf_building_service_article_detail_comment').on('click', '.tf_form_comment .tf_cancel', function () {
        $(this).parents('.tf_action').hide();
        $('.tf_form_comment').find('.txt_comment_content').val('');
    });
    //add comment
    $('#tf_building_service_article_detail_comment').on('click', '.tf_form_comment .tf_save', function () {
        tf_building_service.articlesDetail.comment.addComment($(this).parents('.tf_form_comment'));
    });
    //view more comment -
    $('body').on('click', '#tf_building_service_article_detail_comment_more > a', function () {
        var dateTake = $('#tf_building_service_article_detail_comment_list .tf_article_detail_comment_object_wrap:last').data('date');
        tf_building_service.articlesDetail.comment.viewMoreComment($(this).data('href') + '/' + $(this).data('articles') + '/' + $(this).data('take') + '/' + dateTake);
    });

    //edit
    $('body').on('click', '.tf_article_detail_comment_content_action .tf_edit', function () {
        tf_building_service.articlesDetail.comment.edit.editComment($(this).parents('.tf_article_detail_comment_object'), $(this).parents('#tf_building_service_article_detail_comment_list').data('href-edit'));
    });
    $('body').on('click', '.tf_building_service_articles_comment_edit .tf_save', function () {
        tf_building_service.articlesDetail.comment.edit.save($(this).parents('.tf_building_service_articles_comment_edit'));
    });

    //delete
    $('body').on('click', '.tf_article_detail_comment_content_action .tf_delete', function () {
        tf_building_service.articlesDetail.comment.deleteComment($(this).parents('.tf_article_detail_comment_object'), $(this).parents('#tf_building_service_article_detail_comment_list').data('href-del'));
    });
});