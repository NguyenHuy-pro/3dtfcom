<?php
/*
 *
 * $modelUser
 * dataBuilding
 *
 */
# info of user login
$dataUserLogin = $modelUser->loginUserInfo();
if (count($dataUserLogin) > 0) {
    $loginStatus = true;
    $userLoginId = $dataUserLogin->userId();
} else {
    $loginStatus = false;
    $userLoginId = null;
}
?>
<table class="table">
    <tr>
        <td class="tf-overflow-prevent tf-border-none tf-font-bold">
            <h4 class="">{!! $dataBuilding->shortDescription() !!}</h4>
        </td>
    </tr>
    <tr>
        <td class="tf-border-none">
            <div class="tf-position-rel tf-overflow-prevent tf-overflow-auto ">
                {!! $dataBuilding->description() !!}
            </div>
        </td>
    </tr>
</table>