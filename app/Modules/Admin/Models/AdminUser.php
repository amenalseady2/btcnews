<?php 
namespace App\Modules\Admin\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminUser extends Model {

 	use SoftDeletes;
	protected $table = 'admin_users';
	protected $fillable = array('email', 'password');

    public static function getInstance()
    {
    	return new AdminUser();
    }

    public function scopeId($query,$id)
    {
    	return $query->where('id', '=', $id);
    }

    public function scopeIds($query,$ids)
    {
        return $query->whereIn('id', $ids);     
    }

    public function scopeEmail($query,$email)
    {
        return $query->where('email', '=', $email);
    }

    public function scopePassword($query,$password)
    {
        return $query->where('password', '=', $password);
    }
}

?>