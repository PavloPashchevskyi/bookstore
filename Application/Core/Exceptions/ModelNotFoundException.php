<?php

namespace Application\Core\Exceptions;

/**
 * Description of ModelNotFoundException
 *
 * @author ppd
 */
class ModelNotFoundException extends \Exception
{
    public function __construct($moduleName = "", $modelName = "", \Exception $previous = null) 
    {
        $message = 'Model '.$modelName.' was not found in module '.$moduleName.' of the Application.';
        $code = 14;
        parent::__construct($message, $code, $previous);
    }
}
