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
        $lang=Config::$lang['ru'];
        $token = Config::$api;
        $telegram = new Api($token);
      //  print_r($telegram->setWebhook(['url'=>'https://tg.oxgroup.media']));
        
        $message = $telegram->getWebhookUpdate();
        
        $photoId = $message->getMessage();
        $chatId = $message->getMessage()->getFrom()->getId();
        
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
            //
            $context = stream_context_create(array(
                'http' => array(
                    'method' => 'POST',
                    'header' => 'Referer: http://pornstar.id/' . "\n" . 'Content-Type: application/x-www-form-urlencoded' . PHP_EOL,
                    'content' => $file,
                ),
            ));
            $result = file_get_contents("http://pornstar.id/api-id", false, $context);
            $result = json_decode($result);
            if ($result->action === 'No face detected') {
                print_r($telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => $lang['noface']
                ]));
            } else {
                $result = file_get_contents("http://pornstar.id/api?type=profiles&id=" . implode(",",
                        $result->msg->person[0]),
                    false, stream_context_create(array(
                        'http' => array(
                            'header' => 'Referer: http://pornstar.id/'
                        ),
                    )));
                $result = json_decode($result);
                $rand = mt_rand(0, 3);
                $fullName = str_replace(' ', '', $result->$rand->full_name);
            
            
                print_r($telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => $lang['searchv']
                ]));
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
                    'text' => 'http://tg.oxgroup.media/' . $videoId . "/" . $thumb
                ]));
            }
        }
        
    }
    
    public function post()
    {
        $this->get();
    }
}
