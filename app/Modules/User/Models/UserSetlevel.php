<?php 
namespace App\Modules\User\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSetlevel extends Model {
	protected $fillable = [
        'id', 'level', 'name'
    ];
    protected $table = 'user_setlevel';

    public static function getInstance()
    {
        return new UserSetlevel();
    }
 	
}

?>