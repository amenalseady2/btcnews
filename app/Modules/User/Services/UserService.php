<?php 
namespace App\Modules\User\Services;
use App\Modules\User\Services\UserServiceInterface;
use App\Modules\User\Repositories\Contracts\UserReadbooksRepositoryInterface;
use App\Modules\User\Repositories\Contracts\UserLevelRepositoryInterface;
use App\Modules\User\Repositories\Contracts\UserInfoRepositoryInterface;
use App\Modules\User\Repositories\Contracts\UserCoinLogRepositoryInterface;
use App\Exceptions\ServiceException;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Validator;
use DB;

class UserService implements UserServiceInterface{

    const LAUNCH_COIN_VALUE  = 5;
    const SIGN_COIN_VALUE  = 5;
    const SHARE_COIN_VALUE = 10;
    const COLLECTION_COIN_VALUE = 5;
    const READ_FIVE_MINUTE_COIN_VALUE = 5;
    const READ_TEN_MINUTE_COIN_VALUE = 10;
    const READ_HALFHOUR_COIN_VALUE = 20;
    const FIRST_ACCOUNT_LOGIN_VALUE = 50;
    const COMPLETION_USERINFO_VALUE = 30;
    const MARK_COIN_VALUE  = 50;
    const INVITE_COIN_VALUE = 20;
    const BEINVITED_COIN_VALUE = 50;

	private $userReadbooksRepository;
    private $userLevelRepository;
    private $userInfoRepository;
    private $userCoinLogRepository;

    public function __construct(UserReadbooksRepositoryInterface $userReadbooksRepository,
                                UserLevelRepositoryInterface $userLevelRepository, 
                                UserInfoRepositoryInterface $userInfoRepository,
                                UserCoinLogRepositoryInterface $userCoinLogRepository)
    {
        $this->userReadbooksRepository = $userReadbooksRepository;
        $this->userLevelRepository = $userLevelRepository;
        $this->userInfoRepository =$userInfoRepository;
        $this->userCoinLogRepository =$userCoinLogRepository;
    }

    public function getCoinByLaunch()
    {
        return self::LAUNCH_COIN_VALUE;
    }

    public function getCoinBySign()
    {
        return self::SIGN_COIN_VALUE;
    }

    public function getCoinByShare()
    {
        return self::SHARE_COIN_VALUE;
    }

    public function getCoinByCollection()
    {
        return self::COLLECTION_COIN_VALUE;
    }

    public function getCoinByReadFiveMinute()
    {
        return self::READ_FIVE_MINUTE_COIN_VALUE;
    }

    public function getCoinByReadTenMinute()
    {
        return self::READ_TEN_MINUTE_COIN_VALUE;
    }

    public function getCoinByReadHalfhour()
    {
        return self::READ_HALFHOUR_COIN_VALUE;
    }

    public function getCoinByFirstAccountLogin()
    {
        return self::FIRST_ACCOUNT_LOGIN_VALUE;
    }

    public function getCoinByCompletionUserinfo()
    {
        return self::COMPLETION_USERINFO_VALUE;
    }

    public function getCoinByMark()
    {
        return self::MARK_COIN_VALUE;
    }

    public function getCoinByInvite()
    {
        return self::INVITE_COIN_VALUE;
    }

    public function getCoinByBeInvited()
    {
        return self::BEINVITED_COIN_VALUE;
    }

    public function getCoinByCoinType($coinType)
    {
        $coinTypes = $this->getUserCoinType();
        $validationData = [];
        $validationData['coinType'] = $coinType;
        $rules = [
            'coinType'    => 'required|in:'.implode(',', $coinTypes)
        ];

        $validator = Validator::make($validationData, $rules);
        if($validator->passes()){

            if($coinType == $coinTypes['sign'])
            {
                return self::SIGN_COIN_VALUE;
            }

            if($coinType == $coinTypes['share'])
            {
                return self::SHARE_COIN_VALUE;
            }

            if($coinType == $coinTypes['invite'])
            {
                return self::INVITE_COIN_VALUE;
            }

            if($coinType == $coinTypes['beInvited'])
            {
                return self::BEINVITED_COIN_VALUE;
            }

            if($coinType == $coinTypes['mark'])
            {
                return self::MARK_COIN_VALUE;
            }

            if($coinType == $coinTypes['launch'])
            {
                return self::LAUNCH_COIN_VALUE;
            }

            if($coinType == $coinTypes['collection'])
            {
                return self::COLLECTION_COIN_VALUE;
            }

            if($coinType == $coinTypes['readFiveMinute'])
            {
                return self::READ_FIVE_MINUTE_COIN_VALUE;
            }

            if($coinType == $coinTypes['readTenMinute'])
            {
                return self::READ_TEN_MINUTE_COIN_VALUE;
            }

            if($coinType == $coinTypes['readHalfhour'])
            {
                return self::READ_HALFHOUR_COIN_VALUE;
            }

            if($coinType == $coinTypes['firstAccountLogin'])
            {
                return self::FIRST_ACCOUNT_LOGIN_VALUE;
            }

            if($coinType == $coinTypes['completionUserinfo'])
            {
                return self::COMPLETION_USERINFO_VALUE;
            }

        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }

    }

