<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Passport;
use User;
use Cache;


class UpdateVirtualPassportName extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updateVirtualPassportName';

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

$nameString = 'ابتعاث
أزهار
مياسين
أحلام
أريج
أزهار
أسرار
آيات 
ائتلاف
ابتسام 
ابتعاث 
ابتهاج 
ابتهال
سدرةلينة
دانية
إسراء
آلاء
ديم
هتان
رانسى
ماذى
إسعاد 
أسل
أسمى 
أسماء
أسمهان 
 أشجان
ريتاج
جوليا
رزان
أشواق 
أصالة
أصيلة
 أضواء
 اعتدال 
افتكار 
أفنان 
لاما
ليم
لوليا
ريمان
أسيل
ريما
إقبال 
إكتمال 
إكرام 
ألطاف
ألمى
داليا
ديالا د
ناهد
غوى   
ريف  
بارعة    
باسل    
باسمة  
باهرة 
بتول  
بثينة         
ختام
خديجة
خلود
خواطر
خولة
حلا
حوراء
خاتون
خيرية
داليا
دانة
دانية
دجى
رفيف
رقية
رمزية
رهام
رهف
درية
دعاء
دعد
 زمردة
رولا
ريمان
جنى
ثريا
لمياء
سيرين
أشواق
إلهام
دعاء
رحاب
دانة
 أديب
 أسعد
 إسماعيل
 أشرف
أصهب
 أصيل
 أكرم
أمجد
 أمير
 أنس
 أنيس
 أنور
 أيهم
 أسلم
 أمين
 آدم
 إياد
 إياس
 إيهاب
 أيّوب
 آمر
 آسر
 بارع
 باسل
 باسم
 باه
 بدر
 بدران
 بدوي
 بدير
  بسّام
 بسيل
 بِشر
 بشّار
 بشير
 بصير
 بطاح
 بديع
 باسط
 بسيم
 بدرالدّين
 بهاء الدّين
 بخيت
 تاج
 تامر
 تحسين
 تقي
 تمّام
 تميم
 توفيق
 ترف
 تاج الدّين
 تقيّ الدّين
  ثائر
 ثابت
 ثامر
 ثروت
 ثقيف
 ثاقب
جابر
 جاد
 جاسم
 جرير
 جسور
 جعفر
 جلاء
 جلال
 جليل
 جمال
 جميل
 جدير
 جرّاح
 جلال الدّين
 جمال الدّين
 جهـــاد
 حاتم
 حارث
حازم
 حافظ
 حامد
 حبّاب
 حسام
 حسن
 حسيب
 حسين
 حسني
حسنين
 حقّي
 حكيم
 حليم
 حمّاد
 حمدان
 حمدي
حمزة
 حمود
 حميد
 حنبل
 حنفي
حيّان
 حيدر
 حفيظ
 خاطر
 خافق
 خالد
 خلدون
 خلف
 خليفة
 خليل
 خميس
 خيري
 خضر
 خطيب
 دؤوب
 داني
 داهي
 داوود
 دريد
 دليل
 دهمان
 ديسم
 ذيب
 ذكي
 ذريع
 رائ
 رائف
 رابح
 راتب
 راجح
 راجي
 رازي
 راشد
 راضي
 راغب
 رامز
 رامي
 رامح
وسيم';

        $names = array_filter(explode("\n", $nameString));
        $passports = Passport::getBookSourceVirtualPassport();
        $userPassportIds = $passports->pluck('id')->toArray();

        $userInfos = User::getUserInfoByUserPassportIds($userPassportIds);
        foreach($userInfos AS $key => $userInfo)
        {
            if(isset($names[$key]))
            {
                $name = trim($names[$key]);
            }else{
                $nameKey = array_rand($names,1);
                $name = trim($names[$nameKey]);
            }
            
            $userInfo->nickname = $name;
            $userInfo->save();
        }

        Cache::forget('VIRTUAL_BOOK_SOURCE_PASSPORT_CACHE');

    }
}
