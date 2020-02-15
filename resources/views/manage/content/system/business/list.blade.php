<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 *
 * $modelStaff
 * $modelBusinessType
 * $modelBusiness
 * $dataBusiness
 *
 */

$hFunction = new Hfunction();
$dataStaffLogin = $modelStaff->loginStaffInfo();
$actionStatus = false;
if ($dataStaffLogin->level() == 2) $actionStatus = true;

$title = 'Business';
?>
@extends('manage.content.system.business.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-12 col-sm-12 col-md-12 text-Left tf-padding-20 tf-font-size-20 tf-font-bold">
                <span class="fa fa-database"></span>
                <span>{!! $title !!}</span>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 " style="background-color: #BFCAE6;">
            <div class="col-xs-4 col-sm-4 col-md-4 tf-line-height-40">
                Total : {!! $modelBusiness->totalRecords() !!}
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 text-right tf-line-height-40">
                <select class="tf_filter_business_type"
                        data-href="{!! route('tf.m.c.system.business.filter') !!}" name="cbFilterBusinessType">
                    <option value="">All</option>
                    {!! $modelBusinessType->getOption((isset($filterBusinessTypeId))?$filterBusinessTypeId:'') !!}
                </select>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 tf-line-height-40 text-right">
                @if($actionStatus)
                    <a href="{!! route('tf.m.c.system.business.add.get') !!}">
                        <button class="btn btn-primary tf-link-white-bold">
                            <i class="fa fa-plus"></i> &nbsp;Add new
                        </button>
                    </a>
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 tf_list_object"
             data-href-status="{!! route('tf.m.c.system.business.status') !!}"
             data-href-view="{!! route('tf.m.c.system.business.view') !!}"
             data-href-edit="{!! route('tf.m.c.system.business.edit.get') !!}"
             data-href-del="{!! route('tf.m.c.system.business.delete') !!}">
            <table class="table table-hover">
                <tr>
                    <th class="text-center">No</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Business type</th>
                    <th class="text-center">Status</th>
                    <th class="text-center"></th>
                </tr>
                @if(count($dataBusiness) > 0)
                    <?php
                    $perPage = $dataBusiness->perPage();
                    $currentPage = $dataBusiness->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage;
                    ?>
                    @foreach($dataBusiness as $itemBusiness)
                        <?php
                        $businessId = $itemBusiness->businessId();
                        $status = $itemBusiness->status();
                        ?>
                        <tr class="tf_object" data-object="{!! $businessId !!}">
                            <td class="text-center">
                                {!! $n_o += 1 !!}.
                            </td>
                            <td>
                                {!! $itemBusiness->name() !!}
                            </td>
                            <td>
                                {!! $itemBusiness->description() !!}
                            </td>
                            <td>
                                {!! $itemBusiness->businessType->name() !!}
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
                        <td class="text-center" colspan="6">
                            <?php
                            $hFunction->page($dataBusiness);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection