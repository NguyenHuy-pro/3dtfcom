<?php namespace App\Models\Manage\Content\Seller;

use App\Models\Manage\Content\Seller\Payment\TfSellerPayment;
use App\Models\Manage\Content\Seller\Payment\TfSellerPaymentInfo;
use App\Models\Manage\Content\Seller\Price\TfSellerPaymentPrice;
use Illuminate\Database\Eloquent\Model;

class TfSeller extends Model
{

    protected $table = 'tf_sellers';
    protected $fillable = ['seller_id', 'sellerCode', 'beginDate', 'landShare', 'landShareAccess', 'landShareRegister', 'landInviteRegister', 'bannerShare', 'bannerShareAccess', 'bannerShareRegister', 'bannerInviteRegister', 'buildingShare', 'buildingShareAccess', 'buildingShareRegister', 'status', 'action', 'created_at', 'user_id'];
    protected $primaryKey = 'seller_id';
    public $timestamps = false;

    private $lastId;

    #============ ============ ============ INSERT && UPDATE ============ ============ ============
    #---------- Insert ------------
    public function insert($landShare, $landShareAccess, $landShareRegister, $bannerShare, $bannerShareAccess, $bannerShareRegister, $buildingShare, $buildingShareAccess, $buildingShareRegister, $userId)
    {
        $hFunction = new \Hfunction();
        $modelSeller = new TfSeller();
        $modelSeller->sellerCode = $hFunction->getTimeCode();
        $modelSeller->beginDate = $hFunction->carbonNow();
        $modelSeller->landShare = $landShare;
        $modelSeller->landShareAccess = $landShareAccess;
        $modelSeller->landShareRegister = $landShareRegister;
        $modelSeller->landInviteRegister = 0; //add later
        $modelSeller->bannerShare = $bannerShare;
        $modelSeller->bannerShareAccess = $bannerShareAccess;
        $modelSeller->bannerShareRegister = $bannerShareRegister;
        $modelSeller->bannerInviteRegister = 0; //add later
        $modelSeller->buildingShare = $buildingShare;
        $modelSeller->buildingShareAccess = $buildingShareAccess;
        $modelSeller->buildingShareRegister = $buildingShareRegister;
        $modelSeller->user_id = $userId;
        $modelSeller->created_at = $hFunction->carbonNow();
        if ($modelSeller->save()) {
            $this->lastId = $modelSeller->seller_id;
            return true;
        } else {
            return false;
        }
    }

    //get new id
    public function insertGetId()
    {
        return $this->lastId;
    }

    #----------- Update ----------
    public function resetStatistic($sellerId)
    {
        $hFunction = new \Hfunction();
        return TfSeller::where('seller_id', $sellerId)->update([
            'beginDate' => $hFunction->carbonNow(),
            'landShare' => 0,
            'landShareAccess' => 0,
            'landShareRegister' => 0,
            'bannerShare' => 0,
            'bannerShareAccess' => 0,
            'bannerShareRegister' => 0,
            'buildingShare' => 0,
            'buildingShareAccess' => 0,
            'buildingShareRegister' => 0
        ]);
    }

    public function updateStatus($sellerId, $status)
    {
        return TfSeller::where('seller_id', $sellerId)->update(['status' => $status]);
    }

    //delete
    public function actionDelete($sellerId)
    {
        $modelPaymentInfo = new TfSellerPaymentInfo();
        $modelPayment = new TfSellerPayment();
        if (TfSeller::where('seller_id', $sellerId)->update(['action' => 0, 'status' => 0])) {
            //disable payment info
            $modelPaymentInfo->deleteBySeller($sellerId);

            //disable payment is waiting to process
            $modelPayment->deleteBySeller($sellerId);
        }
    }

