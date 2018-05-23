<?php

namespace App\Repositories;

trait OperateIdTrait 
{
    public function getById($id)
    {
        $model = $this->model;
        return $model->find($id);
    }

    public function getByIds(array $ids,array $orders=array())
    {
        $model = $this->model;
        $model = $model->whereIn('id',$ids);
        $model = $this->order($orders,$model);
        $collection = $model->get();
        return $collection;
    }

    public function updateById($id,array $attributes,$after = null)
    {
        $updateInstance = $this->getById($id);
        return  $this->updateModel($attributes,$updateInstance,$after);
    }

    public function destroyById($id)
    {
        /*
        $destroyInstance = $this->getById($id);
        return $this->destroyModel($destroyInstance);
        */
        return  $this->model->destroy($id);
    }

    public function destroyByIds(array $ids)
    {
        return  $this->model->destroy($ids);
    }

}
