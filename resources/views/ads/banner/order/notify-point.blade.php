@extends('components.container.contain-action-6')
@section('tf_main_action_content')
    <div class="panel panel-default tf-border-none tf-padding-none tf-margin-bot-none">
        <div class="panel-body">
            <div class="tf-padding-30 tf-color-red text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
                {!! trans('frontend_ads.banner_order_point_notify') !!}.
            </div>
            <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <a class="btn btn-primary " href="{!! route('tf.point.online.package.get') !!}">
                    {!! trans('frontend_ads.banner_order_point_buy') !!}
                </a>
                <a class="tf_main_contain_action_close btn btn-default ">
                    {!! trans('frontend_ads.banner_order_point_close') !!}
                </a>
            </div>

        </div>

    </div>
@endsection