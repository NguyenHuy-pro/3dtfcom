<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/18/2016
 * Time: 9:39 AM
 *
 *
 * $dataBannerShare
 *
 */

$dataShareNotify = $dataBannerShare->bannerShareNotify;
?>

@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="panel panel-default tf-margin-padding-none">
        <div class="panel-heading tf-bg tf-color-white">
            <i class="fa fa-eye"></i>
            Share detail
            <button class="btn btn-primary btn-xs tf_m_c_container_close pull-right">Close</button>
        </div>
        <div class="panel-body tf-padding-bot-20">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 text-right">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span style="color: black;">{!! $dataBannerShare->created_at !!}</span>
                    <br/>
                    <i class="fa fa-user"></i>
                    <span class="tf-color-green">{!! $dataBannerShare->user->fullName() !!}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 tf-padding-bot-30">
                    <table class="table table-bordered tf-border-none">
                        <tr>
                            <td class="col-xs-4 col-sm-2 col-md-2 text-right tf-border-top-none">
                                <em>Banner:</em>
                            </td>
                            <td class="col-xs-8 col-sm-10 col-md-10 tf-vertical-middle tf-border-top-none">
                                <h4>{!! $dataBannerShare->banner->name() !!}</h4>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-xs-4 col-sm-2 col-md-2 text-right">
                                <em>To Friend:</em>
                            </td>
                            <td class="col-xs-8 col-sm-10 col-md-10">
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
                            <td class="col-xs-4 col-sm-10 col-md-2 text-right">
                                <em>To email:</em>
                            </td>
                            <td class="col-xs-8 col-sm-10 col-md-10">
                                {!! (empty($dataBannerShare->email))?'Null':$dataBannerShare->email !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="col-xs-4 col-sm-2 col-md-2 text-right">
                                <em>get link:</em>
                            </td>
                            <td class="col-xs-4 col-sm-10 col-md-10">
                                @if(!empty($dataBannerShare->shareLink) && empty($dataBannerShare->email))
                                    {!! $dataBannerShare->shareLink !!}
                                @else
                                    Null
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="col-xs-4 col-sm-2 col-md-2 text-right">
                                <em>Message:</em>
                            </td>
                            <td class="col-xs-8 col-sm-10 col-md-10">
                                {!! (empty($dataBannerShare->message))?'Null':$dataBannerShare->message !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right" colspan="2">
                                <i class="glyphicon glyphicon-eye-open"></i>
                                {!! $dataBannerShare->totalView() !!}
                                &nbsp;&nbsp;
                                <i class="fa fa-users"></i>
                                {!! $dataBannerShare->totalViewRegister() !!}
                            </td>

                        </tr>

                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection