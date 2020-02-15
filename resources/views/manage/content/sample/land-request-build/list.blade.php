<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 */
/*
 * modelStaff
 * modelLandRequestBuild
 * dataLandRequestBuild
 *
 */

$hFunction = new Hfunction();
$dataStaffLogin = $modelStaff->loginStaffInfo();

$actionStatus = false;
if ($dataStaffLogin->checkDepartmentDesign()) $actionStatus = true;

$title = 'Request build';
?>
@extends('manage.content.sample.land-request-build.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        @if($dataStaffLogin->level() == 1)
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="text-Left col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h4><span class="fa fa-database"></span> &nbsp;{!! $title !!}</h4>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="background-color: #BFCAE6;">
                <div class="tf-line-height-40 col-xs-6 col-sm-6 col-md-6 col-lg-12">
                Total : {!! $modelLandRequestBuild->totalRecords() !!}
                </div>
                <div class="tf-line-height-40 text-right col-xs-6 col-sm-6 col-md-6 col-lg-12 "></div>
            </div>
            <div class="tf_list_object col-xs-12 col-sm-12 col-md-12 col-lg-12"
                 data-href-view="{!! route('tf.m.c.sample.land_request_build.view') !!}"
                 data-href-assignment="{!! route('tf.m.c.sample.land_request_build.assignment.get') !!}">
                <table class="table table-hover">
                    <tr>
                        <th>No</th>
                        <th>Sample</th>
                        <th>User</th>
                        <th>Design status</th>
                        <th></th>
                    </tr>
                    @if(count($dataLandRequestBuild) > 0)
                        <?php
                        $perPage = $dataLandRequestBuild->perPage();
                        $currentPage = $dataLandRequestBuild->currentPage();
                        $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                        ?>
                        @foreach($dataLandRequestBuild as $landRequestBuild)
                            <?php
                            $requestId = $landRequestBuild->requestId();
                            $dataLandRequestBuildDesign = $landRequestBuild->landRequestBuildDesignOfRequest();
                            ?>
                            <tr class="tf_object" data-object="{!! $requestId !!}">
                                <td>
                                    {!! $n_o += 1 !!}.
                                </td>
                                <td>
                                    <img style="width: 96px; height: 64px;"
                                         src="{!! $landRequestBuild->pathImage() !!}" alt="sample">
                                </td>
                                <td>
                                    {!! $landRequestBuild->landLicense->user->fullName()  !!}
                                </td>
                                <td>
                                    @if(count($dataLandRequestBuildDesign) > 0)
                                        <em class="tf-color-grey">Processing</em>
                                    @else
                                        @if($actionStatus)
                                            <a class="tf_design_assignment tf-link-green">
                                                Design assignment
                                            </a>
                                        @else
                                            <em class="tf-color-grey">Null</em>
                                        @endif
                                    @endif

                                </td>
                                <td class="text-right">
                                    <a class="tf_object_view btn btn-default btn-xs">
                                        <i class="glyphicon glyphicon-eye-open tf-color"></i> View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        <tr class="odd gradeX" align="center">
                            <td colspan="5">
                                <?php
                                $hFunction->page($dataLandRequestBuild);
                                ?>
                            </td>
                        </tr>
                    @else
                        <tr align="center">
                            <td class="text-center" colspan="5">
                                <em>Not found</em>
                            </td>
                        </tr>
                    @endif
                </table>
            </div>
        @else
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="tf-color-red text-center tf-padding-30 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    You do not have access.
                </div>
            </div>
        @endif
    </div>
@endsection