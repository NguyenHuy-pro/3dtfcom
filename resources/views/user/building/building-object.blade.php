<?php
/*
 *
 * $modelUser
 * $dataUser
 * $dataBuilding
 *
 */
$newSkip = $skip + $take;

# access user info
$userAccessId = $dataUser->userId();
?>
@if(count($dataBuilding) > 0)
    @foreach($dataBuilding as $buildingObject)
        <?php
        $buildingId = $buildingObject->buildingId();
        $alias = $buildingObject->alias();
        $name = $buildingObject->name();
        $shortDescription = $buildingObject->shortDescription();
        $address = $buildingObject->address();
        $phone = $buildingObject->phone();
        $website = $buildingObject->website();
        $sampleId = $buildingObject->sampleId();
        ?>
        <table class="tf_user_building_object tf-user-building-object table table-bordered"  data-building="{!! $buildingId !!}">
            <tr>
                <td class="tf-border-none tf-padding-none " colspan="2">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tf-bg-whitesmoke">
                        <div class="tf-padding-10 text-left col-xs-12 col-sm-3 col-md-2 col-lg-2">
                            <img style="max-width: 64px;" alt="{!! $alias !!}"
                                 src="{!! $buildingObject->buildingSample->pathImage() !!}"/>
                        </div>
                        <div class="tf-padding-10 text-left tf-statistic col-xs-12 col-sm-9 col-md-10 col-lg-10">
                            <h4>{!! $name !!}</h4>


                            <p>
                                <a class="tf-link" href="{!! route('tf.building',$alias) !!}">
                                    {!! trans('frontend_user.building_view_detail') !!}
                                </a>
                                &nbsp;<i class="glyphicon glyphicon-minus tf-color-grey"></i>&nbsp;
                                <a class="tf-link" href="{!! route('tf.home',$alias) !!}" target="_blank">
                                    {!! trans('frontend_user.building_view_on_map') !!}
                                    &nbsp; <i class="fa fa-map-marker tf-font-size-14"></i>
                                </a>
                            </p>
                            <p>
                                <i class="glyphicon glyphicon-eye-open tf-icon"></i>
                                {!! $buildingObject->totalVisit() !!} &nbsp;&nbsp;
                                <i class="glyphicon glyphicon-paperclip tf-icon"></i>
                                {!! $buildingObject->totalFollow() !!} &nbsp;&nbsp;
                                <i class="glyphicon glyphicon-comment tf-icon"></i>
                                {!! $buildingObject->totalComment() !!}&nbsp;&nbsp;
                                <i class="glyphicon glyphicon-thumbs-up tf-icon"></i>
                                {!! $buildingObject->totalLove() !!}&nbsp;&nbsp;
                                <i class="fa fa-share-alt tf-icon"></i>
                                {!! $buildingObject->totalShare() !!}
                            </p>
                        </div>
                    </div>
                </td>
            </tr>
            
            <tr>
                <td class="col-xs-4 col-sm-3 col-md-2 col-lg-2 text-right">
                    {!! trans('frontend_user.building_info_label_introduce') !!}:
                </td>
                <td class="col-xs-8 col-sm-9 col-md-10 col-lg-10 tf-content">
                    @if(empty($shortDescription))
                        <em>{!! trans('frontend_user.building_info_label_none') !!}</em>
                    @else
                        {!! $shortDescription !!}
                    @endif
                </td>
            </tr>
            <tr>
                <td class="col-xs-4 col-sm-3 col-md-2 col-lg-2 text-right">
                    {!! trans('frontend_user.building_info_label_address') !!}:
                </td>
                <td class="col-xs-8 col-sm-9 col-md-10 col-lg-10 tf-content">
                    @if(empty($address))
                        <em>{!! trans('frontend_user.building_info_label_none') !!}</em>
                    @else
                        {!! $address !!}
                    @endif
                </td>
            </tr>
            <tr>
                <td class="col-xs-4 col-sm-3 col-md-2 col-lg-2 text-right">
                    {!! trans('frontend_user.building_info_label_phone') !!}:
                </td>
                <td class="col-xs-8 col-sm-9 col-md-10 col-lg-10 tf-content">
                    @if(empty($phone))
                        <em>{!! trans('frontend_user.building_info_label_none') !!}</em>
                    @else
                        {!! $phone !!}
                    @endif
                </td>
            </tr>
            <tr>
                <td class="col-xs-4 col-sm-3 col-md-2 col-lg-2 text-right">
                    {!! trans('frontend_user.building_info_label_website') !!}
                </td>
                <td class="col-xs-8 col-sm-9 col-md-10 col-lg-10 tf-content">
                    @if(empty($website))
                        <em>{!! trans('frontend_user.building_info_label_none') !!}</em>
                    @else
                        <a href="http://{!! $website !!}" target="_blank">{!! $website !!}</a>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="text-right" colspan="2"></td>
            </tr>
        </table>
    @endforeach
    <?php
    #check more info
    $dataUserMoreBuilding = $dataUser->buildingInfo($userAccessId, $newSkip, $take);
    ?>
    @if(count($dataUserMoreBuilding) > 0)
        <div id="tf_user_building_more" class="text-center">
            <a class="tf-link" data-user="{!! $userAccessId !!}" data-skip="{!! $newSkip !!}" data-take="{!! $take !!}"
               data-href="{!! route('tf.user.building.more') !!}">
                {!! trans('frontend_user.building_info_view_more') !!}
            </a>
        </div>
    @endif
@endif