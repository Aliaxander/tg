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
    /*
     *
     */
        $telegram = new Api("339689903:AAGLaTBGlTQYOhmA0mt1CRof_EbGttBR86I");
        $response = $telegram->getUpdates();
        $response = $telegram->getMe();
        print_r($telegram->sendMessage([
            'chat_id' => '132514008',
            'text' => json_encode($response)
        ]));
        
    }
    
    public function post()
    {
        $this->get();
    }
}
