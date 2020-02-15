<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 11/29/2016
 * Time: 1:31 PM
 *
 * modelUser
 * dataUserImage
 *
 *
 */
?>
@extends('components.container.contain-action-8')
@section('tf_main_action_content')
    <table class="table tf-height-full tf_action_height_fix tf-margin-padding-none ">
        <tr>
            <td class="text-center tf-vertical-middle">
                <img style="max-width: 100%; max-height:100%;"
                     alt="avatar" src="{!! $dataUserImage->pathFullImage() !!}"/>
            </td>
        </tr>
    </table>
@endsection
