<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 2:40 PM
 */
/*
 * modelStaff
 * modelArea
 */

$hFunction = new Hfunction();

$title = 'Size';
?>
@extends('manage.content.map.index')
@section('tf_m_c_content_map')
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="col-md-12 text-Left tf-padding-20 tf-font-size-20 tf-font-bold">
            <span class="fa fa-database"></span>
            <span>{!! $title !!}</span>
        </div>
    </div>
    <div class="tf-bg tf-color-white col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 tf-line-height-40">
            Total : {!! $modelArea->totalRecords()  !!}
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 tf-line-height-40 text-right">

        </div>
    </div>
    <div class="col-md-12">
        <table class="table table-hover">
            <tr>
                <th>No</th>
                <th>Width</th>
                <th>Height</th>
                <th>Left position</th>
                <th>Top position</th>
                <th>X</th>
                <th>Y</th>
            </tr>
            <?php
            $perPage = $dataArea->perPage();
            $currentPage = $dataArea->currentPage();
            $n_o = ($currentPage == 1)?0:($currentPage -1)*$perPage; // set row number
            ?>
            @foreach($dataArea as $itemArea)
                <tr>
                    <td>
                        {!! $n_o += 1 !!}.
                    </td>
                    <td>
                        {!! $itemArea->width() !!}
                    </td>
                    <td >
                        {!! $itemArea->height() !!}
                    </td>
                    <td>
                        {!! $itemArea->leftPosition() !!}
                    </td>
                    <td >
                        {!! $itemArea->topPosition() !!}
                    </td>
                    <td>
                        {!! $itemArea->x !!}
                    </td>
                    <td>
                        {!! $itemArea->y !!}
                    </td>
                </tr>
            @endforeach
            <tr>
                <td class="text-center" colspan="7">
                    <?php
                    $hFunction->page($dataArea);
                    ?>
                </td>
            </tr>
        </table>
    </div>
@endsection