<?php 
namespace App\Modules\Passport\Services;
use App\Modules\Passport\Services\PassportServiceInterface;
use App\Modules\Passport\Repositories\Contracts\UserPassportRepositoryInterface;
use App\Exceptions\ServiceException;
use Illuminate\Validation\Rule;
use Validator;
use Auth;
use Cache;
use DB;

class PassportService implements PassportServiceInterface{

    const VIRTUAL_PRIFIX_DEVICE_ID = 'mobibookapp';
    const VIRTUAL_BOOK_SOURCE_PRIFIX_DEVICE_ID = 'mobibookapp-booksource';
    const VIRTUAL_BOOK_SOURCE_PASSPORT_CACHEKEY = 'VIRTUAL_BOOK_SOURCE_PASSPORT_CACHE';

    private $userPassportRepository;
    public function __construct(UserPassportRepositoryInterface $userPassportRepository)
    {
        $this->userPassportRepository = $userPassportRepository;
    }

    public function getPassportDefaultGoogleId()
    {
        return $this->userPassportRepository->getDefaultGoogleId();
    }

    public function getPassportDefaultFacebookId()
    {
        return $this->userPassportRepository->getDefaultFacebookId();
    }

    public function getPassportDefaultTwitterId()
    {
        return $this->userPassportRepository->getDefaultTwitterId();
    }

    public function loginByDeviceId($deviceId , $ip)
    {
    	$validatorData = [];
    	$validatorData['device_id'] = $deviceId;
        $validator = $this->userPassportRepository->getFilterValidator($validatorData);

        if($validator->passes()) {

        	$password = md5($deviceId);
            $check = DB::table('user_passports')->where('device_id',$deviceId)->first();
            if ($check) {
                $userPassport = $this->getPassportById($check->id);
                $userPassport = $this->resetPassportApiTokenByInstance($userPassport);

                $returnData = [];
                $returnData['action'] = 'login';
                $returnData['userPassport'] = $userPassport;
                return $returnData;

            }else{
                try{
                    $country = json_decode(file_get_contents('http://ip.taobao.com/service/getIpInfo.php?ip='.$ip),true);
                }catch (\Exception $e){
                    $country = [];
                    $country['data']['country'] = '';
                }
                if(empty($country['data']['country']))
                {
                    $country['data']['country'] = "未知";
                }
                $password = bcrypt($password);
                $apiTokenString = $deviceId.rand(100000,999999).time();
                $apiToken = md5($apiTokenString);

                $userPassportData = [
                    'device_id'	    => $deviceId,
                    'google_id'     => $this->getPassportDefaultGoogleId(),
                    'facebook_id'   => $this->getPassportDefaultFacebookId(),
                    'twitter_id'    => $this->getPassportDefaultTwitterId(),
                    'password'      => $password,
                    'api_token'	    => $apiToken,
                    'ip'            => $ip,
                    'country'       => $country['data']['country'],
                ];

                $checks = DB::table('user_passports')->where('device_id',$deviceId)->first();
                if ($checks) {
                    $userPassport = $this->getPassportById($checks->id);
                    $userPassport = $this->resetPassportApiTokenByInstance($userPassport);

                    $returnData = [];
                    $returnData['action'] = 'login';
                    $returnData['userPassport'] = $userPassport;
                    return $returnData;
                }

                $userPassport = $this->userPassportRepository->store($userPassportData);
                Auth::login($userPassport);
                $returnData = [];
                $returnData['action'] = 'register';
                $returnData['userPassport'] = Auth::user();
                return $returnData;
            }

        }else{  
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }        
    }

