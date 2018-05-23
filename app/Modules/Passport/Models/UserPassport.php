<?php

namespace App\Modules\Passport\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserPassport extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'device_id', 'google_id', 'facebook_id', 'twitter_id', 'password', 'api_token','ip','country','onesignal_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $table = 'user_passports';

    public static function getInstance()
    {
        return new UserPassport();
    }

    public function scopeId($query,$id)
    {
        return $query->where('id', '=', $id);
    }    

    public function scopeIds($query,$ids)
    {
        return $query->whereIn('id', $ids);  
    }

    public function scopeDeviceId($query,$deviceId)
    {
        return $query->where('device_id', '=', $deviceId);
    }

    public function scopeOnesignalId($query,$onesignalId)
    {
        return $query->where('onesignal_id', '=', $onesignalId);
    }

    public function scopeContainDeviceId($query,$deviceId)
    {
        return $query->where('device_id', 'like', '%'.$deviceId."%");
    }

    public function scopeGoogleId($query,$googleId)
    {
        return $query->where('google_id', '=', $googleId);
    }    

    public function scopeFacebookId($query,$facebookId)
    {
        return $query->where('facebook_id', '=', $facebookId);
    }    

    public function scopeTwitterId($query,$twitterId)
    {
        return $query->where('twitter_id', '=', $twitterId);
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
        $data['id']             = $this->id;
        $data['device_id']      = $this->device_id;
        $data['google_id']      = $this->google_id;
        $data['facebook_id']    = $this->facebook_id;
        $data['twitter_id']     = $this->twitter_id;
        $data['onesignal_id']   = $this->onesignal_id;
        $data['api_token']      = $this->api_token;
        $data['created_at']     = $this->created_at->toDateTimeString();
        $data['updated_at']     = $this->updated_at->toDateTimeString();
        return $data;
    }


}
