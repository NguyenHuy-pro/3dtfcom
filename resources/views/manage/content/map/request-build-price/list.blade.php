<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 */
/*
 * modelStaff
 * modelSize
 * modelRequestBuildPrice
 */

$hFunction = new Hfunction();

$actionStatus = false;
$dataStaffLogin = $modelStaff->loginStaffInfo();
if ($modelStaff->checkDepartmentBuild($dataStaffLogin->staffId()) && $dataStaffLogin->level() == 1) $actionStatus = true;
$title = 'Build price';
?>
@extends('manage.content.map.request-build-price.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-Left tf-padding-20 tf-font-size-20 tf-font-bold">
                <span class="fa fa-database"></span>
                <span>{!! $title !!}</span>
            </div>
        </div>
        <div class="tf-bg col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="tf-line-height-40 col-xs-4 col-sm-4 col-md-4 col-lg-4 ">
                <a class="tf-link-white" href="{!! route('tf.m.c.map.request_build_price.list') !!}">
                    <i class="glyphicon glyphicon-refresh"></i>
                </a>&nbsp;
                <span class="tf-color-white">Total : {!! $modelRequestBuildPrice->totalRecords() !!}</span>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-right tf-line-height-40">
                <select class="tf_m_c_request_build_price_filter"
                        data-href="{!! route('tf.m.c.map.request_build_price.filter') !!}"
                        name="cbFilterSize">
                    <option value="">All</option>
                    {!! $modelSize->getOption((isset($filterSizeId))?$filterSizeId:'') !!}
                </select>
            </div>
            <div class="text-right tf-line-height-40 col-xs-4 col-sm-4 col-md-4 col-lg-4">
                @if($actionStatus)
                    <a href="{!! route('tf.m.c.map.request_build_price.add.get') !!}">
                        <button class="btn btn-primary tf-link-white-bold">
                            <i class="fa fa-plus"></i> &nbsp;Add new
                        </button>
                    </a>
                @endif
            </div>
        </div>
        <div class="tf_list_object col-xs-12 col-sm-12 col-md-12 col-lg-12"
             data-href-view="{!! route('tf.m.c.map.request_build_price.view') !!}"
             data-href-edit="{!! route('tf.m.c.map.request_build_price.edit.get') !!}">
            <table class="table table-hover">
                <tr>
                    <th>No</th>
                    <th>Size <br/>(Width\Height)</th>
                    <th>Price</th>
                    <th>Staff</th>
                    <th></th>
                </tr>
                @if(count($dataRequestBuildPrice)>0)
                    <?php
                    $perPage = $dataRequestBuildPrice->perPage();
                    $currentPage = $dataRequestBuildPrice->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage;
                    ?>
                    @foreach($dataRequestBuildPrice as $buildPrice)
                        <?php
                        $priceId = $buildPrice->priceId();
                        ?>
                        <tr class="tf_object" data-object="{!! $priceId !!}">
                            <td>
                                {!! $n_o += 1 !!}.
                            </td>
                            <td>
                                {!! $buildPrice->size->name() !!}
                            </td>
                            <td>
                                {!! $buildPrice->price() !!}
                            </td>
                            <td>
                                {!! $buildPrice->staff->fullName() !!}
                            </td>
                            <td class="text-right">
                                <a class="btn btn-default btn-xs tf_object_view">
                                    <i class="glyphicon glyphicon-eye-open tf-color"></i> View
                                </a>
                                @if($actionStatus)
                                    <a class="tf_object_edit btn btn-primary btn-xs">
                                        <i class="glyphicon glyphicon-edit tf-color"></i> Edit
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="text-center" colspan="5">
                            <?php
                            $hFunction->page($dataRequestBuildPrice);
                            ?>
                        </td>
                    </tr>
                @else
                    <tr>
                        <td class="text-center" colspan="5">
                            <em>Not found</em>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection