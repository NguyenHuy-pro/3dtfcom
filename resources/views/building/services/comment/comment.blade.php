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
//articles info
$articleId = $dataBuildingArticles->articlesId();
$totalComment = $dataBuildingArticles->totalComment();
$take = 3;
$dateTake = $hFunction->createdAt();
$buildingArticlesComment = $dataBuildingArticles->commentInfoOfArticles($articleId, $take, $dateTake);
?>
<div class="tf_building_service_article_comment tf-building-service-article-comment col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <form class="tf_form_comment tf-form form-horizontal col-xs-12 col-sm-12 col-md-12 col-lg-12"
                  role="form"
                  enctype="multipart/form-data" method="post"
                  action="{!! route('tf.building.services.article.comment.add') !!}">
                <div class="tf-input form-group form-group-sm">
                        <textarea class="txt_comment_content tf-bg-none form-control" name="txtCommentContent"
                                  placeholder="Enter comment" rows="1"></textarea>
                </div>
                @if($loginStatus)
                    <div class="tf_action tf-action form-group form-group-sm text-right">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <input type="hidden" name="txtArticles" value="{!! $articleId !!}">
                        <button class="tf_cancel btn btn-default btn-sm" type="button">
                            {!! trans('frontend_building.service_article_detail_comment_add_cancel_label') !!}
                        </button>
                        <button class="tf_save btn btn-primary btn-sm" type="button">
                            {!! trans('frontend_building.service_article_detail_comment_add_comment_label') !!}
                        </button>
                    </div>
                @else
                    <div class="tf_action tf-action form-group form-group-sm text-left">
                        <span class="tf-color-red">You must login to comment</span>
                    </div>
                @endif
            </form>
        </div>
    </div>
    <div class="row">
        <div id="tf_building_service_article_comment_list_{!! $articleId !!}" class="tf_building_service_article_comment_list col-xs-12 col-sm-12 col-md-12 col-lg-12"
             data-href-edit="{!! route('tf.building.services.article.comment.edit.get') !!}"
             data-href-del="{!! route('tf.building.services.article.comment.delete') !!}">
            @if(count($buildingArticlesComment) > 0)
                @foreach($buildingArticlesComment as $dataBuildingArticlesComment)
                    @include('building.services.comment.comment-object', compact('modelUser','dataBuildingArticlesComment'))
                @endforeach
            @endif
        </div>
        @if($totalComment > count($buildingArticlesComment))
            <div id="tf_building_service_article_comment_more_{!! $articleId !!}" class="tf_building_service_article_comment_more tf-view-more col-xs-12 col-sm-12 co-md-12 col-lg-12 ">
                <a class="tf-link" data-take="{!! $take !!}" data-articles="{!! $articleId !!}"
                   data-href="{!! route('tf.building.services.article.comment.view_more') !!}">
                    {!! trans('frontend_building.service_article_detail_comment_view_more_label') !!}
                </a>
            </div>
        @endif
    </div>

</div>