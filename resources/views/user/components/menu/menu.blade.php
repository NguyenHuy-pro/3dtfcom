<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 9/12/2016
 * Time: 11:16 AM
 *
 * $modelUser
 * $dataUser
 * $dataAccess
 *
 */


# user login info
$loginStatus = $modelUser->checkLogin();
if ($loginStatus) $loginUserId = $modelUser->loginUserId();// else $loginUserId = null;

#access user info
$accessUserId = $dataUser->userId();
$accessUserCode = $dataUser->nameCode();
$accessUserAlias = $dataUser->alias();

$dataUserStatistic = $dataUser->statisticInfo();

$ownStatus = false;
if ($loginStatus) {
    if ($loginUserId == $accessUserId) {
        $ownStatus = true;
        # friend info
        $totalNewFriendRequest = $dataUserStatistic->friendRequests();
        $totalNewFriendRequest = ($totalNewFriendRequest > 0) ? $totalNewFriendRequest : null;
    }
}

$userMenu = [
        [
                'object' => 'activity',
                'label' => trans('frontend_user.menu_label_wall'),
                'icon-src' => 'information.png',
                'href' => route('tf.user.activity.get', $accessUserAlias),
                'statistic' => null,
                'disable' => false
        ],
        [
                'object' => 'info',
                'label' => trans('frontend_user.menu_label_information'),
                'icon-src' => 'information.png',
                'href' => route('tf.user.info.get', $accessUserId),
                'statistic' => null,
                'disable' => false
        ],
        [
                'object' => 'building',
                'label' => trans('frontend_user.menu_label_building'),
                'icon-src' => 'building.png',
                'href' => route('tf.user.building.get', $accessUserId),
                'statistic' => $dataUserStatistic->buildings(),
                'disable' => false
        ],
        [
                'object' => 'banner',
                'label' => trans('frontend_user.menu_label_banner'),
                'icon-src' => 'bannerLogImg.png',
                'href' => route('tf.user.banner.get', $accessUserId),
                'statistic' => $dataUserStatistic->banners(),
                'disable' => false
        ],
        [
                'object' => 'land',
                'label' => trans('frontend_user.menu_label_land'),
                'icon-src' => 'land-block.png',
                'href' => route('tf.user.land.get', $accessUserId),
                'statistic' => $dataUserStatistic->lands(),
                'disable' => false
        ],
    /*
        [
                'object' => 'project',
                'label' => 'Project',
                'icon-src' => 'project1.png',
                'href' => route('tf.user.project.get', $accessUserId),
                'statistic' => $dataUserStatistic->projects,
                'disable' => false
        ],
    */
        [
                'object' => 'image',
                'label' => trans('frontend_user.menu_label_image'),
                'icon-src' => 'image.png',
                'href' => route('tf.user.image.get', $accessUserId),
                'statistic' => null, //$dataUserStatistic->images,
                'disable' => false
        ],
        [
                'object' => 'friend',
                'label' => trans('frontend_user.menu_label_friend'),
                'icon-src' => 'manager.png',
                'href' => route('tf.user.friend.list', $accessUserId),
                'statistic' => $dataUserStatistic->friends(),
                'notifyStatistic' => (isset($totalNewFriendRequest)) ? $totalNewFriendRequest : null,
                'disable' => false
        ],
        [
                'object' => 'follow',
                'label' => trans('frontend_user.menu_label_follow'),
                'icon-src' => 'observ.png',
                'href' => route('tf.user.follow.get', $accessUserId),
                'statistic' => $dataUserStatistic->buildingFollows(),
                'disable' => false
        ],
        [
                'object' => 'point',
                'label' => trans('frontend_user.menu_label_point'),
                'icon-src' => 'coins-icon.png',
                'href' => route('tf.user.point.recharge.get', $accessUserId),
                'statistic' => null,
                'disable' => ($ownStatus == true) ? false : true
        ],
        [
                'object' => 'share',
                'label' => trans('frontend_user.menu_label_share'),
                'icon-src' => 'share.png',
                'href' => route('tf.user.share.banner.get', $accessUserId),
                'statistic' => null,
                'disable' => ($ownStatus == true) ? false : true
        ],
        [
                'object' => 'ads',
                'label' => trans('frontend_user.menu_label_ads'),
                'icon-src' => 'declaration.png',
                'href' => route('tf.user.ads.get', $accessUserCode),
                'statistic' => null,
                'disable' => ($ownStatus == true) ? false : true
        ],
        [
                'object' => 'seller',
                'label' => trans('frontend_user.menu_label_seller'),
                'icon-src' => 'usd_icon.png',
                'href' => route('tf.user.seller.statistic.get'),
                'statistic' => null,
                'disable' => ($ownStatus == true && $dataUser->checkIsSeller()) ? false : true
        ]

]
?>
<div class="col-xs-12 hidden-sm hidden-md hidden-lg tf-padding-lef-none tf-padding-bot-10 ">
    <a class="tf_m_user_menu_icon glyphicon glyphicon-align-justify tf-link-grey-bold tf-font-size-20"></a>
</div>

<table class="tf_user_menu tf-user-menu table table-hover" data-user="{!! $accessUserId !!}">
    @foreach($userMenu as $menu)
        @if($menu['disable'] == false)
            <tr>
                <td class="tf-padding-none">
                    <a class="tf-link-full tf-padding-10  @if($menu['object'] == $dataAccess['accessObject']) tf-link-red-bold @else tf-link @endif"
                       href="{!! $menu['href'] !!}">
                        @if(isset($menu['notifyStatistic']))
                            <span class="pull-right tf-font-bold tf-bg-red" title="new request">
                            {!! $menu['notifyStatistic'] !!}
                        </span>
                        @endif

                        @if(!is_null($menu['statistic']))
                            <span class="pull-right tf-font-bold">{!! $menu['statistic'] !!}</span>
                        @endif

                        <img class="tf-icon-16" alt="information"
                             src="{!! asset('public/main/icons/'.$menu['icon-src']) !!}"/>
                        &nbsp;
                        <span>{!! $menu['label'] !!}</span>
                    </a>
                </td>
            </tr>
        @endif
    @endforeach
</table>