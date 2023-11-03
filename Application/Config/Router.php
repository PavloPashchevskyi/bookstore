<?php

namespace Application\Config;

class Router
{
    public static function get() {
        return [
            ['prefix' => '/api/v2', 'routes' => []],
            [
                'prefix' => '/api/v1',
                'routes' => [
                    [
                        'method' => 'GET',
                        'urn' => '/books',
                        'class_fqn' => '\Application\Modules\Bookstore\Controllers\BookController',
                        'class_method' => 'listAction',
                        'class_method_parameters' => [],
                    ],
                    [
                        'method' => 'get',
                        'urn' => '/books/:id',
                        'class_fqn' => '\Application\Modules\Bookstore\Controllers\BookController',
                        'class_method' => 'bookAction',
                        'class_method_parameters' => ['id' => '/^[0-9]+$/'],
                    ],
                    [
                        'method' => 'get',
                        'urn' => '/books/?author=&genre=&title=&id=',
                        'class_fqn' => '\Application\Modules\Bookstore\Controllers\BookController',
                        'class_method' => 'filteredListAction',
                        'class_method_parameters' => [
                            'parameters' => ['author' => '', 'genre' => [], 'title' => '', 'id' => '']],
                    ],
                    [
                        'method' => 'post',
                        'urn' => '/books',
                        'class_fqn' => '\Application\Modules\Bookstore\Controllers\BookController',
                        'class_method' => 'addAction',
                        'class_method_parameters' => [],
                    ],
                    [
                        'method' => 'put',
                        'urn' => '/books/:id',
                        'class_fqn' => '\Application\Modules\Bookstore\Controllers\BookController',
                        'class_method' => 'editAction',
                        'class_method_parameters' => ['id' => '/^[0-9]+$/'],
                    ],
                    [
                        'method' => 'patch',
                        'urn' => '/books/:id/title/:title',
                        'class_fqn' => '\Application\Modules\Bookstore\Controllers\BookController',
                        'class_method' => 'editTitleAction',
                        'class_method_parameters' => ['id' => '/^[0-9]+$/', 'title' => '/^.*$/'],
                    ],
                    [
                        'method' => 'patch',
                        'urn' => '/books/:id/author',
                        'class_fqn' => '\Application\Modules\Bookstore\Controllers\BookController',
                        'class_method' => 'editAuthorsAction',
                        'class_method_parameters' => ['id' => '/^[0-9]+$/'],
                    ],
                    [
                        'method' => 'patch',
                        'urn' => '/books/:id/genre',
                        'class_fqn' => '\Application\Modules\Bookstore\Controllers\BookController',
                        'class_method' => 'editGenresAction',
                        'class_method_parameters' => ['id' => '/^[0-9]+$/'],
                    ],
                    [
                        'method' => 'delete',
                        'urn' => '/books/:id',
                        'class_fqn' => '\Application\Modules\Bookstore\Controllers\BookController',
                        'class_method' => 'deleteAction',
                        'class_method_parameters' => ['id' => '/^[0-9]+$/'],
                    ],
                ],
            ],
        ];
    }
}