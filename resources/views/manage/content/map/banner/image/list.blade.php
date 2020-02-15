<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 */
/*
 * modelStaff
 * modelBannerImage
 * dataBannerImage
 */
use Carbon\Carbon;
$hFunction = new Hfunction();

$actionStatus = false;
$dataStaffLogin = $modelStaff->loginStaffInfo();
if ($modelStaff->checkDepartmentBuild($dataStaffLogin->staffId()) && $dataStaffLogin->level() == 1) $actionStatus = true;
$title = 'Image';
?>
@extends('manage.content.map.banner.image.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-Left tf-padding-20 tf-font-size-20 tf-font-bold">
                <span class="fa fa-database"></span>
                <span>{!! $title !!}</span>
            </div>
        </div>
        <div class="tf-bg tf-color-white col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 tf-line-height-40">
                Total : {!! $modelBannerImage->totalRecords()  !!}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 tf-line-height-40 text-right"></div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tf_list_object"
             data-href-view="{!! route('tf.m.c.map.banner.image.view') !!}"
             data-href-del="{!! route('tf.m.c.map.banner.image.delete') !!}">
            <table class="table table-hover ">
                <tr>
                    <th>N_o</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                @if(count($dataBannerImage) > 0)
                    <?php
                    $perPage = $dataBannerImage->perPage();
                    $currentPage = $dataBannerImage->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataBannerImage as $imageObject)
                        <?php
                        $bannerId = $imageObject->bannerId();
                        $imageId = $imageObject->imageId();
                        $status = $imageObject->status();
                        ?>
                        <tr class="tf_object" data-object="{!! $imageId !!}">
                            <td class="tf-font-bold">
                                {!! $n_o += 1 !!}.
                            </td>
                            <td>
                                <img src="{!! $imageObject->pathImage() !!}">
                            </td>
                            <td>
                                @if($status == 1)
                                    <i class="glyphicon glyphicon-ok-circle tf-color-green tf-font-bold"></i>
                                @else
                                    <i class="glyphicon glyphicon-ok-circle tf-color-grey"></i>
                                @endif
                            </td>
                            <td class="text-right">
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
                            $hFunction->page($dataBannerImage);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection