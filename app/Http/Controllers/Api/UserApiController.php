<?php

namespace App\Http\Controllers\Api;
use Illuminate\Routing\Controller as BaseController;
use Output;
use Request;
use DB;

class UserApiController extends BaseController
{
	
	public function register()
	{
		$openid = Request::input('openid','');
		$shareid = Request::input('shareid',0);
		if(!$openid)
		{
			return Output::error('need user uniq id');
		}
		if(DB::table('users')->where('openid',$openid)->first())
		{
			return Output::error('have been registered');
		}
		$data = [];
		$data['openid'] = $openid;
		$data['create_time'] = time();
		$data['last_mine_time'] = $data['create_time'];
		if($shareid)
		{
			$data['pid'] = $shareid;
			$pid = $shareid;
		}else{
			$pid = 0;
		}

		if($userId = DB::table('users')->insertGetId($data))
		{
			//赠币
			$this->checkGiveCoin($userId , $pid);
			$opData = [];
			$opData['id'] = $userId;
			$opData['create_time'] = $data['create_time'];
			$opData['last_mine_time'] = $data['create_time'];
			return Output::success($opData);
		}else{
			return Output::error('sorry save data error , please try again');
		}
	}


	private function checkGiveCoin($uid , $pid)
	{
		if( !$uid || !$pid || ($uid == $pid) || ($pid > $uid) )
		{
			return false;
		}
		$config = DB::table('mine_config')->first();
		if($config)
		{
			$shareCount = DB::table('users')->where('pid',$pid)->count();
			if($config['max_give_coin'] > $shareCount)
			{
				//邀请人赠币
				if($config['give_coin_p'])
				{
					DB::table('users')->where('id',$pid)->increment('money', $config['give_coin_p']);
					DB::table('money_log')->insert([
						'user_id'		=>	$pid,
						'money'			=>	$config['give_coin_p'],
						'modify_type'	=>	1,
						'info'			=>	'邀请赠币',
						'create_time'	=>	time()
					]);
				}
				//被邀请人赠币
				if($config['give_coin_s'])
				{
					DB::table('users')->where('id',$uid)->increment('money', $config['give_coin_s']);
					DB::table('money_log')->insert([
						'user_id'		=>	$uid,
						'money'			=>	$config['give_coin_s'],
						'modify_type'	=>	1,
						'info'			=>	'被邀请赠币',
						'create_time'	=>	time()
					]);
				}
			}
		}
	}

}
