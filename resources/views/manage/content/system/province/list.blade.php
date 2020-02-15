<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 *
 * $modelStaff
 * modelCountry
 * modelProvince
 * dataProvince
 *
 */

$hFunction = new Hfunction();
$dataStaffLogin = $modelStaff->loginStaffInfo();
$actionStatus = false;
if ($dataStaffLogin->level() == 2) $actionStatus = true;

$title = 'Province';
?>
@extends('manage.content.system.province.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="col-xs-12 col-sm-12 col-md-12 text-Left tf-padding-20 tf-font-size-20 tf-font-bold">
                <span class="fa fa-database"></span>
                <span>{!! $title !!}</span>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 " style="background-color: #BFCAE6;">
            <div class="col-xs-4 col-sm-4 col-md-4 tf-line-height-40">
                Total : {!! $modelProvince->totalRecords() !!}
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 text-right tf-line-height-40">
                <select id="cbFilterCountry" class="tf_filter_country"
                        data-href="{!! route('tf.m.c.system.province.filter') !!}" name="cbFilterCountry">
                    <option value="">All country</option>
                    {!! $modelCountry->getOption((isset($filterCountryId))?$filterCountryId:'') !!}
                </select>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 tf-line-height-40 text-right">
                @if($actionStatus)
                    <a href="{!! route('tf.m.c.system.province.add.get') !!}">
                        <button class="btn btn-primary tf-link-white-bold">
                            <i class="fa fa-plus"></i> &nbsp;Add new
                        </button>
                    </a>
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 tf_list_object"
             data-href-build3d="{!! route('tf.m.c.system.province.build3d.get') !!}"
             data-href-status="{!! route('tf.m.c.system.province.status') !!}"
             data-href-view="{!! route('tf.m.c.system.province.view') !!}"
             data-href-edit="{!! route('tf.m.c.system.province.edit.get') !!}"
             data-href-del="{!! route('tf.m.c.system.province.delete') !!}">
            <table class="table table-hover">
                <tr>
                    <th class="text-center">No</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Country</th>
                    <th class="text-center">Build 3D</th>
                    <th class="text-center">Default center</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                @if(count($dataProvince) > 0)
                    <?php
                    $perpage = $dataProvince->perPage();
                    $currentPage = $dataProvince->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perpage;
                    ?>
                    @foreach($dataProvince as $itemProvince)
                        <?php
                        $provinceId = $itemProvince->provinceId();
                        $status = $itemProvince->status();
                        ?>
                        <tr class="tf_object" data-object="{!! $provinceId !!}">
                            <td class="text-center">
                                {!! $n_o += 1 !!}.
                            </td>
                            <td>
                                {!! $itemProvince->name() !!}
                            </td>
                            <td>
                                {!! $itemProvince->provinceType->name() !!}
                            </td>
                            <td>
                                {!! $itemProvince->country->name() !!}
                            </td>
                            <td class="text-center">
                                {{--@if($modelCountry->checkBuild3d($countryID))--}}
                                @if($itemProvince->country->checkBuild3d())
                                    @if($itemProvince->build3dStatus() == 0)
                                        <a class="tf_build3d tf-link-grey glyphicon glyphicon-ok"></a>
                                    @else
                                        <i class="glyphicon glyphicon-ok tf-color-green tf-font-bold"></i>
                                    @endif
                                @else
                                    <em>unOpened country 3D</em>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($itemProvince->defaultCenter() == 0)
                                    <i class="tf-color-grey glyphicon glyphicon-ok-circle"></i>
                                @else
                                    <i class="tf-color-green glyphicon glyphicon-ok-circle"></i>
                                @endif
                            </td>
                            <td >
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
                    <tr>
                        <td class="text-center" colspan="8">
                            <?php
                            $hFunction->page($dataProvince);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection