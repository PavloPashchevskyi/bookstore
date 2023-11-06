<?php

namespace Application\Core;

class View
{
    private $contentType;

    public function __construct($contentType = 'application/json')
    {
        $this->contentType = $contentType;
    }

    public function render($content) {
        header('Content-Type: '.$this->contentType);
        echo json_encode($content);
    }
}