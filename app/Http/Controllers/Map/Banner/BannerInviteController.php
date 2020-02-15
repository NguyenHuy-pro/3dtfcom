<?php namespace App\Http\Controllers\Map\Banner;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Map\Area\TfArea;
use App\Models\Manage\Content\Map\Banner\LicenseInvite\TfBannerLicenseInvite;
use App\Models\Manage\Content\Map\Transaction\TfTransactionStatus;
use App\Models\Manage\Content\System\About\TfAbout;
use App\Models\Manage\Content\System\BusinessType\TfBusinessType;
use App\Models\Manage\Content\System\Province\TfProvince;
use App\Models\Manage\Content\Users\ExchangeBanner\TfUserExchangeBanner;
use App\Models\Manage\Content\Users\Statistic\TfUserStatistic;
use App\Models\Manage\Content\Users\TfUser;
use App\Models\Manage\Content\Users\Card\TfUserCard;
use App\Models\Manage\Content\Map\Banner\TfBanner;
use App\Models\Manage\Content\Map\Banner\License\TfBannerLicense;

#use Illuminate\Http\Request;
use Request;
use Input;


class BannerInviteController extends Controller
{
    public function getInvite($bannerId)
    {
        $modelUser = new TfUser();
        $modelBanner = new TfBanner();
        $modelBannerLicense = new TfBannerLicense();
        if ($modelUser->checkLogin()) {
            if (!empty($bannerId)) {
                $dataBannerLicense = $modelBanner->licenseInfo($bannerId);
                return view('map.banner.invite.invite-form', compact('modelUser', 'modelBannerLicense', 'dataBannerLicense'));
            }
        }
    }

    public function postInvite($bannerLicenseId)
    {
        $modelUser = new TfUser();
        $modelBannerLicense = new TfBannerLicense();
        $hFunction = new \Hfunction();
        $mailObject = new \Mail3dtf();
        $modelBannerLicenseInvite = new TfBannerLicenseInvite();
        $email = Request::input('txtEmail');
        $message = Request::input('txtMessage');

        if ($modelUser->existAccount($email)) {
            return trans('frontend_map.banner_invite_email_notify_registered');
        } else {
            if ($modelBannerLicenseInvite->existEmailInviting($email)) {
                return trans('frontend_map.banner_invite_email_invited');
            } else {
                if ($mailObject->checkExist($email)) {
                    $dataLicense = $modelBannerLicense->getInfo($bannerLicenseId);
                    if (count($dataLicense) > 0) {
                        $licenseId = $dataLicense->licenseId();
                        $inviteCode = $hFunction->getTimeCode();
                        if ($modelBannerLicenseInvite->insert($inviteCode, $email, $message, $licenseId)) {
                            $inviteLink = route('tf.map.banner.invite.access', $inviteCode);
                            if (!empty($email)) {
                                #send by php mailer
                                $userName = $dataLicense->user->fullName();
                                $content = "
                                            Hi, $userName has sent an invitation to you.

                                            $message

                                            You click link below to use FREE BANNER.
                                            $inviteLink
                                            Thanks!";
                                $mailObject->sendFromGmail("Welcome to system 3DTF.COM", $email, $content);
                            }

                        }

                    }

                    return trans('frontend_map.banner_invite_email_notify_successful');

                } else {
                    return trans('frontend_map.banner_invite_email_not_exist');
                }

            }
        }

    }

