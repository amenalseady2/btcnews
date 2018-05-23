<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Requests\Admin\Index\IndexRequest;
use Request;
use Session;
use Output;

class LangController extends BaseController
{
	public function set()
	{
		$lang = Request::input('lang','cn');
		Session::put('userLang',$lang);
		return Output::success();
	}


}
