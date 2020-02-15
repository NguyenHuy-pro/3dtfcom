@extends('components.container.contain-action-6')
@section('tf_main_action_content')
    <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1">
        <form name="tfUserFrmContactEdit" class="tf_user_frm_pass_edit form-horizontal"
              role="form" method='post' enctype="multipart/form-data"
              action="{!! route('tf.user.info.password.edit.post') !!}">
            <div class="form-group text-center">
                <h3>{!! trans('frontend_user.info_account_edit_title') !!}</h3>
            </div>
            <div class="form-group">
                <label>{!! trans('frontend_user.info_account_edit_label_old_pass') !!}</label>
                <input class="form-control" type="password" name="txtOldPassword" value="">
            </div>
            <div class="form-group">
                <label>{!! trans('frontend_user.info_account_edit_label_new_pass') !!}</label>
                <input class="form-control" type="password" name="txtNewPassword" value="">
            </div>
            <div class="form-group">
                <label>{!! trans('frontend_user.info_account_edit_label_confirm_pass') !!}</label>
                <input class="form-control" type="password" name="txtConfirmPassword" value="">
            </div>
            <div class="form-group text-center">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
                <button class="tf_pass_save btn btn-primary" type="button">
                    {!! trans('frontend.button_save') !!}
                </button>
                <button class="tf_main_contain_action_close btn btn-default" type="button">
                    {!! trans('frontend.button_cancel') !!}
                </button>
            </div>
        </form>
    </div>

@endsection