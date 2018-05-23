<?php 
namespace App\Modules\User\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserInfo extends Model {

    use SoftDeletes;
	protected $fillable = [
        'id', 'user_passport_id', 'nickname', 'coin','likebook','sex','thumbnail','age'
    ];
    protected $table = 'user_infos';

    public static function getInstance()
    {
        return new UserInfo();
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

    public function scopeUserPassportIds($query,$userPassportIds)
    {
        return $query->whereIn('user_passport_id', $userPassportIds);
    }

    public function scopeCreatedAtGte($query,$size)
    {
        return $query->where('created_at','>=',$size);
    }

    public function scopeCreatedAtLte($query,$size)
    {
        return $query->where('created_at','<=',$size);
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
        $data['nickname']           = empty($this->nickname) ? '' : $this->nickname;
        $data['sex']                = $this->sex;
        $data['age']                = $this->age;
        // $data['coin']               = $this->coin;
        // $data['thumbnail']          = empty($this->thumbnail) ? '' : $this->thumbnail;
        // $data['created_at']         = $this->created_at->toDateTimeString();
        // $data['updated_at']         = $this->updated_at->toDateTimeString();
        return $data;
    }
}

?>