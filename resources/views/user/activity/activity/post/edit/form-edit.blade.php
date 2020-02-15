<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/6/2016
 * Time: 11:15 AM
 */
$userWallId = $dataUserPost->userWallId();
$postId = $dataUserPost->postId();
$userPostId = $dataUserPost->userPostId();
$postContent = $dataUserPost->content();
$postImage = $dataUserPost->image();

#image
if (empty($postImage)) {
    $srcView = asset('public\main\icons\1.gif');
} else {
    $srcView = $dataUserPost->pathSmallImage();
}

?>
@extends('components.container.contain-action-6')
@section('tf_main_action_content')
    <div class="panel panel-default tf-margin-none">
        <div class="panel-heading tf-bg tf-color-white ">
            <i class="fa fa-edit tf-font-size-14"></i>
            Edit info
        </div>
        <div class="panel-body">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-12">
                <form id="tf_user_activity_post_edit_form" name="tf_user_activity_post_edit_form" class="form-horizontal"
                      enctype="multipart/form-data" method="post" data-post="{!! $postId !!}"
                      action="{!! route('tf.user.activity.post.edit.post', $postId) !!}">
                    <div class="tf_notify form-group text-center tf-color-red"></div>
                    <div class="form-group">
                        <textarea name="txtUserActivityPostsContent" class="form-control" rows="7"
                                  style="max-width: 100%;">{!! $postContent !!}</textarea>
                        <script type="text/javascript">ckeditor('txtUserActivityPostsContent', false)</script>
                    </div>

                    <div id="tf_user_activity_post_edit_image_view_wrap"
                         class="form-group  @if(empty($postImage)) tf-display-none @endif">
                        <img id="tf_user_activity_post_edit_image_view" class="tf-cursor-pointer tf-icon-50" alt="image"
                             title="Click to cancel" src="{!! $srcView !!}"/>
                        <i id="tf_user_activity_post_image_cancel" class="tf-link-red fa fa-close tf-font-size-16"></i>
                    </div>

                    <div id="tf_user_activity_post_edit_action" class="form-group">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-left">
                                <a class="tf-link" title="Upload image">
                                    <img class="tf_select_image tf-icon-30" alt="upload-image"
                                         src="{!! asset('public\main\icons\Photograph.png') !!}">
                                </a>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right ">
                                <select name="cbRelationViewPost" class="btn btn-default btn-sm">
                                    {{--this version only develop function 'public' for posts--}}
                                    {{--default public = 1--}}
                                    <option value="{!! $dataUserPost->viewRelationId() !!}">Public</option>
                                </select>
                                <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
                                <input id="tf_user_activity_post_edit_old_image" name="userActivityPostEditOldImage" type="hidden"
                                       value="{!! $postImage !!}"/>
                                <input id="tf_user_activity_post_edit_image" style="display: none;"
                                       name="userActivityPostEditImage" type="file">
                                <button type="button" class="tf_save btn btn-primary btn-sm tf-link-white">
                                    {!! trans('frontend.button_save') !!}
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
