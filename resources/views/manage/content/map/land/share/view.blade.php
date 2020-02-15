<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/18/2016
 * Time: 9:39 AM
 *
 *
 * dataLandShare
 *
 *
 */
use Carbon\Carbon;

$landId = $dataLandShare->landId();
$shareId = $dataLandShare->shareId();
$shareLink = $dataLandShare->shareLink();
$email = $dataLandShare->email();
$message = $dataLandShare->message();

#notifile info
$dataShareNotify = $dataLandShare->landShareNotify;
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="panel panel-default tf-margin-bot-none">
        <div class="panel-heading tf-bg tf-color-white">
            <i class="fa fa-eye"></i>
            Share detail
            <button class="btn btn-primary btn-xs tf_m_c_container_close pull-right">Close</button>
        </div>
        <div class="panel-body tf-padding-bot-20">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span style="color: black;">{!! $dataLandShare->createdAt() !!}</span>
                    <br/>
                    <i class="fa fa-user"></i>
                    <span class="tf-color-green">{!! $dataLandShare->user->fullName() !!}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tf-padding-bot-30">
                    <table class="table table-bordered tf-border-none">
                        <tr>
                            <td class="col-md-2 text-right tf-border-top-none">
                                <em>Land:</em>
                            </td>
                            <td class="col-md-10 tf-vertical-middle tf-border-top-none">
                                {!! $dataLandShare->land->name() !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-2 text-right">
                                To Friend:
                            </td>
                            <td class="col-md-10">
                                @if(count($dataShareNotify) > 0)
                                    @foreach($dataShareNotify as $value)
                                        <button class="btn btn-default btn-xs tf-color-green tf-margin-bot-5">
                                            {!! $value->user->fullName() !!}
                                        </button>
                                    @endforeach
                                @else
                                    Null
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-2 text-right">
                                <em>To email:</em>
                            </td>
                            <td class="col-md-10">
                                {!! (empty($email))?'Null':$email !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-2 text-right">
                                <em>link:</em>
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
                                <em>Message:</em>
                            </td>
                            <td class="col-md-10">
                                {!! (empty($message))?'Null':$message !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right" colspan="2">
                                <i class="glyphicon glyphicon-eye-open"></i>
                                {!! $dataLandShare->totalView() !!}
                                &nbsp;&nbsp;
                                <i class="fa fa-users"></i>
                                {!! $dataLandShare->totalViewRegister() !!}
                            </td>

                        </tr>

                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection