<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 */
/*
 * modelStaff
 * modelLandIconSample
 * dataLandIconSample
 *
 */

$hFunction = new Hfunction();
$dataStaffLogin = $modelStaff->loginStaffInfo();

$actionStatus = false;
if ($dataStaffLogin->level() == 2) $actionStatus = true;

$title = 'Land icon';
?>
@extends('manage.content.sample.banner.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="colxs-12 col-sm-12 col-md-12 text-Left tf-padding-20 tf-font-size-20 tf-font-bold">
                <span class="fa fa-database"></span>
                <span>{!! $title !!}</span>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 " style="background-color: #BFCAE6;">
            <div class="col-xs-6 col-sm-6 col-md-6 tf-line-height-40">
                Total : {!! $modelLandIconSample->totalRecords() !!}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 tf-line-height-40 text-right">
                @if($actionStatus)
                    <a href="{!! route('tf.m.c.sample.land-icon.add.get') !!}">
                        <button class="btn btn-primary tf-link-white-bold">
                            <i class="fa fa-plus"></i> &nbsp;Add new
                        </button>
                    </a>
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 tf_list_object"
             data-href-view="{!! route('tf.m.c.sample.land-icon.view') !!}"
             data-href-edit="{!! route('tf.m.c.sample.land-icon.edit.get') !!}">
            <table class="table table-hover">
                <tr>
                    <th>No</th>
                    <th>Image</th>
                    <th>Size</th>
                    <th>Transaction status</th>
                    <th>Owner</th>
                    <th></th>
                </tr>
                @if(count($dataLandIconSample) > 0)
                    <?php
                    $perPage = $dataLandIconSample->perPage();
                    $currentPage = $dataLandIconSample->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataLandIconSample as $itemLandIconSample)
                        <?php
                        $sampleId = $itemLandIconSample->sampleId();
                        $ownStatus = $itemLandIconSample->ownStatus();
                        ?>
                        <tr class="tf_object" data-object="{!! $sampleId !!}">
                            <td >
                                {!! $n_o += 1 !!}.
                            </td>
                            <td>
                                <img style="width: 96px; height: 64px;"
                                     src="{!! $itemLandIconSample->pathImage() !!}" alt="sample">
                                &nbsp;&nbsp;&nbsp;
                                <span>{!! $itemLandIconSample->name() !!}</span>
                            </td>
                            <td>
                                {!! $itemLandIconSample->size->name() !!}
                            </td>
                            <td>
                                {!! $itemLandIconSample->transactionStatus->name() !!}
                            </td>
                            <td >
                                <em>
                                    @if($ownStatus == 1)
                                        Owner
                                    @else
                                        Normal
                                    @endif
                                </em>
                            </td>
                            <td class="text-right">
                                <a class="btn btn-default btn-xs tf_object_view">
                                    <i class="glyphicon glyphicon-eye-open tf-color"></i> View
                                </a>
                                @if($actionStatus)
                                    <a class="btn btn-default btn-xs tf_object_edit">
                                        <i class="glyphicon glyphicon-edit tf-color"></i> Edit
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <tr class="odd gradeX" align="center">
                        <td colspan="6">
                            <?php
                            $hFunction->page($dataLandIconSample);
                            ?>
                        </td>
                    </tr>
                @else
                    <tr align="center">
                        <td class="text-center" colspan="6">
                            <em>Not found</em>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection