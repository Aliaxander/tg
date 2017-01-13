<?php
/**
 * Created by OxGroup.
 * User: aliaxander
 * Date: 03.06.15
 * Time: 12:49
 */

use Ox\Router\Router;
use OxApp\helpers\DefaultRequest;

//
//RouteMiddleware::$debug=false;
Router::$requestDriver = DefaultRequest::getRequest();
Router::rout('/test')->app('Test')->save();
Router::rout('/telega')->app('Telegram')->save();
Router::rout('/webhook')->app('Webhook')->save();

Router::rout('/request')->app('SandRequest')->save();
