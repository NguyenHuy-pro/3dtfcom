var tf_building_activity = {
    moreActivity: function (href) {
        var dateTake = $('#tf_building_activity_content .tf_building_activity_object:last').data('date');
        var href = href + '/' + dateTake;
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
                    $('#tf_building_activity_content').append(data);
                } else {
                    tf_main.tf_remove('#tf_building_activity_content_more');
                }
            },
            complete: function () {
                tf_master.tf_main_load_status();
            }
        });

    },
    posts: {
        setWidthTextWrap: function (postId) {
            var wrapObject = $('#tf_building_activity_content').outerWidth();
            var contentObject = $('#tf_building_posts_object_' + postId);
            var content = contentObject.find('.tf_building_posts_object_content_text');
            content.css({'width': 'auto', 'max-width': wrapObject});
        },
        highlight: {
            on: function (postObject) {
                var postId = $(postObject).data('posts');
                var href = $(postObject).find('.tf_highlight_on').data('href') + '/' + postId + '/' + 1;
                tf_master_submit.ajaxHasReload(href, '', false);

            },
            off: function (postObject) {
                if (confirm('Do you want to drop highlight status of this post?')) {
                    var postId = $(postObject).data('posts');
                    var href = $(postObject).find('.tf_highlight_off').data('href') + '/' + postId + '/' + 0;
                    tf_master_submit.ajaxHasReload(href, '', false);
                }
            }
        },
        grantPosts: function (href, buildingId, relationId) {
            var href = href + '/' + buildingId + '/' + relationId;
            tf_master_submit.ajaxHasReload(href, '', false);
            //tf_master_submit.ajaxNotReloadHasRemove(href, '#tf_building_posts_grant_wrap', true, '#tf_building_posts_grant');
        },
        add: {
            getIntroBuilding: function (href) {
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
                            tf_master.tf_main_container_top_close();
                            $('#' + tf_master.bodyIdName()).append(data);
                        }
                    },
                    complete: function () {
                        tf_master.tf_main_load_status();
                    }
                });
            },
            getFormContent: function (href) {
                tf_master_submit.ajaxNotReload(href, $('#' + tf_master.bodyIdName()), false);
            },
            addPosts: function (form) {
                var contentObject = $(form).find("textarea[name='txtBuildingPostsContent']");
                var imageObject = $(form).find("input[name='buildingPostsImage']");
                var buildingIntroObject = $(form).find("input[name='buildingPostsInfo']");
                for (instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }
                if (contentObject.val().length == 0 && imageObject.val() == '' && buildingIntroObject.val() == 0) {
                    alert('You must enter content');
                    contentObject.focus();
                    return false;
                } else {
                    $(form).ajaxForm({
                        beforeSend: function () {
                            tf_master.tf_main_load_status();
                        },
                        success: function (data) {
                            if (data) {
                                if ($('#tf_building_activity_content .tf_building_posts_object').length > 0) {
                                    $('#tf_building_activity_content .tf_building_posts_object:first').before(data);
                                } else {
                                    $('#tf_building_activity_content').append(data);
                                }
                            }
                        },
                        complete: function () {
                            contentObject.val('');
                            contentObject.css('height', 50);
                            $('#tf_building_post_image_cancel').click();
                            $('#tf_building_posts_intro_cancel').click();
                            tf_master.tf_main_load_status();
                            tf_master.tf_main_contain_action_close();
                        }
                    }).submit();
                }
            },
            multipleImagesPreview: function (input, placeToInsertImagePreview) {
                if (input.files) {
                    var filesAmount = input.files.length;
                    for (var i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();
                        reader.onload = function (event) {
                            $('#tf_building_post_mul_image_add_wrap').show();
                            $(placeToInsertImagePreview).show();
                            $(placeToInsertImagePreview).append("<div class='tf_preview_mul_image tf-preview-mul-image'><i class='tf_delete tf-delete tf-link glyphicon glyphicon-remove'></i><img class='tf-img' src='" + event.target.result + "'></div>");
                            $("#tf_building_post_mul_image_add_wrap .tf_delete").click(function () {
                                if ($(this).parent(".tf_preview_mul_image").remove()) {
                                    if ($('.tf_preview_mul_image').length == 0) {
                                        $('#tf_building_post_mul_image_add_wrap').hide();
                                    }
                                }
                            });
                        }
                        reader.readAsDataURL(input.files[i]);

                    }
                }
            }
        },
        edit: {
            getForm: function (href, postId) {
                var href = href + '/' + postId;
                tf_master_submit.ajaxNotReload(href, $('#' + tf_master.bodyIdName()), false);
            },
            getIntroBuilding: function (href) {
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
                            tf_master.tf_main_container_top_close();
                            $('#' + tf_master.bodyIdName()).append(data);
                        }
                    },
                    complete: function () {
                        tf_master.tf_main_load_status();
                    }
                });
            },
            editPost: function (form) {
                var postId = $(form).data('post');
                var contentObject = $(form).find("textarea[name='txtBuildingPostsContent']");
                var imageObject = $(form).find("input[name='buildingPostEditImage']");
                var buildingIntroObject = $(form).find("input[name='buildingPostEditInfo']");
                for (instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }
                if (contentObject.val().length == 0 && imageObject.val() == '' && buildingIntroObject.val() == 0) {
                    alert('You must enter content');
                    contentObject.focus();
                    return false;
                } else {
                    $(form).ajaxForm({
                        beforeSend: function () {
                            tf_master.tf_main_load_status();
                        },
                        success: function (data) {
                            if (data) {
                                $('#tf_building_posts_object_content_' + postId).empty();
                                $('#tf_building_posts_object_content_' + postId).append(data);
                            }
                        },
                        complete: function () {
                            tf_master.tf_main_contain_action_close();
                            tf_master.tf_main_load_status();
                        }
                    }).submit();
                }
            }
        },
        love: function (href) {
            $.ajax({
                url: href,
                type: 'GET',
                cache: false,
                data: {},
                beforeSend: function () {
                },
                success: function (data) {
                    return true;
                },
                complete: function () {
                }
            });
        },
        viewImagePosts: function (href) {
            tf_master_submit.ajaxNotReload(href, $('#' + tf_master.bodyIdName()), false);
        },
        delete: function (href, postId) {
            if (confirm('Do you to delete this post')) {
                var href = href + '/' + postId;
                tf_master_submit.ajaxNotReloadHasRemove(href, '', false, '#tf_building_posts_object_' + postId);
            }
        },
        report: {
            get: function (postObject) {
                var postId = $(postObject).data('posts');
                var href = $(postObject).find('.tf_report').data('href') + '/' + postId;
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
        comment: {
            //add
            addComment: function (form) {
                var content = $(form).find(".txt_comment_content").val();
                if (content.length == 0) {
                    alert('You must enter content');
                    return false;
                } else {
                    var postObject = $(form).parents('.tf_building_posts_object');
                    var totalCommentObject = postObject.find('.tf_building_post_comment_total');
                    // var totalCommentVal = parseInt($(totalCommentObject).text());
                    var postId = postObject.data('posts');
                    var oldAction = $(form).attr('action');
                    $(form).attr('action', oldAction + '/' + postId);
                    $(form).ajaxForm({
                        beforeSend: function () {
                            tf_master.tf_main_load_status();
                        },
                        success: function (data) {
                            if (data) {
                                if ($('#tfBuildingPostsCommentList_' + postId + ' .tf_building_posts_comment_object').length > 0) {
                                    $('#tfBuildingPostsCommentList_' + postId + ' .tf_building_posts_comment_object:first').before(data);
                                } else {
                                    $('#tfBuildingPostsCommentList_' + postId).append(data);
                                }

                                //update total comment
                                var totalCommentObject = postObject.find('.tf_building_post_comment_total');
                                var totalCommentVal = parseInt($(totalCommentObject).text());
                                $(totalCommentObject).text(totalCommentVal + 1);
                            }
                        },
                        complete: function () {
                            // return default of action
                            $(form).attr('action', oldAction);
                            $(form).find(".txt_comment_content").val('');
                            tf_master.tf_main_load_status();
                        }
                    }).submit();
                }
            },

            //edit
            getEditComment: function (href, commentObject) {
                var commentId = $(commentObject).data('comment');
                var containCommentObject = $(commentObject).find('.tf_building_post_object_content');
                var href = href + '/' + commentId;
                tf_master_submit.ajaxNotReload(href, containCommentObject, true);
            },
            postEditComment: function (frmObject) {
                var containCommentObject = $(frmObject).parents('.tf_building_post_object_content');
                tf_master_submit.ajaxFormNotReload(frmObject, containCommentObject, true);
            },

            //view more
            moreComment: function (href, postId) {
                var dateTake = $('#tfBuildingPostsCommentList_' + postId).children('.tf_building_posts_comment_object:last-child').data('date');
                var href = href + '/' + dateTake;
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
                            $('#tfBuildingPostsCommentList_' + postId).append(data);
                        } else {
                            tf_main.tf_remove('#tfBuildingPostsCommentMore_' + postId);
                        }
                    },
                    complete: function () {
                        tf_master.tf_main_load_status();
                    }
                });
            },
            delete: function (href, commentId) {
                var href = href + '/' + commentId;
                tf_master_submit.ajaxNotReload(href, '', false);
            },
        }
    },
}
//========== ========== ========== Posts ========== ========== ==========

$(document).ready(function () {
    // grant to posts
    $('#tf_building_post_form_wrap').on('click', '#tf_building_posts_grant .tf_action', function () {
        var href = $('#tf_building_posts_grant').data('href');
        var buildingId = $('#tf_building_posts_grant').data('building');
        var relationId = $(this).data('relation')
        tf_building_activity.posts.grantPosts(href, buildingId, relationId);
    });

    // get more old post
    $('body').on('click', '#tf_building_activity_content_more > a', function () {
        var buildingId = $('#tf_building_activity_content').data('building');
        var take = $(this).data('take');
        var href = $(this).data('href') + '/' + buildingId + '/' + take;
        tf_building_activity.posts.moreActivity(href);
    });

    //love
    $('#tf_building_activity_content').on('click', '.tf_building_post_love', function () {
        var href = $(this).data('href');
        var postId = $(this).parents('.tf_building_posts_object').data('posts');
        var text = $(this).text();
        var loveObject = $(this).prev('.tf_building_post_love_total');
        var totalLove = parseInt(loveObject.text());
        if (text == 'Love') {
            text = 'UnLove';
            totalLove = totalLove + 1;
            href = href + '/' + postId + '/' + 1;
        } else {
            text = 'Love';
            totalLove = totalLove - 1;
            href = href + '/' + postId + '/' + 0;
        }
        tf_building_activity.posts.love(href);
        $(this).text(text);
        loveObject.text(totalLove);

    });
});

//---------- ---------- ---------- add posts ---------- ---------- ----------
$(document).ready(function () {
    //process when enter content
    $('#tf_building_wrapper').on('click', "#txtBuildingPostsContent", function () {
        tf_main.tf_show('#tf_building_post_action');
    });

    //multiple image
    $('body').on('click', '.tf_building_post_mul_image_add', function () {
        $('.tf_building_post_mul_image_file').click();
    });
    $('body').on('change', '.tf_building_post_mul_image_file', function () {
        tf_building_activity.posts.add.multipleImagesPreview(this, 'div.tf_building_post_mul_image_add_preview');
    });

    //select image to posts
    $('body').on('click', '#tf_building_post_form .tf_select_image', function () {
        $('#tf_building_post_image').click();
    })

    // upload image to posts
    $('body').on('change', '#tf_building_post_form #tf_building_post_image', function () {
        var reader = new FileReader();
        reader.onload = function (e) {
            var img = document.getElementById("tf_building_post_image_view");
            img.src = e.target.result;
            //img.style.display = "inline";
        };
        reader.readAsDataURL(this.files[0]);
        tf_main.tf_show('#tf_building_post_image_view_wrap');
    });

    // cancel  upload image to posts
    $('body').on('click', '#tf_building_post_form #tf_building_post_image_cancel', function () {
        tf_main.tf_hide('#tf_building_post_image_view_wrap');
        $('#tf_building_post_image').val('');
    });

    //get list intro buildings
    $('body').on('click', '#tf_building_post_form .tf_posts_building_intro_get', function () {
        var href = $(this).data('href');
        tf_building_activity.posts.add.getIntroBuilding(href);
    });

    //select intro buildings
    $('body').on('click', '#tf_building_post_select_intro .tf_intro_building', function () {
        var buildingId = $(this).data('building');
        var src = $(this).children('.tf_sample_image').attr('src');
        $('#tf_building_posts_intro_view').attr('src', src);
        $('#tf_building_post_info').val(buildingId);
        tf_main.tf_show('#tf_building_post_intro_view_wrap');
        tf_master.tf_main_container_top_close();
    });

    //cancel select intro buildings
    $('body').on('click', '#tf_building_post_form #tf_building_posts_intro_cancel', function () {
        $('#tf_building_post_info').val(0);
        tf_main.tf_hide('#tf_building_post_intro_view_wrap');
    });

    // get form content of post
    $('#tf_building_post_form_wrap').on('click', '.tf_get_form_content', function () {
        var buildingId = $(this).data('building');
        var href = $(this).data('href') + '/' + buildingId;
        tf_building_activity.posts.add.getFormContent(href);
    });

    // add posts
    $('body').on('click', '#tf_building_post_form .tf_publish', function () {
        var form = $(this).parents('#tf_building_post_form');
        tf_building_activity.posts.add.addPosts(form);
    });

});

//---------- ---------- ----------  EDIT POST ---------- ---------- ----------

$(document).ready(function () {
    // get form edit
    $('#tf_building_activity_content').on('click', '.tf_posts_object_menu .tf_edit', function () {
        var href = $(this).data('href');
        var postId = $(this).parents('.tf_building_posts_object').data('posts');
        tf_building_activity.posts.edit.getForm(href, postId);
    });

    //select image to edit posts
    $('body').on('click', '#tf_building_post_edit_action .tf_select_image', function () {
        $('#tf_building_post_edit_image').click();
    });

    // upload image to posts
    $('body').on('change', '#tf_building_post_edit_image', function () {
        var reader = new FileReader();
        reader.onload = function (e) {
            var img = document.getElementById("tf_building_post_edit_image_view");
            img.src = e.target.result;
            //img.style.display = "inline";
        };
        reader.readAsDataURL(this.files[0]);
        tf_main.tf_show('#tf_building_post_edit_image_view_wrap');
    });

    //cancel  upload image to posts
    $('body').on('click', '#tf_building_post_edit_image_cancel', function () {
        tf_main.tf_hide('#tf_building_post_edit_image_view_wrap');
        $('#tf_building_post_edit_old_image').val('');
        $('#tf_building_post_edit_image').val('');
    });

    //cancel select intro buildings
    $('body').on('click', '#tf_building_posts_edit_intro_cancel', function () {
        $('#tf_building_post_edit_info').val(0);
        tf_main.tf_hide('#tf_building_post_edit_intro_view_wrap');
    });

    //get list intro buildings
    $('body').on('click', '.tf_posts_building_edit_intro_get', function () {
        var href = $(this).data('href');
        tf_building_activity.posts.edit.getIntroBuilding(href);
    });
    //select intro buildings
    $('body').on('click', '#tf_building_post_edit_select_intro .tf_edit_intro_building', function () {
        var buildingId = $(this).data('building');
        var src = $(this).children('.tf_sample_image').attr('src');
        $('#tf_building_posts_edit_intro_view').attr('src', src);
        $('#tf_building_post_edit_info').val(buildingId);
        tf_main.tf_show('#tf_building_post_edit_intro_view_wrap');
        tf_master.tf_main_container_top_close();
    });

    // update
    $('body').on('click', '#tf_building_post_edit_form .tf_update', function () {
        var form = $(this).parents('#tf_building_post_edit_form');
        tf_building_activity.posts.edit.editPost(form);
    });
});

//---------- View full image ------
$(document).ready(function () {
    $('#tf_building_activity_content').on('click', '.tf_building_posts_object .tf_posts_image_show', function () {
        var href = $(this).parents('.tf_posts_image').data('href') + '/' + $(this).data('image');
        tf_building_activity.posts.viewImagePosts(href);
    });
});

//delete post
$(document).ready(function () {
    $('#tf_building_activity_content').on('click', '.tf_posts_object_menu .tf_delete', function () {
        var href = $(this).data('href');
        var postId = $(this).parents('.tf_building_posts_object').data('posts');
        tf_building_activity.posts.delete(href, postId);
    });
});

//========== ========== ========== Comment ========== ========== ==========
$(document).ready(function () {
    //process when enter content
    $('#tf_building_activity_content').on('keyup', '.tf_building_posts_comment_frm .txt_comment_content', function (event) {
        tf_main.tf_textareaAutoHeight(this, 1);
    });

    //add comment
    $('#tf_building_activity_content').on('click', '.tf_building_posts_comment_add', function () {
        var form = $(this).parents('.tf_building_posts_comment_frm');
        tf_building_activity.posts.comment.addComment(form);
    });

    //get edit
    $('#tf_building_activity_content').on('click', '.tf_posts_comment_menu_wrap .tf_edit', function () {
        var href = $(this).data('href');
        var commentObject = $(this).parents('.tf_building_posts_comment_object');
        tf_building_activity.posts.comment.getEditComment(href, commentObject);
    });

    $('#tf_building_activity_content').on('click', '.tf_building_posts_comment_edit_post', function () {
        var frmCommentEdit = $(this).parents('.tf_building_posts_comment_frm_edit');
        tf_building_activity.posts.comment.postEditComment(frmCommentEdit);
    });

    //get more comment
    $('#tf_building_activity_content').on('click', '.tf_building_posts_comment_more > a', function () {
        var postId = $(this).parents('.tf_building_posts_object').data('posts');
        var take = $(this).data('take');
        var href = $(this).data('href') + '/' + postId + '/' + take;
        tf_building_activity.posts.comment.moreComment(href, postId);
    });

    //show menu
    $('#tf_building_activity_content').on('mouseover', '.tf_building_posts_comment_object', function () {
        $(this).find('.tf_posts_comment_menu_wrap').show();
    }).on('mouseout', '.tf_building_posts_comment_object', function () {
        $(this).find('.tf_posts_comment_menu_wrap').hide();
    });

    //delete comment
    $('#tf_building_activity_content').on('click', '.tf_posts_comment_menu .tf_delete', function () {
        var href = $(this).data('href');
        var commentId = $(this).parents('.tf_building_posts_comment_object').data('comment');
        tf_building_activity.posts.comment.delete(href, commentId);
        $(this).parents('.tf_building_posts_comment_object').remove();
    });
});