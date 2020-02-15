<?php
/**
 *
 * Created by PhpStorm.
 * User: HUY
 * Date: 11/29/2016
 * Time: 1:31 PM
 *
 *
 * modelUser
 * dataBuildingShare
 * fromDate
 * toDate
 *
 *
 */
$hFunction = new Hfunction();
?>
@extends('components.container.contain-action-8')
@section('tf_main_action_content')
    <div class="tf_action_height_fix col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <table class="table">
            <tr>
                <th class="tf-font-size-20" colspan="2">
                    <i class="fa fa-list"></i>
                    {!! trans('frontend_user.seller_statistic_view_building_title') !!}
                    <button class="tf_main_contain_action_close btn btn-default btn-sm tf-link-red pull-right"
                            type="button">
                        {!! trans('frontend.button_close') !!}
                    </button>
                </th>
            </tr>
            <tr>
                <td class="tf-border-none text-right">
                    <em class="tf-text-under">{!! trans('frontend_user.seller_statistic_view_from_label') !!}: </em>
                    &nbsp; {!! $hFunction->dateFormatDMY($fromDate,'/') !!} &nbsp;&nbsp;
                    <em class="tf-text-under">{!! trans('frontend_user.seller_statistic_view_to_label') !!}: </em>
                    &nbsp; {!! $hFunction->dateFormatDMY($toDate,'/') !!}
                </td>
            </tr>
            <tr>
                <td class="tf-border-none">
                    <table class="table table-hover">
                        <tr>
                            <th class="tf-border-none">
                                {!! trans('frontend_user.seller_statistic_view_code_label') !!}
                            </th>
                            <th class="text-center tf-border-none">
                                {!! trans('frontend_user.seller_statistic_view_access_label') !!}
                            </th>
                            <th class="text-center tf-border-none">
                                {!! trans('frontend_user.seller_statistic_view_register_label') !!}
                            </th>
                            <th class="tf-border-none text-right">
                                {!! trans('frontend_user.seller_statistic_view_date_label') !!}
                            </th>
                        </tr>
                        @if(count($dataBuildingShare) > 0)
                            @foreach($dataBuildingShare as $buildingShare)
                                <tr>
                                    <td>
                                        {!! $buildingShare->shareCode() !!}
                                    </td>
                                    <td class="text-center">
                                        {!! $buildingShare->totalView() !!}
                                    </td>
                                    <td class="text-center">
                                        {!! $buildingShare->totalViewRegister() !!}
                                    </td>
                                    <td class="text-right">
                                        {!! $buildingShare->createdAt() !!}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4">
                                    {!! trans('frontend_user.seller_statistic_view_null_label') !!}
                                </td>
                            </tr>
                        @endif
                    </table>
                </td>
            </tr>
        </table>

    </div>
@endsection
