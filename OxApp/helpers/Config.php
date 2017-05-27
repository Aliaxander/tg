<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 27.05.17
 * Time: 13:51
 */

namespace OxApp\helpers;

class Config
{
    public static $lang=[
        'ru'=>[
            'searchw' => 'Ищу модель...',
            'noface'=>'Не нашел лиц на фото.',
            'novideo'=>'Не нашел видео или произошла ошибка, попробуйте позже.',
            'error'=>'Произошла ошибка. Попробуйте повторить попытку.'
        ],
        'en'=>[
            'searchw' => 'Finding a model...',
            'noface' => 'Did not find the faces in the photo.',
            'novideo' => 'Did not find the video or an error occurred, please try again later.',
            'error' => 'Error occurred. Try to try again.'
        ]
    ];
}