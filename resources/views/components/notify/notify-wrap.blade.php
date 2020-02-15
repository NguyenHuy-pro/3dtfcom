<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 11/16/2016
 * Time: 5:09 PM
 */
?>
<div id="tf_notify_wrap" class="tf-notify-wrap tf_container_remove tf-zindex-8 tf-box-shadow ">
    <div class="panel panel-default tf-margin-padding-none tf-border-none ">
        <div id="tf_notify_top" class="panel-heading  tf-margin-padding-none ">
            @yield('tf_notify_top')
        </div>

        <div id="tf_notify_content" class="panel-body tf-overflow-auto tf-padding-top-none">
            @yield('tf_notify_content')
        </div>

        <div id="tf_notify_bottom" class="panel-footer tf-margin-padding-none text-center">
            @yield('tf_notify_bottom')
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#tf_notify_content').css('height', windowHeight - 80 - $('#tf_notify_top').outerHeight() - $('#tf_notify_bottom').outerHeight());
        });
    </script>
</div>