<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/11/2016
 * Time: 3:21 PM
 *
 * dataUserActivityComment
 */
?>
<form class="tf_frm_user_activity_comment_edit input-group" method="post" style="background-color: whitesmoke;"
      action="{!! route('tf.user.activity.comment.edit.post', $dataUserActivityComment->commentId()) !!}">
    <input class="txt_comment_content form-control tf-bg-none tf-border-none" name="txtCommentContent"
           placeholder="Enter comment" value="{!! $dataUserActivityComment->content() !!}">
    <span class="input-group-btn tf-border-none">
        <a class="tf_save tf-link">
            <button class="btn btn-default btn-sm tf-border-none tf-bg-none" type="button">
                {!! trans('frontend.button_send') !!}
            </button>
        </a>
    </span>
    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
</form>
