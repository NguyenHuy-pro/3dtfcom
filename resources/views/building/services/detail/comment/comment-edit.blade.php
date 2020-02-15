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
            {!! trans('frontend_building.service_article_detail_comment_edit_title_label') !!}
        </div>
        <div class="panel-body">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-12">
                <form role="form"
                      class="tf_building_service_articles_comment_edit form-horizontal"
                      enctype="multipart/form-data" method="post"
                      action="{!! route('tf.building.services.article.detail.comment.edit.post') !!}">
                    <div class="form-group ">
                        <label>
                            {!! trans('frontend_building.service_articles_edit_content_label') !!}
                            <i class="glyphicon glyphicon-star tf-color-red"></i>
                        </label>
                        <textarea class="form-control" name="txtCommentContent" rows="5">{!! $dataBuildingArticlesComment->content() !!}</textarea>
                    </div>
                    <div class="form-group form-group-sm">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <input type="hidden" name="txtComment"
                               value="{!! $dataBuildingArticlesComment->commentId() !!}">
                        <button class="tf_save btn btn-sm btn-primary" type="button">
                            {!! trans('frontend_building.service_article_detail_comment_edit_save_label') !!}
                        </button>
                        <button class="tf_main_contain_action_close btn btn-sm btn-default" type="button">
                            {!! trans('frontend_building.service_article_detail_comment_edit_cancel_label') !!}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
