<?php
/*
 *
 *
 * modelUser
 * dataBuildingArticles
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
?>
<div class="tf_service_article_comment_object_wrap row" data-date="{!! $dataBuildingArticlesComment->createdAt() !!}">
    <div id="tf_service_article_comment_object_{!! $commentId !!}" class="tf_service_article_comment_object tf-article-comment-object col-xs-12 col-sm-12 col-md-12 col-lg-12"
         data-comment="{!! $commentId !!}">
        @include('building.services.comment.comment-object-content', compact('modelUser', 'dataBuildingArticlesComment'))
    </div>
</div>