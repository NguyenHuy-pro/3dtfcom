<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 9/28/2016
 * Time: 10:49 AM
 *
 * $modelUser
 * $dataBuilding
 * $dataUserBuilding
 *
 *
 */
$hFunction = new Hfunction();

# login user
$dataUserLogin = $modelUser->loginUserInfo();
$loginUserId = $dataUserLogin->userId();

#building info
$buildingId = $dataBuilding->buildingId();
$postRelationId = $dataBuilding->postRelationId();


# info of building owner
$userBuildingId = $dataUserBuilding->userId();

$dataRelation = $dataBuilding->relation->getInfo();
?>
<div id="tf_building_post_form_wrap" class="panel panel-default tf-building-posts-form-wrap">
    <div class="panel-heading tf-bg-none">
        <div class="row">
            <div class="col-xs-8 col-sm-8 col-md-10 col-lg-10">
                <i class="fa fa-comment-o tf-font-size-14"></i>
                {!! trans('frontend_building.posts_add_title') !!}
            </div>

            {{--grant to post--}}
            <div id="tf_building_posts_grant_wrap" class="col-xs-4 col-sm-4 col-md-2 col-lg-2 text-right">
                @if($userLoginId == $userBuildingId)
                    @include('building.posts.form-posts.add.posts-grant', compact(['dataBuilding' => $dataBuilding],'dataRelation'))
                @else
                    @if($postRelationId == 1)
                        <i class="fa fa-globe tf-font-size-16" title="everyone"></i>
                    @elseif($postRelationId == 2)
                        <i class="fa fa-users" title="friends"></i>
                    @endif
                @endif
            </div>

        </div>

    </div>
    <div class="panel-body">
        <a class="tf_get_form_content tf-link-grey" data-building="{!! $buildingId !!}"
           data-href="{!! route('tf.building.posts.add.form.get') !!}">
            {!! trans('frontend_building.posts_get_form_content_label') !!}
        </a>
    </div>
</div>
