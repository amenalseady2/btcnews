<?php

namespace App\Repositories;

use App\Exceptions\RepositoryException;
use Illuminate\Database\Eloquent\Model;
use Validator;

abstract class EloquentRepository 
{
    protected $rules = array(
                        'STORE'  => [],
                        'UPDATE' => [],
                        'FILTERFIELD' => [],
                    );

    protected $filterFields = array();
    protected $orderFields  = array();
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->initValidatorRules();
        $this->initFilterField();
        $this->initOrderField();
    }

    abstract protected function initValidatorRules();
    abstract protected function initFilterField();
    abstract protected function initOrderField();

    public function getOrderFields()
    {
        return $this->orderFields;
    }

    public function getFilterFields()
    {
        return $this->filterFields;
    }

    public function getFilterValidator(array $attributes)
    {
        return Validator::make($attributes,$this->rules['FILTERFIELD']);
    }

    public function getStoreValidator(array $attributes)
    {
        return Validator::make($attributes,$this->rules['STORE']);
    }

    public function getUpdateValidator(array $attributes)
    {
        return Validator::make($attributes, $this->rules['UPDATE']);
    } 

    public function getFilterValidatorRule($filed = '')
    {
        $validator = $this->getFilterValidator([]);
        $rules = $validator->getRules();
        if($filed){
            return $rules[$filed];
        }else{
            return $rules;
        }
    }

    public function getStoreValidatorRule($filed = '')
    {
        $validator = $this->getStoreValidator([]);
        $rules = $validator->getRules();
        if($filed){
            return $rules[$filed];
        }else{
            return $rules;
        }
    }

    public function getUpdateValidatorRule($filed = '')
    {
        $validator = $this->getUpdateValidator([]);
        $rules = $validator->getRules();
        if($filed){
            return $rules[$filed];
        }else{
            return $rules;
        }
    }

    protected function filter( array $fileds, Model $model=null )
    {
        if(empty($model))
        {
            $model = $this->model;   
        }

        $validator = $this->getFilterValidator($fileds);
        if ($validator->passes()){
            foreach($fileds AS $filed => $value)
            {
                if(!is_null($value) && in_array($filed, $this->filterFields))
                {  
                    $filed = camel_case($filed);
                    $model = $model->$filed($value);
                }           
            }
            
            return $model;

        }else{
            $messages = $validator->messages();
            throw new RepositoryException($messages);
        }
    }

    protected function order( array $orders, $model=null )
    {
        if(empty($model))
        {
            $model = $this->model;   
        }

        foreach($orders AS $order)
        {
            if( $order && in_array($order,$this->orderFields) )
            {
                $order = camel_case($order);
                $model = $model->$order();
            }
        }

        return $model;
    }

    public function paginate(array $fileds=array(),array $orders=array(),$limit=20)
    {
        $model = $this->filter($fileds);
        $model = $this->order($orders,$model);
        $page  = $model->paginate($limit);
        return $page;
    }

    public function get(array $fileds=array(),array $orders=array(),$offset=0,$limit=0)
    {
        $model = $this->filter($fileds);
        $model = $this->order($orders,$model);
        if($limit>0)
        {
            $model->skip($offset);
            $model->take($limit);
        }
        $collection = $model->get();
        return $collection;
    }

    public function count(array $fileds=array())
    {
        $model = $this->filter($fileds);
        $count = $model->count();
        return $count;
    }

    public function getOne(array $fileds,array $orders=array())
    {
        $model = $this->filter($fileds);
        if($orders)
        {
            $model = $this->order($orders,$model);
        }
        return  $model->first();
    }

    public function store(array $attributes ,$after = null)
    {
        $validator = $this->getStoreValidator($attributes);
        if($after)
        {
            if($after){
                if(is_array($after)){

                    foreach($after AS $afterOne)
                    {
                        $validator->after($afterOne);
                    }

                }else{
                    $validator->after($after);
                }
            }
        }

        if($validator->passes()){
            
            $model = $this->model;
            return $model->create($attributes);

        }else{

            $messages = $validator->messages();
            throw new RepositoryException($messages);
        }
    }    

    public function updateModel( array $attributes ,Model $model ,$after = null )
    { 
        $validator = $this->getUpdateValidator($attributes);
        if($after)
        {
            if(is_array($after))
            {
                foreach($after AS $afterOne)
                {
                    $validator->after($afterOne);
                }

            }else{
                $validator->after($after);
            }            
        }

        if ($validator->passes()){

            foreach($attributes AS $filed => $attribute)
            {
                if($model->isFillable($filed))
                {
                    $model->$filed = $attribute;                    
                }
            }
            $model->save();
            return $model;

        }else{
            $messages = $validator->messages();
            throw new RepositoryException($messages);
        }
    }

    public function destroyModel( Model $model )
    {
        return $model->delete();
    }

    public function __call( $method,$arguments )
    {
        if( $method == 'update' )
        {
           return $this->updateModel($arguments[0],$arguments[1]);
        }   

        if( $method == 'destroy' )
        {
            return $this->destroyModel($arguments[0]);
        }
    }

}
