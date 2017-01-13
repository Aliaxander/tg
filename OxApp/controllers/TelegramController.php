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

use OxApp\commands\StartCommand;
use OxApp\helpers\GitHubIssues;
use OxApp\models\UpdateId;
use Telegram\Bot\Api;
use Ox\App;
use Telegram\Bot\Commands\CommandBus;
use Telegram\Bot\Commands\HelpCommand;

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
        //        print_r($telegram->sendMessage([
        //            'chat_id' => '-1001082111611@',
        //            'text' => "100 пудов Саня шикарен. Тащусь просто."
        //        ]));
        //$messages = $telegram->getUpdates();
        $messages = $telegram->getUpdates(["offset" => -1]);
        foreach ($messages as $message) {
            $messId = $message->getMessage()->get("message_id");
            print_r($message);
            $updateId = $message->getUpdateId();
            //if (UpdateId::find(["updateId" => $updateId])->count == 0) {
            $text = $message->getMessage()->get("text");
            echo $text;
            if (!empty($message->getMessage()->getReplyToMessage())) {
                $replay = @$message->getMessage()->getReplyToMessage()->getText();
            }
            if (!empty($replay)) {
                $replayResult = explode("[", $replay);
                
                if ($replayResult[0] == "Send me issue message for repo ") {
                    $repo = explode("[", $replay);
                    $repo = str_replace("]", "", $repo[1]);
                    GitHubIssues::addIssue($text, $text, "OxGroup/" . $repo);
                    $telegram->sendMessage([
                        'chat_id' => $this->chatId . '@',
                        'text' => 'Add github issue: ' . $text . ' for repo: ' . $repo,
                        'reply_to_message_id' => $messId
                    ]);
                } else {
                    $this->hideKey($messId);
                    $reply_markup = $telegram->forceReply(['selective' => true]);
                    $response = $telegram->sendMessage([
                        'chat_id' => $this->chatId . '@',
                        'text' => 'Send me issue message for repo [' . $text . ']',
                        'reply_markup' => $reply_markup,
                        'reply_to_message_id' => $messId
                    ]);
                }
            }
            switch ($text) {
                case ("/issue"):
                    $this->addKeyboardRepo($messId);
                    break;
            }
            //                $bot = $message->getMessage()->get("entities");
            //                if (empty($bot)) {
            //                    $chat = $message->getMessage()->get("chat");
            //                    $text = $message->getMessage()->get("text");
            //                    $messId = $message->getMessage()->get("message_id") . "_" . $message->getMessage()->get("date");
            //                    print_r($bot);
            //                    if ($text == "/ты читаешь нас?") {
            //                        $answer = "Вижу только все, что на \"/\"";
            //
            //                    } elseif ($text == "/Кто тут самый крутой?") {
            //                        $answer = "Саня?";
            //                    }
            //                    print_r($telegram->sendMessage([
            //                        'chat_id' => '-1001082111611@',
            //                        'text' => $answer
            //                    ]));
            //                    echo "$text";
            //                } else {
            //                    $text = $message->getMessage()->get("text");
            //                    echo "Command: $text";
            //                    $command = explode(" > ", $text);
            //                    print_r($command);
            //                    $commandBot = @$command[0];
            //                    $repo = @$command[1];
            //                    $message = @$command[2];
            //                    if ($commandBot === "/issue") {
            //                        GitHubIssues::addIssue($message, $message, "OxGroup/" . $repo);
            //                        echo "Repo: $repo";
            //                        echo "title/message: $message";
            //                    }
            //                }
            //   UpdateId::add(['updateId' => $updateId]);
            // }
        }
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
            $i++;
            if ($i > 3) {
                $i = 0;
                $i2++;
            }
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
}

//-1001082111611 - oxgroup dev chat