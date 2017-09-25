<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 24/09/17
 * Time: 19:27
 */

namespace Http;


class Session {

    protected $sessionID;

    public function __construct(){
        $this->init_session();
        $this->setSession_id();
    }

    public function init_session(){
        session_start();
    }

    public function setSession_id(){
        $this->sessionID = session_id();
    }

    public function getSession_id(){
        return $this->sessionID;
    }

    public function sessionExists( $session_name ){
        if( isset($_SESSION[$session_name]) ){
            return true;
        }
        else{
            return false;
        }
    }

    public function createSession( $session_name , $is_array = false ){
        if( !isset($_SESSION[$session_name])  ){
            if( $is_array == true ){
                $_SESSION[$session_name] = array();
            }
            else{
                $_SESSION[$session_name] = '';
            }
        }
    }

    public function insert( $session_name , array $data ){
        if(!is_array($_SESSION[$session_name]) ){
            $_SESSION[$session_name] = [];
        }
        array_push( $_SESSION[$session_name], $data );
    }

    public function dump( $session_name ){
        echo '<pre>';print_r($_SESSION[$session_name]);echo '</pre>';
    }

    public function removeSession( $session_name = '' ){
        if( !empty($session_name) ){
            unset( $_SESSION[$session_name] );
        }
        else{
            unset($_SESSION);
        }
    }

    public function getSessionData( $session_name ){
        return $_SESSION[$session_name];
    }

    public function hasData( $session_name ){
        return isset($_SESSION[$session_name]);
    }

    public function setSessionData( $session_name , $data ){
        $_SESSION[$session_name] = $data;
    }

    public function destroy(){
        session_destroy();
    }

}