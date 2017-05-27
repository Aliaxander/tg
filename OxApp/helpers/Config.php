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
            'searchw' => 'Ищу девушку...',
            'searchv' => 'Ищу видео...',
            'noface'=>'Не нашел лиц на фото.',
            'novideo'=>'Не нашел видео или произошла ошибка, попробуйте позже.'
        ],
        'en'=>[
            'searchw' => 'Finding a girl...',
            'searchv' => 'Search Videos...',
            'noface' => 'Did not find the faces in the photo.',
            'novideo' => 'Did not find the video or an error occurred, please try again later.'
        ]
    ];
    public static $api='339689903:AAGLaTBGlTQYOhmA0mt1CRof_EbGttBR86I';
}