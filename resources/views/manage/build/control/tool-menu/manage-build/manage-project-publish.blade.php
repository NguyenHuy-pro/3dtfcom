<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/3/2016
 * Time: 3:16 PM
 *
 * modelStaff
 * modelProvince
 * provinceAccessId
 * provinceFilterId
 * dataProject
 *
 */

$dataStaff = $modelStaff->loginStaffInfo();

//get staff info
$staffId = $dataStaff->staffId();
$staffLevel = $dataStaff->level();
?>
@extends('manage.build.control.tool-menu.manage-build.tool-manage-wrap')
@section('tf_m_build_tool_manage_top')
    <select class="tf_m_build_manage_project_publish_province" name="manageProjectPublishProvince">
        <option value="0">All province</option>
        {!! $modelProvince->getOptionBuilt3d($provinceFilterId) !!}
    </select>
@endsection
@section('tf_m_build_tool_manage_content')
    @if(count($dataProject) > 0)
        <ul class="list-group">
            @foreach($dataProject as $projectObject)
                <?php
                $n_o = (isset($n_o))?$n_o + 1:1;
                $projectId = $projectObject->projectId();
                $provinceId = $projectObject->provinceId();
                $areaId = $projectObject->areaId();
                ?>
                <li class="list-group-item">
                    {!! $n_o !!} -
                    @if($provinceAccessId != $provinceId)
                        <a class="tf-link" href="{!! route('tf.m.build.province.get',"$provinceId/$areaId") !!}">
                            {!! $projectObject->name !!}
                        </a>
                    @else
                        <a class="tf_m_build_tool_manage_project_name tf-link"
                           data-href="{!! route('tf.m.build.area.coordinates.get') !!}"
                           data-province="{!! $provinceId !!}"
                           data-area-x="{!! $projectObject->area->x() !!}"
                           data-area-y="{!! $projectObject->area->y() !!}">
                            {!! $projectObject->name !!}
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <pre class="tf-color-red">Not found</pre>
    @endif
@endsection
