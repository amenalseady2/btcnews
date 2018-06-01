<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Routing\Controller as BaseController;
use Request;
use DB;

class NewsController extends BaseController
{

	public function index()
	{
		$articles = DB::table('articles')->orderBy('id','desc')->paginate(20);
		return view('admin.articles.index',['articles'=>$articles]);
	}


	public function edit($id)
	{
		$article = DB::table('articles')->where('id',$id)->first();
		return view('admin.articles.update',['row'=>$article]);
	}

	public function update($id)
	{
		$is_open_mine = Request::input('is_open_mine',0);
		$mine_price = Request::input('mine_price',0);
		$mine_num = Request::input('mine_num',0);
		if($mine_price == '' || $mine_num == '')
		{
			return back()->with('status-error', '内容不能为空');
		}
		if($is_open_mine == 1 && $mine_num == 0)
		{
			return back()->with('status-error', '可挖矿次数不能为0');
		}
		DB::table('articles')->where('id',$id)->update([
			'is_open_mine' => $is_open_mine,
			'mine_price' => $mine_price,
			'mine_num' => $mine_num
		]);
		return redirect('/admin/news')->with('status-success', '设置成功 !');
	}

	private function checkAuth()
	{
		if(session('Admin_Session_User')->email != 'admin@admin.com')
		{
			die('Permission denied');
		}
	}
}
