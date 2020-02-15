@extends('components.container.contain-action-wrap')
@section('tf_main_action_wrap')
    <script type="text/javascript">
        $(document).ready(function () {
            var windowHeight = window.innerHeight;//screen.height;
            if($('#tf_main_action_content_wrap').find('.tf_action_height_fix').length > 0){
                $('#tf_main_action_content_wrap').css('height', windowHeight - 80);
                $('.tf_action_height_fix').css('height', windowHeight - 80);
            }else{
                $('#tf_main_action_content_wrap').css('max-height', windowHeight - 80);
            }
        });
    </script>
    <div id="tf_main_action_content_wrap"
         class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2 tf-position-abs tf-zindex-2 tf-margin-top-40 tf-border-radius-10 tf-padding-none tf-bg-white tf-overflow-auto ">
        {{--contain action form--}}
        @yield('tf_main_action_content')
    </div>

@endsection