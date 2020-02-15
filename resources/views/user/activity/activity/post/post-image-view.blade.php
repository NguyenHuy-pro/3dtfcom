<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 2/11/2017
 * Time: 12:27 AM
 *
 * modelUser
 * dataUserPost
 *
 */
?>
@extends('components.container.contain-action-10')
@section('tf_main_action_content')
    <div class="tf_action_height_fix tf-height-full col-xm-12 col-sm-12 col-md-12 col-lg-12 ">
        <table class="table tf-margin-padding-none tf-height-full">
            <tr>
                <td class="text-center tf-vertical-middle">
                    <img style="max-width: 100%; max-height: 100%;" src="{!! $dataUserPost->pathFullImage() !!}">
                </td>
            </tr>
        </table>
    </div>
@endsection
