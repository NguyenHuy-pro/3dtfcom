<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 2:34 PM
 */
$hFunction = new Hfunction();
$modelStaff = new \App\Models\System\TfStaff();
$modelDesignRequest = new \App\Models\Design\TfDesignRequest();
?>
@extends('manage.content.design.index')
@section('tf_m_c_content_design')
    <div class="col-md-12 text-center">
        <h3>Design request</h3>
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
                <th>Size</th>
                <th class="">Description</th>
                <th class="text-center" >Confirm</th>
                <th class="text-center">Date</th>
            </tr>
        </table>
    </div>
@endsection