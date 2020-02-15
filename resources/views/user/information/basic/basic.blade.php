<?php
/*
 *
 * modelUser
 * dataUser
 *
 */
?>
<div class="col-md-12">
    <table class="table">
        <tr>
            <td class="col-xs-4 col-sm-3 col-md-2">
                {!! trans('frontend_user.info_basic_content_label_fullName') !!} :
            </td>
            <td class="col-xs-8 col-sm-9 col-md-10">
                {!! $dataUser->fullName() !!}
            </td>
        </tr>
        <tr>
            <td>
                {!! trans('frontend_user.info_basic_content_label_birthday') !!} :
            </td>
            <td>
                {!! $dataUser->birthday() !!}
            </td>
        </tr>
        <tr>
            <td>
                {!! trans('frontend_user.info_basic_content_label_gender') !!} :
            </td>
            <td>
                @if($dataUser->gender() == 0)
                    {!! trans('frontend_user.info_basic_content_label_male') !!}
                @else
                    {!! trans('frontend_user.info_basic_content_label_female') !!}
                @endif
            </td>
        </tr>
    </table>
</div>