<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/18/2016
 * Time: 9:39 AM
 */
/*
 * dataProvince
 */
$provinceId = $dataProvince->provinceId();

#propery info
$dataProperty = $dataProvince->propertyInfo($provinceId);
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="panel panel-default tf-margin-bot-none">
        <div class="panel-heading tf-bg tf-color-white">
            <i class="fa fa-eye"></i>
            Province 3D detail
            <button class="btn btn-primary btn-xs tf_m_c_container_close pull-right">Close</button>
        </div>
        <div class="panel-body">
            <table class="table table-bordered tf-border-none">
                <tr>
                    <td colspan="4" class="text-right tf-border-top-none">
                        <i class="fa fa-calendar"></i>&nbsp;
                        <span style="color: black;">{!! $dataProvince->createdAt() !!}</span>
                    </td>
                </tr>
                <tr>
                    <td class="col-xs-4 col-sm-3 col-md-2 col-lg-2 text-right">
                        <em>Name</em>
                    </td>
                    <td colspan="3" class="col-xs-8 col-sm-9 col-md-10 col-lg-10">
                        <b>{!! $dataProvince->name() !!}</b>
                    </td>
                </tr>
                <tr>
                    <td class="text-right">
                        <em>Province type</em>
                    </td>
                    <td >
                        {!! $dataProvince->provinceType->name() !!}
                    </td>
                    <td class="text-right">
                        <em>Default</em>
                    </td>
                    <td >
                        @if($dataProvince->defaultCenter() == 0)
                            Normal
                        @else
                            Center
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="text-right">
                        <em>Country</em>
                    </td>
                    <td >
                        {!! $dataProvince->country->name() !!}
                    </td>
                    <td class="text-right">
                        <em>Manager</em>
                    </td>
                    <td>
                        {!! $dataProperty->staff->fullName() !!}
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endsection