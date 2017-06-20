<?php
/**
 * Custom Rating Grifus · Extensions For Grifus
 * 
 * @author     Josantonius - hello@josantonius.com
 * @copyright  Copyright (c) 2017
 * @license    GPL-2.0+
 * @link       https://github.com/Josantonius/Custom-Rating-Grifus.git
 * @since      1.0.0
 */

use Eliasis\App\App,
    Eliasis\Module\Module;

$url = App::MODULES_URL() . Module::CustomRatingGrifus()->get('folder');

return [

    'url' => [

        'css'    => $url . 'public/css/',
        'js'     => $url . 'public/js/',
        'images' => $url . 'public/images/',
    ],
];
