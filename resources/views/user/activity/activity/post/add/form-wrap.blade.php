<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 9/28/2016
 * Time: 10:49 AM
 *
 * $modelUser
 * dataUser
 *
 *
 */
?>
<div class="row">
    <div id="tf_user_activity_post_form_wrap" class="panel panel-default tf-user-activity-posts-form-wrap">
        <div class="panel-heading tf-bg-none">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <i class="fa fa-comment-o tf-font-size-14"></i>
                    {!! trans('frontend_user.wall_post_frm_title') !!}
                </div>
            </div>
        </div>

        <div class="panel-body">
            <a class="tf_get_form_content tf-link-grey" data-user="{!! $dataUser->userId() !!}"
               data-href="{!! route('tf.user.activity.form_post.get') !!}">
                {!! trans('frontend_user.wall_post_frm_input_label') !!}
            </a>
        </div>
    </div>
</div>
