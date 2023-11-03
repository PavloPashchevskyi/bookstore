<?php

declare(strict_types=1);

namespace Application\Core\Routers;

use Application\Config\Router;

class RouterStrategy
{
    public static function parse(?array $defaultRouteOptions = null): array
    {
        $urnFromRequest = $_SERVER['REQUEST_URI'];
        $requestMethod = strtolower($_SERVER['REQUEST_METHOD']);
        $availableRoutesRanges = Router::get();
        $routesPrefixed = [];
        foreach ($availableRoutesRanges as $availableRoutesRange) {
            $prefixPosition = strpos($urnFromRequest, $availableRoutesRange['prefix']);
            if ($prefixPosition !== false && $prefixPosition === 0) {
                $routesPrefixed[] = $availableRoutesRange;
            }
        }
        $filteredRangeRoutes = [];
        $i = 0;
        foreach ($routesPrefixed as $routePrefixed) {
            $prefixLength = strlen($routePrefixed['prefix']);
            foreach ($routePrefixed['routes'] as $route) {
                if (strcasecmp($route['method'], $requestMethod) == 0 &&
                    strcasecmp($route['urn'], substr($urnFromRequest, $prefixLength)) == 0) {
                    $filteredRangeRoutes[$i]['routes'][] = $route;
                }
            }
            $filteredRangeRoutes[$i]['prefix'] = $routePrefixed['prefix'];
            $i++;
        }
        if (empty($filteredRangeRoutes)) {
            return URNRouter::parse($defaultRouteOptions);
        }

        return CustomRouter::parse($filteredRangeRoutes[0]);
    }
}