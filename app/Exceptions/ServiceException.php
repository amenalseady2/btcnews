<?php

namespace App\Exceptions;

use \Exception;
      
class ServiceException extends Exception
{
	public function __construct($messageBag)
	{
		$messageJson = $messageBag->toJson();
		parent::__construct( $messageJson );
	}

}
