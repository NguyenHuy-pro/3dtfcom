<?php namespace App\Models\Manage\Content\Users;

use App\Models\Manage\Content\Map\Banner\LicenseInvite\TfBannerLicenseInvite;
use Illuminate\Database\Eloquent\Model;
use DB;

class UserCheckInfo extends Model
{
    public function bannerLicenseInviteExpiry()
    {
        $modelBannerLicenseInvite = new TfBannerLicenseInvite();
        $modelBannerLicenseInvite->checkExpiryDate();
    }
}
