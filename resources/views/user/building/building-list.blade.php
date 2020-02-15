<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 9/19/2016
 * Time: 8:53 AM
 */
/*
 * $modelUser
 * $dataUser
 *
 */

# user info access
$userAccessId = $dataUser->userId();
$skip = 0;
$take = 2;
$dataBuilding = $dataUser->buildingInfo($userAccessId, $skip, $take);

?>
<div id="tf_user_building" class="tf-padding-none col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
    @include('user.building.building-object',compact('dataBuilding'),
        [
            'modelUser' => $modelUser,
            'dataUser' => $dataUser,
            'skip' => $skip,
            'take' => $take
        ])
</div>
