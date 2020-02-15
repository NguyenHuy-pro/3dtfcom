<?php
/*
 *modelAbout
 *modelUser
 *name
 *
 */

$dataAbout = $modelAbout->defaultInfo();
#about info
if (count($dataAbout) > 0) {
    $metaKeyword = $dataAbout->metaKeyword();
    $metaDescription = $dataAbout->metaDescription();

} else {
    $metaKeyword = null;
    $metaDescription = null;
}

?>

@extends('system.index')
{{--develop seo--}}
@section('metaKeyword'){!! $metaKeyword !!}@endsection

@section('metaDescription'){!! $metaDescription !!}@endsection

@section('tf_system_content')
    <div class="tf_system_contact col-xs-12 col-sm-12 col-md-12">
        @if(!$modelUser->checkLogin())
            <div class="row">
                <div class="col-xs-12 col-sm-10 col-sm-offset-1  col-md-10 col-lg-offset-1 text-center tf-padding-50">
                    <span class="tf-em-1-5">
                        You must login to send contact
                    </span>
                </div>
            </div>
        @else
            <div class="row">
                <form class="tf_system_contact_form col-xs-12 col-sm-10 col-sm-offset-1  col-md-10 col-lg-offset-1"
                      enctype="multipart/form-data"
                      method="POST"
                      action="{!! route('tf.system.contact.add.post') !!}">
                    <div class="form-group">
                        <label>Content <i class="tf-color-red">*</i>:</label>
                        <textarea class="form-control" name="txtContent" rows="10"></textarea>
                    </div>
                    <div class="form-group">
                        <em>We can contact you by information:</em>
                    </div>
                    <div class="form-group">
                        <label>Name :</label>
                        <input class="form-control" name="txtName" placeholder="Contact name"/>
                    </div>
                    <div class="form-group">
                        <label>Email :</label>
                        <input class="form-control" name="txtEmail" placeholder="Contact email"/>
                    </div>
                    <div class="form-group">
                        <label>Phone :</label>
                        <input class="form-control" name="txtPhone" placeholder="Contact phone"/>
                    </div>
                    <div class="form-group text-center">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
                        <button type="button" class="tf_system_contact_add btn btn-primary">Send</button>
                        <button type="reset" class="btn btn-default">Reset</button>

                    </div>
                </form>
            </div>
        @endif
    </div>
@endsection