@extends('manage.content.components.container.contain-action-wrap')
@section('tf_m_c_action_wrap')
    <div id="tf_m_c_action_content"
         class="col-md-10 col-md-offset-1 tf-position-abs tf-zindex-2 tf-margin-top-40 tf-border-radius-10 tf-padding-none tf-bg-white tf-overflow-auto ">
        @yield('tf_m_c_action_content')
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            var windowHeight = window.innerHeight;//screen.height;
            if($('#tf_m_c_action_content').find('.tf_action_height_fix').length > 0){
                $('#tf_m_c_action_content').css('height', windowHeight - 80);
            }else{
                $('#tf_m_c_action_content').css('max-height', windowHeight - 80);
            }
        });
    </script>
@endsection