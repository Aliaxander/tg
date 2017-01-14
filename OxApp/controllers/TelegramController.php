<?php
/**
 * Created by OxGroup.
 * User: Aliaxander
 * Date: 13.01.17
 * Time: 15:13
 *
 * @category  TelegramController
 * @package   OxApp\controllers
 * @author    Aliaxander
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      http://oxgroup.media/
 */

namespace OxApp\controllers;

use OxApp\helpers\GitHubIssues;
use OxApp\models\UpdateId;
use Telegram\Bot\Api;
use Ox\App;

/**
 * Class TelegramController
 *
 * @package OxApp\controllers
 */
class TelegramController extends App
{
    public $chatId = '-1001082111611';//"-";
    
    public function get()
    {
        echo "<pre>";
        $API_KEY = '296504384:AAEFESDASMwjNmneHcDmanAF9nNBO0GA44g';
        $telegram = new Api($API_KEY);
        //        $response = $telegram->setWebhook(['url' => 'https://example.com/<token>/webhook']);
        //
        //        $messages = $telegram->getUpdates(["offset" => -1]);
        // foreach ($messages as $message) {
        $message = $telegram->getWebhookUpdate();
        print_r($message);
        $messId = $message->getMessage()->get("message_id");
        
        $updateId = $message->getUpdateId();
        //if (UpdateId::find(["updateId" => $updateId])->count == 0) {
        $text = $message->getMessage()->get("text");
        echo $text;
        if (!empty($message->getMessage()->getReplyToMessage())) {
            $replay = @$message->getMessage()->getReplyToMessage()->getText();
        }
        if (!empty($replay)) {
            $replayResult = explode("[", $replay);
            
            if ($replayResult[0] == "Send me issue title for repo ") {
                $this->hideKey($messId);
                $reply_markup = $telegram->forceReply(['selective' => true]);
                $repo = str_replace("]", "", $replayResult[1]);
                $response = $telegram->sendMessage([
                    'chat_id' => $this->chatId . '@',
                    'text' => 'Send me issue message for repo [' . $repo . '][Title: ' . $text . ']',
                    'reply_markup' => $reply_markup,
                    'reply_to_message_id' => $messId
                ]);
            } elseif ($replayResult[0] == "Send me issue message for repo ") {
                $repo = str_replace("]", "", $replayResult[1]);
                $title = str_replace(["Title: ", "]"], "", $replayResult[2]);
                $text = $this->autoMarkdownMessage($text);
                GitHubIssues::addIssue($title, $text, "OxGroup/" . $repo);
            } else {
                $this->hideKey($messId);
                $reply_markup = $telegram->forceReply(['selective' => true]);
                $response = $telegram->sendMessage([
                    'chat_id' => $this->chatId . '@',
                    'text' => 'Send me issue title for repo [' . $text . ']',
                    'reply_markup' => $reply_markup,
                    'reply_to_message_id' => $messId
                ]);
            }
        }
        switch ($text) {
            case ("/issue"):
                $this->addKeyboardRepo($messId);
                break;
            case ("/issue@OxCPA_bot"):
                $this->addKeyboardRepo($messId);
                break;
            case ("/шуткани"):
                $this->sendFun();
                break;
            case ("/help"):
                $this->sendHelp();
                break;
            case ("/help@OxCPA_bot"):
                $this->sendHelp();
                break;
        }
    }
    
    private function autoMarkdownMessage($message)
    {
        $content = preg_replace(
            '#((http|https)://[^\s]+(?=\.(jpe?g|png|gif)))(\.(jpe?g|png|gif))#i', '![]($1.$3)', $message
        );
        
        return $content;
    }
    
    public function addKeyboardRepo($replayTo)
    {
        $API_KEY = '296504384:AAEFESDASMwjNmneHcDmanAF9nNBO0GA44g';
        $telegram = new Api($API_KEY);
        $repos = GitHubIssues::getRepos();
        $keyboard = [];
        $i = 0;
        $i2 = 0;
        foreach ($repos as $repo) {
            if ($i > 3) {
                $i = 0;
                $i2++;
            }
            $i++;
            $keyboard[$i2][] = $repo;
        }
        
        $reply_markup = $telegram->replyKeyboardMarkup([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => true,
            'selective' => true
        ]);
        
        $response = $telegram->sendMessage([
            'chat_id' => $this->chatId . '@',
            'text' => 'Choose repository for add issue:',
            'reply_markup' => $reply_markup,
            'reply_to_message_id' => $replayTo
        ]);
    }
    
    public function hideKey($replayTo)
    {
        $API_KEY = '296504384:AAEFESDASMwjNmneHcDmanAF9nNBO0GA44g';
        $telegram = new Api($API_KEY);
        $response = $telegram->sendMessage([
            'chat_id' => $this->chatId . '@',
            'text' => 'Ok.',
            'reply_markup' => $telegram->replyKeyboardHide(['selective' => true]),
            'reply_to_message_id' => $replayTo
        ]);
    }
    
    public function sendFun()
    {
        $API_KEY = '296504384:AAEFESDASMwjNmneHcDmanAF9nNBO0GA44g';
        $telegram = new Api($API_KEY);
        
        $array = ["new+aforizm", "new+anekdot"];
        $rand = rand(0, 1);
        if ($rand == 0) {
            $maxRand = 10;
        } else {
            $maxRand = 40;
        }
        $anekdot = file_get_contents("http://www.umori.li/api/get?site=anekdot.ru&name={$array[$rand]}&num=100");
        $anekdot = json_decode($anekdot);
        $message = @$anekdot[rand(0, $maxRand)]->elementPureHtml;
        $response = $telegram->sendMessage([
            'chat_id' => $this->chatId . '@',
            'text' => $message
        ]);
    }
    
    public function sendHelp()
    {
        $API_KEY = '296504384:AAEFESDASMwjNmneHcDmanAF9nNBO0GA44g';
        $telegram = new Api($API_KEY);
        $message = "Добавить issue: /issue\nШуткануть: /шуткануть\nПротестировать постбек: https://bot.oxgroup.media/request (http/https)";
        $response = $telegram->sendMessage([
            'chat_id' => '-1001082111611@',
            'text' => $message,
        ]);
    }
    
    /**
     * post
     */
    public function post()
    {
        $this->get();
    }
}

//-1001082111611 - oxgroup dev chat