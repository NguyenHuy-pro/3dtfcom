<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/30/2016
 * Time: 11:07 AM
 *
 *
 * $modelProvince
 *
 */

$dataLinkRun = $modelProvince->getLinkRun();
?>

{{--run text--}}
<marquee direction="left" Scrollamount="4" onmouseover="this.stop();" onmouseout="this.start();">
    @if(count($dataLinkRun) > 0)
        @foreach($dataLinkRun as $link)
            <a class="tf-link-grey-bold tf-margin-rig-30" href="http://{!! $link->link() !!}" target="_blank" title="{!! $link->description !!}">
                {!! $link->name() !!}
            </a>
        @endforeach
    @endif
</marquee>
