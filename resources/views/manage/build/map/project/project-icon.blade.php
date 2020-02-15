<?php
/*
 * modelStaff
 * modelProvinceArea
 * dataMapAccess
 * dataProject
 */

# access info on map
$provinceAccess = $dataMapAccess['provinceAccess'];
$areaAccess = $dataMapAccess['areaAccess'];

# staff info
$dataStaffLogin = $modelStaff->loginStaffInfo();
$staffLevel = $dataStaffLogin->level();

# info project
$provinceId = $dataProject->provinceId();
$areaId = $dataProject->areaId();
$projectId = $dataProject->projectId();
$projectName = $dataProject->name();

# info of icon
$dataProjectIcon = $dataProject->iconInfo();
$iconId = $dataProjectIcon->iconId();
$top = $dataProjectIcon->topPosition();
$left = $dataProjectIcon->leftPosition();
$sampleId = $dataProjectIcon->sampleId();

# sale info
$dataProjectTransaction = $dataProject->transactionInfo();

#sample info
$dataProjectIconSample = $dataProjectIcon->projectIconSample;
$widthSample = $dataProjectIconSample->size->width();

# process project name
$maxName = ($widthSample / 32) * 5; // max length of name // 32px = 6 character
$newName = (strlen($projectName) > $maxName) ? mb_substr($projectName, 0, $maxName - 6, 'UTF-8') . "..." : $projectName;
?>
<div id="tf_m_build_project_icon_{!! $iconId !!}" class="tf_m_build_project_icon tf-m-build-project-icon tf-zindex-8"
     data-icon="{!! $iconId !!}" data-sample="{!! $sampleId !!}"
     @if($settingStatus) data-set-position="{!! route('tf.m.build.project.icon.position.set') !!}" @endif
     style="top: {!! $top !!}px;left:{!! $left  !!}px;">

    {{--icon image--}}
    @include('manage.build.map.project.project-icon-image',compact('dataProjectIconSample'))

    {{--detail info--}}
    <div class="dropup tf-m-build-project-name">

        {{--project name--}}
        <span class="dropdown-toggle tf-link " title="{!! $projectName !!}"
              data-toggle="dropdown">{!! $newName !!}</span>

        {{--info --}}
        <table class="dropdown-menu tf-m-build-project-detail">
            <tr>
                <td>
                    <label>Code: </label>
                </td>
                <td colspan="3">
                    {!! $dataProject->nameCode() !!}
                </td>
            </tr>
            <tr>
                <td>
                    <label>Sale status: </label>
                </td>
                <td colspan="3">
                    {!! $dataProjectTransaction->transactionStatus->name() !!}
                </td>
            </tr>
            <?php
            # build info of project
            $dataProjectBuild = $dataProject->infoProjectBuild();
            ?>
            {{--exist publish info--}}
            @if(count($dataProjectBuild) > 0)
                <?php
                $buildId = $dataProjectBuild->buildId();
                $buildStatus = $dataProjectBuild->buildStatus();
                $confirmPublish = $dataProjectBuild->confirmPublish();
                $firstPublish = $dataProjectBuild->firstStatus();
                ?>

                {{--build finishes--}}
                @if($buildStatus == 0 && $confirmPublish == 0)
                    <tr>
                        <td>
                            <label>Publish: </label>
                        </td>
                        <td colspan="3">
                            {{--manage level--}}
                            @if($staffLevel == 1)
                                [<a class="tf_m_build_project_publish_confirm tf-link"
                                    data-build="{!! $buildId !!}"
                                    data-confirm="yes"
                                    data-href="{!! route('tf.m.build.project.publish.yes.get') !!}">
                                    Yes
                                </a>]
                                [<a class="tf_m_build_project_publish_confirm tf-link"
                                    data-build="{!! $buildId !!}"
                                    data-confirm="no"
                                    data-href="{!! route('tf.m.build.project.publish.no.get') !!}">
                                    No
                                </a>]
                                {{--execute level--}}
                            @elseif($staffLevel == 2)
                                <em>Waiting confirm</em>
                            @endif
                        </td>
                    </tr>
                @endif

                @if($buildStatus == 0 && $confirmPublish == 1)
                    <tr>
                        <td>
                            <label> Build : </label>
                        </td>
                        <td colspan="3">
                            <em>Wait opening </em>
                        </td>
                    </tr>
                @endif

                {{--is building--}}
                @if($buildStatus == 1)
                    {{--does not exist publish info--}}
                    @if($staffLevel == 2)
                        <tr>
                            <td>
                                <label>Setup :</label>
                            </td>
                            <td colspan="3">
                                [
                                @if($modelProvinceArea->checkSetup())
                                    <a class="tf_m_build_project_setup_status tf-link"
                                       data-href="{!! route('tf.m.build.project.setup.close') !!}">
                                        Close setup
                                    </a>
                                @else
                                    <a class="tf_m_build_project_setup_status tf-link"
                                       data-href="{!! route('tf.m.build.project.setup.open') !!}">
                                        Open setup
                                    </a>
                                @endif
                                ]
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td>
                            <label> Build : </label>
                        </td>
                        <td colspan="3">
                            <em>Is building</em>
                            @if($staffLevel == 2 and !$settingStatus)
                                [
                                <a class="tf_m_build_project_build_finish tf-link"
                                   data-build="{!! $buildId !!}"
                                   data-href="{!! route('tf.m.build.project.build.finish') !!}">
                                    Finish build
                                </a>
                                ]
                            @endif
                        </td>
                    </tr>
                @endif
            @else
                @if($staffLevel == 2)
                    <tr>
                        <td>
                            <label>Setup :</label>
                        </td>
                        <td colspan="3">
                            [
                            @if($modelProvinceArea->checkSetup())
                                <a class="tf_m_build_project_setup_status tf-link"
                                   data-href="{!! route('tf.m.build.project.setup.close') !!}">
                                    Close setup
                                </a>
                            @else
                                <a class="tf_m_build_project_setup_status tf-link"
                                   data-href="{!! route('tf.m.build.project.setup.open') !!}">
                                    Open setup
                                </a>
                            @endif
                            ]
                        </td>
                    </tr>
                @endif
            @endif
        </table>
    </div>

    {{--action menu--}}
    @if($settingStatus)
        @include('manage.build.map.project.project-menu', ['dataProjcet'=>$dataProject])
    @endif
</div>

