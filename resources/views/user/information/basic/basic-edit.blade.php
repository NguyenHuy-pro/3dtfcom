@extends('components.container.contain-action-6')
@section('tf_main_action_content')
    <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1">
        <form id="tfUserFrmBasicEdit" name="tfUserFrmBasicEdit" class="tf_user_frm_basic_edit form-horizontal "
              role="form" method='post' enctype="multipart/form-data"
              action="{!! route('tf.user.info.basic.edit.post') !!}">
            <div class="form-group text-center">
                <h3>{!! trans('frontend_user.info_basic_edit_title') !!}</h3>
            </div>
            <div class="form-group">
                <label>{!! trans('frontend_user.info_basic_edit_label_first_name') !!}</label>
                <input class="form-control" type="text" name="txtFirstName" value="{!! $dataUser->firstName() !!}">
            </div>
            <div class="form-group">
                <label>{!! trans('frontend_user.info_basic_edit_label_last_name') !!}</label>
                <input class="form-control" type="text" name="txtLastName" value="{!! $dataUser->lastName() !!}">
            </div>
            <div class="form-group">
                <label>{!! trans('frontend_user.info_basic_edit_label_birthday') !!}</label>
                <input id="txtBirthday" class="form-control" type="text" name="txtBirthday"
                       value="{!! $dataUser->birthday() !!}"/>
                <script type="text/javascript">
                    tf_main.tf_setDatepicker('#txtBirthday');
                </script>
            </div>
            <div class="form-group">
                <label>{!! trans('frontend_user.info_basic_edit_label_gender') !!}</label>
                <select class="form-control" name="cbGender">
                    <option value="0" @if($dataUser->gender() == 0) selected="selected" @endif >
                        {!! trans('frontend_user.info_basic_edit_label_male') !!}
                    </option>
                    <option value="1" @if($dataUser->gender() == 1) selected="selected" @endif >
                        {!! trans('frontend_user.info_basic_edit_label_female') !!}
                    </option>
                </select>
            </div>
            <div class="form-group text-center">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
                <button class="tf_basic_save btn btn-primary" type="button">
                    {!! trans('frontend.button_save') !!}
                </button>
                <button class="tf_page_reload btn btn-default" type="button">
                    {!! trans('frontend.button_cancel') !!}
                </button>
            </div>

        </form>
    </div>
@endsection