<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Routing\Controller as BaseController;
use Request;
use DB;

class MineConfigController extends BaseController
{

	public function index()
	{
		$config = DB::table('mine_config')->first();
		if(!$config)
		{
			DB::table('mine_config')->insert([
				'give_coin_p' => 100,
				'give_coin_s' => 100,
				'max_give_coin' => 10,
				'max_mine_time' => 21600,
				'min_mine_time' => 1800,
				'max_mine_coin' => 20
			]);
			$config = DB::table('mine_config')->first();
		}
		return view('admin.mineconfig.update' , ['config' => $config]);
	}

	public function update()
	{
		$config = Request::input();
		foreach ($config as $key => $value) {
			if($value == '' || $value == null)
			{
				return back()->with('status-error','所有字段必填，请重新填写');
			}
		}
		DB::table('mine_config')->update($config);
		return redirect('/admin/mineConfig')->with('status-success','保存成功');
	}
	
}
