<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/5/2016
 * Time: 9:34 AM
 */
?>
@extends('manage.build.components.contain-action-6')
@section('tf_m_build_action_content')
    <form id="frmProjectPublish" name="frmProjectPublish" class="col-md-8 col-md-offset-2" method="post" role="form"
          onsubmit="" action="{!! route('tf.m.build.project.publish.yes.post') !!}">
        <div class="form-group"></div>
        <div class="form-group text-center">
            Publish later
            <select id="cbPublishDay" name="cbPublishDay">
                @for($i = 0; $i <= 30; $i++)
                    <option value="{!! $i !!}">{!! $i !!}</option>
                @endfor
            </select>
            Days.
        </div>
        <div class="form-group text-center">
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <input type="hidden" id="txtProjectPublish" name="txtProjectPublish" value="{!! $projectId !!}">
            <input type="hidden" id="txtPublish" name="txtPublish" value="{!! $buildId !!}">
            <a class="tf-m-build-project-publish-yes-a btn btn-primary">Open</a>
            <button type="button" class="tf_m_build_contain_action_close btn btn-default">Cancel</button>
        </div>
    </form>
@endsection
