<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/6/2016
 * Time: 11:15 AM
 *
 * $dataBuildingArticles
 */

?>
@extends('components.container.contain-action-8')
@section('tf_main_action_content')
    <div class="panel panel-default tf-margin-none">
        <div class="panel-heading tf-bg tf-color-white ">
            <i class="fa fa-edit tf-font-size-14"></i>
            {!! trans('frontend_building.about_description_edit_title') !!}
        </div>
        <div class="panel-body">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-12">
                <form id="tf_building_about_description_edit" role="form" class="form-horizontal"
                      enctype="multipart/form-data" method="post"
                      action="{!! route('tf.building.about.content.edit.post') !!}">
                    <div class="form-group form-group-sm">
                        <label>
                            {!! trans('frontend_building.about_description_edit_short_description_label') !!}
                            <i class="glyphicon glyphicon-star tf-color-red"></i>
                        </label>
                        <input type="text" class="form-control" name="txtShortDescription"
                               value="{!! $dataBuilding->shortDescription() !!}">
                    </div>
                    <div class="form-group ">
                        <label>
                            {!! trans('frontend_building.about_description_edit_description_label') !!}
                            <i class="glyphicon glyphicon-star tf-color-red"></i>
                        </label>
                        <textarea id="txtBuildingDescription" class="form-control" name="txtBuildingDescription">{!! $dataBuilding->description() !!}</textarea>
                        <script type="text/javascript">ckeditor('txtBuildingDescription', true)</script>
                    </div>
                    <div class="form-group form-group-sm">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <input type="hidden" name="txtBuilding" value="{!! $dataBuilding->buildingId() !!}" >
                        <button class="tf_save btn btn-sm btn-primary" type="button">
                            {!! trans('frontend_building.about_description_edit_save_label') !!}
                        </button>
                        <button class="btn btn-sm btn-default" type="reset">
                            {!! trans('frontend_building.about_description_edit_reset_label') !!}
                        </button>
                        <button class="tf_main_contain_action_close btn btn-sm btn-default" type="button">
                            {!! trans('frontend_building.about_description_edit_close_label') !!}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