    //获取用户读书记录列表
    public function getReadListPaginate(array $fileds=array(),$order='',$limit=20)
    {
        $getData = [];
        $getData['order'] = $order;
        $getData += $fileds;
        $validator = $this->userReadbooksRepository->getFilterValidator($getData);
        $rules = $validator->getRules();
        $rules['order'][] = 'in:'.implode(',', $this->userReadbooksRepository->getOrderFields());
        $validator->setRules($rules);
        if ($validator->passes()){
            $UserPage = $this->userReadbooksRepository->paginate($fileds,[$order],$limit);
            return $UserPage;
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    //获取读书记录信息
    public function getReadInfo($id)
    {
        return $this->userReadbooksRepository->getById($id);
    }

    //更新读书记录
    public function updateReadInfo($id,$data)
    {
        return $this->userReadbooksRepository->updateById($id,$data);
    }

    //删除读书记录
    public function deleteReadInfo($id)
    {
        return $this->userReadbooksRepository->destroyById($id);
    }

    //获取用户等级列表
    public function getUserLevelPaginate(array $fileds=array(),$order='',$limit=20)
    {
        $getData = [];
        $getData['order'] = $order;
        $getData += $fileds;
        $validator = $this->userLevelRepository->getFilterValidator($getData);
        $rules = $validator->getRules();
        $rules['order'][] = 'in:'.implode(',', $this->userLevelRepository->getOrderFields());
        $validator->setRules($rules);
        if ($validator->passes()){
            $UserPage = $this->userLevelRepository->paginate($fileds,[$order],$limit);
            return $UserPage;
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    //获取等级信息
    public function getLevelInfo($id)
    {
        return $this->userLevelRepository->getById($id);
    }

    //更新等级记录
    public function updateLevelInfo($id,$data)
    {
        $check = $this->userLevelRepository->getByField('level',$data['level']);
        if(!empty($check) && $check->level)
        {
            if($check->id != $id)
            {
                echo "<script>alert('该等级已存在')</script>";
                echo "<script>history.go(-1);</script>";
                exit();
            }
            
        }
        return $this->userLevelRepository->updateById($id,$data);
    }

    //更新用户详情
    /*
    public function updateUserInfo($id,$data)
    {
        $check = $this->userInfoRepository->getByField('nickname',$data['nickname']);
        if(!empty($check) && $check->nickname)
        {
            if($check->user_id != $id)
            {
                echo "<script>alert('该昵称已存在')</script>";
                echo "<script>history.go(-1);</script>";
                exit();
            }
            
        }
        $userCenterObj = $this->userInfoRepository->getByField('user_id',$id);
        return $this->userInfoRepository->updateById($userCenterObj->id,$data);
    }
    */

    //新增用户详情
    public function addUserInfo($data)
    {
        $check = $this->userInfoRepository->getByField('nickname',$data['nickname']);
        if(!empty($check) && $check->nickname)
        {
            echo "<script>alert('该昵称已存在')</script>";
            echo "<script>history.go(-1);</script>";
            exit();
        }
        return $this->userInfoRepository->addUserInfo($data);
    }

    //删除等级记录
    public function deleteLevelInfo($id)
    {
        return $this->userLevelRepository->destroyById($id);
    }

    //新增等级记录
    public function storeUserLevel($data)
    {
        $check = $this->userLevelRepository->getByField('level',$data['level']);
        if(!empty($check) && $check->level)
        {
                echo "<script>alert('该等级已存在')</script>";
                echo "<script>history.go(-1);</script>";
                exit();
        }
        foreach ($data as $key => $value) 
        {
            if (empty($value)) 
            {
                echo "<script>alert('资料不能为空')</script>";
                echo "<script>history.go(-1);</script>";
                exit();
            }
        }
        return $this->userLevelRepository->storeUserLevel($data);
    }

    //财富榜
    public function ranklist($type,$topNum)
    {
        return $this->userInfoRepository->ranklist($type,$topNum);
    }

    //等级算法
    public function experienceToLevel($experience)
    {
        $info = [];
        $levelAll = $this->userLevelRepository->getAll();
        foreach ($levelAll as $key => $value) 
        {
            if($experience >= $value->experience)
            {
                $info['level'] = $value->level;
                $info['name'] = $value->name; 
                break;
            }
        }
        if(empty($info))
        {
            $info['level'] = 0;
            $info['name'] = "没有头衔"; 
        }
        return $info;
    }

    public function getUserInfoByField($field,$value)
    {
        return $this->userInfoRepository->getByField($field,$value);
    }

    public function addExperience($userid,$num)
    {
        $check = DB::table('user_experience_logs')
                ->where('user_id',$userid)
                ->where('created_at','>',date('Y-m-d H:i:s',time()-10))
                ->first();
        if(is_object($check) && !empty($check))
        {
            return false;
        }
        DB::transaction(function () use($userid,$num){
            DB::insert('INSERT INTO user_experience_logs(user_id,experience,created_at,source) values (?,?,?,?)', [$userid,$num,date('Y-m-d H:i:s',time()),"达到阅读时长"]);
            DB::update('UPDATE user_center set experience = experience+'.$num.',updated_at="'.date('Y-m-d H:i:s',time()).'" where user_id = ?', [$userid]);
        });
        return true;
    }


    //检测coin_log创建日期
    public function todayissetObj($userid,$type)
    {
        $todate = date('Y-m-d',time());
        $check = DB::table('user_coin_logs')
                ->where('user_id',$userid)
                ->where('type',$type)
                ->where('created_at','>=',$todate)
                ->first();
        if(is_object($check) && !empty($check))
        {
            return true;
        }else{
            return false;
        }
    }

    //添加金币
    public function addCoin($userid,$num,$type,$info)
    {
        try
        {
            DB::insert('INSERT INTO user_coin_logs(user_id,coin,type,created_at,source) values (?,?,?,?,?)', [$userid,$num,$type,date('Y-m-d H:i:s',time()),$info]);
            DB::update('UPDATE user_center set coin = coin+'.$num.',updated_at="'.date('Y-m-d H:i:s',time()).'" where user_id = ?', [$userid]);
            return true;
        }catch(\Exception $e)
        {
            return false;
        }
    }

    public function getDefaultCoin()
    {
        return $this->userInfoRepository->getDefaultCoin();
    }

    public function getDefaultExperience()
    {
        return $this->userInfoRepository->getDefaultExperience();
    }

    public function verifyStoreUserInfoPassportId($userPassportId)
    {
        $rules = [
            'user_passport_id' => 'required|unique:user_infos,user_passport_id,NULL,id,deleted_at,NULL',
        ];
        $validator = Validator::make(['user_passport_id'=>$userPassportId], $rules);
        return $validator->passes();
    }

    public function verifyUpdateUserInfoPassportId($userPassportId,$id)
    {
         $rules = [
            'user_passport_id' => ['required',
                        Rule::unique('user_infos')->where(function ($query) use($id,$userPassportId) {
                                $query->where('user_passport_id', $userPassportId)->whereNull('deleted_at');
                        })->ignore($id, 'id'),
                      ]
        ];

        $validator = Validator::make(['user_passport_id'=>$userPassportId], $rules);
        return $validator->passes();
    }

    public function storeDefaultUserInfo($userPassportId)
    {
        $storeData = [];
        $storeData['user_passport_id']  = $userPassportId;
        $storeData['nickname']          = "زائر";
        $storeData['coin']              = $this->getDefaultCoin();
        // $storeData['experience']        = $this->getDefaultExperience();
        return $this->storeUserInfo($storeData);
    }

    public function storeUserInfo(array $storeData)
    {
        $validator = $this->userInfoRepository->getStoreValidator($storeData);
        $rules = $validator->getRules();
        $rules['user_passport_id'][] = 'verifyStoreUserInfoPassportId';
        $validator->setRules($rules);
        $validator->addExtension('verifyStoreUserInfoPassportId', function($attribute, $value, $parameters, $validator) {
            return $this->verifyStoreUserInfoPassportId($value);
        });

        if ($validator->passes()){
            $userInfo = $this->userInfoRepository->store($storeData);
            return $userInfo;
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function updateUserInfo($id,array $updateData)
    {
        $validatorData = [];
        $validatorData += $updateData;
        $validatorData['id'] = $id;    
        $validator = $this->userInfoRepository->getUpdateValidator($validatorData);
        $rules = $validator->getRules();
        $rules['user_passport_id'][] = 'verifyUpdateUserInfoPassportId';
        $validator->setRules($rules);
        $validator->addExtension('verifyUpdateUserInfoPassportId', function($attribute, $value, $parameters, $validator)use($id) {
            return $this->verifyUpdateUserInfoPassportId($value,$id);
        });

        if ($validator->passes()){
            $userInfo = $this->userInfoRepository->updateById($id,$updateData);
            return $userInfo;
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function destoryUserInfoByUserPassportId($userPassportId)
    {
        $this->destoryUserCoinLogByUserPassportId($userPassportId);
        $userInfo =  $this->userInfoRepository->getByUserPassportId($userPassportId);
        if($userInfo){
            return $this->userInfoRepository->destroyById($userInfo->id);
        }else{
            return false;
        }
    }

    public function getUserInfos(array $fileds=array(),$order='id_desc',$offset=0,$limit=20)
    { 
        $data = [];
        $data['order'] = $order;
        $data += $fileds;
        $validator = $this->userInfoRepository->getFilterValidator($data);
        $rules = $validator->getRules();
        $rules['order'][] = 'in:'.implode(',', $this->userInfoRepository->getOrderFields());
        $validator->setRules($rules);
        if ($validator->passes()){
            $userInfos = $this->userInfoRepository->get($fileds,[$order],$offset,$limit);
            return $userInfos;
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function getUserInfoCount(array $fileds=array())
    {
        $data = [];
        $data += $fileds;
        $validator = $this->userInfoRepository->getFilterValidator($data);
        $rules = $validator->getRules();
        $validator->setRules($rules);
        if ($validator->passes()){
            $userInfoCount = $this->userInfoRepository->count($fileds);
            return $userInfoCount;
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function getUserInfoPaginate(array $fileds=array(),$order='id_desc',$limit=20)
    {
        $data = [];
        $data['order'] = $order;
        $data += $fileds;
        $validator = $this->userInfoRepository->getFilterValidator($data);
        $rules = $validator->getRules();
        $rules['order'][] = 'in:'.implode(',', $this->userInfoRepository->getOrderFields());
        $validator->setRules($rules);
        if ($validator->passes()){
            $userInfoPaginate = $this->userInfoRepository->paginate($fileds,[$order],$limit);
            return $userInfoPaginate;
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function updateUserInfoByUserPassportId($userPassportId,array $updateData)
    {
        $userInfo = $this->getUserInfoByUserPassportId($userPassportId);
        return $this->updateUserInfo($userInfo->id,$updateData);
    }

    public function getUserInfoByUserPassportId($userPassportId)
    {
        return $this->userInfoRepository->getByUserPassportId($userPassportId);
    }

    public function getUserInfoByUserPassportIds(array $userPassportIds)
    {
        return $this->userInfoRepository->getByUserPassportIds($userPassportIds);
    }

    public function incrByUserInfoCoinByUserPassportId($userPassportId,$coin)
    {
        return $this->userInfoRepository->incrByCoinByUserPassportId($userPassportId,$coin);
    }

    public function decrByUserInfoCoinByUserPassportId($userPassportId,$coin)
    {
        return $this->userInfoRepository->decrByCoinByUserPassportId($userPassportId,$coin);
    }

    public function getUserCoinType()
    {
        return $this->userCoinLogRepository->getTypes();
    }

    public function getDefaultExtend()
    {
        return $this->userCoinLogRepository->getDefaultExtend();
    }

    public function storeUserCoinLog($storeData)
    {
        if(!isset($storeData['extend']))
        {
            $storeData['extend'] = $this->getDefaultExtend();
        }
        $validator = $this->userCoinLogRepository->getStoreValidator($storeData);
        if ($validator->passes()){
            $userCoinLog = $this->userCoinLogRepository->store($storeData);
            return $userCoinLog;
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function destoryUserCoinLogByUserPassportId($userPassportId)
    {
        $fileds = [];
        $fileds['user_passport_id'] = $userPassportId;
        $userCoinLogs = $this->getUserCoinLogs($fileds,'id_desc',0,0);
        $userCoinLogIds = $userCoinLogs->pluck('id')->toArray();
        return $this->userCoinLogRepository->destroyByIds($userCoinLogIds);
    }

    public function getUserCoinLogs(array $fileds=array(),$order='id_desc',$offset=0,$limit=20)
    { 
        $data = [];
        $data['order'] = $order;
        $data += $fileds;
        $validator = $this->userCoinLogRepository->getFilterValidator($data);
        $rules = $validator->getRules();
        $rules['order'][] = 'in:'.implode(',', $this->userCoinLogRepository->getOrderFields());
        $validator->setRules($rules);
        if ($validator->passes()){
            $userCoinLogs = $this->userCoinLogRepository->get($fileds,[$order],$offset,$limit);
            return $userCoinLogs;
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function getUserCoinLogCount(array $fileds=array())
    {
        $data = [];
        $data += $fileds;
        $validator = $this->userCoinLogRepository->getFilterValidator($data);
        $rules = $validator->getRules();
        $validator->setRules($rules);
        if ($validator->passes()){
            $userCoinLogCount = $this->userCoinLogRepository->count($fileds);
            return $userCoinLogCount;
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function verifyCoinViaLaunch($userPassportId)
    {
        $startTime = date("Y-m-d 00:00:00");
        $endTime = date("Y-m-d 24:00:00");
        $coinTypes = $this->getUserCoinType();

        $fileds = [];
        $fileds['user_passport_id'] = $userPassportId;
        $fileds['created_at_gte'] = $startTime;
        $fileds['created_at_lte'] = $endTime;
        $fileds['type']           = $coinTypes['launch'];
        $userCoinLogCount = $this->getUserCoinLogCount($fileds);

        if($userCoinLogCount > 0)
        {
            return false;
        }else{
            return true;
        }
    }

    public function incrByCoinViaLaunch($userPassportId)
    {
        $validatorData = [];
        $validatorData['user_passport_id'] = $userPassportId;    
        $validator = $this->userInfoRepository->getUpdateValidator($validatorData);
        $rules = $validator->getRules();
        $rules['user_passport_id'][] = 'verifyCoinViaLaunch';
        $validator->setRules($rules);
        $validator->addExtension('verifyCoinViaLaunch', function($attribute, $value, $parameters, $validator) {
            return $this->verifyCoinViaLaunch($value);
        });

        if ($validator->passes()){

            $coinTypes = $this->getUserCoinType();
            $userInfo =  $this->incrByUserInfoCoinByUserPassportId($userPassportId,self::LAUNCH_COIN_VALUE);
            $storeData = [];
            $storeData['user_passport_id'] = $userPassportId;
            $storeData['coin'] = self::LAUNCH_COIN_VALUE;
            $storeData['type'] = $coinTypes['launch'];
            $this->storeUserCoinLog($storeData);
            return $userInfo;

        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function verifyCoinViaSign($userPassportId)
    {
        $startTime = date("Y-m-d 00:00:00");
        $endTime = date("Y-m-d 24:00:00");
        $coinTypes = $this->getUserCoinType();

        $fileds = [];
        $fileds['user_passport_id'] = $userPassportId;
        $fileds['created_at_gte'] = $startTime;
        $fileds['created_at_lte'] = $endTime;
        $fileds['type']           = $coinTypes['sign'];
        $userCoinLogCount = $this->getUserCoinLogCount($fileds);
        if($userCoinLogCount > 0)
        {
            return false;
        }else{
            return true;
        }
    }

    public function getUserSignCoin($userPassportId)
    {
        $dayBeforeConsecutiveSignCount = $this->getDayBeforeConsecutiveSignCount($userPassportId,date('Y-m-d'));
        //新的签到规则：
        if($dayBeforeConsecutiveSignCount >= 6){
            $signCoinValue = rand(18,24); //200%
        }else if($dayBeforeConsecutiveSignCount == 5){
            $signCoinValue = rand(16,20); //180%
        }else if($dayBeforeConsecutiveSignCount == 4){
            $signCoinValue = rand(14,18); //160%
        }else if($dayBeforeConsecutiveSignCount == 3){
            $signCoinValue = rand(13,17); //145%
        }else if($dayBeforeConsecutiveSignCount == 2){
            $signCoinValue = rand(11,15); //130%
        }else if($dayBeforeConsecutiveSignCount == 1){
            $signCoinValue = rand(9,13); //110%
        }else{
            $signCoinValue = rand(8,12); //100%
        }

        return $signCoinValue;
    }

    public function incrByCoinViaSign($userPassportId)
    {   
        $validatorData = [];
        $validatorData['user_passport_id'] = $userPassportId;    
        $validator = $this->userInfoRepository->getUpdateValidator($validatorData);
        $rules = $validator->getRules();
        $rules['user_passport_id'][] = 'verifyCoinViaSign';
        $validator->setRules($rules);
        $validator->addExtension('verifyCoinViaSign', function($attribute, $value, $parameters, $validator) {
            return $this->verifyCoinViaSign($value);
        });

        if ($validator->passes()){

            $signCoinValue =$this->getUserSignCoin($userPassportId);
            $coinTypes = $this->getUserCoinType();
            $userInfo =  $this->incrByUserInfoCoinByUserPassportId($userPassportId,$signCoinValue);

            $storeData = [];
            $storeData['user_passport_id'] = $userPassportId;
            $storeData['coin'] = $signCoinValue;
            $storeData['type'] = $coinTypes['sign'];
            $this->storeUserCoinLog($storeData);
            return $signCoinValue;

        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function getDayBeforeConsecutiveSignCount($userPassportId,$day)
    {
        $coinTypes = $this->getUserCoinType();
        $fileds = [];
        $fileds['user_passport_id'] = $userPassportId;
        $fileds['created_at_lte'] = $day.' 00:00:00';
        $fileds['type'] = $coinTypes['sign'];

        $userCoinLogs = $this->getUserCoinLogs($fileds,'id_desc',0,0);
        $userCoinLogCount = $userCoinLogs->count();

        if($userCoinLogCount == 0)
        {
            return 0;
        }else {

            $userCoinLogCreatedAt = $userCoinLogs->first()->created_at->toDateString();
            $subDay = Carbon::parse($day)->subDay()->toDateString();
            if($userCoinLogCreatedAt == $subDay)
            {
                if($userCoinLogCount == 1)
                {
                    return 1;
                }else{

                    $signs = [];
                    $signs[$userCoinLogs->first()->created_at->toDateString()] = true;
                    for($i=0;$i<$userCoinLogCount-1;$i++)
                    {
                        $currentUserCoinLogTime = $userCoinLogs[$i]->created_at->subDay()->toDateString();
                        $preUserCoinLogTime = $userCoinLogs[$i+1]->created_at->toDateString();
                        if($currentUserCoinLogTime == $preUserCoinLogTime)
                        {
                            $signs[$currentUserCoinLogTime] = true;
                            $signs[$preUserCoinLogTime] = true;
                        }else{
                            break;
                        }
                    }

                    $signsCount = count($signs);
                    return $signsCount%7;
                }

            }else{
                return 0;
            }
        }
    }

    public function verifyCoinViaShare($userPassportId)
    {
        $startTime = date("Y-m-d 00:00:00");
        $endTime = date("Y-m-d 24:00:00");
        $coinTypes = $this->getUserCoinType();

        $fileds = [];
        $fileds['user_passport_id'] = $userPassportId;
        $fileds['created_at_gte'] = $startTime;
        $fileds['created_at_lte'] = $endTime;
        $fileds['type']           = $coinTypes['share'];
        $userCoinLogCount = $this->getUserCoinLogCount($fileds);
        if($userCoinLogCount > 0)
        {
            return false;
        }else{
            return true;
        }
    }

    public function incrByCoinViaShare($userPassportId)
    {
        $validatorData = [];
        $validatorData['user_passport_id'] = $userPassportId;    
        $validator = $this->userInfoRepository->getUpdateValidator($validatorData);
        $rules = $validator->getRules();
        $rules['user_passport_id'][] = 'verifyCoinViaShare';
        $validator->setRules($rules);
        $validator->addExtension('verifyCoinViaShare', function($attribute, $value, $parameters, $validator) {
            return $this->verifyCoinViaShare($value);
        });

        if ($validator->passes()){

            $coinTypes = $this->getUserCoinType();
            $userInfo =  $this->incrByUserInfoCoinByUserPassportId($userPassportId,self::SHARE_COIN_VALUE);

            $storeData = [];
            $storeData['user_passport_id'] = $userPassportId;
            $storeData['coin'] = self::SHARE_COIN_VALUE;
            $storeData['type'] = $coinTypes['share'];
            $this->storeUserCoinLog($storeData);
            return $userInfo;

        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }

    }

    public function verifyCoinViaCollection($userPassportId)
    {
        $startTime = date("Y-m-d 00:00:00");
        $endTime = date("Y-m-d 24:00:00");
        $coinTypes = $this->getUserCoinType();

        $fileds = [];
        $fileds['user_passport_id'] = $userPassportId;
        $fileds['created_at_gte']   = $startTime;
        $fileds['created_at_lte']   = $endTime;
        $fileds['type']             = $coinTypes['collection'];
        $userCoinLogCount = $this->getUserCoinLogCount($fileds);
        if($userCoinLogCount > 0)
        {
            return false;
        }else{
            return true;
        }
    }

    public function incrByCoinViaCollection($userPassportId)
    {
        $validatorData = [];
        $validatorData['user_passport_id'] = $userPassportId;    
        $validator = $this->userInfoRepository->getUpdateValidator($validatorData);
        $rules = $validator->getRules();
        $rules['user_passport_id'][] = 'verifyCoinViaCollection';
        $validator->setRules($rules);
        $validator->addExtension('verifyCoinViaCollection', function($attribute, $value, $parameters, $validator) {
            return $this->verifyCoinViaCollection($value);
        });

        if ($validator->passes()){

            $coinTypes = $this->getUserCoinType();
            $userInfo =  $this->incrByUserInfoCoinByUserPassportId($userPassportId,self::COLLECTION_COIN_VALUE);

            $storeData = [];
            $storeData['user_passport_id'] = $userPassportId;
            $storeData['coin'] = self::COLLECTION_COIN_VALUE;
            $storeData['type'] = $coinTypes['collection'];
            $this->storeUserCoinLog($storeData);
            return $userInfo;

        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function verifyCoinViaReadFiveMinute($userPassportId)
    {
        $startTime = date("Y-m-d 00:00:00");
        $endTime = date("Y-m-d 24:00:00");
        $coinTypes = $this->getUserCoinType();

        $fileds = [];
        $fileds['user_passport_id'] = $userPassportId;
        $fileds['created_at_gte']   = $startTime;
        $fileds['created_at_lte']   = $endTime;
        $fileds['type']             = $coinTypes['readFiveMinute'];
        $userCoinLogCount = $this->getUserCoinLogCount($fileds);
        if($userCoinLogCount > 0)
        {
            return false;
        }else{
            return true;
        }
    }

    public function incrByCoinViaReadFiveMinute($userPassportId)
    {
        $validatorData = [];
        $validatorData['user_passport_id'] = $userPassportId;    
        $validator = $this->userInfoRepository->getUpdateValidator($validatorData);
        $rules = $validator->getRules();
        $rules['user_passport_id'][] = 'verifyCoinViaReadFiveMinute';
        $validator->setRules($rules);
        $validator->addExtension('verifyCoinViaReadFiveMinute', function($attribute, $value, $parameters, $validator) {
            return $this->verifyCoinViaReadFiveMinute($value);
        });

        if ($validator->passes()){

            $coinTypes = $this->getUserCoinType();
            $userInfo =  $this->incrByUserInfoCoinByUserPassportId($userPassportId,self::READ_FIVE_MINUTE_COIN_VALUE);

            $storeData = [];
            $storeData['user_passport_id'] = $userPassportId;
            $storeData['coin'] = self::READ_FIVE_MINUTE_COIN_VALUE;
            $storeData['type'] = $coinTypes['readFiveMinute'];
            $this->storeUserCoinLog($storeData);
            return $userInfo;

        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function verifyCoinViaReadTenMinute($userPassportId)
    {
        $startTime = date("Y-m-d 00:00:00");
        $endTime = date("Y-m-d 24:00:00");
        $coinTypes = $this->getUserCoinType();

        $fileds = [];
        $fileds['user_passport_id'] = $userPassportId;
        $fileds['created_at_gte']   = $startTime;
        $fileds['created_at_lte']   = $endTime;
        $fileds['type']             = $coinTypes['readTenMinute'];
        $userCoinLogCount = $this->getUserCoinLogCount($fileds);
        if($userCoinLogCount > 0)
        {
            return false;
        }else{
            return true;
        }
    }

    public function incrByCoinViaReadTenMinute($userPassportId)
    {
        $validatorData = [];
        $validatorData['user_passport_id'] = $userPassportId;    
        $validator = $this->userInfoRepository->getUpdateValidator($validatorData);
        $rules = $validator->getRules();
        $rules['user_passport_id'][] = 'verifyCoinViaReadTenMinute';
        $validator->setRules($rules);
        $validator->addExtension('verifyCoinViaReadTenMinute', function($attribute, $value, $parameters, $validator) {
            return $this->verifyCoinViaReadTenMinute($value);
        });

        if ($validator->passes()){

            $coinTypes = $this->getUserCoinType();
            $userInfo =  $this->incrByUserInfoCoinByUserPassportId($userPassportId,self::READ_TEN_MINUTE_COIN_VALUE);

            $storeData = [];
            $storeData['user_passport_id'] = $userPassportId;
            $storeData['coin'] = self::READ_TEN_MINUTE_COIN_VALUE;
            $storeData['type'] = $coinTypes['readTenMinute'];
            $this->storeUserCoinLog($storeData);
            return $userInfo;

        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function verifyCoinViaReadHalfhour($userPassportId)
    {
        $startTime = date("Y-m-d 00:00:00");
        $endTime = date("Y-m-d 24:00:00");
        $coinTypes = $this->getUserCoinType();
        $fileds = [];
        $fileds['user_passport_id'] = $userPassportId;
        $fileds['created_at_gte']   = $startTime;
        $fileds['created_at_lte']   = $endTime;
        $fileds['type']             = $coinTypes['readHalfhour'];
        $userCoinLogCount = $this->getUserCoinLogCount($fileds);

        if($userCoinLogCount > 0)
        {
            return false;
        }else{
            return true;
        }
    }

    public function incrByCoinViaReadHalfhour($userPassportId)
    {
        $validatorData = [];
        $validatorData['user_passport_id'] = $userPassportId;    
        $validator = $this->userInfoRepository->getUpdateValidator($validatorData);
        $rules = $validator->getRules();
        $rules['user_passport_id'][] = 'verifyCoinViaReadHalfhour';
        $validator->setRules($rules);
        $validator->addExtension('verifyCoinViaReadHalfhour', function($attribute, $value, $parameters, $validator) {
            return $this->verifyCoinViaReadHalfhour($value);
        });

        if ($validator->passes()){

            $coinTypes = $this->getUserCoinType();
            $userInfo =  $this->incrByUserInfoCoinByUserPassportId($userPassportId,self::READ_HALFHOUR_COIN_VALUE);

            $storeData = [];
            $storeData['user_passport_id'] = $userPassportId;
            $storeData['coin'] = self::READ_HALFHOUR_COIN_VALUE;
            $storeData['type'] = $coinTypes['readHalfhour'];
            $this->storeUserCoinLog($storeData);
            return $userInfo;

        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function incrByCoinViaInvite($userPassportId)
    {
        $validatorData = [];
        $validatorData['user_passport_id'] = $userPassportId;    
        $validator = $this->userInfoRepository->getUpdateValidator($validatorData);
        if ($validator->passes()){

            $coinTypes = $this->getUserCoinType();
            $userInfo =  $this->incrByUserInfoCoinByUserPassportId($userPassportId,self::INVITE_COIN_VALUE);

            $storeData = [];
            $storeData['user_passport_id'] = $userPassportId;
            $storeData['coin'] = self::INVITE_COIN_VALUE;
            $storeData['type'] = $coinTypes['invite'];
            $this->storeUserCoinLog($storeData);
            return $userInfo;

        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function incrByCoinViaBeInvited($userPassportId)
    {
        $validatorData = [];
        $validatorData['user_passport_id'] = $userPassportId;    
        $validator = $this->userInfoRepository->getUpdateValidator($validatorData);
        if ($validator->passes()){

            $coinTypes = $this->getUserCoinType();
            $userInfo =  $this->incrByUserInfoCoinByUserPassportId($userPassportId,self::BEINVITED_COIN_VALUE);

            $storeData = [];
            $storeData['user_passport_id'] = $userPassportId;
            $storeData['coin'] = self::BEINVITED_COIN_VALUE;
            $storeData['type'] = $coinTypes['beInvited'];
            $this->storeUserCoinLog($storeData);
            return $userInfo;

        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }
    
    //获取爱好
    public function likeUserBooks($user_id)
    {
        $field = "user_passport_id";
        return $this->userInfoRepository->getByField($field,$user_id);
    }

    public function verifyCoinViaFirstAccountLogin($userPassportId)
    {
        $coinTypes = $this->getUserCoinType();
        $fileds = [];
        $fileds['user_passport_id'] = $userPassportId;
        $fileds['type']             = $coinTypes['firstAccountLogin'];
        $userCoinLogCount = $this->getUserCoinLogCount($fileds);
        if($userCoinLogCount > 0)
        {
            return false;
        }else{
            return true;
        }
    }

    public function incrByCoinViaFirstAccountLogin($userPassportId)
    {
        $validatorData = [];
        $validatorData['user_passport_id'] = $userPassportId;    
        $validator = $this->userInfoRepository->getUpdateValidator($validatorData);
        $rules = $validator->getRules();
        $rules['user_passport_id'][] = 'verifyCoinViaFirstAccountLogin';
        $validator->setRules($rules);
        $validator->addExtension('verifyCoinViaFirstAccountLogin', function($attribute, $value, $parameters, $validator) {
            return $this->verifyCoinViaFirstAccountLogin($value);
        });

        if ($validator->passes()){

            $coinTypes = $this->getUserCoinType();
            $userInfo =  $this->incrByUserInfoCoinByUserPassportId($userPassportId,self::FIRST_ACCOUNT_LOGIN_VALUE);

            $storeData = [];
            $storeData['user_passport_id'] = $userPassportId;
            $storeData['coin'] = self::FIRST_ACCOUNT_LOGIN_VALUE;
            $storeData['type'] = $coinTypes['firstAccountLogin'];
            $this->storeUserCoinLog($storeData);
            return $userInfo;

        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function verifyCoinViaCompletionUserinfo($userPassportId)
    {
        $coinTypes = $this->getUserCoinType();
        $fileds = [];
        $fileds['user_passport_id'] = $userPassportId;
        $fileds['type']             = $coinTypes['completionUserinfo'];
        $userCoinLogCount = $this->getUserCoinLogCount($fileds);
        if($userCoinLogCount > 0)
        {
            return false;
        }else{
            return true;
        }
    }

    public function incrByCoinViaCompletionUserinfo($userPassportId)
    {
        $validatorData = [];
        $validatorData['user_passport_id'] = $userPassportId;    
        $validator = $this->userInfoRepository->getUpdateValidator($validatorData);
        $rules = $validator->getRules();
        $rules['user_passport_id'][] = 'verifyCoinViaCompletionUserinfo';
        $validator->setRules($rules);
        $validator->addExtension('verifyCoinViaCompletionUserinfo', function($attribute, $value, $parameters, $validator) {
            return $this->verifyCoinViaCompletionUserinfo($value);
        });

        if ($validator->passes()){

            $coinTypes = $this->getUserCoinType();
            $userInfo =  $this->incrByUserInfoCoinByUserPassportId($userPassportId,self::COMPLETION_USERINFO_VALUE);

            $storeData = [];
            $storeData['user_passport_id'] = $userPassportId;
            $storeData['coin'] = self::COMPLETION_USERINFO_VALUE;
            $storeData['type'] = $coinTypes['completionUserinfo'];
            $this->storeUserCoinLog($storeData);
            return $userInfo;

        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function verifyCoinViaMark($userPassportId)
    {
        $coinTypes = $this->getUserCoinType();
        $fileds = [];
        $fileds['user_passport_id'] = $userPassportId;
        $fileds['type']             = $coinTypes['mark'];
        $userCoinLogCount = $this->getUserCoinLogCount($fileds);
        if($userCoinLogCount > 0)
        {
            return false;
        }else{
            return true;
        }
    }

    public function incrByCoinViaMark($userPassportId)
    {
        $validatorData = [];
        $validatorData['user_passport_id'] = $userPassportId;    
        $validator = $this->userInfoRepository->getUpdateValidator($validatorData);
        $rules = $validator->getRules();
        $rules['user_passport_id'][] = 'verifyCoinViaMark';
        $validator->setRules($rules);
        $validator->addExtension('verifyCoinViaMark', function($attribute, $value, $parameters, $validator) {
            return $this->verifyCoinViaMark($value);
        });

        if ($validator->passes()){

            $coinTypes = $this->getUserCoinType();
            $userInfo =  $this->incrByUserInfoCoinByUserPassportId($userPassportId,self::MARK_COIN_VALUE);

            $storeData = [];
            $storeData['user_passport_id'] = $userPassportId;
            $storeData['coin'] = self::MARK_COIN_VALUE;
            $storeData['type'] = $coinTypes['mark'];
            $this->storeUserCoinLog($storeData);
            return $userInfo;

        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function verifyCoinViaPayOrder($userPassportId,$coin)
    {
        $userInfo = $this->getUserInfoByUserPassportId($userPassportId);
        if($userInfo->coin < $coin)
        {
            return false;
        }else{
            return true;
        }
    }

    public function decrByCoinViaPayOrder($userPassportId,$coin,array $extend=[])
    {
        $validatorData = [];
        $validatorData['user_passport_id'] = $userPassportId;
        $validatorData['coin'] = $coin;
        $validatorData['extend'] = $extend;
        $validator = $this->userInfoRepository->getUpdateValidator($validatorData);
        $rules = $validator->getRules();
        $rules['user_passport_id'][] = 'verifyCoinViaPayOrder';
        $rules['extend'][] = 'array';
        $validator->setRules($rules);
        $validator->addExtension('verifyCoinViaPayOrder', function($attribute, $value, $parameters, $validator) {
            $validatorData = $validator->getData();
            return $this->verifyCoinViaPayOrder($value,$validatorData['coin']);
        });

        if ($validator->passes()){

            $coinTypes = $this->getUserCoinType();
            $userInfo =  $this->decrByUserInfoCoinByUserPassportId($userPassportId,$coin);

            $storeData = [];
            $storeData['user_passport_id'] = $userPassportId;
            $storeData['coin'] = -$coin;
            $storeData['type'] = $coinTypes['payOrder'];
            $storeData['extend'] = $extend;
            $this->storeUserCoinLog($storeData);
            return $userInfo;
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }
}