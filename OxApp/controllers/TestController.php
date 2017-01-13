<?php
/**
 * Created by OxGroup.
 * User: Aliaxander
 * Date: 12.01.17
 * Time: 10:48
 *
 * @category  TestController
 * @package   OxApp\controllers
 * @author    Aliaxander
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      http://oxgroup.media/
 */

namespace OxApp\controllers;

use Ox\App;
use Ox\View;
use OxApp\models\Users;
use Telegram\Bot\Api;

/**
 * Class TestController
 *
 * @package OxApp\controllers
 */
class TestController extends App
{
    public function get()
    {
 
//        $API_KEY = '296504384:AAEFESDASMwjNmneHcDmanAF9nNBO0GA44g';
//        $telegram = new Api($API_KEY);
//        $response = $telegram->setWebhook(['url' => 'https://bot.oxgroup.media/telega']);
//        $users = Users::selectBy(
//            'id',
//            'dateCreate',
//            'apikey',
//            'group'
//        )->limit([0 => 5])->find();
//
//        View::build("users", ["users" => $users]);
    }
}
