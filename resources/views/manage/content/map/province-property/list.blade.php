<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 */
/*
 * modelStaff
 * modelProvinceProperty
 */
use Carbon\Carbon;

$hFunction = new Hfunction();

$actionStatus = false;
$dataStaffLogin = $modelStaff->loginStaffInfo();
if ($modelStaff->checkDepartmentBuild($dataStaffLogin->staffId()) && $dataStaffLogin->level() == 1) $actionStatus = true;
$title = 'Property of province';
?>
@extends('manage.content.map.province-property.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-Left tf-padding-20 tf-font-size-20 tf-font-bold">
                <span class="fa fa-database"></span>
                <span>Province property</span>
            </div>
        </div>
        <div class="tf-bg tf-color-white col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 tf-line-height-40">
                Total : {!! $modelProvinceProperty->totalRecords()  !!}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 tf-line-height-40 text-right"></div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tf_list_object"
             data-href-view="{!! route('tf.m.c.map.province-property.view') !!}">
            <table class="table table-hover ">
                <tr>
                    <th>N_o</th>
                    <th>Code</th>
                    <th>Begin</th>
                    <th>End</th>
                    <th>Manager</th>
                    <th></th>
                </tr>
                @if(count($dataProvinceProperty) > 0)
                    <?php
                    $perPage = $dataProvinceProperty->perPage();
                    $currentPage = $dataProvinceProperty->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataProvinceProperty as $propertyObject)
                        <tr class="tf_object" data-object="{!! $propertyObject->propertyId() !!}">
                            <td class="tf-font-bold">
                                {!! $n_o !!}.
                            </td>
                            <td>
                                {!! $propertyObject->code() !!}
                            </td>
                            <td>
                                {!! $propertyObject->dateBegin() !!}
                            </td>
                            <td>
                                {!! $propertyObject->dateEnd() !!}
                            </td>
                            <td>
                                {!! $propertyObject->staff->fullName() !!}
                            </td>

                            <td class="text-center">
                                <a class="btn btn-default btn-xs tf-link  tf_object_view">
                                    <i class="glyphicon glyphicon-eye-open"></i> View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="text-center" colspan="6">
                            <?php
                            $hFunction->page($dataProvinceProperty);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection