<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/1/2016
 * Time: 3:50 PM
 */
use App\Models\Manage\Content\System\Province\TfProvince;
use App\Models\Manage\Content\System\Staff\TfStaff;

$modelProvince = new TfProvince();
$modelStaff = new TfStaff();

//get staff info
$dataStaff = $modelStaff->loginStaffInfo();
$staffId = $dataStaff->staffId();
$staffLevel = $dataStaff->level();
?>
@extends('manage.build.control.tool-menu.manage-build.tool-manage-wrap')
@section('tf_m_build_tool_manage_top')
    <select class="tf_m_build_manage_project_province" name="manageProjectProvince">
        <option value="0">All province</option>
        {!! $modelProvince->getOptionBuilt3d($provinceFilterId) !!}
    </select>
@endsection
@section('tf_m_build_tool_manage_content')
    @if(count($dataProject) > 0)
        <ul class="list-group">
            @foreach($dataProject as $projectObject)
                <?php
                $n_o = (isset($n_o)) ? $n_o + 1 : 1;
                $projectId = $projectObject->projectId();
                $provinceId = $projectObject->provinceID();
                $name = $projectObject->name();
                $areaId = $projectObject->areaID();
                ?>
                <li class="list-group-item">
                    {!! $n_o !!} -
                    @if($provinceAccessId != $provinceId)
                        <a class="tf-link" href="{!! route('tf.m.build.province.get',"$provinceId/$areaId") !!}">
                            {!! $name !!}
                        </a>
                    @else
                        <a class="tf_m_build_tool_manage_project_name tf-link"
                           data-href="{!! route('tf.m.build.area.coordinates.get') !!}"
                           data-province="{!! $provinceId !!}"
                           data-area-x="{!! $projectObject->area->x() !!}"
                           data-area-y="{!! $projectObject->area->y() !!}">
                            {!! $name !!}
                        </a>
                    @endif
                    <?php
                    $dataProjectBuild = $projectObject->infoProjectBuild();
                    ?>
                    @if(count($dataProjectBuild) > 0)
                        <?php
                        $buildId = $dataProjectBuild->buildId();
                        $buildStatus = $dataProjectBuild->buildStatus();
                        $confirmPublish = $dataProjectBuild->confirmPublish();
                        $firstPublish = $dataProjectBuild->firstStatus();
                        ?>
                        {{--project is waiting publish--}}
                        @if($buildStatus == 0 && $confirmPublish == 0)
                            <em class="badge">Waiting Publish</em>
                        @elseif($buildStatus == 0 && $confirmPublish == 1)
                            <em class="badge">Wait opening</em>
                        @else
                            {{--manage level--}}
                            @if($staffLevel == 1)
                                @if(!$dataStaff->checkManageProject($projectId))
                                    <em class="badge">Was granted</em>
                                @else
                                    <em class="badge">Not granted</em>
                                @endif
                                {{--execute level--}}
                            @elseif($staffLevel == 2)
                                {{--project is updating--}}
                                @if($buildStatus == 1)
                                    <em class="badge">Is building</em>
                                @endif
                            @endif
                        @endif
                    @else
                        <em class="badge">Normal</em>
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <pre class="tf-color-red">Not found</pre>
    @endif
@endsection