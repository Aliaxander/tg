<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 14.01.17
 * Time: 1:46
 */

namespace OxApp\controllers;


use Ox\App;
use Telegram\Bot\Api;

/**
 * Class SandRequestController
 *
 * @package OxApp\controllers
 */
class SandRequestController extends App
{
    public function get()
    {
        $method=$this->request->getMethod();
        $userAgent=$this->request->server->get("HTTP_USER_AGENT");
        $ipAddr=$this->request->server->get("REMOTE_ADDR");
        $post = json_encode($this->request->request->all());
        $get = json_encode($this->request->query->all());
        $message="Method: $method
        UserAgent: $userAgent
        IP: $ipAddr
        POST: $post
        GET: $get
        ";
        echo $message;
        $API_KEY = '296504384:AAEFESDASMwjNmneHcDmanAF9nNBO0GA44g';
        $telegram = new Api($API_KEY);
        $response = $telegram->sendMessage([
            'chat_id' => '-1001082111611@',
            'text' => $message,
        ]);
    }
    
    public function post()
    {
        $this->get();
    }
    
    public function put()
    {
        $this->get();
    }
    
    public function delete()
    {
        $this->get();
    }
    
    public function header()
    {
        $this->get();
    }
    
}