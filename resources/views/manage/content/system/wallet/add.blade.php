<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 */
$hObject = new Hfunction();
?>
@extends('manage.content.system.index')
@section('tf_m_c_content_system')
    <div class="col-md-12 text-center">
        <h3 class="tf-margin-30">Add wallet </h3>
    </div>
    <div class="col-md-12">
        <form class="col-md-8 col-md-offset-2" method="post" role="form" action="{!! route('tf.m.c.system.wallet.postAdd') !!}">
            <div class="form-group">
                <label class="control-label">Name <span class="tf-color-red">*</span>:</label>
                <input type="text" class="form-control" id="txtName" name="txtName" placeholder="Enter name">
            </div>
            <div class="form-group">
                <label class="control-label">Logo <span class="tf-color-red">*</span>:</label>
                <?php
                $hObject->selectOneImage('txtLogo','txtLogo');
                ?>
            </div>
            <div class="form-group">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <button type="submit" class="btn btn-default">Save</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{!! route('tf.m.c.system.wallet.getList') !!}">
                    <button type="button" class="btn btn-default">Close</button>
                </a>
            </div>
        </form>
    </div>
@endsection
@section('tf_m_js_page_footer')
    <script src="{{ url('public/manage/content/system/js/wallet.js')}}"></script>
@endsection