<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Requests\Admin\Upload\ImageUploadRequest;
use App\Http\Requests\Admin\Upload\TxtUploadRequest;
use Illuminate\Http\File;
use Request;
use Image;
use Storage;
use Output;

class UploadController extends BaseController
{
	public function imageUpload(ImageUploadRequest $imageUploadRequest)
	{
		$uploadFile = $imageUploadRequest->file('uploadFile');
		$imageWith = $imageUploadRequest->input('width');
		$imageHeight = $imageUploadRequest->input('height');
		$is_Article = $imageUploadRequest->input('is_Article');

		//处理文章图片宽高自适应
		if(isset($is_Article) && $is_Article == 1)
		{
			$img_info  = getimagesize($imageUploadRequest->file('uploadFile'));
			$srcWidth  = $img_info[0];
			$srcHeight = $img_info[1];
			$imageWith = $imageUploadRequest->input('width','640');
			if($srcWidth > $imageWith)
			{
				$imageHeight = ($imageWith/$srcWidth) * $srcHeight;
			}
		}

		if($uploadFile->isValid()) {

			if($imageWith && $imageHeight)
			{
				$directoryName = 'uploadImages/'.date('Ymd');
				Storage::disk('local')->makeDirectory($directoryName);
				$filePath = Storage::disk('local')->putFile($directoryName,$uploadFile);
				$storagePath = storage_path();
				$fullFilePath = $storagePath.'/app/'.$filePath;
		 		$image = Image::make($fullFilePath)->resize($imageWith, $imageHeight);

		 		$fullDirectoryName = $storagePath.'/app/'.$directoryName;
		 		$uploadFilePath = $uploadFile->path();
		 		$imageName = md5($uploadFilePath.rand(100000,999999).time()).'.'.$uploadFile->extension();
		 		$fullImagePath = $fullDirectoryName.'/'.$imageName;

				$image->save($fullImagePath);
				$imageFile = new File($fullImagePath);
				$url = $this->doUpload($imageFile);

				Storage::disk('local')->delete($directoryName.'/'.$imageName);
				Storage::disk('local')->delete($filePath);

				/*
				$uploadFilePath = $uploadFile->path();
		 		$image = Image::make($uploadFilePath)->resize($imageWith, $imageHeight);
		 		$storagePath = storage_path();
		 		$directoryName = 'uploadImages';
		 		Storage::disk('local')->makeDirectory($directoryName);
		 		$fullDirectoryName = $storagePath.'/app/'.$directoryName;
		 		$imageName = md5($uploadFilePath.rand(100000,999999).time()).'.'.$uploadFile->extension();
		 		$fullImagePath = $fullDirectoryName.'/'.$imageName;
				$image->save($fullImagePath);
				$imageFile = new File($fullImagePath);
				$url = $this->doUpload($imageFile);
				Storage::disk('local')->delete($directoryName.'/'.$imageName);
				*/
			}else{
				$url = $this->doUpload($uploadFile);
			}

			if(isset($is_Article) && $is_Article == 1)
			{
				$data['success'] = true;
				$data['msg'] = 'success';
				$data['file_path'] = $url;
				die(json_encode($data));
			}else{
				$data =[];
				$data['url'] = $url;
				return Output::success($data);
			}

		}else{
			return Output::fail();
		}
	}

	public function txtUpload(TxtUploadRequest $txtUploadRequest)
	{
		$uploadFile = $txtUploadRequest->file('uploadFile');
		if($uploadFile->isValid()) {
			$url = $this->doUpload($uploadFile);
			$data =[];
			$data['url'] = $url;
			return Output::success($data);
		}else{
			return Output::fail();
		}
	}

	private function doUpload($uploadFile)
	{
		$diskS3 = Storage::disk('s3');
		$remoteFilePath = 'uploadFiles/'.date("Ymd");
		$filePath = $diskS3->putFile($remoteFilePath, $uploadFile, 'public' );
		$cdnDomain = env('AWS_CDN_DOMAIN');
		$url = $cdnDomain.'/'.$filePath;
		return $url;
	}
}
