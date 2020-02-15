<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/18/2016
 * Time: 9:39 AM
 */
/*
 * dataLandRequestBuild
 */
$title = 'Land icon sample detail';

$dataLandRequestBuildDesign = $dataLandRequestBuild->landRequestBuildDesignOfRequest();
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="panel panel-default tf-margin-bot-none">
        <div class="panel-heading tf-bg tf-color-white">
            <i class="fa fa-eye"></i>
            {!! $title !!}
            <button class="btn btn-primary btn-xs tf_m_c_container_close pull-right">Close</button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="text-right col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span style="color: black;">{!! $dataLandRequestBuild->createdAt() !!}</span>
                    <br/>
                    <em>
                        <i class="glyphicon glyphicon-user"></i>User:
                    </em>
                    <span>{!! $dataLandRequestBuild->landLicense->user->fullName() !!}</span>
                    <br/>
                    <em>Design status:</em>
                    <span>
                        @if(count($dataLandRequestBuildDesign) > 0)
                            Processing
                        @else
                            Waiting
                        @endif
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="tf-padding-bot-30 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <table class="table table-bordered tf-border-none">
                        <tr>
                            <td class="tf-border-top-none" colspan="2">
                                <em class="tf-text-under">About design</em>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right tf-vertical-middle">
                                <em>Sample Image</em>
                            </td>
                            <td class="">
                                <img src="{!! $dataLandRequestBuild->pathImage() !!}" alt="sample">
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-3 text-right ">
                                <em>Land Size</em>
                            </td>
                            <td class="col-md-9 tf-em-1-5 ">
                                {!! $dataLandRequestBuild->landLicense->land->size->name() !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right">
                                <em>Design description</em>
                            </td>
                            <td>
                                {!! $dataLandRequestBuild->designDescription() !!}
                            </td>
                        </tr>

                        <tr>
                            <td class="tf-border-top-none" colspan="2">
                                <em class="tf-text-under">About building</em>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right">
                                <em>Business type</em>
                            </td>
                            <td>
                                {!! $dataLandRequestBuild->businessType->name() !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right">
                                <em>Building name</em>
                            </td>
                            <td>
                                {!! $dataLandRequestBuild->buildingName() !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right">
                                <em>Display name</em>
                            </td>
                            <td>
                                {!! $dataLandRequestBuild->buildingDisplayName() !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right">
                                <em>Website</em>
                            </td>
                            <td>
                                {!! (empty($dataLandRequestBuild->buildingWebsite()))?'Null':$dataLandRequestBuild->buildingWebsite() !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right">
                                <em>Phone</em>
                            </td>
                            <td>
                                {!! (empty($dataLandRequestBuild->buildingPhone()))?'Null':$dataLandRequestBuild->buildingPhone() !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right">
                                <em>Address</em>
                            </td>
                            <td>
                                {!! (empty($dataLandRequestBuild->buildingAddress()))?'Null':$dataLandRequestBuild->buildingAddress() !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right">
                                <em>Email</em>
                            </td>
                            <td>
                                {!! (empty($dataLandRequestBuild->buildingEmail()))?'Null':$dataLandRequestBuild->buildingEmail() !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right">
                                <em>Short description</em>
                            </td>
                            <td>
                                {!! $dataLandRequestBuild->buildingShortDescription() !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right">
                                <em>Description</em>
                            </td>
                            <td>
                                {!! (empty($dataLandRequestBuild->buildingDescription()))?'Null':$dataLandRequestBuild->buildingDescription() !!}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection