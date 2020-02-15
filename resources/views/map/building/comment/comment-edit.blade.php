<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 11/2/2016
 * Time: 4:27 PM
 *
 * $dataBuildingComment
 *
 *
 */
?>
@if(count($dataBuildingComment) > 0)
    <div class="col-md-12">
        <form name="tfMapBuildingCommentEditForm" class="tf_map_building_comment_edit form-horizontal tf-padding-bot-none"
              data-commment="{!! $dataBuildingComment->commentId() !!}" enctype="multipart/form-data" method="post"
              action="{!! route('tf.map.building.comment.edit.post',$dataBuildingComment->commentId()) !!}">
            <div class="form-group tf-margin-bot-none">
            <textarea name="txtComment" class="form-control" rows="2" placeholder="Enter comment"
                      style="max-width: 100%;">{!! $dataBuildingComment->content() !!}</textarea>
                <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
                <a class="tf_comment_edit pull-right tf-link-white btn btn-primary btn-xs">
                    {!! trans('frontend_map.button_send') !!}
                </a>
            </div>
        </form>
    </div>
@endif
