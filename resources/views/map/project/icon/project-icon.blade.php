<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/12/2016
 * Time: 8:31 AM
 *
 * $modelUser
 * $dataMapAccess
 * $dataProject
 *
 */

// access info
$provinceAccess = $dataMapAccess['provinceAccess'];
$areaAccess = $dataMapAccess['areaAccess'];
$landAccess = $dataMapAccess['landAccess'];
$bannerAccess = $dataMapAccess['bannerAccess'];

// info project
$provinceId = $dataProject->provinceId();
$areaId = $dataProject->areaId();
$projectId = $dataProject->projectId();
$projectName = $dataProject->name();

// info of icon
$dataProjectIcon = $dataProject->iconInfo();
$iconId = $dataProjectIcon->iconId();
$sampleId = $dataProjectIcon->sampleId();

//develop to move icon (develop later)
$top = $dataProjectIcon->topPosition();
$left = $dataProjectIcon->leftPosition();
$zIndex = $dataProjectIcon->zIndex();

// info sample
$dataProjectIconSample = $dataProjectIcon->projectIconSample;
$widthSample = $dataProjectIconSample->size->width();

// process project name
$maxName = ($widthSample / 32) * 5; // max length of name // 32px = 6 character
$newName = (strlen($projectName) > $maxName) ? mb_substr($projectName, 0, $maxName - 6, 'UTF-8') . "..." : $projectName;
?>
<div id="tf_project_icon_{!! $iconId !!}" class="tf_project_icon tf-project-icon"
     data-icon="{!! $iconId !!}"
     data-sample="{!! $sampleId !!}"
     style="top: {!! $top !!}px;left:{!! $left  !!}px;z-index:{!! $zIndex  !!};  ">

    {{--icon image--}}
    <img class="tf_project_icon_image" alt="{!! $projectName !!}" src="{!! $dataProjectIconSample->pathImage() !!}"/>

    {{--detail info--}}
    <div class="dropup tf-project-name">

        {{--project name--}}
        <a class="dropdown-toggle tf-link-red tf-font-border-white " title="{!! $projectName !!}" data-toggle="dropdown">
            {!! $newName !!}
        </a>

        {{-- info --}}
        <table class="dropdown-menu tf-project-detail">
            <?php
            $dataProjectLicense = $dataProject->licenseInfo();
            ?>
            {{--exist user (project of user)--}}
            @if(count($dataProjectLicense) > 0)
                <?php
                $projectUserId = $dataProjectLicense->userId();
                $pathAvatar = $dataProjectLicense->user->pathSmallAvatar($projectUserId);
                ?>
                <tr>
                    <td>
                        {{--exist avatar--}}
                        <img class="tf-icon-32" alt="project-avatar" src="{!! $pathAvatar !!}">
                    </td>
                    <td>
                        {!! $dataProjectLicense->user->fullName() !!}
                    </td>
                </tr>
            @else
                {{-- project of system--}}
                <tr>
                    <td>
                        <img class="tf-icon-32 tf-padding-4" alt="project-avatar" src="{!! asset('public/main/icons/3d.jpg') !!}">
                    </td>
                    <td>
                        3dtf.com
                    </td>
                </tr>
            @endif
        </table>
    </div>
</div>


