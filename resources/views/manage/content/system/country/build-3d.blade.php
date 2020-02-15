<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 7/12/2016
 * Time: 9:26 AM
 *
 * dataUser
 * dataCountry
 * dataProvince
 *
 */
$hFunction = new Hfunction();


?>
@extends('manage.content.components.container.contain-action-8')
@section('tf_m_c_action_content')
    @if(!empty($dataProvince))
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            <h2 class="tf-margin-30">Select management personnel </h2>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <form id="frmCountryBuild3d" class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2" method="post" role="form"
                  action="{!! route('tf.m.c.system.country.build3d.post',$dataCountry->countryId()) !!}">
                <div class="form-group text-center">
                    (<em class="tf-color-red">You can not cancel when built, You click 'Accept' to build 3D</em>)
                </div>
                <div class="form-group">
                    <label class="control-label">Manager <span class="tf-color-red">*</span>:</label>
                    <select class="form-control" id="cbManager" name="cbManager">
                        <option value="">Select staff</option>
                        {!! $hFunction->option($dataStaff) !!}
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">Default province <span class="tf-color-red">*</span>:</label>
                    <select class="form-control" id="cbProvince" name="cbProvince">
                        <option value="">Select province</option>
                        {!! $hFunction->option($dataProvince) !!}
                    </select>
                </div>
                <div class="form-group text-center">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <button type="button" class="tf_save btn btn-primary">Accept</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                    <a href="{!! route('tf.m.c.system.country.list') !!}">
                        <button type="button" class="btn btn-default">Close</button>
                    </a>
                </div>
            </form>
        </div>
    @else
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center tf-padding-30">
            <h3>
                This country must exist the province
            </h3>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center tf-padding-30">
            <a href="{!! route('tf.m.c.system.country.list') !!}">
                <button type="button" class="btn btn-primary">Close</button>
            </a>
        </div>
    @endif
@endsection
