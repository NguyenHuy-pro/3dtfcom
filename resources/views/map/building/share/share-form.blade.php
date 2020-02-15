<?php
/*
 * $modelUser
 * $dataBuilding
 */

$hFunction = new Hfunction();

# login user
$dataUserLogin = $modelUser->loginUserInfo();
if (count($dataUserLogin) > 0) {
    $loginUserId = $dataUserLogin->userId();

    #friend info
    $dataFriendUser = $dataUserLogin->infoFriend($loginUserId);
}
# building info
$buildingId = $dataBuilding->buildingId();
$alias = $dataBuilding->alias();

#create share code && link
$shareCode = $hFunction->getTimeCode() . $buildingId;

$shareLink = route('tf.home', "$alias/$shareCode");

?>
@extends('components.container.contain-action-8')
@section('tf_main_action_content')
    <div class="panel panel-default tf-border-none tf-padding-none tf-margin-bot-none">
        <form id="frm_map_building_share" name="frm_map_building_share" method="post" data-building="{!! $buildingId !!}"
              action="{!! route('tf.map.building.share.post', $buildingId) !!}">
            <div class="panel-heading tf-bg tf-color-white tf-border-none ">
                <i class="fa fa-share-alt"></i>
                {!! trans('frontend_map.building_share_title') !!}
            </div>
            <div class="panel-body">
                @if(count($dataUserLogin) > 0)
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="list-group ">
                            <li class="list-group-item tf-border-none tf-padding-none ">
                                <label>
                                    {!! trans('frontend_map.building_share_friend_label') !!}
                                </label>
                            </li>
                            <li class="list-group-item tf-margin-padding-none tf-border-none">
                                <input id="tf_building_share_select_all"
                                       type="checkbox">&nbsp;{!! trans('frontend_map.building_share_friend_all_label') !!}
                            </li>
                            <li class="list-group-item tf-margin-padding-none tf-border-none">
                                <ul class="list-group" style="max-height: 150px; overflow: auto;">
                                    @foreach($dataFriendUser as $friendObject)
                                        <li class="list-group-item tf-border-none tf-padding-bot-none">
                                            <div class="checkbox tf-margin-padding-none">
                                                <label>
                                                    <input class="shareFriend" name="shareFriend[]" type="checkbox"
                                                           value="{!! $friendObject->userId()  !!}">
                                                    {!! $friendObject->fullName() !!}
                                                </label>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                        <div class="form-group">
                            <label>{!! trans('frontend_map.building_share_email_label') !!}</label>
                            <input class="form-control" name="txtEmail" type="text"
                                   placeholder="{!! trans('frontend_map.building_share_email_placeholder') !!}">
                        </div>
                        <div class="form-group">
                            <label>{!! trans('frontend_map.building_share_message_label') !!}</label>
                    <textarea class="form-control" name="txtMessage" rows="3"
                              placeholder="{!! trans('frontend_map.building_share_message_placeholder') !!}"></textarea>

                        </div>
                        <div class="form-group text-center">
                            <input type="hidden" name="shareCode" value="{!! $shareCode !!}">
                            <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
                            <button type="button" class="tf_map_building_share_send btn btn-primary">
                                {!! trans('frontend_map.button_share') !!}
                            </button>
                            <button type="button" class="tf_main_contain_action_close btn btn-default ">
                                {!! trans('frontend_map.button_close') !!}
                            </button>
                        </div>
                    </div>
                @else
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group tf-color-red">
                            Sign in to share to your friend
                        </div>
                    </div>
                @endif
            </div>

            <div class="panel panel-footer tf-margin-bot-none">
                <div class="form-group tf-padding-lef-10 tf-padding-rig-20">
                    <label>
                        {!! trans('frontend_map.building_share_link_label') !!}
                    </label>

                    <div class="input-group">
                        <input id="tf_building_share_link" type="text" class="tf_share_link form-control"
                               value="{!! $shareLink !!}"
                               data-href="{!! route('tf.map.building.share.link', "$buildingId/$shareCode") !!}">
                    <span class="input-group-btn">
                        <button class="btn btn-default tf_copy" type="button"
                                title="{!! trans('frontend_map.building_share_link_copy_title') !!}">
                            <i class="fa fa-copy"></i>
                        </button>
                    </span>
                    </div>
                </div>

            </div>
        </form>
        <script type="text/javascript">
            $(document).ready(function () {
                tf_map_building.share.selectLink();
            });
        </script>
    </div>
@endsection