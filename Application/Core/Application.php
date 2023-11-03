<?php

namespace Application\Core;

use Application\Core\Routers\RouterStrategy;
use Application\Core\Routers\URNRouter;

class Application
{
    private static $moduleName;
    private static $controllerName;
    private static $actionName;
    private static $actionArguments;

    /**
     * @param null $defaultRouteOptions
     * @throws Exceptions\ActionNotFoundException
     * @throws Exceptions\ControllerClassNotDefinedException
     * @throws Exceptions\ControllerNotFoundException
     * @throws Exceptions\ModuleNotFoundException
     */
    public static function start($defaultRouteOptions = null)
    {
        $properties = RouterStrategy::parse($defaultRouteOptions);
        self::$moduleName = $properties['module_name'];
        self::$controllerName = $properties['controller_name'];
        self::$actionName = $properties['action_name'];
        self::$actionArguments = $properties['action_arguments'];

        if(class_exists($properties['class_name'])) {
            $controllerObject = new $properties['class_name']();
        } else {
            throw new Exceptions\ControllerNotFoundException($properties['module_name'], $properties['class_name']);
        }
        if (!$controllerObject) {
            throw new Exceptions\ControllerClassNotDefinedException($properties['module_name'], $properties['controller_name']);
        }
        if(method_exists($controllerObject, $properties['class_method_name'])) {
            call_user_func_array([$controllerObject, $properties['class_method_name']], self::$actionArguments);
        }
        else {
            throw new Exceptions\ActionNotFoundException($properties['module_name'], $properties['controller_name'], $properties['action_name']);
        }
    }

    public static function getModuleName()
    {
        return self::$moduleName;
    }
    
    public static function getControllerName()
    {
        return self::$controllerName;
    }
    
    public static function getActionName()
    {
        return self::$actionName;
    }
}
