<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 2/8/2017
 * Time: 1:40 PM
 *
 *
 * dataBannerLicenseInvite
 *
 */


?>
<div class="tf_banner_invite_notify tf-banner-invite-notify text-center"
     data-invite="{!! $dataBannerLicenseInvite->inviteId() !!}">
    <a id="tf_banner_invite_notify_icon" class="tf_view tf-link-red fa fa-gift tf-font-size-40"
       data-href="{!! route('tf.map.banner.invite.confirm.get') !!}" title=" Click to take this Ad Banner 'Free'"></a>
</div>
