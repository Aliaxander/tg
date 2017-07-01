<?php
/**
 * Created by OxGroup.
 * User: aliaxander
 * Date: 18.05.15
 * Time: 10:34
 */

ini_set("allow_url_fopen", true);
ini_set('display_errors', '1');
date_default_timezone_set('Europe/Moscow');
header('Content-type: text/html; charset=utf-8');
header('Access-Control-Allow-Credentials: true');

$allowHeaders = "X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding";
header('Access-Control-Allow-Headers: ' . $allowHeaders);

header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, OPTIONS');
header('Access-Control-Allow-Origin: *');

$loader = require __DIR__ . '/../vendor/autoload.php';
require(__DIR__ . "/../config.php");
require(__DIR__ . "/../OxApp/Routes.php");
//

//
//$target_url = "https://api.findxfiles.com/faces/process/file";
//
//
//$tmpName = time();
//file_put_contents(__DIR__ . '/../tmp/' . $tmpName,
//    file_get_contents('https://api.telegram.org/file/bot339689903:AAGLaTBGlTQYOhmA0mt1CRof_EbGttBR86I/photos/file_314.jpg')
//);
//
//$target_url = "https://api.findxfiles.com/faces/process/file";
//
//$post = array('picture' => new \CURLFile(realpath(__DIR__ . '/../tmp/' . $tmpName)));
////unlink(__DIR__ . '/../tmp/' . $tmpName);
//
//$ch = curl_init();
//curl_setopt($ch, CURLOPT_URL, $target_url);
//curl_setopt($ch, CURLOPT_POST, 1);
//curl_setopt($ch, CURLOPT_HEADER, 0);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt($ch, CURLOPT_USERAGENT,
//    "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.12; rv:55.0) Gecko/20100101 Firefox/55.0");
//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));
//curl_setopt($ch, CURLOPT_REFERER, 'https://findxfiles.com/');
//curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
//curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
//curl_setopt($ch, CURLOPT_TIMEOUT, 100);
//curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
//
//$result = curl_exec($ch);
//
//
//$result = @json_decode($result);
//foreach ($result as $row) {
//    $rate = round($row->confidence * 1000);
//    $resultPic[$rate] = $row->name;
//}
//
//krsort($resultPic);
//$resultPic = array_values($resultPic);
//$name = $resultPic[0];
//echo $name;