<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 */
/*
 * modelStaff
 * modelCountry
 * modelProvince
 * dataProvince
 */
use Carbon\Carbon;
$hFunction = new Hfunction();

?>
@extends('manage.content.map.province.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-Left tf-padding-20 tf-font-size-20 tf-font-bold">
                <span class="fa fa-database"></span>
                <span>List province 3D</span>
            </div>
        </div>
        <div class="tf-bg tf-color-white col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 tf-line-height-40">
                Total : {!! count($modelProvince->infoBuilt3D())  !!}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 tf-line-height-40 text-right">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tf_list_object"
             data-href-view="{!! route('tf.m.c.map.province.view') !!}">
            <table class="table table-hover ">
                <tr>
                    <th>N_o</th>
                    <th>Name</th>
                    <th>Country</th>
                    <th >Center</th>
                    <th>Date <br>(built)</th>
                    <th class="tf-width-100"></th>
                </tr>
                @if(count($dataProvince) > 0)
                    <?php
                    $perPage = $dataProvince->perPage();
                    $currentPage = $dataProvince->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataProvince as $provinceObject)
                        <?php
                        $provinceId = $provinceObject->provinceId();
                        $default = $provinceObject->defaultCenter();
                        ?>
                        <tr class="tf_object" data-object="{!! $provinceId !!}">
                            <td class="tf-font-bold">
                                {!! $n_o += 1 !!}.
                            </td>
                            <td>
                                {!! $provinceObject->name() !!}
                            </td>
                            <td>
                                {!! $provinceObject->country->name() !!}
                            </td>
                            <td >
                                @if($default == 1)
                                    <i class="glyphicon glyphicon-ok-circle tf-font-bold tf-color-green"></i>
                                @else
                                    <i class="glyphicon glyphicon-ok-circle tf-color-grey"></i>
                                @endif
                            </td>
                            <td>
                                {!! Carbon::parse($provinceObject->createdAt())->format('d-m-Y') !!}
                            </td>

                            <td class="text-center">
                                <a class="btn btn-default btn-xs tf-link  tf_object_view">
                                    <i class="glyphicon glyphicon-eye-open"></i> View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="text-center" colspan="6">
                            <?php
                            $hFunction->page($dataProvince);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection