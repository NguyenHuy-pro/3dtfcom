<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 9/19/2016
 * Time: 8:53 AM
 *
 *
 * $modelUser
 * $dataUser
 */

# user info access
$userAccessId = $dataUser->userId();
$skip = 0;
$take = 2;
$dataLandLicense = $dataUser->landLicenseOfUser($userAccessId, $skip, $take);

?>
<div class="tf-padding-none col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <table id="tf_user_land" class="table table-hover  tf-border-none" >
        @include('user.land.land.land-object',compact('dataLandLicense'),
            [
                'modelUser' => $modelUser,
                'dataUser' => $dataUser,
                'skip' => $skip,
                'take' => $take
            ])
    </table>
</div>
