<?php

namespace Application\Controller;

use Application\Model\Message;
use DB\DBMysql;
use Http\Response;
use DI\Container;
use Http\Session;

class TchatController extends BaseController
{
    public function index()
    {
        /** @var Response $response */
        $response = Container::getService('response');
        $contact = Container::getService('contact');
        $user = Container::getService('user');
        /** @var DBMysql $db */
        $db = Container::getService('db');
        /** @var Session $session */
        $session = Container::getService('session');
        $currentUser = $session->getSessionData('user');
        $currentUserId = $currentUser->getId();

        $db->connect();
        $contacts = $db->findContactsBy($contact, $user, ['user'=> $currentUserId]);

        $response->setVariables(
            [
                'contacts' => $contacts,
            ]
        );
        $response->setTemplate('Tchat/index.php');
        $response->render();

        return $response;
    }

    public function loadMessages()
    {
        /** @var Response $response */
        $response = Container::getService('response');
        $request = $this->getRequest();
        $message = Container::getService('message');
        /** @var Session $session */
        $session = Container::getService('session');

        $currentUser = $session->getSessionData('user');
        /** @var DBMysql $db */
        $db = Container::getService('db');
        $db->connect();
        $getRequestParameters = $this->getRequest()->getRequestParameters();
        $userId = (isset($getRequestParameters["userId"])) ? $getRequestParameters["userId"] : null;
        $messages = $db->findBy($message, [
            'receiver' => $currentUser->getId(),
            'sender' => $userId,
            'OR' => [
                'receiver' => $userId,
                'sender' => $currentUser->getId(),
            ]

            ], 'id');
        $response->setTemplate('Tchat/messages.php');
        if ($request->isXmlHttpRequest()) {
            $response->disableLayout();
        }

        $response->setVariables(
            [
                'messages' => $messages,
                'curentUserId' => 1
            ]
        );
        $response->render();

        return $response;
    }

    public function submitMessage()
    {
        /** @var Response $response */
        $response = Container::getService('response');
        $request = $this->getRequest();
        /** @var Message $message */
        $message = Container::getService('message');
        /** @var Session $session */
        $session = Container::getService('session');

        /** @var DBMysql $db */
        $db = Container::getService('db');
        $db->connect();
        $getRequestParameters = $this->getRequest()->getRequestParameters();

        $currentUser = $session->getSessionData('user');
        $currentUserId = $currentUser->getId();
        $userId = (isset($getRequestParameters["userId"])) ? $getRequestParameters["userId"] : null;
        $messageContent = (isset($getRequestParameters["message"])) ? $getRequestParameters["message"] : null;
        $message->setSender($currentUserId);
        $message->setReceiver($userId);
        $message->setMessage($messageContent);
        $message = $db->insert($message);
        $result = ['code' => $message];
        $result = json_encode($result);
        if ($request->isXmlHttpRequest()) {
            $response->disableLayout();
        }
        $response->setContentType('application/json');

        $response->setContent($result);
        $response->render();

        return $response;
    }
}
