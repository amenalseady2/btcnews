<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Routing\Controller as BaseController;
use Request;
use DB;

class VersionSetController extends BaseController
{

	public function index()
	{
		$this->checkAuth();
		$appId = Request::input('app_id',0);
		if(!isset($appId) || empty($appId))
		{
			exit("需要app id");
		}

		$row = DB::table('version')->where('app_id',$appId)->orderBy('id','desc')->paginate(20);
		return view('admin/version/index',['row'=>$row , 'appId'=>$appId]);
	}

	public function create()
	{
		$this->checkAuth();
		$appId = Request::input('app_id',0);
		if(!isset($appId) || empty($appId))
		{
			exit("需要app id");
		}
		return view('admin/version/create',['appId'=>$appId]);
	}

	public function store()
	{
		$this->checkAuth();
		$version_id = Request::input('version_id','');
		$status = Request::input('status');
		$appId = Request::input('app_id',0);
		if(!isset($appId) || empty($appId))
		{
			exit("需要app id");
		}
		$this->checkVersion($version_id);
		if(DB::table('version')->insert(['version_id'=>$version_id , 'status'=>$status , 'app_id'=>$appId]))
		{
			return redirect('/admin/version?app_id='.$appId)->with('status-success', 'save success !');
		}else{
			echo "<script>alert('error')</script>";
			echo "<script>history.go(-1)</script>";
			exit();
		}
	}

	public function edit($id)
	{
		$this->checkAuth();
		$appId = Request::input('app_id',0);
		if(!isset($appId) || empty($appId))
		{
			exit("需要app id");
		}
		$row = DB::table('version')->where('id',$id)->first();
		return view('admin/version/update',['row'=>$row , 'appId'=>$appId]);
	}

	public function update($id)
	{
		$this->checkAuth();
		$version_id = Request::input('version_id','');
		$status = Request::input('status');
		$this->checkVersion($version_id);
		$appId = Request::input('app_id',0);
		if(!isset($appId) || empty($appId))
		{
			exit("需要app id");
		}
		if(DB::table('version')->where('id',$id)->where('app_id',$appId)->update(['version_id'=>$version_id , 'status'=>$status]))
		{
			return redirect('/admin/version?app_id='.$appId)->with('status-success', 'save success !');
		}else{
			echo "<script>alert('error')</script>";
			echo "<script>history.go(-1)</script>";
			exit();
		}
	}

	public function destroy($id)
	{
		$this->checkAuth();
		$appId = Request::input('app_id',0);
		if(!isset($appId) || empty($appId))
		{
			exit("需要app id");
		}
		if(DB::table('version')->where('id',$id)->delete())
		{
			return redirect('/admin/version?app_id='.$appId)->with('status-success', 'delete success !');
		}else{
			echo "<script>alert('error')</script>";
			echo "<script>history.go(-1)</script>";
			exit();
		}
	}

	public function versionEdit()
	{
		$this->checkAuth();
		$appId = Request::input('app_id',0);
		if(!isset($appId) || empty($appId))
		{
			exit("需要app id");
		}
		$info = DB::table('version_packge_info')->where('app_id',$appId)->first();
		if(!$info)
		{
			$app = DB::table('apps')->where('id',$appId)->first();
			DB::table('version_packge_info')->insert(
				[
					'app_id'	 => $appId,
					'version_id' => 0,
					'name'		 => $app->name,
					'url'		 => 0,
					'info'		 => 0,
					'check_md5'	 => 0,
					'size'		 => 0,
					'path'		 => 2
				]
			);
			$info = DB::table('version_packge_info')->where('app_id',$appId)->first();
		}
		return view('admin/version/versionEdit',['row'=>$info , 'appId'=>$appId]);
	}

	public function versionUpdate()
	{
		$this->checkAuth();
		$appId = Request::input('app_id',0);
		if(!isset($appId) || empty($appId))
		{
			exit("需要app id");
		}
		$version_id = Request::input('version_id','');
		$name 		= Request::input('name','');
		$url 		= Request::input('url','');
		$info 		= Request::input('info','');
		$check_md5 	= Request::input('check_md5','');
		$size 		= Request::input('size','');
		$path 		= Request::input('path','');
		$this->checkVersion($version_id);
		if(empty($name))
		{
			echo "<script>alert('包名必填')</script>";
			echo "<script>history.go(-1)</script>";
			exit();
		}
		if(empty($info))
		{
			echo "<script>alert('更新描述必填')</script>";
			echo "<script>history.go(-1)</script>";
			exit();
		}
		if(empty($check_md5))
		{
			echo "<script>alert('MD5校验值必填')</script>";
			echo "<script>history.go(-1)</script>";
			exit();
		}
		if(empty($size))
		{
			echo "<script>alert('APP包大小必填')</script>";
			echo "<script>history.go(-1)</script>";
			exit();
		}
		DB::table('version_packge_info')->where('app_id',$appId)->update(
			[
				'version_id' => $version_id,
				'name'		 => $name,
				'url'		 => $url,
				'info'		 => $info,
				'check_md5'	 => $check_md5,
				'size'		 => $size,
				'path'		 => $path
			]
		);
		return redirect('/admin/version?app_id='.$appId)->with('status-success', 'save success !');
	}









	private function checkVersion($str=''){
	    if(empty($str))
	    {
	    	echo "<script>alert('version_id 不能为空')</script>";
			echo "<script>history.go(-1)</script>";
			exit();
		}
	    for($i=0;$i<strlen($str);$i++){
	        if(!is_numeric($str[$i]) && $str[$i] != '.')
	        {
	            echo "<script>alert('version_id 格式不正确')</script>";
				echo "<script>history.go(-1)</script>";
				exit();
	        }
	    }
	}

	private function checkAuth()
	{
		if(session('Admin_Session_User')->email != 'admin@admin.com')
		{
			die('Permission denied');
		}
	}
}
