<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 11/24/2016
 * Time: 3:53 PM
 */
$hFunction = new Hfunction();
?>
@extends('components.container.contain-action-6')
@section('tf_main_action_content')
    <div class="col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 tf-padding-top-50 tf-padding-bot-50">
        <form id="frmUserAvatarEdit" name="frmUserAvatarEdit" class="frm_user_avatar_edit form-horizontal" role="form"
              method='post' enctype="multipart/form-data" action="{!! route('tf.user.title.avatar.edit.post') !!}">
            <div class="form-group">

            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">
                    Select image:
                </label>

                <div class="col-md-8">
                    <?php
                    $hFunction->selectOneImage('avatarImage', 'avatarImage');
                    ?>
                </div>
            </div>
            <div class="form-group text-center">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
                <input class="tf_avatar_edit_post btn btn-primary tf-link-white " type="button" name="save" value="Save"/>
                <input class="tf_main_contain_action_close btn btn-default tf-link" type="button" value="Close"/>
            </div>
        </form>
    </div>
@endsection
