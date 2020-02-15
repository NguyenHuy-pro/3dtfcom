<?php
/**
 *
 * Created by PhpStorm.
 * User: HUY
 * Date: 11/29/2016
 * Time: 1:31 PM
 *
 *
 * dataBuildingShare
 *
 *
 */
$shareId = $dataBuildingShare->shareId();
$email = $dataBuildingShare->email();
$shareLink = $dataBuildingShare->shareLink();

$dataBuildingShareView = $dataBuildingShare->infoBuildingShareView();
?>
@extends('components.container.contain-action-8')
@section('tf_main_action_content')
    <div class="tf_action_height_fix col-xs-12 col-sm-12 col-md-12">
        <table class="table">
            <tr>
                <th class="tf-font-size-20" colspan="2">
                    <i class="fa fa-list"></i>
                    Details
                </th>
            </tr>
            <tr>
                <td class="text-right tf-border-none" colspan="2">
                    <i class="fa fa-eye tf-font-size-16 tf-color-grey" title="View"></i>&nbsp;
                    {!! count($dataBuildingShareView) !!}

                    &nbsp;&nbsp;&nbsp;
                    <i class="fa fa-share-alt tf-font-size-16 tf-color-grey"></i>&nbsp;
                    @if(!empty($email) && !empty($shareLink))
                        By email: {!! $email !!}
                    @elseif(empty($email) && !empty($shareLink))
                        Copy link
                    @else
                        Normal
                    @endif
                </td>
            </tr>
            @if(!empty($dataBuildingShareView))
                @foreach($dataBuildingShareView as $viewObject)
                    <tr>
                        <td>
                            <i class="fa fa-calendar tf-font-size-16 tf-color-grey"></i>&nbsp;
                            {!! $viewObject->createdAt() !!}
                        </td>
                        <td>
                            <i class="fa fa-user tf-font-size-16 tf-color-grey" title="Register"></i>+ &nbsp;
                            @if($viewObject->register() == 1)
                                Registered
                            @else
                                None
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
        </table>
    </div>
@endsection
