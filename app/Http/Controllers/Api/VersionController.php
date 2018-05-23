<?php

namespace App\Http\Controllers\Api;
use Illuminate\Routing\Controller as BaseController;
use Output;
use Request;
use Passport;
use DB;

class VersionController extends BaseController
{
	
	public function getInfo()
	{
		$version_code = Request::input('app_version',0);
		$appKey = Request::input('app_key',0);
		$APP = DB::table('apps')->where('app_key',$appKey)->first();
		if(!$APP)
		{
			return Output::error('Not Found The App');
		}

		$checkInfo = DB::table('version')->where('app_id',$APP->id)->where('version_id',$version_code)->first();
		if(!count($checkInfo))
		{
			$checkInfo = DB::table('version')->where('app_id',$APP->id)->orderBy('version_id','desc')->first();
		}
		$status = 2;
		if(isset($checkInfo->status))
		{
			$status = $checkInfo->status;
		}
		$packgeInfo = DB::table('version_packge_info')->where('app_id',$APP->id)->first();
		$data = [];
		if($status == 0)
		{
			$data['update'] = 'No';
		}else{
			$data['update'] = 'Yes';
			//版本号
			$data['new_version'] = $packgeInfo->version_id;
			//下载链接
			$data['apk_file_url'] = $packgeInfo->url;
			//更新日志
			$data['update_log'] = $packgeInfo->info;
			//包大小
			$data['target_size'] = round($packgeInfo->size / (1024*1024),2).'M';
			//MD5校验
			$data['new_md5'] = $packgeInfo->check_md5;
			//是否强更
			if($status == 1)
			{
				$data['constraint'] = false;
			}else{
				$data['constraint'] = true;
			}
		}
		return response()->json($data);
	}
}
