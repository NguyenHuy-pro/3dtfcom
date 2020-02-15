<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 *
 *
 * modelStaff
 * modelBannerShare
 *
 */
/*
 * modelStaff
 * modelBannerShare
 * dataBannerShare
 */
use Carbon\Carbon;

$hFunction = new Hfunction();
#login info
$dataStaffLogin = $modelStaff->loginStaffInfo();
$staffLoginId = $dataStaffLogin->staffId();
$staffLoginLevel = $dataStaffLogin->level();
$actionStatus = false;

if ($modelStaff->checkDepartmentBuild() && $staffLoginLevel == 1) $actionStatus = true;
$title = 'Share';
?>
@extends('manage.content.map.banner.share.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="col-xs-12 col-sm-12 col-md-12 text-Left tf-padding-20 tf-font-size-20 tf-font-bold">
                <span class="fa fa-database"></span>
                <span>{!! $title !!}</span>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12" style="background-color: #BFCAE6;">
            <div class="col-md-6 tf-line-height-40">
                Total : {!! $modelBannerShare->totalRecords()  !!}
            </div>
            <div class="col-md-6 tf-line-height-40 text-right"></div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 tf_list_object"
             data-href-view="{!! route('tf.m.c.map.banner.share.view') !!}">
            <table class="table table-hover ">
                <tr>
                    <th>N_o</th>
                    <th>Banner</th>
                    <th class="text-center">To friends</th>
                    <th class="text-center">To email</th>
                    <th class="text-center">Get link</th>
                    <th class="text-center">Visit</th>
                    <th class="text-center">Register</th>
                    <th>Date</th>
                    <th></th>
                </tr>
                @if(count($dataBannerShare) > 0)
                    <?php
                    $perPage = $dataBannerShare->perPage();
                    $currentPage = $dataBannerShare->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataBannerShare as $shareObject)
                        <?php
                        $shareId = $shareObject->shareId();
                        $shareLink = $shareObject->shareLink();
                        $email = $shareObject->email();
                        $totalVisit = $shareObject->totalView();
                        ?>
                        <tr class="tf_object" data-object="{!! $shareId !!}">
                            <td class="tf-font-bold">
                                {!! $n_o +=1 !!}.
                            </td>
                            <td>
                                {!!$shareObject->banner->name() !!}
                            </td>
                            <td class="text-center">
                                @if(empty($shareLink) && empty($email))
                                    <i class="glyphicon glyphicon-ok-circle tf-color-green tf-font-bold"></i>
                                @else
                                    <i class="glyphicon glyphicon-ok-circle tf-color-grey"></i>
                                @endif
                            </td>
                            <td class="text-center">
                                @if(!empty($email))
                                    <i class="glyphicon glyphicon-ok-circle tf-color-green tf-font-bold"></i>
                                @else
                                    <i class="glyphicon glyphicon-ok-circle tf-color-grey"></i>
                                @endif
                            </td>
                            <td class="text-center">
                                @if(!empty($shareLink) && empty($email))
                                    <i class="glyphicon glyphicon-ok-circle tf-color-green tf-font-bold"></i>
                                @else
                                    <i class="glyphicon glyphicon-ok-circle tf-color-grey"></i>
                                @endif
                            </td>
                            <td class="text-center">
                                {!! $totalVisit !!}
                            </td>
                            <td class="text-center">
                                {!! $shareObject->totalViewRegister() !!}
                            </td>
                            <td>
                                {!! Carbon::parse($shareObject->createdAt())->format('d-m-Y') !!}
                            </td>
                            <td class="text-right">
                                <a class="btn btn-default btn-xs tf-link  tf_object_view">
                                    <i class="glyphicon glyphicon-eye-open"></i> View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="text-center" colspan="9">
                            <?php
                            $hFunction->page($dataBannerShare);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection