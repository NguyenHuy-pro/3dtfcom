<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 *
 * $modelStaff
 * $modelSellerGuideObject
 * dataSellerGuideObject
 *
 */
$hFunction = new Hfunction();

#login info
$dataStaffLogin = $modelStaff->loginStaffInfo();

$actionStatus = false;
if ($dataStaffLogin->level() == 2) $actionStatus = true;

$title = 'Seller object';
?>
@extends('manage.content.seller.guide-object.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="text-Left tf-padding-20 tf-font-size-20 tf-font-bold col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                <span class="fa fa-database"></span>
                <span>{!! $title !!}</span>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="background-color: #BFCAE6;">
            <div class="tf-line-height-40 col-xs-6 col-sm-6 col-md-6 col-lg6 ">
                Total : {!! $modelSellerGuideObject->totalRecords() !!}
            </div>
            <div class="tf-line-height-40 text-right col-xs-6 col-sm-6 col-md-6 col-lg-6 ">
                @if($actionStatus)
                    <a href="{!! route('tf.m.c.seller.guide-object.add.get') !!}">
                        <button class="btn btn-primary tf-link-white-bold">
                            <i class="fa fa-plus"></i> &nbsp;Add new
                        </button>
                    </a>
                @endif
            </div>
        </div>

        <div class="tf_list_object col-xs-12 col-sm-12 col-md-12 col-lg-12 "
             data-href-status="{!! route('tf.m.c.seller.guide-object.status') !!}"
             data-href-view="{!! route('tf.m.c.seller.guide-object.view') !!}"
             data-href-edit="{!! route('tf.m.c.seller.guide-object.edit.get') !!}"
             data-href-del="{!! route('tf.m.c.seller.guide-object.delete') !!}">
            <table class="table table-hover">
                <tr>
                    <th class="text-center">No</th>
                    <th>Name</th>
                    <th class="text-center">Status</th>
                    <th class="text-right"></th>
                </tr>
                @if(count($dataSellerGuideObject) > 0)
                    <?php
                    $perPage = $dataSellerGuideObject->perPage();
                    $currentPage = $dataSellerGuideObject->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataSellerGuideObject as $object)
                        <?php
                        $objectId = $object->objectId();
                        $status = $object->status();
                        ?>
                        <tr class="tf_object" data-object="{!! $objectId !!}">
                            <td class="text-center">
                                {!! $n_o+= 1 !!}.
                            </td>
                            <td>
                                {!! $object->name() !!}
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
                        <td class="text-center" colspan="4">
                            <?php
                            $hFunction->page($dataSellerGuideObject);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection