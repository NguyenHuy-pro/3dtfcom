<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 *
 */
/*
 * $modelStaff
 * $modelStandard
 * $dataStandard
 *
 * */

$hFunction = new Hfunction();
$dataStaffLogin = $modelStaff->loginStaffInfo();

$actionStatus = false;
if ($dataStaffLogin->level() == 2) $actionStatus = true;

$title = 'Standard';
?>
@extends('manage.content.sample.standard.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="col-xs-12 col-sm-12 col-md-12 text-Left tf-padding-20 tf-font-size-20 tf-font-bold">
                <span class="fa fa-database"></span>
                <span>{!! $title !!}</span>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 tf-bg tf-color-white ">
            <div class="col-xs-6 col-sm-6 col-md-6 tf-line-height-40">
                Total : {!! $modelStandard->totalRecords() !!}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 tf-line-height-40 text-right">

            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 tf_list_object"
             data-href-status="{!! route('tf.m.c.sample.standard.status') !!}">
            <table class="table table-hover">
                <tr>
                    <th>No</th>
                    <th class="text-center">Standard</th>
                    <th class="text-center">Width size</th>
                    <th class="text-center">Status</th>
                </tr>
                @if(count($dataStandard) > 0)
                    <?php
                    $perPage = $dataStandard->perPage();
                    $currentPage = $dataStandard->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataStandard as $itemStandard)
                        <?php
                        $standardId = $itemStandard->standardId();
                        $status = $itemStandard->status();
                        ?>
                        <tr class="tf_object" data-object="{!! $standardId !!}">
                            <td>
                                {!! $n_o += 1 !!}.
                            </td>
                            <td class="text-center">
                                {!! $itemStandard->standardValue() !!}
                            </td>
                            <td class="text-center">
                                {!! $itemStandard->standardValue()*32 !!}
                            </td>
                            <td class="text-center">
                                <span class="@if($status == 1) tf-color-green tf-font-bold @else @if($actionStatus) tf_object_status tf-link-grey @else tf-color-grey @endif @endif">
                                    On
                                </span>
                                |
                                    <span class="@if($status == 0) tf-color-green tf-font-bold @else @if($actionStatus) tf_object_status tf-link-grey @else tf-color-grey @endif @endif">
                                    Off
                                </span>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="text-center" colspan="4">
                            <?php
                            $hFunction->page($dataStandard);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection