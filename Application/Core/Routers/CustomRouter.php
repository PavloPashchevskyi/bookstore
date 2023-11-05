<?php

declare(strict_types=1);

namespace Application\Core\Routers;

class CustomRouter implements Routable
{
    public static function parse(array $routesNeeded): array
    {
        $actionName = (strcasecmp(substr($routesNeeded['routes'][0]['class_method'], -6), 'Action') == 0) ?
            substr($routesNeeded['routes'][0]['class_method'], 0, -6) :
            $routesNeeded['routes'][0]['class_method'];
        $actionArguments = $routesNeeded['routes'][0]['class_method_parameters'];
        $controllerFullQualifiedName = $routesNeeded['routes'][0]['class_fqn'];

        $fqnParts = explode("\\", $controllerFullQualifiedName);
        $moduleName = $fqnParts[3];
        $controllerName = $fqnParts[5];
        $actionMethodName = $routesNeeded['routes'][0]['class_method'];

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