<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 9/28/2016
 * Time: 10:49 AM
 *
 * $modelUser
 * $dataBuilding
 *
 *
 */

# login user
$dataUserLogin = $modelUser->loginUserInfo();
$loginUserId = $dataUserLogin->userId();

#building info
$buildingId = $dataBuilding->buildingId();
?>
@extends('components.container.contain-action-6')
@section('tf_main_action_content')
    <div class="panel panel-default tf-margin-none">
        <div class="panel-heading tf-bg tf-color-white ">
            <i class="fa fa-edit tf-font-size-14"></i>
            {!! trans('frontend_building.posts_form_content_title') !!}
        </div>
        <div class="panel-body">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                {{-- form post --}}
                <form id="tf_building_post_form" class="form-horizontal" data-building="{!! $buildingId !!}"
                      enctype="multipart/form-data" method="post"
                      action="{!! route('tf.building.posts.add.post', $buildingId) !!}">
                    <div class="form-group">
                        <textarea id="txtBuildingPostsContent" name="txtBuildingPostsContent"
                                  class="form-control txt_posts_content"
                                  rows="2" style="max-width: 100%;"></textarea>
                        <script type="text/javascript">ckeditor('txtBuildingPostsContent', false)</script>
                    </div>
                    {{-- begin multiple upload image--}}
                    <div id="tf_building_post_mul_image_add_wrap" class="tf-display-none form-group form-group-sm">
                        <div class="row">
                            <div class="tf-display-none col-xm-12 col-xs-12 col-ms-12 col-lg-12">
                                <input class="tf_building_post_mul_image_file" type="file"
                                       name="tf_building_post_mul_image_file[]" multiple="true">
                            </div>
                            <div class="col-xm-12 col-xs-12 col-ms-12 col-lg-12">
                                <div class="tf_building_post_mul_image_add_preview  tf-building-post-mul-image-add-preview " style="overflow-x: auto;"></div>
                            </div>
                        </div>
                    </div>
                    {{-- end multiple upload image--}}

                    {{-- begin introduction building--}}
                    <div id="tf_building_post_intro_view_wrap" class="form-group tf-display-none"
                         style="border: 1px solid #c2c2c2;">
                        <img id="tf_building_posts_intro_view" class="tf-icon-50" alt="posts-building"
                             src="{!! asset('public\main\icons\1.gif') !!}">
                        <i id="tf_building_posts_intro_cancel" class="tf-link fa fa-close pull-right tf-margin-10"></i>
                    </div>
                    {{-- end introduction building--}}
                    {{-- begin old upload--}}
                    <div id="tf_building_post_image_view_wrap" class="form-group tf-display-none">
                        <img id="tf_building_post_image_view" class="tf-cursor-pointer tf-icon-50" alt="image"
                             title="Click to cancel"/>
                        <i id="tf_building_post_image_cancel" class="tf-link-red fa fa-close tf-font-size-16"></i>
                    </div>
                    {{-- end old upload--}}
                    <div id="tf_building_post_action" class="form-group form-group-sm" style="margin-bottom: 0;">
                        <div class="row">
                            <div class="text-left col-xs-12  col-sm-6 col-md-6 col-lg-6">
                                {{-- multiple upload --}}
                                <a class="tf_building_post_mul_image_add tf-link">
                                    <img class="tf-icon-30" alt="upload-image"
                                         src="{!! asset('public\main\icons\Photograph.png') !!}">
                                </a>
                                &nbsp;&nbsp;
                                {{--<a class="tf-link" title="Upload image">
                                    <img class="tf_select_image tf-icon-30" alt="upload-image"
                                         src="{!! asset('public\main\icons\Photograph.png') !!}">
                                </a>
                                &nbsp;&nbsp;--}}
                                <a class="tf_posts_building_intro_get tf-link" title="Select building"
                                   data-href="{!! route('tf.building.posts.building-intro.get') !!}">
                                    <img class="tf-icon-30" alt="intro-building"
                                         src="{!! asset('public\main\icons\building.png') !!}">
                                </a>
                            </div>

                            <div class="text-right col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <select name="cbRelationViewPosts" class="btn btn-default btn-sm">
                                    {{--this version only develop function 'public' for posts--}}
                                    {{--default public = 1--}}
                                    <option value="1">Public</option>
                                </select>
                                <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
                                <input id="tf_building_post_info" name="buildingPostsInfo" type="hidden" value="0"/>
                                <input id="tf_building_post_image" style="display: none;" name="buildingPostsImage"
                                       type="file">
                                <button type="button" class="tf_publish btn btn-primary btn-sm tf-link-white">
                                    {!! trans('frontend.button_publish') !!}
                                </button>
                                <button type="button"
                                        class="tf_main_contain_action_close btn btn-default btn-sm tf-link">
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