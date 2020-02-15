<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 *
 * modelStaff
 * modelCountry
 * dataCountry
 *
 *
 */

$hFunction = new Hfunction();
#login info
$dataStaffLogin = $modelStaff->loginStaffInfo();
$level = $dataStaffLogin->level();
$actionStatus = false;
if ($level == 2) $actionStatus = true;

$title = 'Country';
?>
@extends('manage.content.system.country.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="col-md-12 text-Left tf-padding-20 tf-font-size-20 tf-font-bold">
                <span class="fa fa-database"></span>
                <span>{!! $title !!}</span>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 " style="background-color: #BFCAE6;">
            <div class="col-xs-6 col-sm-6 col-md-6 tf-line-height-40">
                Total : {!! $modelCountry->totalRecords() !!}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 tf-line-height-40 text-right">
                @if($actionStatus)
                    <a href="{!! route('tf.m.c.system.country.add.get') !!}">
                        <button class="btn btn-primary tf-link-white-bold">
                            <i class="fa fa-plus"></i> &nbsp;Add new
                        </button>
                    </a>
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 tf_list_object"
             data-href-build3d="{!! route('tf.m.c.system.country.build3d.get') !!}"
             data-href-status="{!! route('tf.m.c.system.country.status') !!}"
             data-href-view="{!! route('tf.m.c.system.country.view') !!}"
             data-href-edit="{!! route('tf.m.c.system.country.edit.get') !!}"
             data-href-del="{!! route('tf.m.c.system.country.delete') !!}">
            <table class="table table-hover">
                <tr>
                    <th class="text-center">No</th>
                    <th>Name</th>
                    <th class="text-center">International code</th>
                    <th>Flag</th>
                    <th class="text-center">Build 3D</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                @if(count($dataCountry))
                    <?php
                    $perPage = $dataCountry->perPage();
                    $currentPage = $dataCountry->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataCountry as $itemCountry)
                        <?php
                        $countryId = $itemCountry->countryId();
                        $build3d = $itemCountry->build3dStatus();
                        $status = $itemCountry->status();
                        ?>
                        <tr class="tf_object" data-object="{!! $countryId !!}">
                            <td>
                                {!! $n_o += 1 !!}.
                            </td>
                            <td>
                                {!! $itemCountry->name() !!}
                            </td>
                            <td class="text-center">
                                {!! $itemCountry->countryCode() !!}
                            </td>
                            <td>
                                <img style="width: 100px;height: 70px;" src="{!! $itemCountry->pathImage() !!}">
                            </td>
                            <td class="text-center">
                                @if($build3d == 0)
                                    <a class="tf_build3d glyphicon glyphicon-ok tf-link-grey"></a>
                                @else
                                    <a class="glyphicon glyphicon-ok tf-color-green"></a>
                                @endif
                            </td>
                            <td>
                                <span class="@if($status == 1) tf-color-green tf-font-bold @else @if($actionStatus) tf_object_status tf-link-grey @else tf-color-grey @endif @endif">
                                    On
                                </span>
                                |
                                    <span class="@if($status == 0) tf-color-green tf-font-bold @else @if($actionStatus) tf_object_status tf-link-grey @else tf-color-grey @endif @endif">
                                    Off
                                </span>
                            </td>
                            <td class="text-right">
                                <a class="btn btn-default btn-xs tf_object_view">
                                    <i class="glyphicon glyphicon-eye-open tf-color"></i> View
                                </a>
                                @if($actionStatus)
                                    <a class="btn btn-default btn-xs tf_object_edit">
                                        <i class="glyphicon glyphicon-edit tf-color"></i> Edit
                                    </a>
                                    <a class="btn btn-default btn-xs tf_object_delete">
                                        <i class="glyphicon glyphicon-trash tf-color"></i> Delete
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <tr class="odd gradeX" align="center">
                        <td colspan="7">
                            <?php
                            $hFunction->page($dataCountry);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection