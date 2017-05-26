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
        $text = $this->request->request->all();
        $token = "339689903:AAGLaTBGlTQYOhmA0mt1CRof_EbGttBR86I";
        $telegram = new Api($token);
        print_r($telegram->sendMessage([
            'chat_id' => '132514008',
            'text' => 'Search woman...'
        ]));
        $response = $telegram->getUpdates();
        $response = $telegram->getFile(['file_id' => 'AgADAgADKagxG-HJQUkC1cpTC3ic5Lk8tw0ABK47GMhVD8aBw7gDAAEC']);
        $response = $telegram->getFile(['file_id' => 'AgADAgADKagxG-HJQUkC1cpTC3ic5Lk8tw0ABK47GMhVD8aBw7gDAAEC']);
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
 
        $result = file_get_contents("http://pornstar.id/api?type=profiles&id=" . implode(",", $result->msg->person[0]),
            false, stream_context_create(array(
                'http' => array(
                    'header' => 'Referer: http://pornstar.id/'
                ),
            )));
        $result = json_decode($result);
        $rand= mt_rand(0, 3);
        $fullName= str_replace(' ','',$result->$rand->full_name);
        

        print_r($telegram->sendMessage([
            'chat_id' => '132514008',
            'text' => 'Search video...'
        ]));
        $video = file_get_contents(
            "https://www.pornhub.com/webmasters/search?id=44bc40f3bc04f65b7a35&search={$fullName}&thumbsize=medium"
        );
        $video = json_decode($video);
        $video = $video->videos[mt_rand(0, count($video->videos) - 1)];
        print_r($video);
        $videoId = $video->video_id;
        $thumb = str_replace(["https://bi.phncdn.com/videos/",'"'], "", $video->default_thumb);
        $thumb = base64_encode($thumb);
        $thumb=str_replace('=','.', $thumb);
        print_r($telegram->sendMessage([
            'chat_id' => '132514008',
            'text' => 'http://tg.oxgroup.media/' . $videoId . "/" . $thumb
        ]));
    
        //        $count = 0;
//        $resultPhotos = [];
//        foreach ($result as $row) {
//            $count++;
//            $resultPhotos[$result[0]->full_name] = "http://content.pornstar.id/" . $row->profile_image;
//        }
//        echo "Result:";
//        print_r($resultPhotos);
//        foreach ($resultPhotos as $key => $val) {
//            //            print_r("https://api.telegram.org/file/bot$token/" . $response->getFilePath());
//            //
//            print_r($telegram->sendMessage([
//                'chat_id' => '132514008',
//                'text' => $val
//            ]));
//        }
        
    }
    
    public function post()
    {
        $this->get();
    }
}
