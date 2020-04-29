<?php
/*
 *
 * modelAbout
 */
$hFunction = new Hfunction();
#about info
$dataAbout = $modelAbout->defaultInfo();
if (count($dataAbout) > 0) {
    $metaKeyword = $dataAbout->metaKeyword();
    $metaDescription = $dataAbout->metaDescription();

} else {
    $metaKeyword = null;
    $metaDescription = null;
}
?>
@extends('master')

{{--develop seo--}}
@section('metaKeyword'){!! $metaKeyword !!}@endsection
@section('metaDescription'){!! $metaDescription !!}@endsection

@section('titlePage')
    Register
@endsection

@section('shortcutPage')
    <link rel="shortcut icon" href="{!! asset('public/main/icons/3dlogo128.png') !!}"/>
@endsection

{{--css--}}
@section('tf_master_page_css')
    <link href="{{ url('public/register/css/register.css')}}" rel="stylesheet">
@endsection

{{--========== ========= header content ========= ========== --}}
{{--left header--}}
@section('tf_main_header_Left')
    {{--search--}}
    @include('components.search.search-form')
@endsection

{{--========== ========= main content ========= ========== --}}

@section('tf_main_content')
    <div class="tf-register-wrapper col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="row">
            <div class="container tf-padding-top-30 tf-padding-bot-50">
                <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <h4>{!! trans('frontend.register_title') !!}</h4>
                    </div>
                    <form id="frmMainRegister" name="frmMainRegister" role="form" method='post'
                          enctype='multipart/form-data'
                          action="{!! route('tf.register.post') !!}">
                        <div class="tf-padding-bot-20 col-xs-12 col-sm-8 col-md-9 col-lg-9">
                            <div class="form-group" style="border-top: 5px solid #D7D7D7;"></div>
                            @if (Session::has('notifyAddUser'))
                                <div class="form-group text-center tf-color-red">
                                    {!! Session::get('notifyAddUser') !!}
                                    <?php
                                    Session::forget('notifyAddUser');
                                    ?>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>
                                            {!! trans('frontend.register_label_first_name') !!} <span
                                                    class="tf-color-red">*</span>:
                                        </label>
                                        <input id="txtFirstName" class="form-control" type="text" name="txtFirstName"/>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>
                                            {!! trans('frontend.register_label_last_name') !!} <span
                                                    class="tf-color-red">*</span>:
                                        </label>
                                        <input class="form-control" type="text" name="txtLastName" value=""/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>
                                    {!! trans('frontend.register_label_birthday') !!} <span
                                            class="tf-color-red">*</span>:
                                </label>
                                <input id="txtBirthday" class="form-control" name="txtBirthday" value=""/>
                                <script type="text/javascript">
                                    tf_main.tf_setDatepicker('#txtBirthday');
                                    $('#txtBirthday').focus();
                                </script>
                            </div>
                            <div class="form-group">
                                <label>
                                    {!! trans('frontend.register_label_account') !!} <span class="tf-color-red">*</span>
                                    :
                                </label>
                                <input class="form-control" type="text" name="txtAccount"
                                       placeholder="{!! trans('frontend.register_input_account_placeholder') !!}"/>
                            </div>
                            <div class="form-group">
                                <label>
                                    {!! trans('frontend.register_label_password') !!} <span
                                            class="tf-color-red">*</span> :
                                </label>
                                <input class="form-control" type="password" name="txtPassword"/>
                            </div>
                            <div class="form-group">
                                <label>
                                    {!! trans('frontend.register_label_confirm_password') !!} <span
                                            class="tf-color-red">*</span> :
                                </label>
                                <input class="form-control" type="password" name="txtPasswordConfirm"/>
                            </div>
                            <div class="form-group">
                                <label>
                                    {!! trans('frontend.register_label_gender') !!} <span class="tf-color-red">*</span>
                                    :
                                </label>
                                <select class="form-control" name="txtGender">
                                    <option value="0">Male</option>
                                    <option value="1">Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-4 col-md-2 col-lg-2 ">
                                    {!! trans('frontend.register_label_avatar')  !!}:
                                </label>
                                <div class="col-xs-12 col-sm-8 col-md-10 col-lg-10">
                                    <?php
                                    $hFunction->selectOneImage('txtImage', 'txtImage');
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                            <div class="form-group tf-padding-top-10 " style="border-top: 5px solid #D7D7D7">
                                <label>or Sign up</label>
                                {{--<br/>
                                <a class="btn btn-default tf-link-full tf-link-hover-white tf-bg-hover text-center"
                                   style="border-color: blue;" href="{!! route('tf.register.facebook.get') !!}">
                                    Facebook
                                </a>--}}
                                <br/>
                                <a class="btn btn-default tf-link-full tf-link-hover-white tf-bg-hover text-center"
                                   style="border-color: orangered;" href="{!! route('tf.register.google.get') !!}">
                                    Google +
                                </a>
                            </div>

                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>
                                    <input name="confirmReadRule" type="checkbox"> I have read and agree
                                    to <a href="{!! route('tf.help') !!}" target="_blank">the Terms</a> of 3DTF.COM
                                </label>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group text-center">
                                <input type="hidden" name="reserveObjectName" value="{!! $fromObject !!}"/>
                                <input type="hidden" name="reserveObjectID" value="{!! $fromObjectId !!}"/>
                                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                <input class="tf_save btn btn-primary" type="button" name="register"
                                       value="{!! trans('frontend.button_register') !!}"/>
                                <input class="btn btn-default" type="reset" name="reset"
                                       value="{!! trans('frontend.button_reset') !!}"/>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

{{--=========== ========== Footer map =========== =========--}}
@section('tf_main_footer')
    @include('components.footer.footer')
@endsection

@section('tf_master_page_js_footer')
    <script type="text/javascript" src="{!! asset('public/register/js/register.js') !!}"></script>
@endsection