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
 * modelRuleBannerRank
 */

$hFunction = new Hfunction();

$actionStatus = false;
$dataStaffLogin = $modelStaff->loginStaffInfo();
if ($modelStaff->checkDepartmentBuild($dataStaffLogin->staffId()) && $dataStaffLogin->level() == 1) $actionStatus = true;
$title = 'Banner rule';
?>
@extends('manage.content.map.rule-banner-rank.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-Left tf-padding-20 tf-font-size-20 tf-font-bold">
                <span class="fa fa-database"></span>
                <span>{!! $title !!}</span>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tf-bg ">
            <div class="tf-line-height-40 col-xs-4 col-sm-4 col-md-4 col-lg-4 ">
                <a class="tf-link-white" href="{!! route('tf.m.c.map.rule_banner_rank.list') !!}">
                    <i class="glyphicon glyphicon-refresh"></i>
                </a>&nbsp;
                <span class="tf-color-white">
                    Total : {!! $modelRuleBannerRank->totalRecords() !!}
                </span>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-right tf-line-height-40">
                <select class="tf_m_c_rule_land_rank_filter"
                        data-href="{!! route('tf.m.c.map.rule_banner_rank.filter') !!}" name="cbFilterType">
                    <option value="">All</option>
                    {!! $modelSize->getOption((isset($filterSizeId))?$filterSizeId:'') !!}
                </select>
            </div>
            <div class="text-right tf-line-height-40 col-xs-4 col-sm-4 col-md-4 col-lg-4">
                @if($actionStatus)
                    <a href="{!! route('tf.m.c.map.rule_banner_rank.add.get') !!}">
                        <button class="btn btn-primary tf-link-white-bold">
                            <i class="fa fa-plus"></i> &nbsp;Add new
                        </button>
                    </a>
                @endif
            </div>
        </div>
        <div class="tf_list_object col-xs-12 col-sm-12 col-md-12 col-lg-12"
             data-href-view="{!! route('tf.m.c.map.rule_banner_rank.view') !!}"
             data-href-edit="{!! route('tf.m.c.map.rule_banner_rank.edit.get') !!}">
            <table class="table table-hover">
                <tr>
                    <th>No</th>
                    <th>Rank</th>
                    <th>Size <br/>(Width\Height)</th>
                    <th>Sale price</th>
                    <th>Sale Month</th>
                    <th>Free Month</th>
                    <th></th>
                </tr>
                @if(count($dataRuleBannerRank)>0)
                    <?php
                    $perPage = $dataRuleBannerRank->perPage();
                    $currentPage = $dataRuleBannerRank->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage;
                    ?>
                    @foreach($dataRuleBannerRank as $itemRuleBannerRank)
                        <?php
                        $ruleId = $itemRuleBannerRank->ruleId();
                        $rankId = $itemRuleBannerRank->rankId();
                        ?>
                        <tr class="tf_object" data-object="{!! $ruleId !!}">
                            <td>
                                {!! $n_o += 1 !!}.
                            </td>
                            <td>
                                {!! $itemRuleBannerRank->rank->rankValue() !!}
                            </td>
                            <td>
                                {!! $itemRuleBannerRank->size->name() !!}
                            </td>
                            <td>
                                {!! $itemRuleBannerRank->salePrice() !!}
                            </td>
                            <td>
                                {!! $itemRuleBannerRank->saleMonth() !!}
                            </td>
                            <td>
                                {!! $itemRuleBannerRank->freeMonth() !!}
                            </td>
                            <td class="text-right">
                                <a class="btn btn-default btn-xs tf_object_view">
                                    <i class="glyphicon glyphicon-eye-open tf-color"></i> View
                                </a>
                                @if($itemRuleBannerRank->rank->checkRoot($rankId))
                                    <a class="tf_object_edit btn btn-primary btn-xs">
                                        <i class="glyphicon glyphicon-edit tf-color"></i> Edit
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="text-center" colspan="8">
                            <?php
                            $hFunction->page($dataRuleBannerRank);
                            ?>
                        </td>
                    </tr>
                @else
                    <tr>
                        <td class="text-center" colspan="7">
                            <em>Not found</em>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection