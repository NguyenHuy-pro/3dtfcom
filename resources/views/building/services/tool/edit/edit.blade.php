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
            {!! trans('frontend_building.service_articles_edit_title') !!}
        </div>
        <div class="panel-body">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-12">
                <form role="form"
                      class="tf_building_service_tool_articles_edit tf-building-service-articles-edit form-horizontal"
                      data-articles="{!! $dataBuildingArticles->articlesId() !!}"
                      enctype="multipart/form-data" method="post"
                      action="{!! route('tf.building.services.tool.article.edit.post',$dataBuildingArticles->articlesId()) !!}">
                    <div class="form-group form-group-sm">
                        <label>
                            {!! trans('frontend_building.service_articles_edit_type_label') !!}
                            <i class="glyphicon glyphicon-star tf-color-red"></i>
                        </label>
                        <select class="form-control" name="cbServiceType">
                            @if(count($dataBuildingServiceType) > 0)
                                @foreach($dataBuildingServiceType as $buildingServiceType)
                                    <option value="{!! $buildingServiceType->typeId() !!}"
                                            @if($dataBuildingArticles->typeId() == $buildingServiceType->typeId()) selected="selected" @endif >
                                        {!! $buildingServiceType->name() !!}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group form-group-sm">
                        <label>
                            {!! trans('frontend_building.service_articles_edit_title_label') !!}
                            <i class="glyphicon glyphicon-star tf-color-red"></i>
                        </label>
                        <input type="text" class="form-control" name="txtTitle"
                               value="{!! $dataBuildingArticles->name() !!}">
                    </div>
                    @if(!empty($dataBuildingArticles->avatar()))
                        <div class="form-group form-group-sm">
                            <label>
                                {!! trans('frontend_building.service_articles_edit_old_avatar_label') !!}
                            </label>
                            <br/>
                            <img class="" alt="old-avatar" style="max-width: 100px;"
                                 src="{!! $dataBuildingArticles->pathSmallImage() !!}">
                        </div>
                    @endif
                    <div class="form-group form-group-sm">
                        <label>
                            {!! trans('frontend_building.service_articles_edit_avatar_label') !!}
                        </label>
                        <input class="tf_txtAvatar" style="display: none;" type="file" name="txtAvatar">
                        <br/>
                        <img class="tf_select_image tf-link tf-icon-30" alt="upload-image"
                             src="{!! asset('public\main\icons\Photograph.png') !!}">
                    </div>
                    <div class="tf_avatar_preview form-group"></div>
                    <div class="form-group form-group-sm">
                        <label>
                            {!! trans('frontend_building.service_articles_edit_short_description_label') !!}
                            <i class="glyphicon glyphicon-star tf-color-red"></i>
                        </label>
                        <input type="text" class="form-control" name="txtShortDescription"
                               value="{!! $dataBuildingArticles->shortDescription() !!}">
                    </div>
                    <div class="form-group ">
                        <label>
                            {!! trans('frontend_building.service_articles_edit_content_label') !!}
                            <i class="glyphicon glyphicon-star tf-color-red"></i>
                        </label>
                        <textarea id="txtBuildingArticlesContent" class="form-control" name="txtContent"
                                  rows="5">{!! $dataBuildingArticles->content() !!}</textarea>
                        <script type="text/javascript">ckeditor('txtBuildingArticlesContent', true)</script>
                    </div>
                    {{--<div class="form-group">
                        <a class="tf-link" href="#">
                            + {!! trans('frontend_building.service_articles_add_relation_img_label') !!}
                        </a>
                    </div>--}}
                    <div class="form-group form-group-sm">
                        <label>
                            {!! trans('frontend_building.service_articles_add_link_label') !!}
                        </label>
                        <textarea class="form-control" name="txtLink"
                                  rows="3">{!! $dataBuildingArticles->link() !!}</textarea>
                    </div>
                    <div class="form-group form-group-sm">
                        <label>
                            {!! trans('frontend_building.service_articles_edit_keyword_label') !!}
                        </label>
                        <input type="text" class="form-control" name="txtKeyWord"
                               value="{!! $dataBuildingArticles->keyword() !!}">
                    </div>
                    <div class="form-group form-group-sm">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <button class="tf_save btn btn-sm btn-primary" type="button">
                            {!! trans('frontend_building.service_articles_edit_save_label') !!}
                        </button>
                        <button class="btn btn-sm btn-default" type="reset">
                            {!! trans('frontend_building.service_articles_edit_reset_label') !!}
                        </button>
                        <button class="tf_main_contain_action_close btn btn-sm btn-default" type="button">
                            {!! trans('frontend_building.service_articles_edit_close_label') !!}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
