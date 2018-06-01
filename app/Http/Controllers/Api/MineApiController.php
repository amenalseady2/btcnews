<?php

namespace App\Http\Controllers\Api;
use Illuminate\Routing\Controller as BaseController;
use Output;
use Request;
use DB;

class MineApiController extends BaseController
{
	
	//获取挖矿规则
	public function getMineRule()
	{
		$config = DB::table('mine_config')->first();
		$data = [];
		if($config){
			$data['max_mine_time'] = $config['max_mine_time'];
			$data['min_mine_time'] = $config['min_mine_time'];
			$data['max_mine_coin'] = $config['max_mine_coin'];
		}

		return Output::success($data);
	}

	//挖矿接口
	public function mine()
	{
		$openid = Request::input('openid','');
		if(!$openid)
		{
			return Output::error('need user uniq id');
		}
		$user = DB::table('users')->where('openid',$openid)->first();
		if(!$user)
		{
			return Output::error('not found user');
		}
		$config = DB::table('mine_config')->first();
		if($config)
		{
			
		}
	}
}
