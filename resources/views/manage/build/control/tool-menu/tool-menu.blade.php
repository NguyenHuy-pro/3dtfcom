<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 7/25/2016
 * Time: 9:35 AM
 */

/*
 *
 * modelStaff
 * modelPublicType
 * dataMapAccess
 */
# staff info
$dataStaffLogin = $modelStaff->loginStaffInfo();

$loginStaffId = $dataStaffLogin->staffId();
$staffLevelAccess = $dataStaffLogin->level();

# access info
$provinceAccess = $dataMapAccess['provinceAccess'];
$areaAccess = $dataMapAccess['areaAccess'];
$setupStatus = 1;
?>
<div id="tf_m_build_control_map" class="tf_m_build_tool_menu tf-m-build-tool-menu">
    <img id="tf_m_build_tool_manage_project" class="tf_m_build_tool_manage_icon tf-m-build-tool-menu-icon"
         title="list project" alt="menu" data-manage-object="project"
         data-href="{!! route('tf.m.build.map.tool.manage.project.get',$provinceAccess) !!}"
         src="{!! asset('public/main/icons/miniMap-off.png')!!}" alt="manage-project"/>
    {{--parts build - level 1--}}
    @if($staffLevelAccess == 1)
        <img id="tf_m_build_tool_manage_project_publish" class="tf_m_build_tool_manage_icon tf-m-build-tool-menu-icon"
             title="publish" data-manage-object="projectPublish"
             data-href="{!! route('tf.m.build.map.tool.manage.project.publish.get',$provinceAccess) !!}"
             src="{!! asset('public/main/icons/publish.jpg')!!}" alt="manage-publish"/>
        <img class="tf-m-build-tool-menu-icon" onclick="tf_main.tf_toggle('#tf_m_build_tool_manage_wrap');" title="badinfo"
             src="{!! asset('public/main/icons/khong.png')!!}" alt="bad-info"/>
        <img class="tf-m-build-tool-menu-icon" onclick="tf_main.tf_toggle('#tf_m_build_tool_manage_wrap');" title="copyright"
             src="{!! asset('public/main/icons/edit1.png')!!}" alt="copy-right"/>
    @elseif($staffLevelAccess == 2)
        @if($modelProvinceArea->checkSetup())
            <select name="cbpublic" class="tf_m_build_tool_build_public"
                    data-href="{!! route('tf.m.build.map.tool.build.public.get') !!}">
                <option value="0">Type public</option>
                {!! $modelPublicType->getOption() !!}
            </select>
            {{--background--}}
            <img class="tf_m_build_tool_build_icon tf-m-build-tool-menu-icon" title="add background" alt="background"
                 data-href="{!! route('tf.m.build.map.tool.build.project-background.get') !!}"
                 src="{!! asset('public/main/icons/area.gif')!!}"/>

            {{--land--}}
            <img class="tf_m_build_tool_build_icon tf-m-build-tool-menu-icon" title="add land" alt="land"
                 data-href="{!! route('tf.m.build.map.tool.build.land.get') !!}"
                 src="{!! asset('public/main/icons/icon-land.gif')!!}"/>
            {{--banner--}}
            <img class="tf_m_build_tool_build_icon tf-m-build-tool-menu-icon" title="add banner" alt="banner"
                 data-href="{!! route('tf.m.build.map.tool.build.banner.get') !!}"
                 src="{!! asset('public/main/icons/bannerLogImg.png')!!}"/>

            {{--project--}}
            <img class="tf_m_build_tool_build_icon  tf-m-build-tool-menu-icon" title="sample project" alt="sample-project"
                 data-href="{!! route('tf.m.build.map.tool.build.project.get') !!}"
                 src="{!! asset('public/main/icons/sampleproject.jpg')!!}"/>
        @endif
    @endif
</div>
