<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/11/2016
 * Time: 3:21 PM
 */
?>
<form class="tf_building_posts_comment_frm_edit input-group" method="post" style="background-color: whitesmoke;"
      action="{!! route('tf.building.posts.comment.edit.post', $dataBuildingPostComment->commentId()) !!}">
    <textarea class="form-control txt_comment_content tf-bg-none tf-border-none" name="txtCommentContent"
              rows="2" placeholder="Enter comment">{!! $dataBuildingPostComment->content() !!}</textarea>
    <span class="input-group-btn tf-border-none">
        <a class="tf_building_posts_comment_edit_post tf-link">
            <button class="btn btn-default tf-border-none tf-bg-none" type="button">
                Send
            </button>
        </a>
    </span>
    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
</form>
