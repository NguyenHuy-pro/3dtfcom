<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 2:35 PM
 */
$hFunction = new Hfunction();
$modelStaff = new \App\Models\System\TfStaff();
$modelDesignStore = new \App\Models\Design\TfDesignStore();
?>
@extends('manage.content.design.index')
@section('tf_m_c_content_design')
    <div class="col-md-12 text-center">
        <h3>Design Store </h3>
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
                <th>Image</th>
                <th>Design object</th>
                <th>Designer</th>
                <th class="">Point</th>
                <th class="text-center" >Confirm</th>
                <th class="text-center" >Valid</th>
                <th>Date</th>
            </tr>
        </table>
    </div>
@endsection