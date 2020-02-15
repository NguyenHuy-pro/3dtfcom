<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/18/2016
 * Time: 9:39 AM
 */
use App\Models\Manage\Content\Users\TfUser;
use App\Models\Manage\Content\System\Province\TfProvince;

$modelUser = new TfUser();
$modelProvince = new TfProvince();

#user info
$userId = $dataUser->user_id;
$pathAvatar = $modelUser->pathSmallAvatar($userId, true);

#contact info
$dataUserContact = $modelUser->contactInfo($userId)
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="panel panel-default tf-margin-bot-none">
        <div class="panel-heading">
            <i class="fa fa-eye"></i>
            Detail User
            <button class="btn btn-default btn-xs tf_m_c_container_close pull-right">Close</button>
        </div>
        <div class="panel-body">
            <div class="col-md-12 text-right">
                <i class="fa fa-calendar"></i>&nbsp;
                <span style="color: black;">{!! $dataUser->dateAdded !!}</span>
            </div>
            <div class="row">
                <div class="col-md-6 tf-padding-20">
                    <div class="col-md-12 tf-padding-bot-30">
                        <table class="table table-bordered tf-border-none">
                            <tr>
                                <td colspan="2" class="tf-border-none">
                                    <label>User info</label>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-2 text-right">
                                    <em>Name</em>
                                </td>
                                <td class="col-md-10">
                                    {!! $dataUser->firstName.' '.$dataUser->lastName !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-2 text-right">
                                    <em>Code</em>
                                </td>
                                <td class="col-md-10">
                                    {!! $dataUser->nameCode !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-2 text-right">
                                    <em>Birthday</em>
                                </td>
                                <td class="col-md-10">
                                    {!! $dataUser->birthday !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-2 text-right">
                                    <em>Gender</em>
                                </td>
                                <td class="col-md-10">
                                    {!! ($dataUser->gender == 0)?'Male':'Female' !!}
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-12 tf-padding-bot-30">
                        <table class="table table-bordered tf-border-none">
                            <tr>
                                <td colspan="2" class="tf-border-none">
                                    <label>Contact info</label>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-2 text-right tf-vertical-middle">
                                    <em>Avatar</em>
                                </td>
                                <td class="col-md-10">
                                    <img src="{!! $pathAvatar !!}">
                                </td>
                            </tr>

                            <tr>
                                <td class="col-md-2 text-right">
                                    <em>Province</em>
                                </td>
                                <td class="col-md-10">
                                    @if(empty($dataUserContact->province_id))
                                        Null
                                    @else
                                        {!! $modelProvince->name($dataUserContact->province_id) !!}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-2 text-right">
                                    <em>Address</em>
                                </td>
                                <td class="col-md-10">
                                    {!! (empty($dataUserContact->address))?'Null':$dataUserContact->address !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-2 text-right">
                                    <em>Phone</em>
                                </td>
                                <td class="col-md-10">
                                    {!! (empty($dataUserContact->phone))?'Null':$dataUserContact->phone !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-2 text-right">
                                    <em>Email</em>
                                </td>
                                <td class="col-md-10">
                                    {!! (empty($dataUserContact->email))?'Null':$dataUserContact->email !!}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-md-6 tf-padding-20 tf-padding-bot-30">
                    <div class="col-md-12 tf-padding-bot-30">
                        <table class="table table-bordered tf-border-none">
                            <tr>
                                <td colspan="2" class="tf-border-none">
                                    <label>Account info</label>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-2 text-right">
                                    <em>Account</em>
                                </td>
                                <td class="col-md-10">
                                    {!! $dataUser->account !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-2 text-right">
                                    <em>New user</em>
                                </td>
                                <td class="col-md-10">
                                    @if($dataUser->newInfo == 1)
                                        <i class="glyphicon glyphicon-ok tf-color-green tf-font-bold"></i>
                                    @else
                                        <i class="glyphicon glyphicon-ok tf-color-grey"></i>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-2 text-right">
                                    <em>Confirm status</em>
                                </td>
                                <td class="col-md-10">
                                    @if($dataUser->confirm == 1)
                                        <i class="glyphicon glyphicon-ok tf-color-green tf-font-bold"></i>
                                    @else
                                        <i class="glyphicon glyphicon-ok tf-color-grey"></i>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-2 text-right">
                                    <em>action status</em>
                                </td>
                                <td class="col-md-10">
                                    @if($dataUser->status == 1)
                                        <i class="glyphicon glyphicon-ok tf-color-green tf-font-bold"></i>
                                    @else
                                        <i class="glyphicon glyphicon-ok tf-color-grey"></i>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection