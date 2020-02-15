<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/18/2016
 * Time: 9:39 AM
 */
use App\Models\Manage\Content\Building\TfBuilding;
use App\Models\Manage\Content\Building\Banner\TfBuildingBanner;
$buildingId = $dataBuildingBanner->buildingId();
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="panel panel-default tf-margin-bot-none">
        <div class="panel-heading tf-bg tf-color-white">
            <i class="fa fa-eye"></i>
            Detail banner
            <button class="btn btn-default btn-xs tf_m_c_container_close pull-right">Close</button>
        </div>
        <div class="panel-body">
            <table class="table table-bordered tf-border-none">
                <tr>
                    <td colspan="2" class="text-right tf-border-top-none">
                        <i class="fa fa-calendar"></i>
                        <span style="color: black;">{!! $dataBuildingBanner->createdAt() !!}</span>
                    </td>
                </tr>
                <tr>
                    <td class="col-md-2 text-right">
                        Building :
                    </td>
                    <td class="col-md-10 tf-vertical-middle ">
                        {!! $dataBuildingBanner->building->name() !!}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="tf-border-none">
                        <img style="max-width: 100%;" alt="banner-image"
                             src="{!! $dataBuildingBanner->pathFullImage() !!}"/>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endsection