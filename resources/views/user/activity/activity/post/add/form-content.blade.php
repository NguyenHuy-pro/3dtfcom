<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 9/28/2016
 * Time: 10:49 AM
 *
 * modelUser
 * modelRelation
 * dataUserWall
 *
 *
 */

# login user
//$dataUserLogin = $modelUser->loginUserInfo();
//$loginUserId = $dataUserLogin->userId();


?>
@extends('components.container.contain-action-6')
@section('tf_main_action_content')
    <div class="panel panel-default tf-margin-none">
        <div class="panel-heading tf-bg tf-color-white ">
            <i class="fa fa-edit tf-font-size-14"></i>
            {!! trans('frontend_user.posts_form_content_title') !!}
        </div>
        <div class="panel-body">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                {{-- form post --}}
                <form class="tf_user_activity_post_form form-horizontal" enctype="multipart/form-data" method="post"
                      action="{!! route('tf.user.activity.form_post.post', $dataUserWall->userId()) !!}">
                    <div class="form-group">
                    <textarea id="txtUserActivityPostsContent" name="txtUserActivityPostsContent"
                              class="txt_posts_content form-control"
                              rows="2" style="max-width: 100%;"></textarea>
                        <script type="text/javascript">ckeditor('txtUserActivityPostsContent',false)</script>
                    </div>

                    <div id="tf_user_activity_post_image_view_wrap" class="form-group tf-display-none">
                        <img id="tf_user_activity_post_image_view" class="tf-cursor-pointer tf-icon-50" alt="image"
                             title="Click to cancel"/>
                        <i id="tf_user_activity_post_image_cancel" class="tf-link-red fa fa-close tf-font-size-16"></i>
                    </div>

                    <div id="tf_user_activity_post_action" class="form-group  ">
                        <div class="row">
                            <div class="text-left col-xs-12  col-sm-6 col-md-6 col-lg-6">
                                <a class="tf-link" title="Upload image">
                                    <img class="tf_select_image tf-icon-30" alt="upload-image"
                                         src="{!! asset('public\main\icons\Photograph.png') !!}">
                                </a>
                            </div>
                            <div class="text-right col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <select name="cbRelationViewPosts" class="btn btn-default btn-sm">
                                    {{--this version only develop function 'public' for posts--}}
                                    {{--default public = 1--}}
                                    <option value="{!! $modelRelation->publicRelationId() !!}">Public</option>
                                </select>
                                <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
                                <input id="tf_user_activity_post_image" style="display: none;"
                                       name="userActivityPostsImage"
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