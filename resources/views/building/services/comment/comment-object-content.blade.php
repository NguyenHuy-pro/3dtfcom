<?php
/*
 *
 *
 * modelUser
 * dataBuildingAccess
 *
 *
 */
$hFunction = new Hfunction();
$mobileDetect = new Mobile_Detect();
$dataUserLogin = $modelUser->loginUserInfo();
if (count($dataUserLogin) > 0) {
    $loginStatus = true;
    $userLoginId = $dataUserLogin->userId();
} else {
    $loginStatus = false;
    $userLoginId = null;
}
$commentId = $dataBuildingArticlesComment->commentId();
$dataUserComment = $dataBuildingArticlesComment->user;
$dataUserCommentId = $dataBuildingArticlesComment->userId();
$dataUserCommentAlias = $dataUserComment->alias();
?>
<table id="tf_article_comment_content_{!! $commentId !!}" class="tf-article-comment-content table" data-comment="{!! $commentId !!}">
    <tr>
        <td class="tf_avatar tf-avatar" rowspan="2">
            <a class="tf-link" href="{!! route('tf.user.home',$dataUserCommentAlias) !!}">
                <img src="{!! $dataUserComment->pathSmallAvatar($dataUserComment->userId(), true) !!}"
                     alt="{!! $dataUserComment->fullName() !!}">
            </a>
        </td>
        <td class="tf-content" >
            <div class="tf_content_content tf-content-content">
                <a class="tf-link-bold" href="{!! route('tf.user.home',$dataUserCommentAlias) !!}">
                    {!! $dataUserComment->fullName() !!}
                </a>
                <br/>
                {!! $hFunction->identifyLink($dataBuildingArticlesComment->content()) !!}
            </div>
        </td>
    </tr>
    <tr>
        <td class="tf-action text-right" colspan="2">
            <i class="tf-color-grey glyphicon glyphicon-calendar"></i>
                <span class="tf-color-grey tf-font-bold">
                    {!! $dataBuildingArticlesComment->createdAt() !!}
                </span>
            @if($loginStatus)
                <div class="tf_article_comment_content_action tf-article-comment-content-action btn-group">
                    <button class="tf-link-grey-bold tf-border-none btn btn-xs btn-default dropdown-toggle"
                            type="button" data-toggle="dropdown">
                        <i class="fa fa-ellipsis-h"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        @if($dataUserCommentId == $userLoginId)
                            <li>
                                <a class="tf_edit_comment tf-bg-hover" data-href="#">
                                    {!! trans('frontend_building.service_article_detail_comment_action_edit_label') !!}
                                </a>
                            </li>
                            <li>
                                <a class="tf_delete_comment tf-bg-hover" data-href="#">
                                    {!! trans('frontend_building.service_article_detail_comment_action_delete_label') !!}
                                </a>
                            </li>
                        @else
                            @if($dataBuildingArticlesComment->buildingArticles->checkArticlesOfUser($userLoginId))
                                <li>
                                    <a class="tf_delete tf-bg-hover" href="#">
                                        {!! trans('frontend_building.service_article_detail_comment_action_delete_label') !!}
                                    </a>
                                </li>
                            @endif
                        @endif
                    </ul>
                </div>
            @endif
        </td>
    </tr>
    <script type="text/javascript">
        tf_building_service.articlesComment.setWidthCommentWrap(<?php echo $commentId ?>);
    </script>
</table>