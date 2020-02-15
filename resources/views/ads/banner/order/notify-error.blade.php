@extends('components.container.contain-action-6')
@section('tf_main_action_content')
    <div class="panel panel-default tf-border-none tf-padding-none tf-margin-bot-none">
        <div class="panel-body">
            <div class="tf-padding-30 text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
                {!! trans('frontend_ads.banner_order_error_notify') !!}.
            </div>
            <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <a class="btn btn-primary" href="{!! route('tf.ads.banner.list.get') !!}">
                    {!! trans('frontend_ads.banner_order_login_close') !!}
                </a>
            </div>

        </div>

    </div>
@endsection