<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Requests\Admin\Index\IndexRequest;
use Admin;

class IndexController extends BaseController
{
	public function index()
	{
		Admin::loginOut();
		return view('admin/index/index');
	}

	public function login(IndexRequest $indexRequest)
	{
		$email 	  =  $indexRequest->input('email');
		$password =  $indexRequest->input('password');

		$result = Admin::login($email,$password);
		if($result)
		{
			return redirect('admin/administrators/user');
		}else{
			return redirect('admin/index');
		}
	}

}
