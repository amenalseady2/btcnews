<?php 
namespace App\Presenters\Eloquent;
use App\Presenters\Contracts\ConsoleParameterPersenterInterface;
use Illuminate\Database\Eloquent\Model;
use Request;

class ConsoleParameterPersenter implements ConsoleParameterPersenterInterface
{  
	protected $model;
	public function setReviseModel(Model $model)
	{
		$this->model = $model;
	}

	public function getReviseParameter($key)
	{
		if($this->getInputParameter($key))
		{
			return $this->getInputParameter($key);
		}else if(isset($this->model)){
			return $this->model->$key;
		}else{
			return '';
		}
	}

	public function getReviseDataParameter($key,$format = 'Y-m-d')
	{
		$dataParameter = $this->getReviseParameter($key);
		if($dataParameter)
		{
			return date($format,strtotime($dataParameter));
		}else{
			return '';
		}
	}
	
	public function getReviseArrayParameter($key)
	{
		$arrayParameter = $this->getReviseParameter($key);
		if($arrayParameter)
		{
			return $arrayParameter;
		}else{
			return [];
		}
	}

	public function getInputParameter($key)
	{
		$requestParameter = Request::input($key);
		if($requestParameter)
		{
			return $requestParameter;
		}

		$oldRequestParameter = Request::old($key);
		if($oldRequestParameter)
		{
			return $oldRequestParameter;
		}

		$defaultParameter = '';
		return $defaultParameter;

	}

	public function getInputAll()
	{
		$requestData = Request::all();
		return $requestData;
	}

}