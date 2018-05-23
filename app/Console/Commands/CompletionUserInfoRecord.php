<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Passport;
use User;

class CompletionUserInfoRecord extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'completionUserInfoRecord';

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
        $userPassports = Passport::getUserPassports([],'id_desc',0,0);
        foreach($userPassports AS $userPassport)
        {
            $userInfo = User::getUserInfoByUserPassportId($userPassport->id);
            if(!$userInfo)
            {
                $userInfo = User::storeDefaultUserInfo($userPassport->id);
            }
        }

        return 'ok';
    }
}
