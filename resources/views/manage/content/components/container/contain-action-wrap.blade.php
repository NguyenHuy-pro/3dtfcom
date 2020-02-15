{{--contain action form--}}
<div id="tf_m_c_container_wrap" class="row tf-position-abs tf-width-height-full tf-margin-padding-none tf-zindex-7"
     style="top: 0;left: 0;">
    <div class="col-md-12 tf_m_c_container_close tf-cursor-pointer tf-height-full tf-opacity-7 tf-bg"></div>
    @yield('tf_m_c_action_wrap')

    <script type="text/javascript">
        windowHeight = window.innerHeight;
        $('#tf_m_c_container_wrap').css('min-height', windowHeight);
    </script>
</div>