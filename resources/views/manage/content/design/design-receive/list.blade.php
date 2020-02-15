<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 2:38 PM
 */
$hFunction = new Hfunction();
$modelStaff = new \App\Models\System\TfStaff();
$modelDesignRequest = new \App\Models\Design\TfDesignRequest();
$modelDesignReceive = new \App\Models\Design\TfDesignReceive();
?>
@extends('manage.content.design.index')
@section('tf_m_c_content_design')
    <div class="col-md-12 text-center">
        <h3>Receive Design </h3>
    </div>
    <div class="col-md-12 " style="background-color: #BFCAE6;">
        <div class="col-md-6 tf-line-height-40">
            Total : 0
        </div>
        <div class="col-md-6 tf-line-height-40 text-right">

        </div>
    </div>
    <div class="col-md-12">
        <table class="table table-hover">
            <tr>
                <th class="text-center">No</th>
                <th>Begin</th>
                <th>End</th>
                <th class="">Point</th>
                <th class="text-center" >Complete</th>
            </tr>
        </table>
    </div>
@endsection