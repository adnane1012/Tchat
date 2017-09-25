<?php

namespace Application\Controller;

use Http\Request;
use Http\Response;
use DI\Container;

class BaseController
{
    public function getRequest()
    {
        /** @var Request $request */
        $request = Container::getService('request');
        return $request;
    }
}