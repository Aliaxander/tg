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
        if (!empty($payload->head_commit->id)) {
            $sender = $payload->sender->login;
            $commit = $payload->head_commit->id;
            $message = $payload->head_commit->message;
            $repo = $payload->repository->full_name;
            $message = "[$repo] New commit {$commit} - {$sender}: {$message}";
        } elseif (!empty($payload->issue) && $payload->action == 'opened') {
            $repository = $payload->repository->full_name;
            $url = $payload->issue->html_url;
            $text = $payload->issue->title;
            $message = "New issue [$repository]: {$text} {$url}";
        } elseif (!empty($payload->issue) && $payload->action == 'closed') {
            $repository = $payload->repository->full_name;
            $url = $payload->issue->html_url;
            $title = $payload->issue->title;
            $sender = $payload->sender->login;
            $message = "{$sender} closed issue [$repository]: {$title} {$url}";
        }
        //chatId=132514008
        $telegram = new Api("296504384:AAEFESDASMwjNmneHcDmanAF9nNBO0GA44g");
        
        print_r($telegram->sendMessage([
            'chat_id' => '-1001082111611@',
            'text' => $message
        ]));
    }
    
    public function post()
    {
        $this->get();
    }
}
