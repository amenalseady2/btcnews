<?php 
namespace App\Modules\User\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCoinLog extends Model {

    use SoftDeletes;
    protected $table = 'user_coin_logs';
    protected $fillable = array('user_passport_id', 'coin', 'type', 'extend');
    protected $casts = [
        'extend' => 'array',
    ];

    public static function getInstance()
    {
        return new UserCoinLog();
    }

    public function scopeId($query,$id)
    {
        return $query->where('id', '=', $id);
    }

    public function scopeIds($query,$ids)
    {
        return $query->whereIn('id', $ids);     
    }

    public function scopeUserPassportId($query,$userPassportId)
    {
        return $query->where('user_passport_id', '=', $userPassportId);
    }

    public function scopeType($query,$type)
    {
        return $query->where('type', '=', $type);
    }

    public function scopeTypes($query,$types)
    {
        return $query->whereIn('type', $types);
    }

    public function scopeCreatedAtGte($query,$videoCount)
    {
        return $query->where('created_at','>=',$videoCount);
    }

    public function scopeCreatedAtLte($query,$videoCount)
    {
        return $query->where('created_at','<=',$videoCount);
    }

    public function scopeIdAsc($query)
    {
        return $query->orderBy('id', 'asc');
    }

    public function scopeIdDesc($query)
    {
        return $query->orderBy('id', 'desc');
    }

    public function formatForApp()
    {
        $data = array();
        $data['id']                 = $this->id;
        $data['user_passport_id']   = $this->user_passport_id;
        $data['coin']               = $this->coin;
        $data['type']               = $this->type;
        $data['extend']             = $this->extend?$this->extend:(object)array();
        $data['created_at']         = $this->created_at->toDateTimeString();
        $data['updated_at']         = $this->updated_at->toDateTimeString();
        return $data;
    }
}

?>