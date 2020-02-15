<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 11/1/2016
 * Time: 2:44 PM
 *
 * $modelUser
 * $dataBuildingComment
 *
 */

$hFunction = new Hfunction();
#user login
$dataUserLogin = $modelUser->loginUserInfo();

# comment info
$commentId = $dataBuildingComment->commentId();
$buildingId = $dataBuildingComment->buildingId();
$dateAdded = $dataBuildingComment->createdAt();
$commentUserId = $dataBuildingComment->userId();
$content = $dataBuildingComment->content();

# user comment
$dataUserComment = $dataBuildingComment->user;
$pathCommentUserAvatar = $dataUserComment->pathSmallAvatar($dataUserComment->userId(), true);
$commentUserAlias = $dataUserComment->alias();// $modelUser->alias($commentUserId);
?>
<table id="tf_map_building_comment_object_{!! $commentId !!}" class="tf_map_building_comment_object tf-map-building-comment-object table" data-date="{!! $dateAdded !!}" data-comment="{!! $commentId !!}">
    <tr>
        <td class="tf_avatar tf-avatar" rowspan="2">
            <a class="tf_link  tf-link" href="{!! route('tf.user.home', $commentUserAlias) !!}" target="_blank">
                <img src="{!! $pathCommentUserAvatar !!}" alt="{!! $commentUserAlias !!}">
            </a>

        </td>
        <td class="tf_comment_object_content_wrap tf-content" >
            @include('map.building.comment.comment-object-content', [
                'dataBuildingComment' =>$dataBuildingComment
            ])
        </td>
    </tr>
    <tr>
        <td class="tf-action text-right" colspan="2">
            <i class="tf-color-grey glyphicon glyphicon-calendar"></i>
                <span class="tf-color-grey tf-font-bold">
                    {!! $dateAdded !!}
                </span>
            @if(count($dataUserLogin) > 0)
                <div class="tf_comment_content_action tf-comment-content-action btn-group">
                    <button class="tf-link-grey-bold tf-border-none btn btn-xs btn-default dropdown-toggle"
                            type="button" data-toggle="dropdown">
                        <i class="fa fa-ellipsis-h"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">

                            <?php
                            $loginUserId = $dataUserLogin->userId();
                            ?>
                            @if($loginUserId == $commentUserId || $dataBuildingComment->building->checkBuildingOfUser($buildingId, $loginUserId))
                                @if($loginUserId == $commentUserId )
                                    <li>
                                        <a class="tf_edit tf-bg-hover" data-href="{!! route('tf.map.building.comment.edit.get') !!}">
                                            {!! trans('frontend_map.building_comment_menu_edit') !!}
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <a class="tf_delete tf-bg-hover" data-href="{!! route('tf.map.building.comment.delete') !!}">
                                        {!! trans('frontend_map.building_comment_menu_delete') !!}
                                    </a>
                                </li>
                            @endif
                    </ul>
                </div>
            @endif
        </td>
    </tr>
    <script type="text/javascript">
        $(document).ready(function () {
            var wrapWidth = $('#tfMapBuildingCommentList').outerWidth();
            $('#tfMapBuildingCommentList').find('.tf_content').css('width', wrapWidth - 50);
        });
        tf_map_building.comment.setWidthCommentWrap(<?php echo $commentId ?>);
    </script>
</table>
