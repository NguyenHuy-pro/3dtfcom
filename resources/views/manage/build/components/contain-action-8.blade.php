@extends('manage.build.components.contain-action-wrap')
@section('tf_m_build_action_wrap')
    <div id="tf_m_build_action_content_wrap" class="col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2 tf-position-abs tf-zindex-2 tf-margin-top-40 tf-border-radius-10 tf-padding-none tf-bg-white tf-overflow-auto "  >
        <!-- contain action form -->
        @yield('tf_m_build_action_content')
                <!-- end contain action form -->
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            hWindow = window.innerHeight;//screen.height;
            $('#tf_m_build_action_content_wrap').css('max-height',hWindow-80);
        });
    </script>
@endsection