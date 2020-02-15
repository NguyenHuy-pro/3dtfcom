<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 7/25/2016
 * Time: 9:04 AM
 */
?>
<div id="tf_m_build_tool_build_wrap" class="tf-m-build-tool-build-wrap">
    <div id="tf_m_build_tool_build_content" class="tf-m-build-tool-build-content">
        @yield('tf_m_build_tool_build_content')
    </div>
    <div id="tf_m_build_tool_build_bottom" class="tf-m-build-tool-build-bottom text-center">
        <span class="tf-link-red" onclick="tf_main.tf_remove('#tf_m_build_tool_build_wrap');">Close</span>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            var headerTop = 36;
            var heightBuildWrap = $('#tf_m_build_wrapper').outerHeight() - headerTop - 40;
            var heightBuildBottom = $('#tf_m_build_tool_build_bottom').outerHeight();
            $('#tf_m_build_tool_build_content').css('height', heightBuildWrap - heightBuildBottom);
        });
    </script>
</div>
