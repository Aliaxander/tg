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

use Telegram\Bot\Api;
use Ox\App;

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
        $payload = json_decode($text["payload"]);
        //$pusher = $payload->pusher;
        $sender = $payload->sender->login;
        $commit = $payload->head_commit->id;
        $message = $payload->head_commit->message;
        $repo = $payload->repository->full_name;
        $message = "[$repo] New commit {$commit} - {$sender}: {$message}";
        //chatId=132514008
        $telegram = new Api("296504384:AAEFESDASMwjNmneHcDmanAF9nNBO0GA44g");
        
        print_r($telegram->sendMessage([
            'chat_id' => '132514008',
            'text' => $message
        ]));
    }
    
    public function post()
    {
        $this->get();
    }
    
}