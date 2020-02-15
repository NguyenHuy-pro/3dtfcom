<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 */
/*
 * modelStaff
 * modelBuildingBanner
 * dataBuildingBanner
 */
use Carbon\Carbon;

$hFunction = new Hfunction();
?>
@extends('manage.content.building.index')
@section('tf_m_c_building_content')
    <div class="row tf_m_c_building_banner tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            <h3>List banner</h3>
        </div>
        <div class="tf-bg tf-color-white col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 tf-line-height-40">
                Total : {!! $modelBuildingBanner->totalRecords()  !!}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 tf-line-height-40 text-right"></div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tf_list_object"
             data-href-view="{!! route('tf.m.c.building.banner.view') !!}"
             data-href-del="{!! route('tf.m.c.building.banner.delete') !!}">
            <table class="table table-hover ">
                <tr>
                    <th class="tf-width-70 text-center">N_o</th>
                    <th>Image</th>
                    <th>Building</th>
                    <th>Date</th>
                    <th class="tf-width-200"></th>
                </tr>
                @if(count($dataBuildingBanner) > 0)
                    <?php
                    $perPage = $dataBuildingBanner->perPage();
                    $currentPage = $dataBuildingBanner->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataBuildingBanner as $bannerObject)
                        <?php
                        $bannerId = $bannerObject->bannerId();
                        $buildingId = $bannerObject->buildingId();
                        ?>
                        <tr class="tf_object" data-object="{!! $bannerId !!}">
                            <td class="text-center">
                                {!! $n_o +=1 !!}.
                            </td>
                            <td>
                                <img style="width: 64px; height: 32px" alt="banner-image"
                                     src="{!! $bannerObject->pathSmallImage() !!}"/>
                            </td>
                            <td>
                                {!! $bannerObject->building->name() !!}
                            </td>
                            <td>
                                {!! Carbon::parse($bannerObject->createdAt())->format('d-m-Y') !!}
                            </td>
                            <td class="text-center">
                                <a class="btn btn-default btn-xs  tf_object_view">
                                    <img class="tf-icon-14" src="{!! asset('public/main/icons/observ.png') !!}"> View
                                </a>
                                <a class="btn btn-default btn-xs tf_object_delete">
                                    <img class="tf-icon-14" src="{!! asset('public/main/icons/del.png') !!}"> Delete
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="text-center" colspan="5">
                            <?php
                            $hFunction->page($dataBuildingBanner);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection

@section('tf_m_js_page_footer')
    <script src="{{ url('public/manage/content/building/js/building-banner.js')}}"></script>
@endsection