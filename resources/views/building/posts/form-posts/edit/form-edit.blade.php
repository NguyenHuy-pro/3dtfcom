<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/6/2016
 * Time: 11:15 AM
 */
$buildingId = $dataBuildingPost->buildingId();
$postId = $dataBuildingPost->postId();
$userPostId = $dataBuildingPost->userId();
$postContent = $dataBuildingPost->content();
$postImage = $dataBuildingPost->image();
$postBuildingIntroId = $dataBuildingPost->buildingIntroId();

#image
if (empty($postImage)) {
    $srcView = asset('public\main\icons\1.gif');
} else {
    $srcView = $dataBuildingPost->pathSmallImage();
}

#introduce building
if (empty($postBuildingIntroId)) {
    $introSrcView = asset('public\main\icons\1.gif');
} else {
    $dataBuildingIntro = $dataBuildingPost->building->getInfo($postBuildingIntroId);
    $introSrcView = $dataBuildingIntro->buildingSample->pathImage();
}
?>
@extends('components.container.contain-action-6')
@section('tf_main_action_content')
    <div class="panel panel-default tf-margin-none">
        <div class="panel-heading tf-bg tf-color-white ">
            <i class="fa fa-edit tf-font-size-14"></i>
            {!! trans('frontend_building.posts_edit_title') !!}
        </div>
        <div class="panel-body">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-12">
                <form id="tf_building_post_edit_form" name="tf_building_post_edit_form" class="form-horizontal"
                      enctype="multipart/form-data" method="post" data-post="{!! $postId !!}"
                      action="{!! route('tf.building.posts.edit.post', $postId) !!}">
                    <div class="tf_notify form-group text-center tf-color-red"></div>
                    <div class="form-group">
                        <textarea name="txtBuildingPostsContent" class="form-control" rows="7"
                                  style="max-width: 100%;">{!! $postContent !!}</textarea>
                        <script type="text/javascript">ckeditor('txtBuildingPostsContent', false)</script>
                    </div>

                    <div id="tf_building_post_edit_image_view_wrap"
                         class="form-group  @if(empty($postImage)) tf-display-none @endif">
                        <img id="tf_building_post_edit_image_view" class="tf-cursor-pointer tf-icon-50" alt="image"
                             title="Click to cancel" src="{!! $srcView !!}"/>
                        <i id="tf_building_post_edit_image_cancel" class="tf-link-red fa fa-close tf-font-size-16"></i>
                    </div>

                    <div id="tf_building_post_edit_intro_view_wrap"
                         class="form-group @if(empty($postBuildingIntroId)) tf-display-none @endif"
                         style="border: 1px solid #c2c2c2;">
                        <img id="tf_building_posts_edit_intro_view" class="tf-icon-50" alt="posts-building"
                             src="{!! $introSrcView !!}">
                        <i id="tf_building_posts_edit_intro_cancel" class="tf-link fa fa-close pull-right tf-margin-10"></i>
                    </div>

                    <div id="tf_building_post_edit_action" class="form-group">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-left">
                                <a class="tf-link" title="Upload image">
                                    <img class="tf_select_image tf-icon-30" alt="upload-image"
                                         src="{!! asset('public\main\icons\Photograph.png') !!}">
                                </a>
                                &nbsp;&nbsp;
                                <a class="tf_posts_building_edit_intro_get tf-link" title="Select building"
                                   data-href="{!! route('tf.building.posts.edit.building-intro.get') !!}">
                                    <img class="tf-icon-30" alt="intro-building"
                                         src="{!! asset('public\main\icons\building.png') !!}">
                                </a>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right ">
                                <select name="cbRelationViewPostsEdit" class="btn btn-default btn-sm">
                                    <option value="1">Public</option>
                                </select>
                                <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
                                <input id="tf_building_post_edit_old_image" name="buildingPostEditOldImage" type="hidden"
                                       value="{!! $postImage !!}"/>
                                <input id="tf_building_post_edit_info" name="buildingPostEditInfo" type="hidden"
                                       value="{!! $postBuildingIntroId !!}"/>
                                <input id="tf_building_post_edit_image" style="display: none;"
                                       name="buildingPostEditImage" type="file">
                                <button type="button" class="tf_update btn btn-primary btn-sm tf-link-white">
                                    {!! trans('frontend.button_update') !!}
                                </button>
                                <button type="button" class="tf_main_contain_action_close btn btn-default btn-sm tf-link">
                                    {!! trans('frontend.button_close') !!}
                                </button>
                            </div>

                        </div>

                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
