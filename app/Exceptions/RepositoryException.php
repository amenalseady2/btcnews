<?php

namespace App\Exceptions;

use \Exception;
      
class RepositoryException extends Exception
{
 	public function __construct($messageBag)
	{
		$messageJson = $messageBag->toJson();
		parent::__construct( $messageJson );
	}
}
