<?php
/*
 *
 * $modelUser
 * dataBuilding
 *
 */
$hFunction = new Hfunction();

#user login
$dataUserLogin = $modelUser->loginUserInfo();

#building info
$buildingId = $dataBuilding->buildingId();

# comment info

$take = 5;
$dateTake = $hFunction->createdAt();
$resultBuildingComment = $dataBuilding->commentInfoOfBuilding($buildingId, $take, $dateTake);

?>
@extends('components.container.contain-action-8')
@section('tf_main_action_content')

    <div id="tf_map_building_comment_wrap"
         class="panel panel-default tf-border-none tf-padding-none tf-margin-bot-none "
         data-building="{!! $buildingId !!}">
        <div id="tfMapBuildingCommentHeader" class="panel-heading tf-color-white tf-bg  tf-border-none ">
            <div class="row">
                <div class="col-xs-8 col-sm-8 col-md-8">
                    <i class="glyphicon glyphicon-comment"></i>&nbsp;
                    {!! trans('frontend_map.building_comment_title') !!}
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 text-right">
                    <span class="tf_main_contain_action_close glyphicon glyphicon-remove tf-link-red "></span>
                </div>
            </div>
        </div>
        <div id="tfMapBuildingCommentBody" class="panel-body tf-overflow-auto">
            <div class="tf_comment_form_wrap col-xs-12 col-sm-12 col-md-12">
                @if(count($dataUserLogin) > 0)
                    <?php
                    $pathUserLoginAvatar = $dataUserLogin->pathSmallAvatar($dataUserLogin->userId(), true);
                    ?>
                    <div class="media">
                        <a class="tf_avatar pull-left" href="#">
                            <img class="media-object tf-icon-50" src="{!! $pathUserLoginAvatar !!}"
                                 alt="{!! $dataUserLogin->alias() !!}">
                        </a>

                        <div class="tf_form media-body">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <form id="tfMapBuildingCommentForm" class="form-horizontal" method="post" role="form"
                                      name="tfMapBuildingCommentForm" enctype="multipart/form-data"
                                      action="{!! route('tf.map.building.comment.add.post',$buildingId) !!}">
                                    <div class="form-group">
                                    <textarea name="txtComment" class="txt_content tf-pull-left form-control" rows="1"
                                              placeholder="Enter comment" style="max-width: 100%;"></textarea>
                                    </div>
                                    <div class="form-group text-right ">
                                        <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
                                        <button class="tf_comment_publish btn btn-primary btn-sm tf-link-white"
                                                type="button">
                                            {!! trans('frontend_map.button_send') !!}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <p><em class="tf-color-red">{!! trans('frontend_map.building_comment_notify_login') !!}</em></p>
                @endif
            </div>
            <div id="tfMapBuildingCommentList" class="col-xs-12 col-sm-12 col-md-12 tf-margin-bot-20">
                @if(count($resultBuildingComment) > 0)
                    @foreach($resultBuildingComment as $dataBuildingComment)
                        @include('map.building.comment.comment-object', compact('dataBuildingComment'),
                            [
                                'modelUser'=>$modelUser,
                            ])
                        <?php
                        $checkDateViewMore = $dataBuildingComment->createdAt();
                        ?>
                    @endforeach

                @endif

            </div>

            {{--view more old comment--}}
            @if(count($resultBuildingComment) > 0)
                <?php
                #check exist of comment
                $resultMore = $dataBuilding->commentInfoOfBuilding($buildingId, $take, $checkDateViewMore);
                ?>
                @if(count($resultMore) > 0)
                    <div id="tfMapBuildingCommentViewMore" class="col-md-12 tf-margin-bot-20">
                        <i class="fa fa-comments-o tf-font-size-16"></i>
                        <a class="tf-link" data-take="{!! $take !!}"
                           data-href="{!! route('tf.map.building.comment.more') !!}">
                            {!! trans('frontend_map.building_comment_view_more') !!}
                        </a>
                    </div>
                @endif
            @endif

        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            var headerTop = $('#tfMapBuildingCommentHeader').outerHeight();
            $('#tfMapBuildingCommentBody').css('height', windowHeight - headerTop - 80);

            var formWrapWidth = $('.tf_comment_form_wrap').outerWidth();
            var avatarWidth = $('.tf_comment_form_wrap').find('.tf_avatar').outerWidth();
            $('.tf_comment_form_wrap').find('.tf_form').css('width', formWrapWidth - avatarWidth);
        });
    </script>
@endsection