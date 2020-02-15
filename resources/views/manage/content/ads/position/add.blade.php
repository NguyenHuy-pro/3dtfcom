<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 */

$title = 'Add position';
$adsStandard = [120, 125, 160, 180, 200, 234, 250, 300, 320, 366, 468, 580, 728, 750, 930, 970, 980];
?>
@extends('manage.content.ads.position.index')
@section('tf_m_c_container_object')
    <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        <h3 class="tf-margin-30">{!! $title !!}</h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <form class="tf_frm_add col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2 "
              name="tf_frm_add"
              method="post" role="form" action="{!! route('tf.m.c.ads.position.add.post') !!}">
            @if (Session::has('notifyAdsPosition'))
                <div class="form-group text-center tf-color-red">
                    {!! Session::get('notifyAdsPosition') !!}
                    <?php
                    Session::forget('notifyAdsPosition');
                    ?>
                </div>
            @endif
            <div class="form-group">
                <label class="control-label">Name <span class="tf-color-red">*</span>:</label>
                <input type="text" class="form-control" name="txtName" placeholder="Enter name">
            </div>
            <div class="form-group">
                <label class="control-label">Width size <span class="tf-color-red">*</span>:</label>
                <select name="cbWidth" class="form-control">
                    <option value="0">Select width</option>
                    @foreach($adsStandard as $value)
                        <option value="{!! $value !!}">
                            {!! $value !!}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group text-center">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <button type="button" class="tf_save btn btn-primary">Save</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{!! route('tf.m.c.ads.position.list') !!}">
                    <button type="button" class="btn btn-default">Close</button>
                </a>
            </div>
        </form>
    </div>
@endsection
