<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 */
/*
 * modelStaff
 * modelLand
 * modelTransactionStatus
 * dataLand
 */
use Carbon\Carbon;
$hFunction = new Hfunction();

$actionStatus = false;
$dataStaffLogin = $modelStaff->loginStaffInfo();
if ($modelStaff->checkDepartmentBuild($dataStaffLogin->staffId()) && $dataStaffLogin->level() == 1) $actionStatus = true;
$title = 'Land';
?>
@extends('manage.content.map.land.land.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-md-12 text-Left tf-padding-20 tf-font-size-20 tf-font-bold">
                <span class="fa fa-database"></span>
                <span>{!! $title !!}</span>
            </div>
        </div>
        <div class="tf-bg tf-color-white col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 tf-line-height-40">
                Total : {!! $modelLand->totalRecords()  !!}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 tf-line-height-40 text-right"></div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tf_list_object"
             data-href-view="{!! route('tf.m.c.map.land.view') !!}"
             data-href-del="{!! route('tf.m.c.map.land.delete') !!}">
            <table class="table table-hover ">
                <tr>
                    <th>N_o</th>
                    <th>Name</th>
                    <th>Sale status</th>
                    <th class="text-center">Publish</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th></th>
                </tr>
                @if(count($dataLand) > 0)
                    <?php
                    $perPage = $dataLand->perPage();
                    $currentPage = $dataLand->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataLand as $landObject)
                        <?php
                        $landId = $landObject->landId();
                        $projectId = $landObject->projectId();
                        $status = $landObject->status();
                        ?>
                        <tr class="tf_object" data-object="{!! $landId !!}">
                            <td class="text-center tf-font-bold">
                                {!! $n_o += 1 !!}.
                            </td>
                            <td>
                                {!! $landObject->name() !!}
                            </td>
                            <td>
                                {!! $modelTransactionStatus->name($landObject->transactionStatusID()) !!}
                            </td>
                            <td class="text-center">
                                @if($landObject->publish() == 1)
                                    <i class="glyphicon glyphicon-ok-circle tf-color-green tf-font-bold"></i>
                                @else
                                    <i class="glyphicon glyphicon-ok-circle tf-color-grey"></i>
                                @endif
                            </td>
                            <td >
                                @if($landObject->status() == 1)
                                    <i class="glyphicon glyphicon-ok-circle tf-color-green tf-font-bold"></i>
                                @else
                                    <i class="glyphicon glyphicon-ok-circle tf-color-grey"></i>
                                @endif
                            </td>
                            <td>
                                {!! Carbon::parse($landObject->createdAt())->format('d-m-Y') !!}
                            </td>

                            <td class="text-right">
                                <a class="btn btn-default btn-xs tf-link  tf_object_view">
                                    <i class="glyphicon glyphicon-eye-open"></i> View
                                </a>
                                <a class="btn btn-default btn-xs tf_object_delete">
                                    <i class="glyphicon glyphicon-trash tf-color"></i> Delete
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="text-center" colspan="7">
                            <?php
                            $hFunction->page($dataLand);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection