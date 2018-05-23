<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Routing\Controller as BaseController;
use Request;
use DB;

class AppsController extends BaseController
{

	public function index()
	{
		$apps = DB::table('apps')->orderBy('id','desc')->paginate(20);
		return view('admin.apps.index',['apps'=>$apps]);
	}

	public function create()
	{
		return view('admin.apps.create');
	}

	public function store()
	{
		$name = Request::input('name','');
		if(!isset($name) || empty($name))
		{
			echo "<script>alert('应用名必填')</script>";
			echo "<script>history.go(-1)</script>";
			exit();
		}
		$count = DB::table('apps')->where('name',$name)->count();
		if($count)
		{
			echo "<script>alert('应用名已存在')</script>";
			echo "<script>history.go(-1)</script>";
			exit();
		}
		$storeData = [];
		$storeData['name'] = $name;
		$storeData['create_time'] = time();
		$storeData['app_key'] = bcrypt($name.$storeData['create_time']);
		DB::table('apps')->insert($storeData);
		return redirect('/admin/apps')->with('status-success', 'save success !');
	}

	public function edit($id)
	{
		$app = DB::table('apps')->where('id',$id)->first();
		return view('admin.apps.update',['row'=>$app]);
	}

	public function update($id)
	{
		$name = Request::input('name','');
		if(!isset($name) || empty($name))
		{
			echo "<script>alert('应用名必填')</script>";
			echo "<script>history.go(-1)</script>";
			exit();
		}
		$count = DB::table('apps')->where('name',$name)->where('id','!=',$id)->count();
		if($count)
		{
			echo "<script>alert('应用名已存在')</script>";
			echo "<script>history.go(-1)</script>";
			exit();
		}
		$updateData = [];
		$updateData['name'] = $name;
		DB::table('apps')->where('id',$id)->update($updateData);
		return redirect('/admin/apps')->with('status-success', 'save success !');
	}

	public function destroy($id)
	{
		$this->checkAuth();
		DB::table('apps')->where('id',$id)->delete();
		return redirect('/admin/apps')->with('status-success', 'delete success !');
	}

	private function checkAuth()
	{
		if(session('Admin_Session_User')->email != 'admin@admin.com')
		{
			die('Permission denied');
		}
	}
}
