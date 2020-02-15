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
$staffLevel = $dataStaffLogin->level();
if ($dataStaffLogin->checkDepartmentDesign()) {
    $actionStatus = true;
}

?>
@extends('manage.content.sample.land-request-build-design.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="text-Left col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h4><span class="fa fa-database"></span> &nbsp; Design list</h4>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="background-color: #BFCAE6;">
            <div class="tf-line-height-40 col-xs-6 col-sm-6 col-md-6 col-lg-12">

            </div>
            <div class="tf-line-height-40 text-right col-xs-6 col-sm-6 col-md-6 col-lg-12 "></div>
        </div>
        <div class="tf_list_object col-xs-12 col-sm-12 col-md-12 col-lg-12"
             data-href-view="{!! route('tf.m.c.sample.land_request_build_design.view') !!}"
             data-href-upload="{!! route('tf.m.c.sample.land_request_build_design.design.get') !!}"
             data-href-publish="{!! route('tf.m.c.sample.land_request_build_design.publish.confirm') !!}">
            <table class="table table-hover">
                <tr>
                    <th>No</th>
                    <th>Sample</th>
                    <th>Designer</th>
                    <th>Design</th>
                    <th>Publish</th>
                    <th>deadline</th>
                    <th></th>
                </tr>
                @if(count($dataLandRequestBuildDesign) > 0)
                    <?php
                    $perPage = $dataLandRequestBuildDesign->perPage();
                    $currentPage = $dataLandRequestBuildDesign->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataLandRequestBuildDesign as $design)
                        <?php
                        $designId = $design->designId();
                        $image = $design->image();
                        ?>
                        <tr class="tf_object" data-object="{!! $designId !!}">
                            <td>
                                {!! $n_o += 1 !!}.
                            </td>
                            <td>
                                <img style="width: 96px; height: 64px;"
                                     src="{!! $design->landRequestBuild->pathImage() !!}" alt="sample">
                            </td>
                            <td>
                                {!! $design->staff->fullName()  !!}
                            </td>
                            <td>
                                @if(empty($image))
                                    @if($staffLevel == 2)
                                        <a class="tf_design_upload tf-link btn btn-default">
                                            Upload
                                        </a>
                                    @else
                                        Null
                                    @endif
                                @else
                                    <img src="{!! $design->pathImage() !!}" alt="design">
                                @endif
                            </td>
                            <td>
                                @if(empty($image))
                                    Null
                                @else
                                    @if($staffLevel == 1)
                                        <a class="tf_design_publish tf-link-green" data-publish="y">
                                            Yes
                                        </a>
                                        &nbsp;|&nbsp;
                                        <a class="tf_design_publish tf-link-green" data-publish="n">
                                            No
                                        </a>
                                    @else
                                        Processing
                                    @endif
                                @endif
                            </td>
                            <td>
                                {!! $design->deliveryDate() !!}
                            </td>
                            <td class="text-right">
                                <a class="tf_object_view btn btn-default btn-xs">
                                    <i class="glyphicon glyphicon-eye-open tf-color"></i> View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="odd gradeX" align="center">
                        <td colspan="7">
                            <?php
                            $hFunction->page($dataLandRequestBuildDesign);
                            ?>
                        </td>
                    </tr>
                @else
                    <tr align="center">
                        <td class="text-center" colspan="7">
                            <em>Not found</em>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection