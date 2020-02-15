<?php
/*
 *modelAbout
 *modelUser
 *modelNotify
 *dataSystemAccess
 *
*/
$hFunction = new Hfunction();
$dataAbout = $modelAbout->defaultInfo();
#about info
if (count($dataAbout) > 0) {
    $metaKeyword = $dataAbout->metaKeyword();
    $metaDescription = $dataAbout->metaDescription();

} else {
    $metaKeyword = null;
    $metaDescription = null;
}

$take = 10;
$dateTake = $hFunction->carbonNow();

#notification info
$notifyInfo = $modelNotify->infoIsUsing($take, $dateTake);
?>
@extends('system.index')

{{--develop seo--}}
@section('metaKeyword'){!! $metaKeyword !!}@endsection

@section('metaDescription'){!! $metaDescription !!}@endsection

@section('tf_system_content')
    <div class="row tf_system_notify">
        <div class="tf_list_content col-xs-12 col-sm-12 col-md-12"
             data-href-view="{!! route('tf.system.notify.view.get') !!}">
            @if(count($notifyInfo) > 0)
                @foreach($notifyInfo as $dataNotify)
                    @include('system.notify.notify-object', compact('dataNotify'),
                        [
                            'modelNotify'=>$modelNotify,
                        ])
                    <?php
                    $checkDateViewMore = $dataNotify->createdAt();
                    ?>
                @endforeach
            @else
                <em>There is not notification</em>
            @endif
        </div>
        {{--view more old image--}}
        @if(count($notifyInfo) > 0)
            <?php
            #check exist of image
            $resultMore = $modelNotify->infoIsUsing($take, $checkDateViewMore);
            ?>
            @if(count($resultMore) > 0)
                <div class="tf_view_more col-xs-12 col-sm-12 col-md-12 tf-padding-20 text-center">
                    <a class="tf-link" data-take="{!! $take !!}"
                       data-href="{!! route('tf.system.notify.more.get') !!}">
                        View more
                    </a>
                </div>
            @endif
        @endif

    </div>
@endsection