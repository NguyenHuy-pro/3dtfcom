<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 */
/*
 * modelStaff
 * modelRuleProjectRank
 * dataRuleProjectRank
 */
use Carbon\Carbon;

$hFunction = new Hfunction();

$actionStatus = false;
$dataStaffLogin = $modelStaff->loginStaffInfo();
if ($modelStaff->checkDepartmentBuild($dataStaffLogin->staffId()) && $dataStaffLogin->level() == 1) $actionStatus = true;
$title = 'Project rule';
?>
@extends('manage.content.map.rule-project-rank.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-Left tf-padding-20 tf-font-size-20 tf-font-bold">
                <span class="fa fa-database"></span>
                <span>{!! $title !!}</span>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tf-bg tf-color-white ">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 tf-line-height-40">
                Total : {!! $modelRuleProjectRank->totalRecords() !!}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 tf-line-height-40 text-right">
                @if($actionStatus)
                    <a href="{!! route('tf.m.c.map.rule-project-rank.add.get') !!}">
                        <button class="btn btn-primary tf-link-white-bold">
                            <i class="fa fa-plus"></i> &nbsp;Add new
                        </button>
                    </a>
                    <a class="tf_edit" data-href="{!! route('tf.m.c.map.rule-project-rank.edit.get') !!}">
                        <button class="btn btn-primary tf-link-white-bold">
                            <i class="glyphicon glyphicon-edit"></i> &nbsp;Edit
                        </button>
                    </a>
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tf_list_object" data-href-view="{!! route('tf.m.c.map.rule-project-rank.view') !!}">
            <table class="table table-hover">
                <tr>
                    <th>No</th>
                    <th>Rank</th>
                    <th>
                        Sale Price <br> (Point)
                    </th>
                    <th>Month</th>
                    <th></th>
                </tr>
                @if(count($dataRuleProjectRank) > 0)
                    <?php
                    $perPage = $dataRuleProjectRank->perPage();
                    $currentPage = $dataRuleProjectRank->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage;
                    ?>
                    @foreach($dataRuleProjectRank as $rankObject)
                        <tr class="tf_object" data-object="{!! $rankObject->ruleId() !!}">
                            <td class="tf-font-bold">
                                {!! $n_o += 1 !!}.
                            </td>
                            <td>
                                {!! $rankObject->rank->rankValue() !!}
                            </td>
                            <td>
                                {!! $rankObject->salePrice() !!}
                            </td>
                            <td>
                                {!! $rankObject->saleMonth() !!}
                            </td>

                            <td class="text-right">
                                <a class="btn btn-default btn-xs tf_object_view">
                                    <i class="glyphicon glyphicon-eye-open tf-color"></i> View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="text-center" colspan="5">
                            <?php
                            $hFunction->page($dataRuleProjectRank);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection