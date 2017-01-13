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
        $telegram = new Api("296504384:AAEFESDASMwjNmneHcDmanAF9nNBO0GA44g");
    
        print_r($telegram->sendMessage([
            'chat_id' => '-1001082111611@',
            'text' => '123'
        ]));
        echo 1;
    }
}
