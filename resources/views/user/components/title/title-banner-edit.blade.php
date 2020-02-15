<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 9/27/2016
 * Time: 11:48 AM
 */
$hFunction = new Hfunction();
?>
@extends('components.container.contain-action-6')
@section('tf_main_action_content')
    <div class="tf-padding-top-50 tf-padding-bot-50 col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1 ">
        <form id="frmUserBannerEdit" name="frmUserBannerEdit" class="frm_user_banner_edit form-horizontal" role="form"
              method='post' enctype="multipart/form-data" action="{!! route('tf.user.title.banner.edit.post') !!}">
            <div class="form-group">

            </div>
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4 ">
                    Select image:
                </label>
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <?php
                    $hFunction->selectOneImage('bannerImage', 'bannerImage');
                    ?>
                </div>
            </div>
            <div class="form-group text-center">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
                <button type="button" class="tf_banner_edit_post tf-link-white btn btn-primary"  name="agree">
                    {!! trans('frontend.button_agree') !!}
                </button>
                <button type="button" class="tf_main_contain_action_close tf-link btn btn-default">
                    {!! trans('frontend.button_close') !!}
                </button>
            </div>
        </form>
    </div>
@endsection
