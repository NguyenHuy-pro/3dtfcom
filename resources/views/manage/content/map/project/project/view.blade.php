<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/18/2016
 * Time: 9:39 AM
 */
/*
 * modelProvinceArea
 * dataProject
 */


$projectId = $dataProject->projectId();
$provinceId = $dataProject->provinceId();
$areaId = $dataProject->areaId();

#area info
$dataArea = $dataProject->area->getInfo($areaId);

# property info (of staff)
$dataProjectProperty = $dataProject->propertyInfo();

# license info (of user)
$dataProjectLicense = $dataProject->licenseInfo($projectId);

#build info
$dataProjectBuild = $dataProject->infoProjectBuild();

?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="panel panel-default tf-margin-bot-none">
        <div class="panel-heading tf-bg tf-color-white">
            <i class="fa fa-eye"></i>
            Project detail
            <button class="btn btn-primary btn-xs tf_m_c_container_close pull-right">Close</button>
        </div>
        <div class="panel-body">
           <div class="row">
               <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                   <i class="fa fa-calendar"></i>&nbsp;
                   <span style="color: black;">{!! $dataProject->createdAt() !!}</span>
               </div>
           </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 tf-padding-20">
                    <table class="table table-bordered tf-border-none">
                        <tr>
                            <td colspan="2" class="tf-border-none">
                                <label>Project info</label>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-2 text-right">
                                <em>Icon</em>
                            </td>
                            <td class="col-md-10" style="background-color: green;">
                                <img src="{!! $dataProject->pathIconImage() !!}">
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-2 text-right">
                                <em>Name</em>
                            </td>
                            <td class="col-md-10">
                                <b>{!! $dataProject->name() !!}</b>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-2 text-right">
                                <em>Province</em>
                            </td>
                            <td class="col-md-10">
                                {!! $dataProject->province->name() !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-2 text-right">
                                <em>Position</em>
                            </td>
                            <td class="col-md-10">
                                {!! 'X: '.$dataArea->x().'  Y: '.$dataArea->y() !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-2 text-right">
                                <em>Point</em>
                            </td>
                            <td class="col-md-10">
                                {!! $dataProject->pointValue() !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-2 text-right">
                                <em>Default staus</em>
                            </td>
                            <td class="col-md-10">
                                @if($modelProvinceArea->checkCenter($provinceId, $areaId))
                                    Center
                                @else
                                    Normal
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 tf-padding-20">
                    <table class="table table-bordered tf-border-none">
                        <tr>
                            <td colspan="2" class="tf-border-none">
                                <label>Manage info</label>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-2 text-right">
                                <em>Manager</em>
                            </td>
                            <td class="col-md-10">
                                {!! $dataProjectProperty->staff->fullName() !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-2 text-right">
                                <em>Begin</em>
                            </td>
                            <td class="col-md-10">
                                {!! $dataProjectProperty->dateBegin() !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-2 text-right">
                                <em>End</em>
                            </td>
                            <td class="col-md-10">
                                {!! $dataProjectProperty->dateEnd() !!}
                            </td>
                        </tr>
                    </table>
                </div>

            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 tf-padding-20">
                    <table class="table table-bordered tf-border-none">
                        <tr>
                            <td colspan="2" class="tf-border-none">
                                <label>Build info</label>
                            </td>
                        </tr>
                        @if(count($dataProjectBuild) > 0)
                            <tr>
                                <td class="col-md-2 text-right">
                                    <em>Status</em>
                                </td>
                                <td class="col-md-10">
                                    @if($dataProjectBuild->buildStatus() == 1)
                                        Being built
                                    @else
                                        Waiting publish
                                    @endif
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td class="col-md-2 text-right">
                                    <em>Status</em>
                                </td>
                                <td class="col-md-10">
                                    Does not build
                                </td>
                            </tr>
                        @endif
                    </table>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 tf-padding-20">
                    <table class="table table-bordered tf-border-none">
                        <tr>
                            <td colspan="2" class="tf-border-none">
                                <label>License info</label>
                            </td>
                        </tr>
                        @if(count($dataProjectLicense) > 0)
                            <tr>
                                <td class="col-md-2 text-right">
                                    <em>User</em>
                                </td>
                                <td class="col-md-10">
                                    <span>Develop later</span>
                                </td>
                            </tr>

                        @else
                            <tr>
                                <td colspan="2">
                                    <span class="tf-color-red">Develop later</span>
                                </td>
                            </tr>

                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection