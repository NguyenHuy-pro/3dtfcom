<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 */
/*
 * modelStaff
 * modelBannerImageVisit
 * dataBannerImageVisit
 */
use Carbon\Carbon;

$hFunction = new Hfunction();

$actionStatus = false;
$dataStaffLogin = $modelStaff->loginStaffInfo();
if ($modelStaff->checkDepartmentBuild($dataStaffLogin->staffId()) && $dataStaffLogin->level() == 1) $actionStatus = true;
$title = 'Visit image of banner';
?>
@extends('manage.content.map.banner.image-visit.index')
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
                Total : {!! $modelBannerImageVisit->totalRecords()  !!}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 tf-line-height-40 text-right">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tf_list_object"
             data-href-view="{!! route('tf.m.c.map.banner.image.visit.view') !!}">
            <table class="table table-hover ">
                <tr>
                    <th>N_o</th>
                    <th>Image</th>
                    <th> Access IP</th>
                    <th>User</th>
                    <th>Date</th>
                    <th ></th>
                </tr>
                @if(count($dataBannerImageVisit) > 0)
                    <?php
                    $perPage = $dataBannerImageVisit->perPage();
                    $currentPage = $dataBannerImageVisit->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataBannerImageVisit as $visitObject)
                        <?php
                        $visitId = $visitObject->visit_id;
                        ?>
                        <tr class="tf_object" data-object="{!! $visitId !!}">
                            <td class="tf-font-bold">
                                {!! $n_o += 1!!}.
                            </td>
                            <td class="tf-vertical-middle">
                                <img src="{!! $visitObject->bannerImage->pathImage() !!}">
                            </td>
                            <td class="tf-vertical-middle">
                                {!! $visitObject->accessIP() !!}
                            </td>
                            <td class="tf-vertical-middle">
                                @if(empty($visitObject->userId()))
                                    <em>Null</em>
                                    @else
                                    {!! $visitObject->user->fullName() !!}
                                @endif
                            </td>
                            <td class="tf-vertical-middle">
                                {!! Carbon::parse($visitObject->createdAt())->format('d-m-Y') !!}
                            </td>
                            <td class="text-right tf-vertical-middle">
                                <a class="btn btn-default btn-xs tf-link  tf_object_view">
                                    <i class="glyphicon glyphicon-eye-open"></i> View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="text-center" colspan="6">
                            <?php
                            $hFunction->page($dataBannerImageVisit);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection