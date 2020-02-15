<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 11/1/2016
 * Time: 2:44 PM
 *
 * $modelUser
 * $dataBuildingComment
 *
 */

$hFunction = new Hfunction();
$content = $dataBuildingComment->content();

# user comment
$dataUserComment = $dataBuildingComment->user;
$pathCommentUserAvatar = $dataUserComment->pathSmallAvatar($dataUserComment->userId(), true);
$commentUserAlias = $dataUserComment->alias();// $modelUser->alias($commentUserId);
?>
<div class="tf_comment_object_content tf-content-content">
    <a class="tf-link-bold" href="{!! route('tf.user.home',$commentUserAlias) !!}">
        {!! $dataUserComment->fullName() !!}
    </a>
    <br/>
    @if(strlen($content) > 200)
        {!! $hFunction->cutString($content, 200,'...') !!}
        <br/>
        <a class="tf_view_more tf-link" data-href="{!! route('tf.map.building.comment.content.get') !!}">
            {!! trans('frontend_map.label_view_more') !!}
        </a>
    @else
        {!! $hFunction->identifyLink($content) !!}
    @endif
</div>
