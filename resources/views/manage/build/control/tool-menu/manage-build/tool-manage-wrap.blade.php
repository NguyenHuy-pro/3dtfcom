<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 7/25/2016
 * Time: 8:57 AM
 */
?>
<div id="tf_m_build_tool_manage_wrap" class="tf-m-build-tool-manage-wrap">
    <div id="tf_m_build_tool_manage_top" class="tf-line-height-30 tf-bg-c2">
        @yield('tf_m_build_tool_manage_top')
    </div>
    <div id="tf_m_build_tool_manage_content" class="tf-overflow-auto">
        @yield('tf_m_build_tool_manage_content')
    </div>
    <div id="tf_m_build_tool_manage_bottom" class="tf-line-height-30 tf-bg-c2 text-center">
        <span class="tf-link-red" onclick="tf_main.tf_remove('#tf_m_build_tool_manage_wrap');">Close</span>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            var headerTop = 36;
            var  heightManageWrap = $('#tf_m_build_wrapper').outerHeight() - headerTop - 40;
            var heightManageTop = $('#tf_m_build_tool_manage_top').outerHeight();
            var heightManageBottonm = $('#tf_m_build_tool_manage_bottom').outerHeight();
            $('#tf_m_build_tool_manage_content').css('height', heightManageWrap - heightManageBottonm - heightManageTop);
        });
    </script>
</div>

