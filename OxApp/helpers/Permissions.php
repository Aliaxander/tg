<?php
/**
 * Created by OxGroup.
 * User: Aliaxander
 * Date: 30.03.16
 * Time: 15:47
 */

namespace OxApp\helpers;

use Ox\App;
use OxApp\models\UserGroups;
use OxApp\models\Users;

/**
 * Class Permissions
 *
 * @package OxApp\helpers
 */
class Permissions
{
    protected static $usersCache = [];
    
    /**
     * @param $permName
     *
     * @return bool
     */
    public static function hasPermission($permName, $bool = true)
    {
        $result = false;
        if (is_string($permName)) {
            $result = self::checkPermission($permName);
        } elseif (is_array($permName)) {
            foreach ($permName as $stringName) {
                $result = self::checkPermission($stringName);
                if ($result !== $bool) {
                    break;
                }
            }
        }
        
        return $result;
    }
    
    private static function checkPermission($string)
    {
        $result = false;
        if (isset(App::$user->permissions->$string)) {
            $result = App::$user->permissions->$string;
        } elseif (isset(App::$userGroup->permissions->$string)) {
            $result = App::$userGroup->permissions->$string;
        }
        
        return $result;
    }
    
    /**
     * @param $userId
     * @param $permName
     *
     * @return bool
     */
    public static function hasUserPermission($userId, $permName)
    {
        if (isset(self::$usersCache[$userId][$permName])) {
            $result = self::$usersCache[$userId][$permName];
        } else {
            $user = Users::find(array('id' => $userId));
            if ($user->count === 1) {
                $user = $user->rows[0];
                $result = false;
                $userGroup = UserGroups::find(array('id' => $user->group));
                if ($userGroup->count === 1) {
                    $userGroup = (object)$userGroup->rows[0];
                } else {
                    $userGroup = false;
                }
                //print_r($userGroup);
                if (is_string($userGroup->permissions)) {
                    $userGroupPermissions = @json_decode($userGroup->permissions);
                } else {
                    $userGroupPermissions = $userGroup->permissions;
                }
                //print_r($userGroupPermissions);
                $userPermissions = @json_decode($user->permissions);
                //print_r($userPermissions);
                if (isset($userPermissions->$permName)) {
                    $result = $userPermissions->$permName;
                } elseif (isset($userGroupPermissions->$permName)) {
                    $result = $userGroupPermissions->$permName;
                }
            } else {
                $result = false;
            }
            self::$usersCache[$userId][$permName] = $result;
        }
        
        return $result;
    }
}
