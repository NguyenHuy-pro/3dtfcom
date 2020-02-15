<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 2/27/2017
 * Time: 7:39 PM
 */

$hFunction = new Hfunction();
$object = 'building'; // this version only search on building

if($object == 'building'){
# info building
$buildingId = $searchObject->building_id;

$dataBuilding = $modelBuilding->getInfo($buildingId);
$name = $dataBuilding->name();
$shortDescription = $dataBuilding->shortDescription();
$website = $dataBuilding->website();
$address = $dataBuilding->address();
$email = $dataBuilding->email();

$dataLand = $dataBuilding->landLicense->land;
$landId = $dataLand->landId();
#get project info
$dataProject = $dataLand->project;
?>
<div class="tf_main_search_result_object list-group tf-main-search-result-object"
     data-province="{!! $dataProject->provinceId() !!}"
     data-area="{!! $dataProject->areaId() !!}"
     data-land="{!! $landId !!}"
     data-building="{!! $buildingId !!}">
    <div class="list-group-item tf-padding-bot-none tf-border-none">
        <a class="tf_name tf-link-bold tf-text-under list-group-item-heading">
            <h5>{!! $hFunction->searchBoldText($keyword,$name)  !!}</h5>
        </a>
        @if(!empty($website))
            <p class="list-group-item-text" style="word-wrap: break-word;">
                <a class="tf_website tf-link-green" target="_blank"
                   data-visit-href="{!! route('tf.building.visit.web.plus') !!}"
                   href="http://{!! $website !!}">
                    <em>{!! $hFunction->searchBoldText($keyword,$website) !!}</em>
                </a>
            </p>
        @endif
        <p class="list-group-item-text">
            <a class="tf-link" href="{!! route('tf.building.about.get', $dataBuilding->alias()) !!}" target="_blank">
                {!! $hFunction->searchBoldText($keyword,$shortDescription) !!}
            </a>
        </p>
        @if(!empty($address))
            <p class="list-group-item-text tf-color-grey">
                <span class="glyphicon glyphicon-home"></span>
                <em>{!! $hFunction->searchBoldText($keyword,$address) !!}</em>
            </p>
        @endif
    </div>
</div>
<?php
}
?>