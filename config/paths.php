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

$DS = App::DS;

$ROOT = Module::CustomRatingGrifus()->get('path', 'root');

return [

    'path' => [

        'page'       => $ROOT.'src'.$DS.'template'.$DS.'page'.$DS,
        'languages'  => $ROOT.'languages'.$DS,
        'meta-boxes' => $ROOT.'src'.$DS.'template'.$DS.'meta-boxes'.$DS,
    ],
];
