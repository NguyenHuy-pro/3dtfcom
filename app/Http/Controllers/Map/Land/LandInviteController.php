<?php namespace App\Http\Controllers\Map\Land;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Map\Area\TfArea;
use App\Models\Manage\Content\Map\Land\License\TfLandLicense;
use App\Models\Manage\Content\Map\Land\LicenseInvite\TfLandLicenseInvite;
use App\Models\Manage\Content\Map\Transaction\TfTransactionStatus;
use App\Models\Manage\Content\System\About\TfAbout;

use App\Models\Manage\Content\System\Province\TfProvince;

use App\Models\Manage\Content\Users\Card\TfUserCard;
use App\Models\Manage\Content\Users\ExchangeLand\TfUserExchangeLand;
use App\Models\Manage\Content\Users\Statistic\TfUserStatistic;
use App\Models\Manage\Content\Users\TfUser;
//use Illuminate\Http\Request;
use FIle;
use Input;
use DB;
use Request;

class LandInviteController extends Controller
{

    public function getInvite($licenseId)
    {
        $modelUser = new TfUser();
        $modelLandLicense = new TfLandLicense();
        if ($modelUser->checkLogin()) {
            $dataLandLicense = $modelLandLicense->getInfo($licenseId);
            if (count($dataLandLicense)) {
                return view('map.land.invite.invite-form', compact('modelUser', 'modelLandLicense', 'dataLandLicense'));
            }
        }
    }

    public function postInvite($landLicenseId)
    {
        $modelUser = new TfUser();
        $modelLandLicense = new TfLandLicense();
        $hFunction = new \Hfunction();
        $mailObject = new \Mail3dtf();
        $modelLandLicenseInvite = new TfLandLicenseInvite();
        $email = Request::input('txtEmail');
        $message = Request::input('txtMessage');

        if ($modelUser->existAccount($email)) {
            return trans('frontend_map.land_invite_email_notify_registered');
        } else {
            if ($modelLandLicenseInvite->existEmailInviting($email)) {
                return trans('frontend_map.land_invite_email_invited');
            } else {
                if ($mailObject->checkExist($email)) {
                    $dataLicense = $modelLandLicense->getInfo($landLicenseId);
                    if (count($dataLicense) > 0) {
                        $licenseId = $dataLicense->licenseId();
                        $inviteCode = $hFunction->getTimeCode();
                        if ($modelLandLicenseInvite->insert($inviteCode, $email, $message, $licenseId)) {
                            $inviteLink = route('tf.map.land.invite.access', $inviteCode);
                            if (!empty($email)) {
                                //send by php mailer
                                $userName = $dataLicense->user->fullName();
                                $content = "
                                            Hi, $userName has sent an invitation to you.

                                            $message

                                            You click link below to use FREE Land.
                                            $inviteLink
                                            Thanks!";
                                $mailObject->sendFromGmail("Welcome to system 3DTF.COM", $email, $content);
                            }
                        }

                    }

                    return trans('frontend_map.land_invite_email_notify_successful');

                } else {
                    return trans('frontend_map.land_invite_email_not_exist');
                }

            }
        }

    }

    public function accessInvite($inviteCode = null)
    {
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        $modelProvince = new TfProvince();
        $modelArea = new TfArea();
        $modelLandLicense = new TfLandLicense();
        $modelLicenseInvite = new TfLandLicenseInvite();

        $dataLandLicenceInvite = $modelLicenseInvite->getInfoOfCode($inviteCode);
        if (count($dataLandLicenceInvite) > 0) {
            $modelLandLicense->setAccessInviteCode($inviteCode);
            $dataLand = $dataLandLicenceInvite->landLicense->land;
            $dataProject = $dataLand->project;
            $dataMapAccess = [
                'provinceAccess' => $dataProject->provinceId(),
                'areaAccess' => $dataProject->areaId(),
                'landAccess' => $dataLand,
                'bannerAccess' => null,
                'inviteCode' => $inviteCode,
                'businessTypeAccess' => null
            ];

            //set load area into history
            $modelArea->setMainHistoryArea($dataProject->areaId());
            return view('map.map', compact('modelAbout', 'modelUser', 'modelProvince', 'modelArea', 'dataMapAccess'));
        } else {
            return redirect()->route('tf.home');
        }

    }

    //confirm
    public function getInviteConfirm($inviteCode)
    {
        $modelLandLicenseInvite = new TfLandLicenseInvite();
        $dataLandLicenseInvite = $modelLandLicenseInvite->getInfoOfCode($inviteCode);
        return view('map.land.invite.invite-confirm', compact('dataLandLicenseInvite'));
    }

    public function postInviteConfirm($inviteCode)
    {
        $hFunction = new \Hfunction();
        $modelUser = new TfUser();
        $modelUserCard = new TfUserCard();
        $modelTransactionStatus = new TfTransactionStatus();
        $modelLandLicense = new TfLandLicense();
        $modelUserStatistic = new TfUserStatistic();
        $modelLandLicenseInvite = new TfLandLicenseInvite();

        $email = Request::input('txtEmail');
        $firstName = Request::input('txtFirstName');
        $lastName = Request::input('txtLastName');
        $password = Request::input('txtPassword');
        $token = Request::input('_token');

        $result = array(
            'result' => 'success',
            'content' => ''
        );

        $dataLandLicenseInvite = $modelLandLicenseInvite->getInfoOfCode($inviteCode);
        $inviteId = $dataLandLicenseInvite->inviteId();
        $inviteEmail = $dataLandLicenseInvite->email();
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
                    $dataLandLicense = $dataLandLicenseInvite->landLicense;
                    $licenseId = $dataLandLicense->licenseId();
                    $landId = $dataLandLicense->landId();
                    $dateBegin = $hFunction->carbonNow();
                    $dateEnd = $dataLandLicense->dateEnd();

                    //new license of banner
                    $transactionStatusId = $modelTransactionStatus->inviteStatusId();
                    if ($modelLandLicense->insert($dateBegin, $dateEnd, $landId, $newUserId, $transactionStatusId)) {
                        $newLicenseId = $modelLandLicense->insertGetId();

                        //insert exchange
                        $modelUserExchangeBanner = new TfUserExchangeLand();
                        $cardId = $modelUser->cardId($newUserId);
                        $modelUserExchangeBanner->insert(0, $cardId, $newLicenseId);

                        $modelUserStatistic->plusLand($newUserId);

                        //cancel old license
                        $modelLandLicense->actionDelete($licenseId);
                        $modelLandLicense->cancelLicense('invite', 'give to another user', $licenseId);
                    }

                    $dataLandLicenseInvite->updateAgree($inviteId);
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