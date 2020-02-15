<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 7/15/2016
 * Time: 10:26 AM
 *
 *
 * modelProvince
 * dataProvince
 * areaId
 * dataStaff
 * dataProjectIconSample
 */

$hFunction = new Hfunction();

?>
@extends('manage.build.components.contain-action-8')
@section('tf_m_build_action_content')
    <form id="frmAreaOpenProject" name="frmAreaOpenProject" class="col-xs-8 col-sm-8 col-md-8 col-md-offset-2"
          method="post" role="form"
          data-area="{!! $areaId !!}"
          data-province="{!! $dataProvince->provinceId() !!}"
          action="{!! route('tf.m.build.project.add.post') !!}">
        <div class="form-group text-center">
            <h3>Info project</h3>
        </div>
        <div class="form-group">
            <label class="control-label">Manager <span class="tf-color-red">*</span>:</label>
            <select class="form-control" id="cbStaffManager" name="cbStaffManager">
                <option value="">Select staff</option>
                {!! $hFunction->option($dataStaff) !!}
            </select>
        </div>
        <div class="form-group">
            <label class="control-label">Name<span class="tf-color-red">*</span>:</label>
            <input id="txtName" class="form-control" data-href="{!! route('tf.m.build.project.add.name.check') !!}"
                   name="txtName" title="you can change name"
                   value="{!! $dataProvince->name().'-project-'.$areaId !!}">
        </div>
        <div class="form-group">
            <label class="control-label">Icon <span class="tf-color-red">*</span>:</label>
            <table class="tf-m-build-icon-wrap form-control tf-overflow-auto"
                   style="height: 100px; background-color: #d7d7d7;">
                @foreach($dataProjectIconSample as $itemIcon)
                    <tr>
                        <td class="col-md-4">
                            <input type="radio" name="radIconSample" value="{!! $itemIcon->sampleId() !!}">
                        </td>
                        <td class="col-md-8">
                            <img class="tf-img-100"
                                 src="{!! $itemIcon->pathImage() !!}">
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="form-group">
            <label class="control-label">Short description:</label>
            <input id="txtShortDescription" class="form-control" name="txtShortDescription">
        </div>
        <div class="form-group">
            <label class="control-label">Transaction_status <span class="tf-color-red">*</span>:</label>
            <select class="form-control" id="cbTransactionStatus" name="cbTransactionStatus">
                <option value="3">Normal</option>
            </select>
        </div>
        <div class="form-group text-center">
            <input id="frmAreaOpenProject_token" type="hidden" name="_token" value="{!! csrf_token() !!}">
            <button type="button" class="tf_m_build_project_add_post btn btn-primary">Open</button>
            <button type="button" class="tf_m_build_contain_action_close btn btn-default">Cancel</button>
        </div>
    </form>
@endsection