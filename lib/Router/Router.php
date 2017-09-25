<?php

namespace Router;

class Router
{
    public function __construct($map)
    {
        $this->map = $map;
    }

    public function check($uri)
    {
        return array_key_exists($uri, $this->map);
    }

    public function getAction($uri)
    {
        if (!$this->check($uri)) {
            return false;
        }

        return $this->map[$uri];
    }
//    function call($controller, $action)
//    {
//        require_once('controllers/' . $controller . 'controller.php');
//
//        switch ($controller) {
//            case 'pages':
//                $controller = new PagesController();
//                break;
//            case 'posts':
//                // we need the model to query the database later in the controller
//                require_once('models/post.php');
//                $controller = new PostsController();
//                break;
//        }
//
//        $controller->{$action}();
//    }
}
