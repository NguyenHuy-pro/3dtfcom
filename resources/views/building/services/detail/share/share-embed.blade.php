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
@extends('components.container.contain-action-6')
@section('tf_main_action_content')
    <div id="tf_building_service_article_detail_share_embed" class=" panel panel-default tf-margin-none">
        <div class="panel-heading tf-bg tf-color-white ">
            <i class="glyphicon glyphicon-link tf-font-size-14"></i>
            <span>{!! trans('frontend_building.service_article_detail_share_embed_title') !!}</span>
        </div>
        <div class="panel-body">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-12">
                <form role="form" class="form-horizontal"
                      enctype="multipart/form-data" method="post" action="">
                    <div class="form-group ">
                        <textarea class="tf_article_embed_get_link_copy form-control" name="txtCommentContent" rows="5"><iframe width="560" height="315" src="{!! route('tf.building.services.article.detail.embed',$dataBuildingArticles->alias()) !!}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe></textarea>
                    </div>
                    <div class="text-right form-group form-group-sm">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <input type="hidden" name="txtArticles"
                               value="{!! $dataBuildingArticles->articlesId() !!}">
                        <button class="tf_article_embed_get_link btn btn-sm btn-primary" type="button">
                            {!! trans('frontend_building.service_article_detail_share_embed_copy') !!}
                        </button>
                        <button class="tf_main_contain_action_close btn btn-sm btn-default" type="button">
                            {!! trans('frontend_building.service_article_detail_share_embed_cancel') !!}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
