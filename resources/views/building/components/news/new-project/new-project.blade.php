<?php
/*
 *
 * $modelUser
 * $dataBuilding
 * $recentProjectList
 *
 */

?>
<table class=" table tf-building-news-new-project">
    @foreach($recentProjectList as $recentProject)
        <?php
            $provinceId = $recentProject->provinceId();
            $areaId = $recentProject->areaId();
        ?>
        <tr>
            <td>
                <a class="tf-link" href="{!! route('tf.map.province.access', "$provinceId/$areaId") !!}" target="_blank">
                    <img class="tf-project-icon" src="{!! $recentProject->pathIconImage() !!}" alt="{!! $recentProject->name() !!}">
                </a>
                <br/>
                <a class="tf-link" href="{!! route('tf.map.province.access', "$provinceId/$areaId") !!}" target="_blank">
                    {!! $recentProject->name() !!}
                </a>
                &nbsp;&nbsp;
                <a class="fa fa-map-marker tf-link-green tf-font-size-20" href="{!! route('tf.map.province.access', "$provinceId/$areaId") !!}"></a>
            </td>
        </tr>
    @endforeach
</table>