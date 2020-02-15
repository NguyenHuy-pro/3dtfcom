<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/1/2016
 * Time: 9:26 AM
 */
?>
@extends('manage.build.components.contain-action-8')
@section('tf_m_build_action_content')
    <div class="panel panel-default tf-margin-padding-none">
        <div class="panel-heading">
            <h3 class="panel-title">Icon sample <em>(click to select)</em></h3>
        </div>
        <div class="panel-body">
            <form id="frmProjectIconEdit" name="frmProjectIconEdit" data-icon="{!!  $dataProjectIcon->iconId() !!}"
                  method="post"
                  role="form" action="{!! route('tf.m.build.project.icon.edit.post') !!}">
                <div class="form-group">
                    @if(count($dataProjectIconSample)> 0)
                        @foreach($dataProjectIconSample as $itemSample)
                            <div class="col-md-2">
                                <div class="text-center" style="width: 96px; height: 96px; background-color: green;">
                                    <img class="tf_m_build_project_icon_edit_sample" style="max-width: 100%;max-height: 100%;"
                                         data-sample="{!! $itemSample->sample_id !!}"
                                         src="{!! $itemSample->pathImage() !!}">
                                </div>
                            </div>
                        @endforeach
                    @else
                        not found
                    @endif
                </div>
                <div class="form-group">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                </div>
            </form>
        </div>
        <div class="panel-footer text-center">
            <button type="button" class="tf_m_build_contain_action_close btn btn-primary">Cancel</button>
        </div>
    </div>
@endsection
