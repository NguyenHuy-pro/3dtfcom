<?php
/*
 * modelBuilding
 * dataBuilding
 * dataBusiness
 */
#building info
$buildingId = $dataBuilding->buildingId();
$displayName = $dataBuilding->displayName();
$widthSample = $dataBuilding->buildingSample->size->width();
$maxName = (($widthSample / 32) * 4); // max length of name // 32px = 6 character
$maxName = ($widthSample > 64) ? $maxName - 2 : $maxName;

$buildingBusinessId = $modelBuilding->listBusinessId($buildingId);

?>
@extends('components.container.contain-action-8')
@section('tf_main_action_content')
    <form id="frmMapBuildingEdit" name="frmMapBuildingEdit"
          class="panel panel-default tf-border-none tf-padding-none tf-margin-bot-none col-xs-12 col-sm-12 col-md-12 col-lg-12 "
          data-building="{!! $buildingId !!}" data-land="{!! $dataBuilding->landId() !!}"
          method="post" action="{!! route('tf.map.building.info.edit.post',$buildingId) !!}">
        <div id="tfMapBuildingEdit_header" class="panel-heading tf-bg tf-color-white tf-border-none ">
            <i class="fa fa-pencil-square-o tf-font-size-16"></i> &nbsp;
            {!! trans('frontend_map.building_info_edit_title') !!}
        </div>
        <div id="tfMapBuildingEdit_body" class="panel-body tf-padding-lef-50 tf-padding-rig-50 tf-overflow-auto">
            <div class="form-group">
                <label>
                    {!! trans('frontend_map.building_info_edit_name_label') !!}
                </label><span class="tf-color-red">*</span>
                <input name="txtName" type="text" class="form-control" value="{!! $dataBuilding->name() !!}">
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label>{!! trans('frontend_map.land_build_add_show_name_label') !!}</label>
                        <em>(At most {!! $maxName !!} words)</em>
                        <span class="tf-color-red">*</span>
                        <input data-length="{!! $maxName !!}" name="txtDisplayName" type="text" class="form-control"
                               value="{!! $displayName !!}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group text-center">
                        <span id="txtPreviewName">{!! $displayName !!}</span>
                        <br/>
                        <img alt="sample" src="{!! $dataBuilding->buildingSample->pathImage() !!}"/>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>
                    {!! trans('frontend_map.building_info_edit_business_label') !!}
                </label><span class="tf-color-red">*</span>

                <div class="form-control" style="height: 200px">
                    <ul class="list-group ">
                        <?php
                        $checkAllStatus = true;
                        ?>
                        <li class="list-group-item tf-margin-padding-none tf-border-none">
                            <ul class="list-group" style="max-height: 150px; overflow: auto;">
                                @foreach($dataBusiness as $business)
                                    <?php
                                    if (!in_array($business->business_id, $buildingBusinessId)) $checkAllStatus = false;
                                    ?>
                                    <li class="list-group-item tf-border-none tf-padding-bot-none">
                                        <div class="checkbox tf-margin-padding-none">
                                            <label>
                                                <input class="buildingBusiness" name="buildingBusiness[]"
                                                       @if(in_array($business->businessId(), $buildingBusinessId))checked="checked"
                                                       @endif
                                                       type="checkbox" value="{!! $business->businessId() !!}">
                                                {!! $business->name() !!}
                                            </label>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="col-md-12 tf-padding-lef-30 tf-padding-bot-10">
                    <input id="frmMapBuildingEdit_check_all" type="checkbox"
                           @if($checkAllStatus) checked="checkedx" @endif> Check all
                </div>
            </div>
            <div class="form-group">
                <label>
                    {!! trans('frontend_map.building_info_edit_summary_label') !!}
                </label><span class="tf-color-red">*</span>
                <input name="txtShortDescription" type="text" class="form-control"
                       value="{!! $dataBuilding->shortDescription() !!}">
            </div>
            <div class="form-group">
                <label>
                    {!! trans('frontend_map.building_info_edit_description_label') !!}
                </label>
                <textarea id="txtDescription" class="form-control" name="txtDescription"
                          rows="10">{!! $dataBuilding->description() !!}</textarea>
                <script type="text/javascript">ckeditor('txtDescription')</script>
            </div>
            <div class="form-group">
                <label>
                    {!! trans('frontend_map.building_info_edit_website_label') !!}
                </label>
                <input name="txtWebsite" type="text" class="form-control" value="{!! $dataBuilding->website() !!}">
            </div>
            <div class="form-group">
                <label>
                    {!! trans('frontend_map.building_info_edit_email_label') !!}
                </label>
                <input name="txtEmail" type="text" class="form-control" placeholder="Enter email"
                       value="{!! $dataBuilding->email() !!}">
            </div>
            <div class="form-group">
                <label>
                    {!! trans('frontend_map.building_info_edit_phone_label') !!}
                </label>
                <input name="txtPhone" type="text" class="form-control" value="{!! $dataBuilding->phone() !!}">
            </div>
            <div class="form-group">
                <label>
                    {!! trans('frontend_map.building_info_edit_address_label') !!}
                </label>
                <input name="txtAddress" type="text" class="form-control" value="{!! $dataBuilding->address() !!}">
            </div>
        </div>
        <div id="tfMapBuildingEdit_footer"
             class="panel panel-footer text-center tf-border-none tf-margin-bot-none tf-bg-whitesmoke">
            <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
            <button type="button" class="tf_save btn btn-primary">
                {!! trans('frontend_map.button_save') !!}
            </button>
            <button type="button" class="tf_main_contain_action_close btn btn-default ">
                {!! trans('frontend_map.button_close') !!}
            </button>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                var headerHeight = $('#tfMapBuildingEdit_header').outerHeight();
                var footerHeight = $('#tfMapBuildingEdit_footer').outerHeight();
                $('#tfMapBuildingEdit_body').css('height', windowHeight - headerHeight - footerHeight - 80);
            });
        </script>
    </form>
@endsection