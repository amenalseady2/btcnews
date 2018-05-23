<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Passport;
use User;

class CreateVirtualPassport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'createVirtualPassport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {  
        for($i=0;$i<100;$i++)
        {
            $tag = md5( time().$i.rand(100000,999999) );
            $deviceId = 'mobibookapp-booksource-'.$tag;
            $returnData = Passport::loginByDeviceId($deviceId);
            $passport = $returnData['userPassport']; 
    
            $platforms = ['fb','gp','tt','cu'];
            $platformKey = array_rand($platforms,1);
            $platform = $platforms[$platformKey];
            $nickname = $platform.'_'.str_random(5).'_'.rand(100,999);

            $userInfoData = [];
            $userInfoData['user_passport_id'] = $passport->id;
            $userInfoData['nickname'] = $nickname;
            $userInfoData['coin'] = User::getDefaultCoin();
            // $userInfoData['experience'] = User::getDefaultExperience();
            User::storeUserInfo($userInfoData);
        }

        return 'ok';
    }
}
