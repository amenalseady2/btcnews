<?php
namespace App\Http\Controllers\Api;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Requests\Api\Passport\LoginByDeviceIdRequest;
use App\Http\Requests\Api\Passport\LoginByFacebookIdRequest;
use App\Http\Requests\Api\Passport\LoginByGoogleIdRequest;
use App\Http\Requests\Api\Passport\LoginByTwitterIdRequest;
use Passport;
use User;
use Socialite;
use Output;
use Request;

class PassportController extends BaseController
{
	public function loginByDeviceId(LoginByDeviceIdRequest $loginByDeviceIdRequest)
	{
		if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
		$ip = getenv("HTTP_CLIENT_IP");
		else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
		$ip = getenv("HTTP_X_FORWARDED_FOR");
		else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
		$ip = getenv("REMOTE_ADDR");
		else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
		$ip = $_SERVER['REMOTE_ADDR'];
		else
		$ip = "unknown";
		$deviceId = $loginByDeviceIdRequest->Input('device_id');
		$logintReturn = Passport::loginByDeviceId($deviceId , $ip);
		$action = $logintReturn['action'];
		$passport = $logintReturn['userPassport'];
		$userInfo = $this->getUserInfoByUserPassportId($passport->id);

		$data =[];
		$data['passport'] = $passport->formatForApp();
		$data['userInfo'] = $userInfo->formatForApp();
		$data['action'] = $action;
		return Output::success($data);
	}

	public function loginByGoogleId(LoginByGoogleIdRequest $loginByGoogleIdRequest)
	{
		$googleId = $loginByGoogleIdRequest->Input('google_id');
		$passport = Passport::user();
		$passport = Passport::loginByGoogleId($googleId);

		if($passport)
		{
			$userInfo = $this->getUserInfoByUserPassportId($passport->id);
			$data =[];
			$data['action'] = 'login';
			$data['passport'] = $passport->formatForApp();
			$data['userInfo'] = $userInfo->formatForApp();
			return Output::success($data);
		}else{

			$passportDefaultGoogleId = Passport::getPassportDefaultGoogleId();
			$passport = Passport::user();
			if($passport->google_id == $passportDefaultGoogleId)
			{
				$passport = Passport::bindGoogleId($googleId,$passport->id);
				$userInfo = $this->getUserInfoByUserPassportId($passport->id);
				$data =[];
				$data['action'] = 'bind';
				$data['passport'] = $passport->formatForApp();
				$data['userInfo'] = $userInfo->formatForApp();
				return Output::success($data);
			}else{
				$messages = [];
				$messages['google_id'] = trans('api.theDeviceIsAlreadyBoundToTheGoogle_id');
				return Output::fail($messages);
			}
		}
	}

	public function loginByFacebookId(LoginByFacebookIdRequest $loginByFacebookIdRequest)
	{
		$facebookId = $loginByFacebookIdRequest->Input('facebook_id');
		$passport = Passport::loginByFacebookId($facebookId);

		if($passport)
		{
			$userInfo = $this->getUserInfoByUserPassportId($passport->id);
			$data =[];
			$data['action'] = 'login';
			$data['passport'] = $passport->formatForApp();
			$data['userInfo'] = $userInfo->formatForApp();
			return Output::success($data);
		}else{

			$passportDefaultFacebookId = Passport::getPassportDefaultFacebookId();
			$passport = Passport::user();
			if($passport->facebook_id == $passportDefaultFacebookId)
			{
				$passport = Passport::bindFacebookId($facebookId,$passport->id);
				$userInfo = $this->getUserInfoByUserPassportId($passport->id);
				$data =[];
				$data['action'] = 'bind';
				$data['passport'] = $passport->formatForApp();
				$data['userInfo'] = $userInfo->formatForApp();
				return Output::success($data);
			}else{
				$messages = [];
				$messages['facebook_id'] = trans('api.theDeviceIsAlreadyBoundToTheFacebook_id');
				return Output::fail($messages);
			}
		}
	}

	public function loginByTwitterId(LoginByTwitterIdRequest $loginByTwitterIdRequest)
	{
		$twitterId = $loginByTwitterIdRequest->Input('twitter_id');
		$passport = Passport::loginByTwitterId($twitterId);

		if($passport)
		{
			$userInfo = $this->getUserInfoByUserPassportId($passport->id);
			$data =[];
			$data['action'] = 'login';
			$data['passport'] = $passport->formatForApp();
			$data['userInfo'] = $userInfo->formatForApp();
			return Output::success($data);
		}else{

			$passportDefaultTwitterId = Passport::getPassportDefaultTwitterId();
			$passport = Passport::user();
			if($passport->twitter_id == $passportDefaultTwitterId)
			{
				$passport = Passport::bindTwitterId($twitterId,$passport->id);
				$userInfo = $this->getUserInfoByUserPassportId($passport->id);
				$data =[];
				$data['action'] = 'bind';
				$data['passport'] = $passport->formatForApp();
				$data['userInfo'] = $userInfo->formatForApp();
				return Output::success($data);
			}else{
				$messages = [];
				$messages['twitter_id'] = trans('api.theDeviceIsAlreadyBoundToTheTwitter_id');
				return Output::fail($messages);
			}
		}
	}

	private function getUserInfoByUserPassportId($userPassportId)
	{
		$userInfo = User::getUserInfoByUserPassportId($userPassportId);
		if(!$userInfo)
		{
			$userInfo = User::storeDefaultUserInfo($userPassportId);
		}
		return $userInfo;
	}

	private function incrByCoinViaFirstAccountLogin($userPassportId){
		$coinViaFirstAccountLoginTag = User::verifyCoinViaFirstAccountLogin($userPassportId);
		if($coinViaFirstAccountLoginTag){
			User::incrByCoinViaFirstAccountLogin($userPassportId);
		}

		return $coinViaFirstAccountLoginTag;
	}

	public function googleRedirect()
	{
		return Socialite::driver('google')->redirect();
	}

	public function getGoogleUser()
	{
		$user = Socialite::driver('google')->stateless()->user();
		$data = [];
		$data['user'] = $user;
		return view('api/googleUser',$data);
	}

	public function facebookRedirect()
	{
		return Socialite::driver('facebook')->redirect();
	}

	public function getFacebookUser()
	{
		$user = Socialite::driver('facebook')->stateless()->user();
		$data = [];
		$data['user'] = $user;
		return view('api/facebookUser',$data);
	}

	public function twitterRedirect()
	{
		return Socialite::driver('twitter')->redirect();
	}

	public function getTwitterUser()
	{
		$user = Socialite::driver('twitter')->user();
		$data = [];
		$data['user'] = $user;
		return view('api/twitterUser',$data);
	}

	public function setOnesignalId(Request $Request)
	{
		$passport = Passport::user();
		$onesignalId = $Request::input('onesignal_id');
		Passport::updatePassport($passport->id , ['onesignal_id' => $onesignalId]);
		return Output::success();
	}
}
