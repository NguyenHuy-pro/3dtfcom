<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 2/8/2017
 * Time: 1:40 PM
 *
 *
 * dataLandLicense
 *
 */

$inviteCode = $dataLandLicense->getAccessInviteCode();
?>
<a id="tf_land_invite_notify_icon" class="tf-land-invite-notify tf-zindex-8 tf-link-red fa fa-gift tf-font-size-40"
   data-code="{!! $inviteCode  !!}" data-href="{!! route('tf.map.land.invite.confirm.get') !!}"></a>