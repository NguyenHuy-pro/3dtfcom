<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 *
 * modelStaff
 * modelLandShare
 * dataLandShare
 *
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
@extends('manage.content.map.land.share.index')
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
                Total : {!! $modelLandShare->totalRecords()  !!}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 tf-line-height-40 text-right">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tf_list_object"
             data-href-view="{!! route('tf.m.c.map.land.share.view') !!}">
            <table class="table table-hover ">
                <tr>
                    <th>N_o</th>
                    <th>Land</th>
                    <th class="text-center">To friends</th>
                    <th class="text-center">To email</th>
                    <th class="text-center">Get link</th>
                    <th class="text-center">Visit</th>
                    <th class="text-center">Register</th>
                    <th>Date</th>
                    <th></th>
                </tr>
                @if(count($dataLandShare) > 0)
                    <?php
                    $perPage = $dataLandShare->perPage();
                    $currentPage = $dataLandShare->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>

                    @foreach($dataLandShare as $shareObject)
                        <?php
                        $shareId = $shareObject->shareId();
                        $shareLink = $shareObject->shareLink();
                        $email = $shareObject->email();
                        $dataLand = $shareObject->land;
                        ?>
                        @if(!empty($dataLand))
                            <tr class="tf_object" data-object="{!! $shareId !!}">
                                <td>
                                    {!! $n_o +=1 !!}.
                                </td>
                                <td>
                                    {!! $dataLand->name() !!}
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
                                    {!! $shareObject->totalView() !!}
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
                        @endif
                    @endforeach
                    <tr>
                        <td class="text-center" colspan="9">
                            <?php
                            $hFunction->page($dataLandShare);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection