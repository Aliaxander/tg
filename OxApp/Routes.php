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
Router::rout('/:text=>id')->app('Test')->save();
Router::rout('/webhook')->app('Webhook')->save();
