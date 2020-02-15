<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/19/2016
 * Time: 11:18 AM
 *
 * $modelUser
 * $dataLand
 *
 */

$hFunction = new Hfunction();

# login user
$dataUserLogin = $modelUser->loginUserInfo();

if (count($dataUserLogin) > 0) {
    $loginUserId = $dataUserLogin->userId();

    #friend info
    $dataFriendUser = $dataUserLogin->infoFriend($loginUserId);
}


# land info
$landId = $dataLand->landId();

#create share code && link
$shareCode = $hFunction->getTimeCode() . $landId;

$shareLink = route('tf.map.land.access', "$landId/$shareCode");

?>
@extends('components.container.contain-action-8')
@section('tf_main_action_content')
    <form id="frmMapLandShare" name="frmMapLandShare"
          class="panel panel-default tf-border-none tf-padding-none tf-margin-bot-none "
          method="post" action="{!! route('tf.map.land.share.post', $landId) !!}">
        <div class="panel-heading tf-bg tf-color-white tf-border-none ">
            <i class="fa fa-share-alt tf-font-size-16"></i>&nbsp;
            {!! trans('frontend_map.land_share_title') !!}
        </div>
        <div class="panel-body">
            @if(count($dataUserLogin) > 0)
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <ul class="list-group ">
                        <li class="list-group-item tf-border-none tf-padding-none ">
                            <label>{!! trans('frontend_map.land_share_friend_label') !!}:</label>
                        </li>
                        <li class="list-group-item tf-margin-padding-none tf-border-none">
                            <input id="tf_land_share_select_all"
                                   type="checkbox"> &nbsp; {!! trans('frontend_map.land_share_friend_all_label') !!}
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
                        <label>{!! trans('frontend_map.land_share_email_label') !!}</label>
                        <input class="form-control" name="txtEmail" type="text"
                               placeholder="{!! trans('frontend_map.land_share_email_placeholder') !!}">
                    </div>
                    <div class="form-group">
                        <label>{!! trans('frontend_map.land_share_message_label') !!}</label>
                    <textarea class="form-control" name="txtMessage" rows="3"
                              placeholder="{!! trans('frontend_map.land_share_message_placeholder') !!}"></textarea>

                    </div>
                    <div class="form-group text-center">
                        <input type="hidden" name="shareCode" value="{!! $shareCode !!}">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
                        <button type="button" class="tf_map_land_share_send btn btn-primary">
                            {!! trans('frontend_map.button_send') !!}
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

        <div class="panel panel-footer  text-left tf-margin-bot-none">
            <div class="form-group tf-padding-lef-10 tf-padding-rig-20">
                <label>
                    {!! trans('frontend_map.land_share_link_label') !!}
                </label>

                <div class="input-group">
                    <input id="tf_land_share_link" type="text" class="tf_share_link form-control"
                           value="{!! $shareLink !!}"
                           data-href="{!! route('tf.map.land.share.link', "$landId/$shareCode") !!}">
                <span class="input-group-btn">
                    <button class="btn btn-default tf_copy" type="button"
                            title="{!! trans('frontend_map.land_share_link_copy_title') !!}">
                        <i class="fa fa-copy"></i>
                    </button>
                </span>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                tf_land.share.selectLink();
            });
        </script>
    </form>
@endsection
