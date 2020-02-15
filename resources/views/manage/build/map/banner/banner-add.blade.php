<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 7/30/2016
 * Time: 10:29 AM
 */

$hFunction = new Hfunction();
?>
@extends('manage.build.components.contain-action-8')
@section('tf_m_build_action_content')
    <form id="frmBuildBannerAdd" name="frmBuildBannerAdd" class="col-md-8 col-md-offset-2" method="post" role="form"
          action="{!! route('tf.m.build.banner.add.post') !!}">
        <div class="form-group text-center">
            <h3>Add banner</h3>
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
                        {!! $dataBannerRule->size->name() !!}
                    </td>
                    <td class="text-center">
                        {!! $dataBannerRule->salePrice() !!}
                    </td>
                    <td class="text-center">
                        {!! $dataBannerRule->saleMonth() !!}
                    </td>
                    <td class="text-center">
                        {!! $dataBannerRule->freeMonth() !!}
                    </td>
                </tr>
            </table>
        </div>
        {{--only apply for sale status and free status--}}
        <div class="form-group">
            <label class="control-label">Transaction status <span class="tf-color-red">*</span>:</label>
            <select class="form-control" id="cbTransactionStatus" name="cbTransactionStatus">
                {!! $hFunction->option($dataBannerAdd['dataTransactionStatus'],2) !!}
            </select>
        </div>

        <div class="form-group text-center">
            <input id="frmAreaOpenProject_token" type="hidden" name="_token" value="{!! csrf_token() !!}">
            <input type="hidden" id="txtProject" name="txtProject" value="{!! $dataProject->projectId() !!}">
            <input type="hidden" id="txtBannerSample" name="txtBannerSample"
                   value="{!! $dataBannerSample->sampleId() !!}">
            <input type="hidden" id="txtTopPosition" name="txtTopPosition"
                   value="{!! $dataBannerAdd['topPosition'] !!}">
            <input type="hidden" id="txtLeftPosition" name="txtLeftPosition"
                   value="{!! $dataBannerAdd['leftPosition'] !!}">
            <button type="button" class="tf_m_build_banner_add_post btn btn-primary">Add</button>
            <button type="button" class="tf_m_build_contain_action_close btn btn-default">Cancel</button>
        </div>
    </form>
@endsection
