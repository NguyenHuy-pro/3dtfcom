<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 */
/*
 * modelStaff
 * modelAdsBannerImage
 * dataAdsBannerImage
 */
use Carbon\Carbon;
$hFunction = new Hfunction();

$actionStatus = false;
$dataStaffLogin = $modelStaff->loginStaffInfo();
if ($modelStaff->checkDepartmentSystem($dataStaffLogin->staffId()) && $dataStaffLogin->level() == 2) $actionStatus = true;
$title = 'Image';
?>
@extends('manage.content.ads.banner-image.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="text-Left tf-padding-20 tf-font-size-20 tf-font-bold col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                <span class="fa fa-database"></span>
                <span>{!! $title !!}</span>
            </div>
        </div>
        <div class="tf-bg tf-color-white col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 tf-line-height-40">
                Total : {!! $modelAdsBannerImage->totalRecords()  !!}
            </div>
            <div class="tf-line-height-40 text-right col-xs-6 col-sm-6 col-md-6 col-lg-6 "></div>
        </div>
        <div class="tf_list_object col-xs-12 col-sm-12 col-md-12 col-lg-12 "
             data-href-view="{!! route('tf.m.c.ads.banner-image.view') !!}"
             data-href-del="{!! route('tf.m.c.ads.banner-image.delete') !!}">
            <table class="table table-hover ">
                <tr>
                    <th>N_o</th>
                    <th>Image</th>
                    <th>Date</th>
                    <th></th>
                </tr>
                @if(count($dataAdsBannerImage) > 0)
                    <?php
                    $perPage = $dataAdsBannerImage->perPage();
                    $currentPage = $dataAdsBannerImage->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataAdsBannerImage as $imageObject)
                        <?php
                        $imageId = $imageObject->imageId();
                        ?>
                        <tr class="tf_object" data-object="{!! $imageId !!}">
                            <td class="tf-vertical-middle tf-font-bold">
                                {!! $n_o += 1 !!}.
                            </td>
                            <td>
                                <img style="max-width: 150px; max-height: 150px" src="{!! $imageObject->pathImage() !!}">
                            </td>
                            <td class="tf-vertical-middle">
                                {!! $imageObject->createdAt() !!}
                            </td>
                            <td class="tf-vertical-middle text-right">
                                <a class="btn btn-default btn-xs tf-link  tf_object_view">
                                    <i class="glyphicon glyphicon-eye-open"></i> View
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
                        <td class="text-center" colspan="4">
                            <?php
                            $hFunction->page($dataAdsBannerImage);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection