<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/18/2016
 * Time: 9:39 AM
 */
/*
 * modelTransactionStatus
 * dataLand
 */

#land info
$landId = $dataLand->landId();

#license info
$dataLandLicense = $dataLand->licenseInfo();

?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="panel panel-default tf-margin-bot-none">
        <div class="panel-heading tf-bg tf-color-white">
            <i class="fa fa-eye"></i>
            Land detail
            <button class="btn btn-primary btn-xs tf_m_c_container_close pull-right">Close</button>
        </div>
        <div class="panel-body">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                <i class="fa fa-calendar"></i>&nbsp;
                <span style="color: black;">{!! $dataLand->createdAt() !!}</span>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 tf-padding-20">
                    <table class="table table-bordered tf-border-none">
                        <tr>
                            <td colspan="2" class="tf-border-none">
                                <label>Land info</label>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-2 text-right">
                                <em>Name</em>
                            </td>
                            <td class="col-md-10">
                                {!! $dataLand->name !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-2 text-right">
                                <em>Project</em>
                            </td>
                            <td class="col-md-10">
                                {!! $dataLand->project->name !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-2 text-right">
                                <em>Publish</em>
                            </td>
                            <td class="col-md-10">
                                @if($dataLand->publish == 1)
                                    Published
                                @else
                                    Waiting publish
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 tf-padding-20">
                    <table class="table table-bordered tf-border-none">
                        <tr>
                            <td colspan="2" class="tf-border-none">
                                <label>Sale info</label>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-2 text-right">
                                <em>Status</em>
                            </td>
                            <td class="col-md-10">
                                {!! $modelTransactionStatus->name($dataLand->transactionStatusID()) !!}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="tf-border-none">
                                <label>License info</label>
                            </td>
                        </tr>
                        @if(count($dataLandLicense) > 0)
                            <tr>
                                <td class="col-md-2 text-right">
                                    <em>User</em>
                                </td>
                                <td class="col-md-10">
                                    {!! $dataLandLicense->user->fullName() !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-2 text-right">
                                    <em>Begin</em>
                                </td>
                                <td class="col-md-10">
                                    {!! $dataLandLicense->dateBegin !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-2 text-right">
                                    <em>End</em>
                                </td>
                                <td class="col-md-10">
                                    {!! $dataLandLicense->dateEnd !!}
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="2">
                                    <em>Null</em>
                                </td>
                            </tr>
                        @endif
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection