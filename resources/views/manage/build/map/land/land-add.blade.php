<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 7/25/2016
 * Time: 11:36 AM
 */
$hFunction = new Hfunction();
?>
@extends('manage.build.components.contain-action-8')
@section('tf_m_build_action_content')
    <form id="frmBuildLandAdd" name="frmBuildLandAdd" class="col-md-8 col-md-offset-2" method="post" role="form"
          action="{!! route('tf.m.build.land.add.get') !!}">
        <div class="form-group text-center">
            <h3>Add land</h3>
        </div>
        {{--rule info--}}
        <div class="form-group">
            <label class="control-label">Rule:</label>
            <table class="table">
                <tr>
                    <td class="text-center">Size(px)</td>
                    <td class="text-center">Price (Point)</td>
                    <td class="text-center">Sale (month)</td>
                    <td class="text-center">Free (month)</td>
                </tr>
                <tr>
                    <td class="text-center">
                        {!! $dataLandRule->size->name() !!}
                    </td>
                    <td class="text-center">
                        {!! $dataLandRule->salePrice() !!}
                    </td>
                    <td class="text-center">
                        {!! $dataLandRule->saleMonth() !!}
                    </td>
                    <td class="text-center">
                        {!! $dataLandRule->freeMonth() !!}
                    </td>
                </tr>
            </table>
        </div>
        {{--only apply for sale status and free status--}}
        <div class="form-group">
            <label class="control-label">Transaction status <span class="tf-color-red">*</span>:</label>
            <select class="form-control" id="cbTransactionStatus" name="cbTransactionStatus">
                {!! $hFunction->option($dataLandAdd['dataTransactionStatus'],2) !!}
            </select>
        </div>
        <div class="form-group text-center">
            <input id="frmAreaOpenProject_token" type="hidden" name="_token" value="{!! csrf_token() !!}">
            <input type="hidden" id="txtProject" name="txtProject" value="{!! $dataProject->projectid() !!}">
            <input type="hidden" id="txtSize" name="txtSize" value="{!! $dataSize->sizeId() !!}">
            <input type="hidden" id="txtTopPosition" name="txtTopPosition" value="{!! $dataLandAdd['topPosition'] !!}">
            <input type="hidden" id="txtLeftPosition" name="txtLeftPosition"
                   value="{!! $dataLandAdd['leftPosition'] !!}">
            <button type="button" class="tf_m_build_land_add_post btn btn-primary">Add</button>
            <button type="button" class="tf_m_build_contain_action_close btn btn-default">Cancel</button>
        </div>
    </form>
@endsection
