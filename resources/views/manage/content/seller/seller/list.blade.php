<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 *
 * $modelStaff
 * $modelSeller
 * dataSeller
 *
 */
$hFunction = new Hfunction();

#login info
$dataStaffLogin = $modelStaff->loginStaffInfo();

$actionStatus = false;
if ($dataStaffLogin->level() == 2) $actionStatus = true;

$title = 'Affiliate';
?>
@extends('manage.content.seller.seller.index')
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
                Total : {!! $modelSeller->totalRecords() !!}
            </div>
            <div class="tf-line-height-40 text-right col-xs-6 col-sm-6 col-md-6 col-lg-6 "></div>
        </div>

        <div class="tf_list_object col-xs-12 col-sm-12 col-md-12 col-lg-12 "
             data-href-status="{!! route('tf.m.c.seller.seller.status') !!}"
             data-href-view="{!! route('tf.m.c.seller.seller.view') !!}"
             data-href-del="{!! route('tf.m.c.seller.seller.delete') !!}">
            <table class="table table-hover">
                <tr>
                    <th class="text-center">No</th>
                    <th>Code</th>
                    <th>User</th>
                    <th>Date</th>
                    <th class="text-center">Status</th>
                    <th class="text-right"></th>
                </tr>
                @if(count($dataSeller) > 0)
                    <?php
                    $perPage = $dataSeller->perPage();
                    $currentPage = $dataSeller->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataSeller as $object)
                        <?php
                        $sellerId = $object->sellerId();
                        $status = $object->status();
                        ?>
                        <tr class="tf_object" data-object="{!! $sellerId !!}">
                            <td class="text-center">
                                {!! $n_o+= 1 !!}.
                            </td>
                            <td>
                                {!! $object->sellerCode() !!}
                            </td>
                            <td>
                                {!! $object->user->fullName() !!}
                            </td>
                            <td>
                                {!! $object->createdAt() !!}
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
                            $hFunction->page($dataSeller);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection