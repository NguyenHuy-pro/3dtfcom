<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 */
/*
 * modelStaff
 * modelUserImage
 * dataUserImage
 */
use Carbon\Carbon;
$hFunction = new Hfunction();

$dataStaffLogin = $modelStaff->loginStaffInfo();
#check action of level
$actionStatus = false;
if ($dataStaffLogin->level() == 2) $actionStatus = true; #level execute

?>
@extends('manage.content.user.image.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="text-Left tf-padding-20 tf-font-size-20 tf-font-bold col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <span class="fa fa-database"></span>
                <span>Image</span>
            </div>
        </div>
        <div class="tf-bg tf-color-white col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
            <div class="col-md-6 tf-line-height-40">
                Total : {!! $modelUserImage->totalRecords() !!}
            </div>
            <div class="tf-line-height-40 text-right col-xs-12 col-sm-12 col-md-12 col-lg-12"></div>
        </div>
        <div class="tf_list_object col-xs-12 col-sm-12 col-md-12 col-lg-12"
             data-href-view="{!! route('tf.m.c.user.image.view') !!}"
             data-href-del="{!! route('tf.m.c.user.image.delete') !!}">
            <table class="table table-hover">
                <tr>
                    <th >No</th>
                    <th>Image</th>
                    <th >User</th>
                    <th ></th>
                </tr>
                @if(count($dataUserImage) > 0)
                    <?php
                    $perPage = $dataUserImage->perPage();
                    $currentPage = $dataUserImage->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataUserImage as $imageObject)
                        <?php
                        $imageId = $imageObject->imageId();
                        $userId = $imageObject->userId();
                        ?>
                        <tr class="tf_object" data-object="{!! $imageId !!}">
                            <td class="text-center tf-font-bold tf-vertical-middle">
                                {!! $n_o += 1!!}.
                            </td>
                            <td class="tf-vertical-middle">
                                <img style="max-width: 100px; max-height: 50px;" src="{!! $imageObject->pathSmallImage() !!}">
                            </td>
                            <td class="tf-vertical-middle">
                                {!! $imageObject->user->fullName() !!}
                            </td>
                            <td class="text-right tf-vertical-middle">
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
                        <td class="text-center" colspan="5">
                            <?php
                            $hFunction->page($dataUserImage);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection