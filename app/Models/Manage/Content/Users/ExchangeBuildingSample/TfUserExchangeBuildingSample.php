<?php namespace App\Models\Manage\Content\Users\ExchangeBuildingSample;

use Illuminate\Database\Eloquent\Model;

class TfUserExchangeBuildingSample extends Model
{

    protected $table = 'tf_user_exchange_building_samples';
    protected $fillable = ['sample_id', 'card_id', 'point', 'created_at'];
    protected $primaryKey = 'exchange_id';
    public $timestamps = false;

    #========== ========== ========= INSERT && UPDATE =========== =========== =========
    public function insert($cardId, $sampleId, $point = '')
    {
        $hFunction = new \Hfunction();
        $modelExchange = new TfUserExchangeBuildingSample();
        $modelExchange->card_id = $cardId;
        $modelExchange->sample_id = $sampleId;
        $modelExchange->point = $point;
        $modelExchange->created_at = $hFunction->carbonNow();
        return $modelExchange->save();
    }

    #========== ========== ========== RELATION ========= ========== ==========
    #----------- TF-BUILDING SAMPLE -----------
    public function buildingSample(){
        return $this->belongsTo('App\Models\Manage\Content\Sample\Building\TfBuildingSample', 'sample_id', 'sample_id');
    }

    # ---------  TF-USER-CARD ----------
    public function userCard()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\Card\TfUserCard', 'card_id', 'card_id');
    }

    # total records
    public function totalRecords(){
        return TfUserExchangeBuildingSample::count();
    }

}