    public function deleteByUser($userId)
    {
        return TfSeller::where('user_id', $userId)->update(['action' => 0, 'status' => 0]);
    }
    #============ ============ ============ CHECK INFO ============ ============ ==========
    //check payment
    public function checkPayment()
    {
        $hFunction = new \Hfunction();
        $modelSeller = new TfSeller();
        $modelSellerPayment = new TfSellerPayment();
        $modelSellerPaymentPrice = new TfSellerPaymentPrice();
        $day = date("d");
        $hour = date("H");
        if ($day == 15 && $hour % 8) {
            $dataSeller = $this->getInfo();
            $dataSellerPrice = $modelSellerPaymentPrice->infoIsActive();
            if (count($dataSeller) > 0) {
                $priceId = $dataSellerPrice->priceId();
                $accessNumber = $dataSellerPrice->accessValue();
                $registerNumber = $dataSellerPrice->registerValue();
                $paymentLimit = $dataSellerPrice->paymentLimit();
                foreach ($dataSeller as $seller) {
                    $fromDate = $seller->beginDate();
                    $sellerId = $seller->sellerId();
                    $landShareAccess = $seller->landShareAccess();
                    $landShareRegister = $seller->landShareRegister();
                    $landInviteRegister = $seller->landInviteRegister();
                    $bannerShareAccess = $seller->bannerShareAccess();
                    $bannerShareRegister = $seller->bannerShareRegister();
                    $bannerInviteRegister = $seller->bannerInviteRegister();
                    $buildingShareAccess = $seller->buildingShareAccess();
                    $buildingShareRegister = $seller->buildingShareRegister();

                    $totalAccess = ($landShareAccess + $bannerShareAccess + $buildingShareAccess);
                    $totalRegister = ($landShareRegister + $landInviteRegister + $bannerShareRegister + $bannerInviteRegister + $buildingShareRegister);
                    $totalPayment = ($totalAccess / $accessNumber) + ($totalRegister / $registerNumber);
                    if ($totalPayment >= $paymentLimit) {
                        if ($modelSellerPayment->insert($fromDate, $hFunction->carbonNow(), $totalAccess, $totalRegister, $totalPayment, $sellerId, $priceId)) {
                            $modelSeller->resetStatistic($sellerId);
                        }
                    }

                    //$toDate = $hFunction->dateTimePlusDay($fromDate, 30);
                    //$checkDate = $hFunction->carbonNow();
                    //while ($toDate <= $checkDate) {
                    //if ($modelSellerPayment->insert($fromDate, $toDate, $totallAccess, $totalRegister, $totalPay, $sellerId, $priceId)) {
                    //}
                    //}
                }
            }
        }

    }
    #============ ============ ============ RELATION ============ ============ ============
    #---------- TF-USER ----------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    public function  checkExistUser($userId)
    {
        $result = TfSeller::where('user_id', $userId)->count();
        return ($result > 0) ? true : false;
    }

    public function infoOfUser($userId)
    {
        return TfSeller::where('user_id', $userId)->first();
    }

    public function plusLandShareOfUser($userId)
    {
        return $this->plusStatisticOfUser($userId, 'landShare');
    }

    public function plusLandShareAccessOfUser($userId)
    {
        return $this->plusStatisticOfUser($userId, 'landShareAccess');
    }

    public function plusLandShareRegisterOfUser($userId)
    {
        return $this->plusStatisticOfUser($userId, 'landShareRegister');
    }

    public function plusLandInviteRegisterOfUser($userId)
    {
        return $this->plusStatisticOfUser($userId, 'landInviteRegister');
    }

    public function plusBannerShareOfUser($userId)
    {
        return $this->plusStatisticOfUser($userId, 'bannerShare');
    }

    public function plusBannerShareAccessOfUser($userId)
    {
        return $this->plusStatisticOfUser($userId, 'bannerShareAccess');
    }

    public function plusBannerShareRegisterOfUser($userId)
    {
        return $this->plusStatisticOfUser($userId, 'bannerShareRegister');
    }

    public function plusBannerInviteRegisterOfUser($userId)
    {
        return $this->plusStatisticOfUser($userId, 'bannerInviteRegister');
    }

    public function plusBuildingShareOfUser($userId)
    {
        return $this->plusStatisticOfUser($userId, 'buildingShare');
    }

    public function plusBuildingShareAccessOfUser($userId)
    {
        return $this->plusStatisticOfUser($userId, 'buildingShareAccess');
    }

    public function plusBuildingShareRegisterOfUser($userId)
    {
        return $this->plusStatisticOfUser($userId, 'buildingShareRegister');
    }

    public function plusStatisticOfUser($userId, $field)
    {
        $value = TfSeller::where('user_id', $userId)->pluck($field);
        return TfSeller::where('user_id', $userId)->update([$field => $value + 1]);
    }

    #---------- TF-SELLER-PAYMENT-----------
    public function sellerPayment()
    {
        return $this->hasMany('App\Models\Manage\Content\Seller\Payment\TfSellerPayment', 'seller_id', 'seller_id');
    }

    public function sellerPaymentOfSeller($sellerId, $take = null, $dateTake)
    {
        $modelSellerPayment = new TfSellerPayment();
        return $modelSellerPayment->infoOfSeller($sellerId, $take, $dateTake);
    }

    #---------- TF-SELLER-PAYMENT-INFO-----------
    public function sellerPaymentInfo()
    {
        return $this->hasMany('App\Models\Manage\Content\Seller\Payment\TfSellerPaymentInfo', 'seller_id', 'seller_id');
    }

    public function paymentInfoIsActive($sellerId = null)
    {
        $modelSellerPaymentInfo = new TfSellerPaymentInfo();
        if (empty($sellerId)) $sellerId = $this->sellerId();
        return $modelSellerPaymentInfo->infoIsActiveOfSeller($sellerId);
    }

    #============ ============ ============ GET INFO ============ ============ ============
    public function getInfoByCode($sellerCode)
    {
        return TfSeller::where('sellerCode', $sellerCode)->first();
    }

    public function getInfo($sellerId = null, $field = null)
    {
        if (empty($sellerId)) {
            return TfSeller::where('action', 1)->where('status', 1)->get();
        } else {
            $result = TfSeller::where('seller_id', $sellerId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfSeller::where('seller_id', $objectId)->pluck($column);
        }
    }

    public function sellerId()
    {
        return $this->seller_id;
    }

    public function sellerCode($sellerId = null)
    {
        return $this->pluck('sellerCode', $sellerId);
    }

    public function beginDate($sellerId = null)
    {
        return $this->pluck('beginDate', $sellerId);
    }

    public function landShare($sellerId = null)
    {
        return $this->pluck('landShare', $sellerId);
    }

    public function landShareAccess($sellerId = null)
    {
        return $this->pluck('landShareAccess', $sellerId);
    }

    public function landShareRegister($sellerId = null)
    {
        return $this->pluck('landShareRegister', $sellerId);
    }

    public function landInviteRegister($sellerId = null)
    {
        return $this->pluck('landInviteRegister', $sellerId);
    }

    public function bannerShare($sellerId = null)
    {
        return $this->pluck('bannerShare', $sellerId);
    }

    public function bannerShareAccess($sellerId = null)
    {
        return $this->pluck('bannerShareAccess', $sellerId);
    }

    public function bannerShareRegister($sellerId = null)
    {
        return $this->pluck('bannerShareRegister', $sellerId);
    }

    public function bannerInviteRegister($sellerId = null)
    {
        return $this->pluck('bannerInviteRegister', $sellerId);
    }

    public function buildingShare($sellerId = null)
    {
        return $this->pluck('buildingShare', $sellerId);
    }

    public function buildingShareAccess($sellerId = null)
    {
        return $this->pluck('buildingShareAccess', $sellerId);
    }

    public function buildingShareRegister($sellerId = null)
    {
        return $this->pluck('buildingShareRegister', $sellerId);
    }

    public function status($sellerId = null)
    {
        return $this->pluck('status', $sellerId);
    }

    public function createdAt($sellerId = null)
    {
        return $this->pluck('created_at', $sellerId);
    }

    public function userId($sellerId = null)
    {
        return $this->pluck('sellerId', $sellerId);
    }

    #total records
    public function totalRecords()
    {
        return TfSeller::where('action', 1)->count();
    }

}