    public function loginByGoogleId($googleId)
    {
        $validatorData = [];
        $validatorData['google_id'] = $googleId;
        $validator = $this->userPassportRepository->getFilterValidator($validatorData);
        if($validator->passes()) {
            $userPassport = $this->getPassportByGoogleId($googleId);
            if($userPassport){
                $userPassport = $this->resetPassportApiTokenByInstance($userPassport);
                return $userPassport;
            }else{
                return false;
            }

        }else{  
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function loginByFacebookId($facebookId)
    {
        $validatorData = [];
        $validatorData['facebook_id'] = $facebookId;
        $validator = $this->userPassportRepository->getFilterValidator($validatorData);
        if($validator->passes()) {
            $userPassport = $this->getPassportByFacebookId($facebookId);
            if($userPassport){
                $userPassport = $this->resetPassportApiTokenByInstance($userPassport);
                return $userPassport;
            }else{
                return false;
            }

        }else{  
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function loginByTwitterId($twitterId)
    {
        $validatorData = [];
        $validatorData['twitter_id'] = $twitterId;
        $validator = $this->userPassportRepository->getFilterValidator($validatorData);
        if($validator->passes()) {
            $userPassport = $this->getPassportByTwitterId($twitterId);
            if($userPassport){
                $userPassport = $this->resetPassportApiTokenByInstance($userPassport);
                return $userPassport;
            }else{
                return false;
            }

        }else{  
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function bindGoogleId($googleId,$id)
    {
        $validatorData = [];
        $validatorData['google_id'] = $googleId;
        $validatorData['id'] = $id;
        $validator = $this->userPassportRepository->getUpdateValidator($validatorData);
        $rules = $validator->getRules();
        $rules['id'][] = 'verifyPassportId';
        $rules['google_id'][] = 'uniqueGoogleId';
        $validator->setRules($rules);
        $validator->addExtension('verifyPassportId', function($attribute, $value, $parameters, $validator) {
            return $this->verifyPassportId($value);
        });
        $validator->addExtension('uniqueGoogleId', function($attribute, $value, $parameters, $validator) {
            $data = $validator->getData();
            return $this->uniqueGoogleId($value,$data['id']);
        });

        if ($validator->passes()){
                
            $updateData = [];
            $updateData['google_id'] = $googleId;
            $userPassport = $this->updatePassport($id,$updateData);
            return $this->resetPassportApiTokenByInstance($userPassport);

        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function bindFacebookId($facebookId,$id)
    {
        $validatorData = [];
        $validatorData['facebook_id'] = $facebookId;
        $validatorData['id'] = $id;
        $validator = $this->userPassportRepository->getUpdateValidator($validatorData);
        $rules = $validator->getRules();
        $rules['id'][] = 'verifyPassportId';
        $rules['facebook_id'][] = 'uniqueFacebookId';
        $validator->setRules($rules);
        $validator->addExtension('verifyPassportId', function($attribute, $value, $parameters, $validator) {
            return $this->verifyPassportId($value);
        });
        $validator->addExtension('uniqueFacebookId', function($attribute, $value, $parameters, $validator) {
            $data = $validator->getData();
            return $this->uniqueFacebookId($value,$data['id']);
        });

        if ($validator->passes()){
                
            $updateData = [];
            $updateData['facebook_id'] = $facebookId;
            $userPassport = $this->updatePassport($id,$updateData);
            return $this->resetPassportApiTokenByInstance($userPassport);

        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function bindTwitterId($twitterId,$id)
    {
        $validatorData = [];
        $validatorData['twitter_id'] = $twitterId;
        $validatorData['id'] = $id;
        $validator = $this->userPassportRepository->getUpdateValidator($validatorData);
        $rules = $validator->getRules();
        $rules['id'][] = 'verifyPassportId';
        $rules['twitter_id'][] = 'uniqueTwitterId';
        $validator->setRules($rules);
        $validator->addExtension('verifyPassportId', function($attribute, $value, $parameters, $validator) {
            return $this->verifyPassportId($value);
        });

        $validator->addExtension('uniqueTwitterId', function($attribute, $value, $parameters, $validator) {
            $data = $validator->getData();
            return $this->uniqueTwitterId($value,$data['id']);
        });

        if ($validator->passes()){
                
            $updateData = [];
            $updateData['twitter_id'] = $twitterId;
            $userPassport = $this->updatePassport($id,$updateData);
            return $this->resetPassportApiTokenByInstance($userPassport);

        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function user()
    {
        return Auth::user();
    }

    public function check()
    {
        return Auth::check();
    }

    public function updatePassport($id,$updateData)
    {
        $validatorData = [];
        $validatorData += $updateData;
        $validatorData['id'] = $id;    
        $validator = $this->userPassportRepository->getUpdateValidator($validatorData);
        $rules = $validator->getRules();
        $rules['id'][] = 'verifyPassportId';
        $validator->setRules($rules);
        $validator->addExtension('verifyPassportId', function($attribute, $value, $parameters, $validator) {
            return $this->verifyPassportId($value);
        });

        if ($validator->passes()){

            $passport = $this->userPassportRepository->updateById($id,$updateData);
            return $passport;

        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function destoryPassportById($id)
    {
        return $this->userPassportRepository->destroyById($id);
    }

    public function resetPassportApiTokenByInstance($userPassport)
    {
        $apiTokenString = $userPassport->device_id.rand(100000,999999).time();
        $attributes = [];
        $attributes['api_token'] = md5($apiTokenString);
        return $this->userPassportRepository->updateModel($attributes,$userPassport);
    }

    public function verifyPassportId($id)
    {
        $rules = [
            'id' => 'required|integer|exists:user_passports,id',
        ];
        $validator = Validator::make(['id'=>$id], $rules);
        return $validator->passes();
    }

    public function verifyDeviceId($deviceId)
    {
        $rules = [
            'device_id' => 'required|string|exists:user_passports,device_id',
        ];
        $validator = Validator::make(['device_id'=>$deviceId], $rules);
        return $validator->passes();
    }

    public function uniqueGoogleId($googleId,$id=null)
    {
        if($id)
        {
            $rules = [
                'google_id' => [
                    'required',
                    'string',
                    'max:100',
                    Rule::unique('user_passports')->ignore($id, 'id')
                ]
            ];

        }else{
            $rules = [
                'google_id' => 'required|string|max:100|unique:user_passports,google_id',
            ];
        }
        
        $validator = Validator::make(['google_id'=>$googleId], $rules);
        return $validator->passes();
    }

    public function uniqueFacebookId($facebookId,$id=null)
    {

        if($id)
        {
            $rules = [
                'facebook_id' => [
                    'required',
                    'string',
                    'max:100',
                    Rule::unique('user_passports')->ignore($id, 'id')
                ]
            ];

        }else{
            $rules = [
                'facebook_id' => 'required|string|max:100|unique:user_passports,facebook_id',
            ];
        }

        $validator = Validator::make(['facebook_id'=>$facebookId], $rules);
        return $validator->passes();
    }

    public function uniqueTwitterId($twitterId,$id=null)
    {
        if($id)
        {
            $rules = [
                'twitter_id' => [
                    'required',
                    'string',
                    'max:100',
                    Rule::unique('user_passports')->ignore($id, 'id')
                ]
            ];
        }else{
            $rules = [
                'twitter_id' => 'required|string|max:100|unique:user_passports,twitter_id',
            ];
        }

        $validator = Validator::make(['twitter_id'=>$twitterId], $rules);
        return $validator->passes();
    }

    //获取用户列表
    public function getUserPassportPaginate(array $fileds=array(),$order='id_desc',$limit=20)
    {
        $getUserData = [];
        $getUserData['order'] = $order;
        $getUserData += $fileds;
        $validator = $this->userPassportRepository->getFilterValidator($getUserData);
        $rules = $validator->getRules();
        $rules['order'][] = 'in:'.implode(',', $this->userPassportRepository->getOrderFields());
        $validator->setRules($rules);
        if ($validator->passes()){
            $UserPage = $this->userPassportRepository->paginate($fileds,[$order],$limit);
            return $UserPage;
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function getUserPassports(array $fileds=array(),$order='id_desc',$offset=0,$limit=20)
    { 
        $data = [];
        $data['order'] = $order;
        $data += $fileds;
        $validator = $this->userPassportRepository->getFilterValidator($data);
        $rules = $validator->getRules();
        $rules['order'][] = 'in:'.implode(',', $this->userPassportRepository->getOrderFields());
        $validator->setRules($rules);
        if ($validator->passes()){
            $userPassports = $this->userPassportRepository->get($fileds,[$order],$offset,$limit);
            return $userPassports;
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function getPassportById($id)
    {
        $validator = $this->userPassportRepository->getFilterValidator(['id'=>$id]);
        if($validator->passes()) {
            return $this->userPassportRepository->getById($id);
        }else{  
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function getPassportByDeviceId($deviceId)
    {
        $validator = $this->userPassportRepository->getFilterValidator(['device_id'=>$deviceId]);
        if($validator->passes()) {

            $fileds = [];
            $fileds['device_id'] = $deviceId;
            return $this->userPassportRepository->getOne($fileds);

        }else{  
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function getPassportByGoogleId($googleId)
    {

        $validator = $this->userPassportRepository->getFilterValidator(['google_id'=>$googleId]);
        if($validator->passes()) {

            $fileds = [];
            $fileds['google_id'] = $googleId;
            return $this->userPassportRepository->getOne($fileds);

        }else{  
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function getPassportByFacebookId($facebookId)
    {
        $validator = $this->userPassportRepository->getFilterValidator(['facebook_id'=>$facebookId]);
        if($validator->passes()) {

            $fileds = [];
            $fileds['facebook_id'] = $facebookId;
            return $this->userPassportRepository->getOne($fileds);

        }else{  
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function getPassportByTwitterId($twitterId)
    {
        $validator = $this->userPassportRepository->getFilterValidator(['twitter_id'=>$twitterId]);
        if($validator->passes()) {

            $fileds = [];
            $fileds['twitter_id'] = $twitterId;
            return $this->userPassportRepository->getOne($fileds);

        }else{  
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function getUserIdByField($field,$value)
    {
        return $this->userPassportRepository->getUserIdByField($field,$value);
    }

    //禁用或恢复用户
    public function setUserStatus($id)
    {
        $userPassport = $this->userPassportRepository->getById($id);
        if(is_object($userPassport) && !empty($userPassport))
        {
            if($userPassport->status == 0)
            {
                if($this->userPassportRepository->setUserStatus($id,1))
                return json_encode(['status'=>200,'type'=>'jinyong']);
            }else{
                if($this->userPassportRepository->setUserStatus($id,0))
                return json_encode(['status'=>200,'type'=>'huifu']);
            }
            return false;
        }else{
            return false;
        }
    }

    public function getBookSourceVirtualPassport()
    {
        $minutes = 24*60;
        $passports = Cache::remember(self::VIRTUAL_BOOK_SOURCE_PASSPORT_CACHEKEY, $minutes , function() {
            $fileds = [];
            $fileds['contain_device_id'] = self::VIRTUAL_BOOK_SOURCE_PRIFIX_DEVICE_ID;
            $passports = $this->getUserPassports($fileds,'id_desc',0,0);
            return $passports;
        });

        return $passports;
    }

    public function getBookSourceVirtualPassportOne()
    {
        $passports = $this->getBookSourceVirtualPassport();
        $passport = $passports->random();
        return $passport;
    }
    public function deviceId($device_id)
    {
        $field = 'api_token';
        return $this->userPassportRepository->getUserIdByField($field,$device_id);
    }
}