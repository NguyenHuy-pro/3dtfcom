<?php
/*
 *
 * $modelUser
 * modelBuilding
 * buildingArticles
 *
 */
# info of user login
$mobileDetect = new Mobile_Detect();
$dataUserLogin = $modelUser->loginUserInfo();
$createdAt = $buildingArticles->createdAt();
$articleAlias = $buildingArticles->alias();
$articlesId = $buildingArticles->articlesId();
$avatar = $buildingArticles->avatar();
?>
<div class="row">
    <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
        <div class="media">
            @if(!empty($avatar))
                <a class="pull-left"
                   href="{!! route('tf.building.services.article.detail.get',$articleAlias) !!}">
                    <img class="media-object" style="width: 30px; height: 30px;"
                         src="{!! $buildingArticles->pathSmallImage() !!}" alt="...">
                </a>
            @endif
            <div class="media-body">
                <a href="{!! route('tf.building.services.article.detail.get',$articleAlias) !!}">
                    {!! $buildingArticles->name() !!}
                </a><br/>
                <span class="tf-color-grey">{!! $createdAt !!}</span>
            </div>
        </div>
    </div>
    <div class="text-right col-xs-12 col-sm-2 col-md-2 col-lg-2">
        <div class="btn-group">
            <button class="tf-link tf-border-none btn btn-xs btn-default dropdown-toggle"
                    type="button"
                    data-toggle="dropdown">
                <i class="tf-font-size-20 fa fa-ellipsis-h"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-right tf-padding-none">
                <li>
                    <a class="tf_edit tf-link tf-bg-hover " data-href="{!! route('tf.building.services.tool.article.edit.get') !!}">Edit</a>
                </li>
                <li>
                    <a class="tf_delete tf-bg-hover" data-href="{!! route('tf.building.services.tool.article.delete') !!}">
                        Delete
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
