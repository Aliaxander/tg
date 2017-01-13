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
use Telegram\Bot\Api;
use Ox\App;

/**
 * Class TelegramController
 *
 * @package OxApp\controllers
 */
class TelegramController extends App
{
    public function get()
    {
        $API_KEY = '296504384:AAEFESDASMwjNmneHcDmanAF9nNBO0GA44g';
        $telegram = new Api($API_KEY);
        $messages = $telegram->getUpdates();
        $telegram->getUpdates(["offset" => -1]);
        foreach ($messages as $message) {
            $bot = $message->getMessage()->get("entities");
            if (empty($bot)) {
                $chat = $message->getMessage()->get("chat");
                $text = $message->getMessage()->get("text");
                $messId = $message->getMessage()->get("message_id") . "_" . $message->getMessage()->get("date");
                print_r($bot);
                echo "$text";
            } else {
                $text = $message->getMessage()->get("text");
                echo "Command: $text";
                $command = explode(" > ", $text);
                print_r($command);
                $commandBot = @$command[0];
                $repo = @$command[1];
                $message = @$command[2];
                if ($commandBot === "/issue") {
                    GitHubIssues::addIssue($message, $message, "OxGroup/" . $repo);
                    echo "Repo: $repo";
                    echo "title/message: $message";
                }
            }
        }
    }
}
