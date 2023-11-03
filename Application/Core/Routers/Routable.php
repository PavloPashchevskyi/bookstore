<?php

namespace Application\Core\Routers;

interface Routable
{
    public static function parse(array $routesData): array;
}