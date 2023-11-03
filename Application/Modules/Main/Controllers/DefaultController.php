<?php

namespace Application\Modules\Main\Controllers;

use Application\Core\Controller;

/**
 * Description of DefaultController
 *
 * @author ppd
 */
class DefaultController extends Controller
{
    public function indexAction()
    {
        echo 'Hello, world!';
    }

    public function infoAction()
    {
        phpinfo();
    }
}
