<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/28/2016
 * Time: 10:28 AM
 *
 * $dataStaff
 *
 */

$staffId = $dataStaff->staffId();
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="panel panel-default tf-margin-bot-none">
        <div class="panel-heading tf-bg tf-color-white">
            <i class="fa fa-eye"></i>
            Staff detail
            <button class="btn btn-primary btn-xs tf_m_c_container_close pull-right">Close</button>
        </div>
        <div class="panel-body">
            <div class="col-xs-12 col-sm-12 col-md-12 text-right">
                <i class="fa fa-calendar"></i>&nbsp;
                <span style="color: black;">{!! $dataStaff->createdAt() !!}</span>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 tf-padding-20">
                    <div class="col-xs-12 col-sm-12 col-md-12 tf-padding-bot-30">
                        <table class="table table-bordered tf-border-none">
                            <tr>
                                <td colspan="2" class="tf-border-none">
                                    <label>Staff info</label>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3 text-right">
                                    <img style="max-width: 100%;" src="{!! $dataStaff->pathSmallImage($dataStaff->image()) !!}">
                                </td>
                                <td class="col-md-9 tf-vertical-middle">
                                    {!! $dataStaff->fullName() !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">
                                    <em>Code</em>
                                </td>
                                <td >
                                    {!! $dataStaff->nameCode() !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">
                                    <em>Birthday</em>
                                </td>
                                <td >
                                    {!! $dataStaff->birthday() !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">
                                    <em>Gender</em>
                                </td>
                                <td >
                                    {!! ($dataStaff->gender() == 0)?'Male':'Female' !!}
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-xs-12 c0l-sm-12 col-md-12 tf-padding-bot-30">
                        <table class="table table-bordered tf-border-none">
                            <tr>
                                <td colspan="2" class="tf-border-none">
                                    <label>Contact info</label>
                                </td>
                            </tr>

                            <tr>
                                <td class="col-md-3 text-right">
                                    <em>Province</em>
                                </td>
                                <td class="col-md-9">
                                    @if(empty($dataStaff->provinceId()))
                                        Null
                                    @else
                                        {!! $dataStaff->province->name() !!}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">
                                    <em>Address</em>
                                </td>
                                <td>
                                    {!! (empty($dataStaff->address()))?'Null':$dataStaff->address() !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">
                                    <em>Phone</em>
                                </td>
                                <td >
                                    {!! (empty($dataStaff->phone()))?'Null':$dataStaff->phone() !!}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 tf-padding-20 tf-padding-bot-30">
                    <div class="col-md-12 tf-padding-bot-30">
                        <table class="table table-bordered tf-border-none">
                            <tr>
                                <td colspan="2" class="tf-border-none">
                                    <label>Account info</label>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3 text-right">
                                    <em>Account</em>
                                </td>
                                <td class="col-md-9">
                                    {!! $dataStaff->account() !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">
                                    <em>New staff</em>
                                </td>
                                <td >
                                    @if($dataStaff->newInfo() == 1)
                                        <i class="glyphicon glyphicon-ok tf-color-green tf-font-bold"></i>
                                    @else
                                        <i class="glyphicon glyphicon-ok tf-color-grey"></i>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">
                                    <em>Confirm status</em>
                                </td>
                                <td >
                                    @if($dataStaff->confirm() == 1)
                                        <i class="glyphicon glyphicon-ok tf-color-green tf-font-bold"></i>
                                    @else
                                        <i class="glyphicon glyphicon-ok tf-color-grey"></i>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">
                                    <em>Action status</em>
                                </td>
                                <td>
                                    @if($dataStaff->status() == 1)
                                        <i class="glyphicon glyphicon-ok tf-color-green tf-font-bold"></i>
                                    @else
                                        <i class="glyphicon glyphicon-ok tf-color-grey"></i>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">
                                    <em>Department</em>
                                </td>
                                <td>
                                    {!! $dataStaff->department->name() !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">
                                    <em>Manager</em>
                                </td>
                                <td>
                                    {!! $dataStaff->fullName($dataStaff->manager($staffId)) !!}
                                </td>
                            </tr>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
