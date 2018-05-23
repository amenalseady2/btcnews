<?php 
namespace App\Modules\User\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserReadbooks extends Model {
	protected $fillable = [
        'id', 'user_id', 'book_id', 'readindex'
    ];
    protected $table = 'user_readbooks';

    public static function getInstance()
    {
        return new UserReadbooks();
    }
 	
}

?>