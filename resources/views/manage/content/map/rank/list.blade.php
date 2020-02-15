<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 2:41 PM
 */
/*
 * modelStaff
 * modelRank
 * dataRank
 */

$hFunction = new Hfunction();
$dataStaffLogin = $modelStaff->loginStaffInfo();
$actionStatus = false;
if ($dataStaffLogin->level() == 2) $actionStatus = true;
$title = 'Rank';
?>
@extends('manage.content.map.rank.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-Left tf-padding-20 tf-font-size-20 tf-font-bold">
                <span class="fa fa-database"></span>
                <span>{!! $title !!}</span>
            </div>
        </div>
        <div class="tf-bg tf-color-white col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 tf-line-height-40">
                Total : {!! $modelRank->totalRecords()  !!}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 tf-line-height-40 text-right">

            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <table class="table table-hover">
                <tr>
                    <th>No</th>
                    <th>Value</th>
                    <th>From <br/>(point)</th>
                    <th>To <br/>(point)</th>
                    <th>Type</th>
                </tr>
                @if(count($dataRank))
                    <?php
                    $perPage = $dataRank->perPage();
                    $currentPage = $dataRank->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataRank as $itemRank)
                        <tr class="tf_object" data-object="{!! $itemRank->rankId()  !!}">
                            <td>
                                {!! $n_o +=1 !!}.
                            </td>
                            <td>
                                {!! $itemRank->rankValue() !!}
                            </td>
                            <td>
                                {!! $itemRank->pointBegin() !!}
                            </td>
                            <td>
                                {!! $itemRank->pointEnd() !!}
                            </td>
                            <td>
                                <em>
                                    @if($itemRank->type == 1)
                                        Root
                                    @else
                                        Normal
                                    @endif
                                </em>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="text-center" colspan="5">
                            <?php
                            $hFunction->page($dataRank);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection