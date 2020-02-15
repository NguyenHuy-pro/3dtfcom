/**
 * Created by 3D on 3/26/2016.
 */
var tf_user_activity = {

    //love
    love: function (href) {
        tf_master_submit.ajaxNotReload(href, '', false);
    },
    comment: {
        addComment: function (form) {
            var content = $(form).find(".txt_comment_content").val();
            if (content.length == 0) {
                alert('You must enter content');
                $(content).focus();
                return false;
            } else {
                var activityObject = $(form).parents('.tf_user_activity_object');
                var activityId = activityObject.data('activity');
                var oldAction = $(form).attr('action');
                $(form).attr('action', oldAction + '/' + activityId);
                $(form).ajaxForm({
                    beforeSend: function () {
                        tf_master.tf_main_load_status();
                    },
                    success: function (data) {
                        if (data) {
                            if ($('#tf_user_activity_comment_list_' + activityId + ' .tf_user_activity_comment_object').length > 0) {
                                $('#tf_user_activity_comment_list_' + activityId + ' .tf_user_activity_comment_object:first').before(data);
                            } else {
                                $('#tf_user_activity_comment_list_' + activityId).append(data);
                            }

                            //update total comment
                            var totalCommentObject = activityObject.find('.tf_user_activity_comment_total');
                            $(totalCommentObject).text(parseInt($(totalCommentObject).text()) + 1);
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
        //--------- edit ---------
        getEditComment: function (href, commentObject) {
            var commentId = $(commentObject).data('comment');
            var containCommentObject = $(commentObject).find('.tf_comment_content');
            tf_master_submit.ajaxNotReload(href + '/' + commentId, containCommentObject, true);
        },
        postEditComment: function (form) {
            var containCommentObject = $(form).parents('.tf_comment_content');
            var content = $(form).find(".txt_comment_content").val();
            if (content.length == 0) {
                alert('You must enter content');
                $(content).focus();
                return false;
            } else {
                tf_master_submit.ajaxFormNotReload(form, containCommentObject, true);
            }

        },

        //view more
        moreComment: function (href, activityId) {
            var dateTake = $('#tf_user_activity_comment_list_' + activityId).children('.tf_user_activity_comment_object:last-child').data('date');
            $.ajax({
                url: href + '/' + dateTake,
                type: 'GET',
                cache: false,
                data: {},
                beforeSend: function () {
                    tf_master.tf_main_load_status();
                },
                success: function (data) {
                    if (data) {
                        $('#tf_user_activity_comment_list_' + activityId).append(data);
                    } else {
                        tf_main.tf_remove('#tf_user_activity_comment_more_' + activityId);
                    }
                },
                complete: function () {
                    tf_master.tf_main_load_status();
                }
            });
        },
        delete: function (href, commentId) {
            if (confirm('Do you want to delete this comment?')) {
                tf_master_submit.ajaxNotReload(href + '/' + commentId, '', false);
            }
        },
    },
    more: function (href) {
        var dateTake = $('#tf_user_activity_list .tf_user_activity_object:last').data('date');
        $.ajax({
            url: href + '/' + dateTake,
            type: 'GET',
            cache: false,
            data: {},
            beforeSend: function () {
                tf_master.tf_main_load_status();
            },
            success: function (data) {
                if (data) {
                    $('#tf_user_activity_list').append(data);
                } else {
                    tf_main.tf_remove('#tf_user_activity_more_wrap');
                }
            },
            complete: function () {
                tf_master.tf_main_load_status();
            }
        });
    },
    post: {
        //----------- add ----------
        getPostForm: function (href) {
            tf_master_submit.ajaxNotReload(href, $('#' + tf_master.bodyIdName()), false);
        },
        publish: function (form) {
            var contentObject = $(form).find("textarea[name='txtUserActivityPostsContent']");
            var imageObject = $(form).find("input[name='userActivityPostsImage']");
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
            if (contentObject.val().length == 0 && imageObject.val() == '') {
                alert('You must enter content');
                contentObject.focus();
                return false;
            } else {

                if (imageObject.val() != '') {
                    if (tf_main.tf_checkFile(imageObject.val(), 'gif,jpg,jpge,png,GIF,JPG,JPGE,PNG')) {
                        $(form).ajaxForm({
                            beforeSend: function () {
                                tf_master.tf_main_load_status();
                            },
                            success: function (data) {
                                if (data) {
                                    tf_main.tf_remove('#tf_user_activity_null_notify');
                                    if ($('#tf_user_activity_list .tf_user_activity_object').length > 0) {
                                        $('#tf_user_activity_list .tf_user_activity_object:first').before(data);
                                    } else {
                                        $('#tf_user_activity_list').append(data);
                                    }
                                }
                            },
                            complete: function () {
                                contentObject.val('');
                                contentObject.css('height', 50);
                                $('#tf_user_activity_post_image_cancel').click();
                                tf_master.tf_main_load_status();
                                tf_master.tf_main_contain_action_close();
                            }
                        }).submit();
                    } else {
                        alert('Only image type: gif,jpg,jpge,png,GIF,JPG,JPGE,PNG');
                        return false;
                    }
                } else {
                    $(form).ajaxForm({
                        beforeSend: function () {
                            tf_master.tf_main_load_status();
                        },
                        success: function (data) {
                            if (data) {
                                tf_main.tf_remove('#tf_user_activity_null_notify');
                                if ($('#tf_user_activity_list .tf_user_activity_object').length > 0) {
                                    $('#tf_user_activity_list .tf_user_activity_object:first').before(data);
                                } else {
                                    $('#tf_user_activity_list').append(data);
                                }
                            }
                        },
                        complete: function () {
                            contentObject.val('');
                            contentObject.css('height', 50);
                            $('#tf_user_activity_post_image_cancel').click();
                            tf_master.tf_main_load_status();
                            tf_master.tf_main_contain_action_close();
                        }
                    }).submit();
                }


            }
        },
        //--------- edit --------
        getPostEdit: function (href) {
            tf_master_submit.ajaxNotReload(href, $('#' + tf_master.bodyIdName()), false);
        },
        editSave: function (form) {
            var postId = $(form).data('post');
            var contentObject = $(form).find("textarea[name='txtUserActivityPostsContent']");
            var oldImage = $(form).find("input[name='userActivityPostEditOldImage']");
            var imageObject = $(form).find("input[name='userActivityPostEditImage']");

            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
            if (contentObject.val().length == 0 && oldImage.val() == '') {
                alert('You must enter content edit');
                contentObject.focus();
                return false;
            } else {
                if (imageObject.val() != '') {
                    if (tf_main.tf_checkFile(imageObject.val(), 'gif,jpg,jpge,png,GIF,JPG,JPGE,PNG')) {
                        $(form).ajaxForm({
                            beforeSend: function () {
                                tf_master.tf_main_load_status();
                            },
                            success: function (data) {
                                if (data) {
                                    $('#tf_user_activity_post_object_content_wrap_' + postId).empty();
                                    $('#tf_user_activity_post_object_content_wrap_' + postId).append(data);
                                }
                            },
                            complete: function () {
                                tf_master.tf_main_contain_action_close();
                                tf_master.tf_main_load_status();
                            }
                        }).submit();
                    } else {
                        alert('Only image type: gif,jpg,jpge,png,GIF,JPG,JPGE,PNG');
                        return false;
                    }
                } else {
                    $(form).ajaxForm({
                        beforeSend: function () {
                            tf_master.tf_main_load_status();
                        },
                        success: function (data) {
                            if (data) {
                                $('#tf_user_activity_post_object_content_wrap_' + postId).empty();
                                $('#tf_user_activity_post_object_content_wrap_' + postId).append(data);
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
        //---------- view --------
        view: function (href) {
            tf_master_submit.ajaxNotReload(href, $('#' + tf_master.bodyIdName()), false);
        },
        //--------- Love --------
        love: function (href) {
            tf_master_submit.ajaxNotReload(href, '', false);
        },
        //--------- delete --------
        delete: function (postId, href) {
            if (confirm('Do you to delete this post')) {
                var href = href + '/' + postId;
                tf_master_submit.ajaxNotReloadHasRemove(href, '', false, '#tf_user_activity_post_object_' + postId);
            }
        },
        comment: {
            addComment: function (form) {
                var content = $(form).find(".txt_comment_content").val();
                if (content.length == 0) {
                    alert('You must enter content');
                    $(content).focus();
                    return false;
                } else {
                    var postObject = $(form).parents('.tf_user_activity_post_object');
                    var postId = postObject.data('post');
                    var oldAction = $(form).attr('action');
                    $(form).attr('action', oldAction + '/' + postId);
                    $(form).ajaxForm({
                        beforeSend: function () {
                            tf_master.tf_main_load_status();
                        },
                        success: function (data) {
                            if (data) {
                                if ($('#tf_user_activity_post_comment_list_' + postId + ' .tf_user_activity_post_comment_object').length > 0) {
                                    $('#tf_user_activity_post_comment_list_' + postId + ' .tf_user_activity_post_comment_object:first').before(data);
                                } else {
                                    $('#tf_user_activity_post_comment_list_' + postId).append(data);
                                }

                                //update total comment
                                var totalCommentObject = postObject.find('.tf_user_activity_post_comment_total');
                                $(totalCommentObject).text(parseInt($(totalCommentObject).text()) + 1);
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
            //--------- edit ---------
            getEditComment: function (href, commentObject) {
                var commentId = $(commentObject).data('comment');
                var containCommentObject = $(commentObject).find('.tf_comment_content');
                tf_master_submit.ajaxNotReload(href + '/' + commentId, containCommentObject, true);
            },
            postEditComment: function (form) {
                var containCommentObject = $(form).parents('.tf_comment_content');
                var content = $(form).find(".txt_comment_content").val();
                if (content.length == 0) {
                    alert('You must enter content');
                    $(content).focus();
                    return false;
                } else {
                    tf_master_submit.ajaxFormNotReload(form, containCommentObject, true);
                }

            },

            //view more
            moreComment: function (href, postId) {
                var dateTake = $('#tf_user_activity_post_comment_list_' + postId).children('.tf_user_activity_post_comment_object:last-child').data('date');
                $.ajax({
                    url: href + '/' + dateTake,
                    type: 'GET',
                    cache: false,
                    data: {},
                    beforeSend: function () {
                        tf_master.tf_main_load_status();
                    },
                    success: function (data) {
                        if (data) {
                            $('#tf_user_activity_post_comment_list_' + postId).append(data);
                        } else {
                            tf_main.tf_remove('#tf_user_activity_post_comment_more_' + postId);
                        }
                    },
                    complete: function () {
                        tf_master.tf_main_load_status();
                    }
                });
            },
            delete: function (href, commentId) {
                if (confirm('Do you want to delete this comment?')) {
                    tf_master_submit.ajaxNotReload(href + '/' + commentId, '', false);
                }
            },
        }
    },

}
//========== ========= view more ========== ===========
$(document).ready(function(){
    $('.tf_user_activity_more').on('click', function () {
        var href = $(this).data('href') + '/' + $(this).data('user') + '/' + $(this).data('take');
        tf_user_activity.more(href);
    })
});
//========== ========== Comment ========= ========
$(document).ready(function () {
    //show menu
    $('body').on('mouseover', '.tf_user_activity_comment_object', function () {
        $(this).find('.tf_comment_menu_wrap').show();
    }).on('mouseout', '.tf_user_activity_comment_object', function () {
        $(this).find('.tf_comment_menu_wrap').hide();
    });

    //get more comment
    $('.tf_user_activity_object').on('click', '.tf_comment_view_more > a', function () {
        var activityId = $(this).data('activity');
        tf_user_activity.comment.moreComment($(this).data('href') + '/' + activityId + '/' + $(this).data('take'), activityId);
    });

    //add
    $('body').on('click', '.tf_frm_user_activity_comment .tf_send', function () {
        tf_user_activity.comment.addComment($(this).parents('.tf_frm_user_activity_comment'));
    });

    //edit
    $('.tf_user_activity_comment_list').on('click', '.tf_comment_menu_wrap .tf_edit', function () {
        tf_user_activity.comment.getEditComment($(this).data('href'), $(this).parents('.tf_user_activity_comment_object'));
    });

    $('body').on('click', '.tf_frm_user_activity_comment_edit .tf_save', function () {
        tf_user_activity.comment.postEditComment($(this).parents('.tf_frm_user_activity_comment_edit'));
    });

    //----------- delete comment -------
    $('.tf_user_activity_comment_list').on('click', '.tf_comment_menu .tf_delete', function () {
        tf_user_activity.comment.delete($(this).data('href'), $(this).parents('.tf_user_activity_comment_object').data('comment'));

        //update total comment
        var totalCommentObject = $(this).parents('.tf_user_activity_object').find('.tf_user_activity_comment_total');
        $(totalCommentObject).text(parseInt($(totalCommentObject).text()) - 1);
        $(this).parents('.tf_user_activity_comment_object').remove();
    });
});

//========== ========== Love ========= ========
$(document).ready(function () {
    $('body').on('click', '.tf_user_activity_love', function () {
        var href = $(this).data('href');
        var activityId = $(this).parents('.tf_user_activity_object').data('activity');
        var text = $(this).text();
        var loveObject = $(this).prev('.tf_user_activity_love_total');
        var totalLove = parseInt(loveObject.text());
        if (text == 'Love') {
            text = 'UnLove';
            totalLove = totalLove + 1;
            href = href + '/' + activityId + '/' + 1;
        } else {
            text = 'Love';
            totalLove = totalLove - 1;
            href = href + '/' + activityId + '/' + 0;
        }
        tf_user_activity.love(href);
        $(this).text(text);
        loveObject.text(totalLove);

    });
});
//========== ========== Post ========= ========
$(document).ready(function () {
    //------------ Add ---------------
    //post
    $('#tf_user_activity_post_form_wrap').on('click', '.tf_get_form_content', function () {
        var href = $(this).data('href') + '/' + $(this).data('user');
        tf_user_activity.post.getPostForm(href);
    });
    //process when enter content
    $('#tf_user_activity_wrap').on('click', "#txtUserActivityPostsContent", function () {
        //tf_main.tf_show('#tf_building_post_action');
    });

    //select image to posts
    $('body').on('click', '.tf_user_activity_post_form .tf_select_image', function () {
        $('#tf_user_activity_post_image').click();
    })

    // upload image to posts
    $('body').on('change', '.tf_user_activity_post_form #tf_user_activity_post_image', function () {
        var reader = new FileReader();
        reader.onload = function (e) {
            var img = document.getElementById("tf_user_activity_post_image_view");
            img.src = e.target.result;
            //img.style.display = "inline";
        };
        reader.readAsDataURL(this.files[0]);
        tf_main.tf_show('#tf_user_activity_post_image_view_wrap');
    });

    // cancel  upload image to posts
    $('body').on('click', '.tf_user_activity_post_form #tf_user_activity_post_image_cancel', function () {
        tf_main.tf_hide('#tf_user_activity_post_image_view_wrap');
        $('#tf_user_activity_post_image').val('');
    });

    // add posts
    $('body').on('click', '.tf_user_activity_post_form .tf_publish', function () {
        var formObject = $(this).parents('.tf_user_activity_post_form');
        tf_user_activity.post.publish(formObject);
    });
    $('.tf_user_activity_list').on('click', '.tf_post_image', function () {
        var postId = $(this).parents('.tf_user_activity_post_object_content').data('post');
        var href = $(this).data('href') + '/' + postId;
        tf_user_activity.post.view(href);
    });
    //============ Edit ===========
    $('body').on('click', '.tf_user_activity_post_object .tf_post_edit', function () {
        var postId = $(this).parents('.tf_user_activity_post_object').data('post');
        var href = $(this).data('href') + '/' + postId;
        tf_user_activity.post.getPostEdit(href);
    });

    //select image to edit posts
    $('body').on('click', '#tf_user_activity_post_edit_action .tf_select_image', function () {
        $('#tf_user_activity_post_edit_image').click();
    });

    // upload image to posts
    $('body').on('change', '#tf_user_activity_post_edit_image', function () {
        var reader = new FileReader();
        reader.onload = function (e) {
            var img = document.getElementById("tf_user_activity_post_edit_image_view");
            img.src = e.target.result;
            //img.style.display = "inline";
        };
        reader.readAsDataURL(this.files[0]);
        tf_main.tf_show('#tf_user_activity_post_edit_image_view_wrap');
    });

    //cancel  upload image to posts
    $('body').on('click', '#tf_user_activity_post_image_cancel', function () {
        tf_main.tf_hide('#tf_user_activity_post_edit_image_view_wrap');
        $('#tf_user_activity_post_edit_old_image').val('');
        $('#tf_user_activity_post_edit_image').val('');
    });
    // update
    $('body').on('click', '#tf_user_activity_post_edit_form .tf_save', function () {
        var form = $(this).parents('#tf_user_activity_post_edit_form');
        tf_user_activity.post.editSave(form);
    });


    //========== love post ==============
    $('body').on('click', '.tf_user_activity_post_love', function () {
        var href = $(this).data('href');
        var postId = $(this).parents('.tf_user_activity_post_object').data('post');
        var text = $(this).text();
        var loveObject = $(this).prev('.tf_user_activity_post_love_total');
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
        tf_user_activity.post.love(href);
        $(this).text(text);
        loveObject.text(totalLove);

    });

    //========= delete ==========
    $('body').on('click', '.tf_user_activity_post_object .tf_post_delete', function () {
        var postId = $(this).parents('.tf_user_activity_post_object').data('post');
        var href = $(this).data('href');
        tf_user_activity.post.delete(postId, href);
    });
});

//---------- Post comment ----------
$(document).ready(function () {
    //show menu
    $('body').on('mouseover', '.tf_user_activity_post_comment_object', function () {
        $(this).find('.tf_post_comment_menu_wrap').show();
    }).on('mouseout', '.tf_user_activity_post_comment_object', function () {
        $(this).find('.tf_post_comment_menu_wrap').hide();
    });

    //get more comment
    $('.tf_user_activity_post_object').on('click', '.tf_comment_view_more > a', function () {
        var postId = $(this).data('post');
        var href = $(this).data('href') + '/' + postId + '/' + $(this).data('take');
        tf_user_activity.post.comment.moreComment(href, postId);
    });

    //============ Add ============
    $('body').on('click', '.tf_frm_user_activity_posts_comment .tf_send', function () {
        var form = $(this).parents('.tf_frm_user_activity_posts_comment');
        tf_user_activity.post.comment.addComment(form);
    });

    //============ Edit ============
    $('.tf_user_activity_post_comment_list').on('click', '.tf_post_comment_menu_wrap .tf_edit', function () {
        var href = $(this).data('href');
        var commentObject = $(this).parents('.tf_user_activity_post_comment_object');
        tf_user_activity.post.comment.getEditComment(href, commentObject);
    });

    $('body').on('click', '.tf_frm_user_activity_post_comment_edit .tf_save', function () {
        var form = $(this).parents('.tf_frm_user_activity_post_comment_edit');
        tf_user_activity.post.comment.postEditComment(form);
    });

    //----------- delete comment -------
    $('.tf_user_activity_post_comment_list').on('click', '.tf_post_comment_menu .tf_delete', function () {
        var href = $(this).data('href');
        var commentId = $(this).parents('.tf_user_activity_post_comment_object').data('comment');
        tf_user_activity.post.comment.delete(href, commentId);

        //update total comment
        var totalCommentObject = $(this).parents('.tf_user_activity_post_object').find('.tf_user_activity_post_comment_total');
        $(totalCommentObject).text(parseInt($(totalCommentObject).text()) - 1);
        $(this).parents('.tf_user_activity_post_comment_object').remove();
    });
});
