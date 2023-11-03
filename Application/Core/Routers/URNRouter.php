<?php

declare(strict_types=1);

namespace Application\Core\Routers;

class URNRouter implements Routable
{
    /**
     * @param array $defaultRouteOptions
     * @return array
     */
    public static function parse(array $defaultRouteOptions): array
    {
        $siteFolder = ($_SERVER['HTTP_HOST'] == 'localhost') ? 1 : 0;
        $routes = explode('/', $_SERVER['REQUEST_URI']);
        $namesValidation = [];
        foreach($routes as $i => $name) {
            $namesValidation[$siteFolder + $i] = preg_match('/$[a-zA-Z_]+.*^/', $name);
        }
        if(!empty($routes[$siteFolder + 1]) /*&& $namesValidation[$siteFolder + 1]*/) {
            if(is_dir('Application/Modules/'.ucfirst($routes[$siteFolder + 1]))) {
                $moduleName = ucfirst($routes[$siteFolder + 1]);
            }
            else {
                $moduleName = ucfirst($defaultRouteOptions['module']);
                $controllerName = ucfirst($routes[$siteFolder + 1]);
            }
        }
        else {
            if(is_dir('Application/Modules/'.ucfirst($defaultRouteOptions['module']))) {
                $moduleName = ucfirst($defaultRouteOptions['module']);
                $controllerName = ucfirst($defaultRouteOptions['controller']);
            }
            else {
                throw new Exceptions\ModuleNotFoundException($moduleName);
            }
        }
        if(!empty($routes[$siteFolder + 2])) {
            if(is_dir('Application/Modules/'.ucfirst($routes[$siteFolder + 1]))) {
                $controllerName = ucfirst($routes[$siteFolder + 2]);
            }
            else {
                $controllerName = ucfirst($routes[$siteFolder + 1]);
                $actionName = $routes[$siteFolder + 2];
            }
        }
        else {
            $controllerName = ucfirst($defaultRouteOptions['controller']);
        }
        if(!empty($routes[$siteFolder + 3])) {
            if(is_dir('Application/Modules/'.ucfirst($routes[$siteFolder + 1]))) {
                $actionName = $routes[$siteFolder + 3];
            }
            else {
                $actionName = $routes[$siteFolder + 2];
                $recordId = $routes[$siteFolder + 3];
            }
        }
        else {
            if(is_dir('Application/Modules/'.ucfirst($routes[$siteFolder + 1]))) {
                $actionName = $defaultRouteOptions['action'];
            }
            else {
                $controllerName = ucfirst(!empty($routes[$siteFolder + 2]) ? $routes[$siteFolder + 2] : $defaultRouteOptions['controller']);
                $actionName = $defaultRouteOptions['action'];
            }
        }
        if(!empty($routes[$siteFolder + 4])) {
            $actionArguments = array_slice($routes, $siteFolder + 4);
        }
        $actionMethodName = (strpos($actionName, 'Action') === false) ? $actionName.'Action' :
            $actionName;
        $moduleNamespace = "\\Application\\Modules\\".ucfirst($moduleName);
        $modelControllerFirstNamePart = ucfirst($controllerName);
        $controllerClassName = $modelControllerFirstNamePart.'Controller';
        $controllerFullQualifiedName = $moduleNamespace."\\Controllers\\".$controllerClassName;
        return [
            'module_name' => $moduleName,
            'controller_name' => $controllerName,
            'action_name' => $actionName,
            'action_arguments' => (!empty($actionArguments)) ? $actionArguments : [],
            'class_name' => $controllerFullQualifiedName,
            'class_method_name' => $actionMethodName,
        ];
    }
}