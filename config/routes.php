<?php
return array(
    'index' => array(
        'Application\\Controller\\TchatController',
        'index',
    ),
    'login' => array(
        'Application\\Controller\\LoginController',
        'index',
    ),
    'logout' => array(
        'Application\\Controller\\LoginController',
        'logout',
    ),
    'loadMessages' => array(
        'Application\\Controller\\TchatController',
        'loadMessages',
    ),
    'submitMessage' => array(
        'Application\\Controller\\TchatController',
        'submitMessage',
    ),
);