    public function accessInvite($inviteCode = null)
    {
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        $modelBusinessType = new TfBusinessType();
        $modelProvince = new TfProvince();
        $modelArea = new TfArea();
        $modelBannerLicense = new TfBannerLicense();
        $modelLicenseInvite = new TfBannerLicenseInvite();

        $dataBannerLicenceInvite = $modelLicenseInvite->getInfoOfCode($inviteCode);
        if (count($dataBannerLicenceInvite) > 0) {
            $modelBannerLicense->setAccessInviteCode($inviteCode);
            $dataBanner = $dataBannerLicenceInvite->bannerLicense->banner;
            $dataProject = $dataBanner->project;
            $dataMapAccess = [
                'provinceAccess' => $dataProject->provinceId(),
                'areaAccess' => $dataProject->areaId(),
                'landAccess' => null,
                'bannerAccess' => $dataBanner,
                'inviteCode' => $inviteCode,
                'businessTypeAccess' => $modelBusinessType->getAccess()
            ];

            # set load area into history
            $modelArea->setMainHistoryArea($dataProject->areaId());
            return view('map.map', compact('modelAbout', 'modelUser', 'modelProvince', 'modelArea', 'dataMapAccess'));
        } else {
            return redirect()->route('tf.home');
        }

    }

    //confirm
    public function getInviteConfirm($inviteId)
    {
        $modelBannerLicenseInvite = new TfBannerLicenseInvite();
        $dataBannerLicenseInvite = $modelBannerLicenseInvite->getInfo($inviteId);
        return view('map.banner.invite.invite-confirm', compact('dataBannerLicenseInvite'));
    }

    public function postInviteConfirm($inviteId)
    {
        $hFunction = new \Hfunction();
        $modelUser = new TfUser();
        $modelUserCard = new TfUserCard();
        $modelTransactionStatus = new TfTransactionStatus();
        $modelBannerLicense = new TfBannerLicense();
        $modelUserStatistic = new TfUserStatistic();
        $modelBannerLicenseInvite = new TfBannerLicenseInvite();

        $email = Request::input('txtEmail');
        $firstName = Request::input('txtFirstName');
        $lastName = Request::input('txtLastName');
        $password = Request::input('txtPassword');
        $token = Request::input('_token');

        $result = array(
            'result' => 'success',
            'content' => ''
        );

        $dataBannerLicenseInvite = $modelBannerLicenseInvite->getInfo($inviteId);
        $inviteEmail = $dataBannerLicenseInvite->email();
        if ($email == $inviteEmail) {
            if ($modelUser->existAccount($email)) {
                $result['result'] = 'fail';
                $result['content'] = 'This email registered';
            } else {
                if ($modelUser->insert($firstName, $lastName, $email, $password, null, 0, $token)) {
                    $newUserId = $modelUser->insertGetId();
                    $modelUserStatistic->insert($newUserId, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
                    $nameCode = $modelUser->nameCode($newUserId);

                    //insert card
                    $modelUserCard->insert(150, $newUserId);
                    //old license info
                    $dataBannerLicense = $dataBannerLicenseInvite->bannerLicense;
                    $licenseId = $dataBannerLicense->licenseId();
                    $bannerId = $dataBannerLicense->bannerId();
                    $dateBegin = $hFunction->carbonNow();
                    $dateEnd = $dataBannerLicense->dateEnd();

                    //new license of banner
                    $transactionStatusId = $modelTransactionStatus->inviteStatusId();
                    if ($modelBannerLicense->insert($dateBegin, $dateEnd, $bannerId, $newUserId, $transactionStatusId)) {
                        $newLicenseId = $modelBannerLicense->insertGetId();

                        //insert exchange
                        $modelUserExchangeBanner = new TfUserExchangeBanner();
                        $cardId = $modelUser->cardId($newUserId);
                        $modelUserExchangeBanner->insert(0, $cardId, $newLicenseId);

                        $modelUserStatistic->plusBanner($newUserId);

                        //cancel old license
                        $modelBannerLicense->actionDelete($licenseId);
                        $modelBannerLicense->cancelLicense('invite', 'give to another user', $licenseId);
                    }

                    $dataBannerLicenseInvite->updateAgree($inviteId);
                    $result['result'] = 'success';
                    $result['content'] = route('tf.register.account.verify', $nameCode); #verify account

                } else {
                    $result['result'] = 'fail';
                    $result['content'] = 'Sorry, Enter info to again.';
                }

            }
        } else {
            $result['result'] = 'fail';
            $result['content'] = 'Sorry, You must enter address email received invitation';
        }
        die(json_encode($result));
    }
}