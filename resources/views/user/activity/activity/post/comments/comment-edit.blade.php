<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/11/2016
 * Time: 3:21 PM
 *
 * dataUserPostComment
 */
?>
<form class="tf_frm_user_activity_post_comment_edit input-group" method="post" style="background-color: whitesmoke;"
      action="{!! route('tf.user.activity.post.comment.edit.post', $dataUserPostComment->commentId()) !!}">
    <input class="txt_comment_content form-control tf-bg-none tf-border-none" name="txtCommentContent"
           placeholder="Enter comment" value="{!! $dataUserPostComment->content() !!}">
    <span class="input-group-btn tf-border-none">
        <a class="tf_save tf-link">
            <button class="btn btn-default btn-sm tf-border-none tf-bg-none" type="button">
                Send
            </button>
        </a>
    </span>
    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
</form>
