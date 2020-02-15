<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/27/2016
 * Time: 11:12 AM
 */
?>
@extends('manage.content.master')
@section('tf_m_c_titlePage')
    System
@endsection
@section('tf_m_c_content')
    <div class="row">
        <div class="col-md-12" style="min-height: 1000px;">
            <form class="tf_frm_system_staff_confirm col-md-6 col-md-offset-3" name="frmStaffConfirm" method="POST"
                  role="form" action="{!! route('tf.m.c.system.staff.account.confirm.post') !!}">
                <div class="form-group text-center">
                    <h3>Verification</h3>
                </div>
                @if (Session::has('notifyConfirmStaff'))
                    <div class="form-group text-center tf-color-red">
                        {!! Session::get('notifyConfirmStaff') !!}
                        <?php
                        Session::forget('notifyConfirmStaff');
                        ?>
                    </div>
                @endif
                <div class="form-group">
                    <label class="control-label">Your account <span class="tf-color-red">*</span>:</label>
                    <input type="email" class="form-control" name="txtAccount" placeholder="Enter your email">
                </div>

                <div class="form-group">
                    <label class="control-label">Code <span class="tf-color-red">*</span>:</label>
                    <input type="text" class="form-control" name="txtVerificationCode"
                           placeholder="Enter verification code">
                </div>
                <div class="form-group">
                    <label class="control-label">New password <span class="tf-color-red">*</span>:</label>
                    <input type="password" class="form-control" name="txtPassword" placeholder="Enter password">
                </div>
                <div class="form-group">
                    <label class="control-label">Confirm password <span class="tf-color-red">*</span>:</label>
                    <input type="password" class="form-control" name="txtConfirmPassword"
                           placeholder="Enter confirm password">
                </div>
                <div class="form-group text-center">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <button type="button" class="tf_send btn btn-default">Send</button>
                    <a href="{!! route('tf.m.login.get') !!}">
                        <button type="button" class="btn btn-default">Close</button>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('tf_m_js_page_footer')
    <script src="{{ url('public/manage/content/system/staff/js/staff.js')}}"></script>
@endsection