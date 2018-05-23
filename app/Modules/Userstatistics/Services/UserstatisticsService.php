<?php 
namespace App\Modules\Userstatistics\Services;
use App\Modules\Userstatistics\Services\UserstatisticsServiceInterface;
use App\Modules\Userstatistics\Repositories\Contracts\UserstatisticsRepositoryInterface;
use App\Exceptions\ServiceException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redis;
use Validator;
use DB;
class UserstatisticsService implements UserstatisticsServiceInterface{

	private $userstatisticsRepository;

    public function __construct(UserstatisticsRepositoryInterface $userstatisticsRepository)
    {
        $this->userstatisticsRepository = $userstatisticsRepository;
    }

    //登录次数统计
    public function setUserLogins($device_id)
    {
        $today = date('Y-m-d',time());
        if(empty($device_id)) return false;
        $userArr = Redis::get('ReadBookuserArray_'.$today);
        if(empty($userArr))
        {
            $userArr = array();
            $userArr[] = $device_id;
            Redis::set('ReadBookuserArray_'.$today, json_encode($userArr));
            Redis::setx('ReadBookuserArray_'.$today,86400*2);
        }else{
            $userArr = json_decode($userArr,true);
            $check = 1;
            foreach ($userArr as $val) 
            {
                if($val==$device_id)
                {
                    $check = 0;
                    break;
                }
            }
            if($check == 1)
            {
                $userArr[] = $device_id;
                Redis::set('ReadBookuserArray_'.$today, json_encode($userArr));
            }
        }

        $count = $check = Redis::get('ReadBookuserCount_'.$today);
        $count+=1;
        Redis::set('ReadBookuserCount_'.$today, $count);
        if(empty($check))
        {
            Redis::setx('ReadBookuserCount_'.$today, 86400*2);
        }
    }

    //登陆人数
    public function getUserCount()
    {
        $today = date('Y-m-d',time());
        $userArray = json_decode(Redis::get('ReadBookuserArray_'.$today),true);
        return count($userArray);
    }

    //登录次数
    public function getLoginCount()
    {
        $today = date('Y-m-d',time());
        return Redis::get('ReadBookuserCount_'.$today);
    }

    public function getHistoryCount()
    {
        $monthDay = date('Y-m-d',time()-(86400*30));
        return DB::table('user_logincount')->where('date', '>=',$monthDay)->orderBy('date', 'desc')->get();
    }
}