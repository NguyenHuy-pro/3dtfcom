<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 */
/*
 * modelStaff
 * modelBannerLicense
 * dataBannerLicense
 */
use Carbon\Carbon;

$hFunction = new Hfunction();

$actionStatus = false;
$dataStaffLogin = $modelStaff->loginStaffInfo();
if ($modelStaff->checkDepartmentBuild($dataStaffLogin->staffId()) && $dataStaffLogin->level() == 1) $actionStatus = true;
$title = 'License';
?>
@extends('manage.content.map.banner.license.index')
@section('tf_m_c_container_object')
    <div class="row tf_m_c_map_banner_license tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-Left tf-padding-20 tf-font-size-20 tf-font-bold">
                <span class="fa fa-database"></span>
                <span>{!! $title !!}</span>
            </div>
        </div>
        <div class="tf-bg tf-color-white col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 tf-line-height-40">
                Total : {!! $modelBannerLicense->totalRecords()  !!}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 tf-line-height-40 text-right"></div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tf_list_object"
             data-href-view="{!! route('tf.m.c.map.banner.license.view') !!}">
            <table class="table table-hover ">
                <tr>
                    <th>N_o</th>
                    <th>Code</th>
                    <th>Begin</th>
                    <th>End</th>
                    <th>User</th>
                    <th></th>
                </tr>
                @if(count($dataBannerLicense) > 0)
                    <?php
                    $perPage = $dataBannerLicense->perPage();
                    $currentPage = $dataBannerLicense->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataBannerLicense as $licenseObject)
                        <?php
                        $licenseId = $licenseObject->licenseId();
                        ?>
                        <tr class="tf_object" data-object="{!! $licenseId !!}">
                            <td class="text-center tf-font-bold">
                                {!! $n_o +=1 !!}.
                            </td>
                            <td>
                                {!! $licenseObject->name() !!}
                            </td>
                            <td>
                                {!! $licenseObject->dateBegin() !!}
                            </td>
                            <td>
                                {!! $licenseObject->dateEnd() !!}
                            </td>
                            <td>
                                {!! $licenseObject->user->fullName() !!}
                            </td>

                            <td class="text-center">
                                <a class="btn btn-default btn-xs tf-link  tf_object_view">
                                    <i class="glyphicon glyphicon-eye-open"></i> View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="text-center" colspan="6">
                            <?php
                            $hFunction->page($dataBannerLicense);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection