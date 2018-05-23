<?php 
namespace App\Services\Eloquent;

use App\Services\Contracts\OutputServiceInterface;

class OutputService implements OutputServiceInterface
{
    public function success($data = null)
    {
        $returnData = [];
        $returnData['status']  = 200;
        $returnData['message']['success'] = 'success';
        if($data)
        {
            $returnData['data'] = $data;
        }

        return response()->json($returnData);
    }

    public function fail(array $messages = array())
    {
        $returnData = [];
        $returnData['status']  = 201;
        if($messages)
        {
            $returnData['message'] = $messages;
        }else{
            $returnData['message']['fail'] = 'fail';
        }

        return response()->json($returnData);
    }

    public function failValidationException($validationException = null)
    {
        $returnData = [];
        $returnData['status']  = 201;

        if($validationException)
        {
            $messages = $validationException->errors()->toArray();
            $returnData['message'] = $messages;
        }else{
            $returnData['message']['fail'] = 'fail';
        }

        return response()->json($returnData);
    }

    public function exception()
    {
        $returnData = [];
        $returnData['status']  = 202;
        $returnData['message']['exception'] = 'exception';
        return response()->json($returnData);
    }

    public function needLogin()
    {
        $returnData = [];
        $returnData['status']  = 203;
        $returnData['message']['exception'] = 'needLogin';
        return response()->json($returnData);
    }

    public function needSecret()
    {
        $returnData = [];
        $returnData['status']  = 205;
        $returnData['message']['exception'] = 'needSecret';
        return response()->json($returnData);
    }

    public function apiTokenException()
    {
        $returnData = [];
        $returnData['status']  = 204;
        $returnData['message']['exception'] = 'apiTokenError';
        return response()->json($returnData);
    }

    public function error($errorInfo)
    {
        $returnData = [];
        $returnData['status']  = 401;
        $returnData['message'] = $errorInfo;
        return response()->json($returnData);
    }
    
    public function abnormalInfo($info)
    {
        $returnData = [];
        $returnData['status']  = 202;
        $returnData['message']['abnormalinfo'] = $info;
        return response()->json($returnData);
    }

    public function unique($errorInfo)
    {
        $returnData = [];
        $returnData['status']  = 206;
        $returnData['message'] = $errorInfo;
        return response()->json($returnData);
    }
}