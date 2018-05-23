<?php
namespace App\Http\Controllers\Rpc;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Requests\Rpc\Upload\ImageUploadRequest;
use App\Http\Requests\Rpc\Upload\PdfUploadRequest;
use App\Http\Requests\Rpc\Upload\EpubUploadRequest;
use App\Http\Requests\Rpc\Upload\ContentUploadRequest;
use Illuminate\Http\File;
use Request;
use Image;
use Storage;
use Output;
use Exception;

class UploadController extends BaseController
{
	public function imageUpload(ImageUploadRequest $imageUploadRequest)
	{
		$imageUrl = $imageUploadRequest->input('imageUrl');
		$imageWith = $imageUploadRequest->input('width');
		$imageHeight = $imageUploadRequest->input('height');

		$directoryName = 'rpcUploadImages/'.date('Ymd');
		Storage::disk('local')->makeDirectory($directoryName);

		$parseUrlArray = parse_url($imageUrl);
		$iamgeUrlInfo = pathinfo($parseUrlArray['path']);
		if(isset($iamgeUrlInfo['extension']))
		{
	 		$imageName = md5($imageUrl.rand(100000,999999).time()).'.'.$iamgeUrlInfo['extension'];
		}else{
			$imageName = md5($imageUrl.rand(100000,999999).time());
		}

		try {

			$imageContent = file_get_contents($imageUrl);
			$imagePath = $directoryName.'/'.$imageName;
			Storage::disk('local')->put($imagePath, $imageContent);
			$storagePath = storage_path();
			$fullImagePath = $storagePath.'/app/'.$imagePath;

			if($imageWith && $imageHeight)
			{
				$image = Image::make($fullImagePath)->resize($imageWith, $imageHeight);
				$image->save($fullImagePath);
			}

			$imageFile = new File($fullImagePath);
			$url = $this->doUpload($imageFile);

			Storage::disk('local')->delete($imagePath);

			$data =[];
			$data['url'] = $url;
			return Output::success($data);

		} catch (Exception $e) {
			return Output::exception();
		}
	}

	public function contentUpload(ContentUploadRequest $contentUploadRequest)
	{
		$fileContents = $contentUploadRequest->input('content');
		$fileName = md5(rand(100000,999999).time());

		$directoryName = 'rpcContentUploads/'.date('Ymd');
		Storage::disk('s3')->makeDirectory($directoryName);

		$filePath = $directoryName.'/'.$fileName;
		Storage::disk('local')->put($filePath, $fileContents);

		$storagePath = storage_path();
		$fullFilePath = $storagePath.'/app/'.$filePath;

		$contentFile = new File($fullFilePath);
		$url = $this->doUpload($contentFile);

		Storage::disk('local')->delete($filePath);

		$data =[];
		$data['url'] = $url;
		return Output::success($data);
	}

	public function pdfUpload(PdfUploadRequest $pdfUploadRequest)
	{
		$pdfUrl = $pdfUploadRequest->input('pdfUrl');
		$directoryName = 'rpcUploadPdfs/'.date('Ymd');
		Storage::disk('local')->makeDirectory($directoryName);
		$pdfUrlInfo = pathinfo($pdfUrl);
		$pdfName = md5($pdfUrl.rand(100000,999999).time()).'.pdf';

		try {
			$pdfUrlInfo = parse_url($pdfUrl);
			if($pdfUrlInfo['scheme'] == 'http')
			{
				$pdfContent = file_get_contents($pdfUrl);
			}else{

		      	$ch = curl_init();
		        curl_setopt($ch, CURLOPT_URL, $pdfUrl);
		        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.106 Safari/537.36");
		        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
		        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
		        curl_setopt($ch, CURLOPT_TIMEOUT, 3600);
		        curl_setopt($ch, CURLOPT_HEADER, FALSE);
		        curl_setopt($ch, CURLOPT_BUFFERSIZE, 20971520);
		        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		 		$pdfContent = curl_exec($ch);
		 		unset($ch);
			}

		} catch (Exception $e) {
			return Output::exception();
		}

		$pdfPath = $directoryName.'/'.$pdfName;
		Storage::disk('local')->put($pdfPath, $pdfContent);
		$storagePath = storage_path();
		$fullPdfPath = $storagePath.'/app/'.$pdfPath;

		$pdfFile = new File($fullPdfPath);
		$extensionType = $pdfFile->guessExtension();
		if($extensionType == 'pdf')
		{
			$url = $this->doUpload($pdfFile,$pdfName);
			Storage::disk('local')->delete($pdfPath);
			$data =[];
			$data['url'] = $url;
			return Output::success($data);
		}else{
			Storage::disk('local')->delete($pdfPath);
			$messages =[];
			$messages['pdfUrl'] = 'pdfUrl Extension error';
			return Output::fail($messages);
		}
	}

	public function epubUpload(EpubUploadRequest $epubUploadRequest)
	{
		$epubUrl = $epubUploadRequest->input('epubUrl');
		$directoryName = 'rpcUploadEpubs/'.date('Ymd');
		Storage::disk('local')->makeDirectory($directoryName);

		$pdfUrlInfo = pathinfo($epubUrl);
		$epubName = md5($epubUrl.rand(100000,999999).time()).'.epub';

		try {
			$pdfUrlInfo = parse_url($epubUrl);
			if($pdfUrlInfo['scheme'] == 'http')
			{
				$pdfContent = file_get_contents($epubUrl);
			}else{

		      	$ch = curl_init();
		        curl_setopt($ch, CURLOPT_URL, $epubUrl);
		        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.106 Safari/537.36");
		        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
		        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
		        curl_setopt($ch, CURLOPT_TIMEOUT, 3600);
		        curl_setopt($ch, CURLOPT_HEADER, FALSE);
		        curl_setopt($ch, CURLOPT_BUFFERSIZE, 20971520);
		        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		 		$pdfContent = curl_exec($ch);
		 		unset($ch);
			}

		} catch (Exception $e) {
			return Output::exception();
		}

		$epubPath = $directoryName.'/'.$epubName;
		Storage::disk('local')->put($epubPath, $pdfContent);
		$storagePath = storage_path();
		$fullEpubPath = $storagePath.'/app/'.$epubPath;
		$epubFile = new File($fullEpubPath);
		$extensionType = $epubFile->guessExtension();

		if(in_array($extensionType, ['epub','zip']))
		{
			$url = $this->doUpload($epubFile,$epubName);
			Storage::disk('local')->delete($epubPath);

			$data =[];
			$data['url'] = $url;
			return Output::success($data);
		}else{

			Storage::disk('local')->delete($epubPath);
			$messages =[];
			$messages['epubUrl'] = 'epubUrl Extension error';
			return Output::fail($messages);
		}

	}

	private function doUpload($uploadFile,$fileName='')
	{
		$diskS3 = Storage::disk('s3');
		$remoteFilePath = 'uploadFiles/'.date("Ymd");

		if($fileName){
			$filePath = $diskS3->putFileAs($remoteFilePath, $uploadFile, $fileName );
			$diskS3->setVisibility($filePath, 'public');
		}else{
			$filePath = $diskS3->putFile($remoteFilePath, $uploadFile, 'public');
		}

		$cdnDomain = env('AWS_CDN_DOMAIN');
		$url = $cdnDomain.'/'.$filePath;
		return $url;
	}


}
