<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 */
/*
 * modelStaff
 * modelBuilding
 * dataBuilding
 */
use Carbon\Carbon;

$hFunction = new Hfunction();
#check action
$actionStatus = false;
if ($modelStaff->checkDepartmentBuild($modelStaff->loginStaffID())) $actionStatus = true;
?>
@extends('manage.content.building.index')
@section('tf_m_c_building_content')
    <div class="row tf_m_c_building_building tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            <h3>List building</h3>
        </div>
        <div class="tf-bg tf-color-white col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 tf-line-height-40">
                Total : {!! $modelBuilding->totalRecords()  !!}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 tf-line-height-40 text-right">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tf_list_object"
             data-href-view="{!! route('tf.m.c.building.building.view') !!}"
             data-href-status="{!! route('tf.m.c.building.building.status') !!}"
             data-href-del="{!! route('tf.m.c.building.building.delete') !!}">
            <table class="table table-hover ">
                <tr>
                    <th >N_o</th>
                    <th >Image</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th ></th>
                </tr>
                @if(count($dataBuilding) > 0)
                    <?php
                    $perPage = $dataBuilding->perPage();
                    $currentPage = $dataBuilding->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataBuilding as $buildingObject)
                        <?php
                        $n_o = $n_o + 1;
                        $buildingId = $buildingObject->buildingId();
                        $status = $buildingObject->status();
                        ?>
                            <tr class="tf_object" data-object="{!! $buildingId !!}">
                                <td class="tf-vertical-middle">
                                    {!! $n_o +=1 !!}.
                                </td>
                                <td>
                                    <img style="max-width: 96px; max-height: 64px" alt="{!! $buildingObject->alias() !!}"
                                         src="{!! $modelBuilding->pathImageSample($buildingObject->sampleId()) !!}"/>
                                </td>
                                <td class="tf-vertical-middle">
                                    {!! $buildingObject->name() !!}
                                </td>
                                <td class="tf-vertical-middle">
                                    {!! Carbon::parse($buildingObject->createdAt()->format('d-m-Y')) !!}
                                </td>
                                <td class="tf-vertical-middle">
                                <span class="@if($status == 1) tf-color-green tf-font-bold @else @if($actionStatus) tf_object_status tf-link-grey @else tf-color-grey @endif @endif">
                                    On
                                </span>
                                    |
                                <span class="@if($status == 0) tf-color-green tf-font-bold @else @if($actionStatus) tf_object_status tf-link-grey @else tf-color-grey @endif @endif">
                                    Off
                                </span>
                                </td>
                                <td class="text-right tf-vertical-middle">
                                    <a class="btn btn-default btn-xs  tf_object_view">
                                        <i class="glyphicon glyphicon-eye-open tf-color"></i> View
                                    </a>
                                    @if($actionStatus)
                                        <a class="btn btn-default btn-xs tf_object_delete">
                                            <i class="glyphicon glyphicon-trash tf-color"></i> Delete
                                        </a>
                                    @endif
                                </td>
                            </tr>
                    @endforeach
                    <tr>
                        <td class="text-center" colspan="6">
                            <?php
                            $hFunction->page($dataBuilding);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection

@section('tf_m_js_page_footer')
    <script src="{{ url('public/manage/content/building/js/building.js')}}"></script>
@endsection