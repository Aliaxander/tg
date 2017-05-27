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

/**
 * Class TestController
 *
 * @package OxApp\controllers
 */
class TestController extends App
{
    public function get()
    {
       $id=$this->request->get('id');
       $img=$this->request->get('img');
       $img = str_replace('.smooth', '=', $img);
       View::build('users',['id'=>trim($id),'img'=>trim(base64_decode($img))]);
    }
}
