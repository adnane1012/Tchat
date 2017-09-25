<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 24/09/17
 * Time: 12:56
 */

namespace DI;


class Container
{

    private static $services;
    private static $container;
    private static $maps = [
        'response' => 'Http\\Response',
        'request' => 'Http\\Request',
        'session' => 'Http\\Session',
        'view' => '\Template\View',
        'db' => '\DB\DBMysql',
        'user' => '\Application\Model\User',
        'message' => '\\Application\\Model\\Message',
        'contact' => '\\Application\\Model\\Contact',
    ];

    private function __construct()
    {

    }

    public static function getContainer()
    {
        if (!is_object(self::$container)) {
            self::$container = new self;
        }

        return self::$container;
    }

    public static function addService($key, $obj)
    {
        if (self::$services === null) {
            self::$services = (object)array();
        }
        self::$services->$key = $obj;
    }

    public static function createNewService($key)
    {
        if (!isset(self::$maps[$key])) {
            throw new \Exception('Service not found.');
        }

        self::addService($key, new self::$maps[$key]);
    }

    public static function getService($key)
    {
        if (!is_object(self::$services) || !isset(self::$services->{$key})) {
            self::createNewService($key);
        }

        return self::$services->{$key};
    }

    public static function serviceClassAsSingleton($key, $value, $arguments = null)
    {

    }

} 
