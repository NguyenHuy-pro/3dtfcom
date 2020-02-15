<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/18/2016
 * Time: 9:39 AM
 *
 * $dataRuleBannerRank
 *
 */
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="panel panel-default tf-margin-bot-none">
        <div class="panel-heading tf-bg tf-color-white">
            <i class="fa fa-eye"></i>
            Detail info
            <button class="btn btn-primary btn-xs tf_m_c_container_close pull-right">Close</button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="text-right col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span style="color: black;">{!! $dataRuleBannerRank->createdAt() !!}</span>
                </div>
            </div>
            <div class="row">
                <div class="tf-padding-bot-30 col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                    <table class="table table-bordered tf-border-none">
                        <tr>
                            <td class="text-right tf-border-top-none col-xs-4 col-sm-3 col-md-2 col-lg-2 ">
                                <label><em>Size</em></label>
                            </td>
                            <td class="tf-border-top-none col-xs-8 col-sm-9 col-md-10 col-lg-10">
                                ({!! $dataRuleBannerRank->size->width().' x '.$dataRuleBannerRank->size->height() !!})px
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right col-xs-4 col-sm-3 col-md-2 col-lg-2 ">
                                <label><em>Sale price</em></label>
                            </td>
                            <td class="col-xs-8 col-sm-9 col-md-10 col-lg-10">
                                {!! $dataRuleBannerRank->salePrice() !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right col-xs-4 col-sm-3 col-md-2 col-lg-2 ">
                                <label><em>Sale month</em></label>
                            </td>
                            <td class="col-xs-8 col-sm-9 col-md-10 col-lg-10">
                                {!! $dataRuleBannerRank->saleMonth() !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right col-xs-4 col-sm-3 col-md-2 col-lg-2 ">
                                <label><em>Free month</em></label>
                            </td>
                            <td class="col-xs-8 col-sm-9 col-md-10 col-lg-10">
                                {!! $dataRuleBannerRank->freeMonth() !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right">
                                <label><em>Rank</em></label>
                            </td>
                            <td>
                                {!! $dataRuleBannerRank->rank->rankValue() !!}
                            </td>
                        </tr>

                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection