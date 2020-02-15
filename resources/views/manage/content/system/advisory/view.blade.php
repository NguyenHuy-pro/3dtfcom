<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/18/2016
 * Time: 9:39 AM
 *
 * $dataAdvisory
 * $modelUser
 */

#user info
$userId = $dataAdvisory->userId();
$pathAvatar = $modelUser->pathSmallAvatar($userId, true);

#contact info
$dataUserContact = $modelUser->contactInfo($userId)
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="panel panel-default tf-margin-bot-none">
        <div class="panel-heading tf-bg tf-color-white">
            <i class="fa fa-eye"></i>
            Detail advisory
            <button class="btn btn-primary btn-xs tf_m_c_container_close pull-right">Close</button>
        </div>
        <div class="panel-body">
            <div class="col-xs-12 col-sm-12 col-md-12 text-right">
                <i class="fa fa-calendar"></i>&nbsp;
                <span style="color: black;">{!! $dataAdvisory->createdAt() !!}</span>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 tf-padding-bot-30">
                <table class="table table-bordered tf-border-none">
                    @if(!empty($dataAdvisory->userId()))
                        <tr>
                            <td class="col-xs-4 col-sm-3 col-md-3 text-right">
                                <img style="max-width: 100px; max-height: 100px;" src="{!! $pathAvatar !!}">
                            </td>
                            <td class="col-xs-8 col-sm-9 col-md-9 tf-vertical-middle">
                                {!! $modelUser->fullName($userId) !!}
                            </td>
                        </tr>
                    @endif
                    @if(!empty($dataAdvisory->name()) || !empty($dataAdvisory->phone()) || !empty($dataAdvisory->email()))
                        <tr>
                            <td colspan="2" class="tf-border-none tf-padding-20"></td>
                        </tr>
                        <tr>
                            <td class="text-right tf-font-bold tf-border-none">
                                New contact info
                            </td>
                            <td class="col-md-10 tf-border-none"></td>
                        </tr>
                        <tr>
                            <td class="col-md-2 text-right">
                                <em>Name</em>
                            </td>
                            <td class="col-md-10">
                                {!! $dataAdvisory->name() !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-2 text-right">
                                <em>Phone</em>
                            </td>
                            <td class="col-md-10">
                                {!! $dataAdvisory->phone() !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-2 text-right">
                                <em>Email</em>
                            </td>
                            <td class="col-md-10">
                                {!! $dataAdvisory->email() !!}
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td colspan="2" class="tf-border-none tf-padding-20"></td>
                    </tr>
                    <tr>
                        <td class="col-md-2 text-right">
                            <em>Content</em>
                        </td>
                        <td class="col-md-10">
                            {!! $dataAdvisory->content() !!}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection