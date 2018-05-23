<?php 
namespace App\Services\Eloquent;
use App\Services\Contracts\UtilityServiceInterface;
use \Curl\Curl;
use Log;

class UtilityService implements UtilityServiceInterface
{
    public function array_form_keys($filed,$array)
    {
    	$formArray = array();
    	foreach($array AS $key => $val)
    	{
    		$formArray[$filed.'['.$key.']'] = $val;
    	}
    	return $formArray;
    }

    public function isMobile($mobile) 
    {
        
        if (!is_numeric($mobile)) {
            return false;
        }
        return preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#', $mobile) ? true : false;
    }

    public function tranTimeToString($stringTime)
    {
        $time = strtotime($stringTime);
        $rtime = date("m-d H:i",$time);
        $htime = date("H:i",$time);
               
        $time = time() - $time;
               
        if ($time < 60)
        {
            $str = '刚刚';
        }
        elseif ($time < 60 * 60)
        {
            $min = floor($time/60);
            $str = $min.'分钟前';
        }
        elseif ($time < 60 * 60 * 24)
        {
            $h = floor($time/(60*60));
            $str = $h.'小时前 '.$htime;
        }
        elseif ($time < 60 * 60 * 24 * 3)
        {
            $d = floor($time/(60*60*24));
            if($d==1)
                $str = '昨天 '.$rtime;
            else
                $str = '前天 '.$rtime;
        }
        else
        {
            $str = $rtime;
        }
        return $str;
    }

    public function tranTimeToSimpleString($stringTime)
    {
        $time = strtotime($stringTime);
        $rtime = date("m-d H:i",$time);
        $htime = date("H:i",$time);
               
        $time = time() - $time;
               
        if ($time < 60)
        {
            $str = '刚刚';
        }
        elseif ($time < 60 * 60)
        {
            $min = floor($time/60);
            $str = $min.'分钟前';
        }
        elseif ($time < 60 * 60 * 24)
        {
            $h = floor($time/(60*60));
            $str = $h.'小时前';
        }
        elseif ($time < 60 * 60 * 24 * 3)
        {
            $d = floor($time/(60*60*24));
            if($d==1)
                $str = '昨天';
            else
                $str = '前天';
        }
        else
        {
            $str = date('m月d日',$time);
        }
        return $str;
    }

    public function isPhone()
    { 
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
        {
            return true;
        } 
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset ($_SERVER['HTTP_VIA']))
        { 
            // 找不到为flase,否则为true
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        } 
        // 脑残法，判断手机发送的客户端标志,兼容性有待提高
        if (isset ($_SERVER['HTTP_USER_AGENT']))
        {
            $clientkeywords = array ('nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap',
                'mobile'
                ); 
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
            {
                return true;
            } 
        } 
        // 协议法，因为有可能不准确，放到最后判断
        if (isset ($_SERVER['HTTP_ACCEPT']))
        { 
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
            {
                return true;
            } 
        } 
        return false;
    } 

    public function putCDN($filePath,$appName,$type='file')
    {
        $pathInfo = pathinfo($filePath);
        $fileName = $pathInfo['filename'].'.'.$pathInfo['extension'];

        $fileContent = base64_encode(file_get_contents($filePath));
        $cdnApi = 'http://pushcdn.mysada.com/api.php?key=58307deb71dd486ef8afc742056780c0'; 
        $curl = new Curl();
        $resultJson = $curl->post($cdnApi, array(
            'appName' => $appName,
            'fileContent' => $fileContent,
            'fileName' => $fileName,
            'type' => $type
        ));

        $result = json_decode($resultJson,true);
        Log::debug($result['content']);
        
        return $result['content'];
    }

    public function putContentCDN($content,$fileName,$appName,$type='file')
    {
        $content = base64_encode($content);
        $cdnApi = 'http://pushcdn.mysada.com/api.php?key=58307deb71dd486ef8afc742056780c0'; 
        $curl = new Curl();
        $resultJson = $curl->post($cdnApi, array(
            'appName' => $appName,
            'fileContent' => $content,
            'fileName' => $fileName,
            'type' => $type
        ));

        $result = json_decode($resultJson,true);
        Log::debug($result['content']);

        return $result['content'];
    }

    public function getUrlHeaderSize($url)
    {
        $headers = get_headers($url);
        foreach($headers AS $header)
        {
            if(stristr($header,'Content-Length'))
            {
                return trim(str_replace('Content-Length:', '', $header));
            }
        }

        return false;
    }

    public function clearSpecialStringTag($string)
    {
        $string = strip_tags($string);
        $string = preg_replace('/&#(.*?);/', '', $string);
        return $string;
    }   

}