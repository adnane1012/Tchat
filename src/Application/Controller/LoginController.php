<?php

namespace Application\Controller;

use Application\Model\User;
use DB\DBMysql;
use DI\Container;
use Http\Request;
use Http\Response;
use Http\Session;

class LoginController
{
    public function index()
    {
        /** @var Session $session */
        $session = Container::getService('session');

        /** @var Response $response */
        $response = Container::getService('response');

        /** @var Request $request */
        $request = Container::getService('request');

        if ($session->hasData('user')) {
            $response->redirect($request->getUri().'?page=index');
        }

        /** @var DBMysql $db */
        $db = Container::getService('db');

        /** @var User $user */
        $user = Container::getService('user');


        if ($request->isPost()) {
            $data = $request->getRequestParameters();
            $data = [
                'username' => $data['username'],
                'password' => md5($data['password']),
            ];
            $result = $db->findBy($user, $data);

            if (count($result) > 0) {
                $data['id'] = $result[0]->getId();
                $session->setSessionData('user', $result[0]);
                $response->redirect($request->getUri().'?page=index');
            }
            $response->setVariables(['failed'=>true]);
        }

        return $response->setTemplate('Login/index.php')->render();
    }


    public function logout()
    {
        /** @var Session $session */
        $session = Container::getService('session');
        $session->destroy();

        $request = Container::getService('request');
        $response = Container::getService('response');
        $response->redirect($request->getUri().'?page=login');
    }
}
