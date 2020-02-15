<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 *
 * modelAdsBanner
 * modelAdsPosition
 */

$hFunction = new Hfunction();
$title = 'Add banner';
$adsStandardHeight = [50, 60, 90, 100, 120, 125, 150, 180, 200, 250, 240, 280, 300, 360, 400, 600, 1050];
?>
@extends('manage.content.ads.banner.index')
@section('tf_m_c_container_object')
    <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        <h3 class="tf-margin-30">{!! $title !!}</h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <form class="tf_frm_add col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2 "
              name="tf_frm_add"
              method="post" role="form" action="{!! route('tf.m.c.ads.banner.add.post') !!}">
            @if (Session::has('notifyAdsBanner'))
                <div class="form-group text-center tf-color-red">
                    {!! Session::get('notifyAdsBanner') !!}
                    <?php
                    Session::forget('notifyAdsBanner');
                    ?>
                </div>
            @endif
            <div class="form-group">
                <label class="control-label">Page <span class="tf-color-red">*</span>:</label>
                <select name="cbPage" class="form-control">
                    <option value="0">Select page</option>
                    {!! $modelAdsPage->getOption() !!}
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Position <span class="tf-color-red">*</span>:</label>
                <select name="cbPosition" class="tf_position form-control"
                        data-href="{!! route('tf.m.c.ads.banner.add.width.get') !!}">
                    <option value="0">Select position</option>
                    {!! $modelAdsPosition->getOption() !!}
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Image size (W / H) <span class="tf-color-red">*</span>:</label>
                <button class="tf_display_width tf-padding-lef-20 tf-padding-rig-20 text-center" type="button">0
                </button>
                &nbsp;x &nbsp;
                <select name="cbHeight" class="tf_height text-center">
                    <option value="0">Select height</option>
                    @foreach($adsStandardHeight as $value)
                        <option value="{!! $value !!}">
                            {!! $value !!}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Price <span class="tf-color-red">*</span>:</label>
                <select name="cbShow" class="text-center">
                    <option value="0">Select number</option>
                    @for($i=10 ; $i <= 10000; $i = $i+10)
                        <option value="{!! $i !!}">
                            {!! $i !!}
                        </option>
                    @endfor
                </select>
                display &nbsp; / &nbsp; 1 point
            </div>
            <div class="form-group">
                <label class="control-label">Icon:</label>
                <?php
                $hFunction->selectOneImage('imageFile', 'imageFile');
                ?>
            </div>
            <div class="form-group text-center">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <button type="button" class="tf_save btn btn-primary">Save</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{!! route('tf.m.c.ads.banner.list') !!}">
                    <button type="button" class="btn btn-default">Close</button>
                </a>
            </div>
        </form>
    </div>
@endsection
