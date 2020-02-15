<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/18/2016
 * Time: 9:39 AM
 *
 * $dataBuildingShare
 *
 */
use Carbon\Carbon;
$buildingId = $dataBuildingShare->buildingId();
$shareId = $dataBuildingShare->shareId();
$shareLink = $dataBuildingShare->shareLink();
$email = $dataBuildingShare->email();
$message = $dataBuildingShare->content();

#building info
$dataBuilding = $dataBuildingShare->building;
#notifile info
$dataShareNotify = $dataBuildingShare->buildingShareNotify;
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="panel panel-default tf-margin-bot-none">
        <div class="panel-heading tf-bg tf-color-white">
            <i class="fa fa-eye"></i>
            Detail share
            <button class="btn btn-primary btn-xs tf_m_c_container_close pull-right">Close</button>
        </div>
        <div class="panel-body">
            <table class="table table-bordered tf-border-none">
                <tr>
                    <td colspan="2" class="text-right tf-border-top-none">
                        <i class="glyphicon glyphicon-calendar"></i>
                        {!! $dataBuildingShare->createdAt()  !!}
                        <br/>
                        <i class="fa fa-user"></i>
                        <span class="tf-color-green">{!! $dataBuildingShare->user->fullName() !!}</span>
                    </td>
                </tr>
                <tr>
                    <td class="col-md-2 text-right tf-border-top-none">
                        <img src="{!! $dataBuilding->buildingSample->pathImage() !!}">
                    </td>
                    <td class="col-md-10 tf-vertical-middle tf-border-top-none">
                        <h4>{!! $dataBuilding->name() !!}</h4>
                    </td>
                </tr>
                <tr>
                    <td class="col-md-2 text-right">
                        To Friend:
                    </td>
                    <td class="col-md-10">
                        @if(count($dataShareNotify) > 0)
                            @foreach($dataShareNotify as $notifyObject)
                                <button class="btn btn-default btn-xs tf-color-green tf-margin-bot-5">{!! $notifyObject->user->fullName() !!}</button>
                            @endforeach
                        @else
                            Null
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="col-md-2 text-right">
                        To email:
                    </td>
                    <td class="col-md-10">
                        {!! (empty($email))?'Null':$email !!}
                    </td>
                </tr>
                <tr>
                    <td class="col-md-2 text-right">
                        To email:
                    </td>
                    <td class="col-md-10">
                        @if(!empty($shareLink) && empty($email))
                            {!! $shareLink !!}
                        @else
                            Null
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="col-md-2 text-right">
                        Message
                    </td>
                    <td class="col-md-10">
                        {!! (empty($message))?'Null':$message !!}
                    </td>
                </tr>

                <tr>
                    <td class="text-right" colspan="2">
                        <i class="glyphicon glyphicon-eye-open"></i>
                        {!! $dataBuildingShare->totalView() !!}
                        &nbsp;&nbsp;
                        <i class="fa fa-users"></i>
                        {!! $dataBuildingShare->totalViewRegister() !!}
                    </td>

                </tr>

            </table>
        </div>
    </div>
@endsection