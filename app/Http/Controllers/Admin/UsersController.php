<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Routing\Controller as BaseController;
use Request;
use DB;

class UsersController extends BaseController
{

	public function index()
	{
		$row = DB::table('users')->orderBy('id','desc')->paginate(20);
		return view('admin.users.index',['row' => $row]);
	}
	
	
}
