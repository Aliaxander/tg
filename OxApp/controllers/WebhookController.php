<?php
/**
 * Created by OxGroup.
 * User: Aliaxander
 * Date: 13.01.17
 * Time: 15:20
 *
 * @category  WebhookController
 * @package   OxApp\controllers
 * @author    Aliaxander
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      http://oxgroup.media/
 */

namespace OxApp\controllers;

use Ox\App;
use OxApp\helpers\Config;
use OxApp\models\Bots;
use OxApp\models\Requests;
use OxApp\models\Users;
use Telegram\Bot\Api;

/**
 * Class WebhookController
 *
 * @package OxApp\controllers
 */
class WebhookController extends App
{
    public function get()
    {
        
        $botId = 1;
        $lang = Config::$lang['ru'];
        $token = Bots::find(['id' => $botId])->rows[0]->api;
        $telegram = new Api($token);
        //  print_r($telegram->setWebhook(['url'=>'https://tg.oxgroup.media']));
        
        $message = $telegram->getWebhookUpdate();
        
        $photoId = $message->getMessage();
        $chatId = $message->getMessage()->getFrom()->getId();
        $text = $message->getMessage()->getText();
        $userData = $message->getMessage()->getFrom();
        if (preg_match("/\/start/", $text)) {
            
            $users = Users::find(['chatId' => $chatId]);
            if ($users->count === 0) {
                $params = explode(' ', $text);
                $params = explode('-', @$params[1]);
                Users::add([
                    'chatId' => $chatId,
                    'webId' => @$params[0],
                    'refId' => @$params[2],
                    'botId' => $botId,
                    'count' => 10,
                    'lang' => @$params[1],
                    'userData' => json_encode($userData),
                    'inviteId' => substr(str_shuffle(str_repeat($chatId . "abcdefghijklmnopqrstuvwxyz",
                        7)), 0, 7)
                ]);
                $user = Users::find(['chatId' => $chatId])->rows[0];
            }
            print_r($telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => "Привет. Просто загрузи фото и я найду видео с похожей моделью."
            ]));
        }
        $user = Users::find(['chatId' => $chatId])->rows[0];
        Users::where(['id' => $user->id])->update(['requests' => $user->requests + 1]);
        try {
            print_r($chatId);
            if (!empty($photoId->getPhoto())) {
                print_r($telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => $lang['searchw']
                ]));
                $photo = $photoId->getPhoto();
                $fileId = $photo[3]['file_id'];
                $response = $telegram->getFile(['file_id' => $fileId]);
                $file = "https://api.telegram.org/file/bot$token/" . $response->getFilePath();
                // Requests::add(['user' => $user->id, 'photo' => $file]);
                print_r($telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => $file
                ]));
                $context = stream_context_create(array(
                    'http' => array(
                        'method' => 'POST',
                        'header' => 'Referer: http://pornstar.id/' . "\n" . 'Content-Type: application/x-www-form-urlencoded' . PHP_EOL,
                        'content' => $file,
                    ),
                ));
                $result = @file_get_contents("http://pornstar.id/api-id", false, $context);
                print_r($telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => $result . " "
                ]));
                $result = json_decode($result);
                if ($result->action === 'No face detected') {
                    print_r($telegram->sendMessage([
                        'chat_id' => $chatId,
                        'text' => $lang['noface']
                    ]));
                } else {
                    $result = @file_get_contents("http://pornstar.id/api?type=profiles&id=" . implode(",",
                            $result->msg->person[0]),
                        false, stream_context_create(array(
                            'http' => array(
                                'header' => 'Referer: http://pornstar.id/'
                            ),
                        )));
                    print_r($telegram->sendMessage([
                        'chat_id' => $chatId,
                        'text' => $result . " "
                    ]));
                    /*
                    $result = json_decode($result);
                    $rand = 1;
                    $fullName = str_replace(' ', '', $result->$rand->full_name);
                   
                    try {
                        $video = file_get_contents(
                            "https://www.pornhub.com/webmasters/search?id=44bc40f3bc04f65b7a35&search={$fullName}&thumbsize=medium"
                        );
                        $video = json_decode($video);
                        $video = $video->videos[mt_rand(0, count($video->videos) - 1)];
                        print_r($video);
                        $videoId = $video->video_id;
                        $thumb = $video->default_thumb;
                        $thumb = base64_encode($thumb);
                        $thumb = str_replace('=', '.smooth', $thumb);
                        print_r($telegram->sendMessage([
                            'chat_id' => $chatId,
                            'text' => 'https://pornface.ebot.biz/' . $videoId . "/" . $thumb
                        ]));
                        Users::where(['id' => $user->id])->update(['count' => $user->count - 1]);
                    } catch (\Exception $e) {
                        print_r($telegram->sendMessage([
                            'chat_id' => $chatId,
                            'text' => $lang['novideo']
                        ]));
                    }
                    */
                }
            }
        } catch (\Exception $e) {
            print_r($telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => $lang['error']
            ]));
            print_r($telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => json_encode($e)
            ]));
        }
    
}

public
function post()
{
    $this->get();
}
}
