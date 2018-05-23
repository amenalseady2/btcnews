<?php 
namespace App\Presenters\Contracts;
use Illuminate\Database\Eloquent\Model;
/**
 * Interface TopicRepositoryInterface.
 */
interface ConsoleParameterPersenterInterface
{

	public function setReviseModel(Model $model);

	public function  getReviseParameter($key);

	public function getInputParameter($key);

	public function getInputAll();
}
