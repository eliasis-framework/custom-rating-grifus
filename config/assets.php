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

use Eliasis\Module\Module;

$css = Module::CustomRatingGrifus()->get('url')['css'];
$js  = Module::CustomRatingGrifus()->get('url')['js'];

return [

    'assets' => [

        'js' => [
            'customRatingGrifus' => [
                'name'      => 'customRatingGrifus',
                'url'       => $js . 'custom-rating-grifus.js',
                'place'     => 'front',
                'deps'      => ['jquery'],
                'version'   => '1.0.0',
                'footer'    => false,
                'params'    => [
                    'ajax_url' => admin_url('admin-ajax.php'),
                ],
            ],
            'customRatingGrifusHome' => [
                'name'      => 'customRatingGrifusHome',
                'url'       => $js . 'custom-rating-grifus-home.js',
                'place'     => 'front',
                'deps'      => ['jquery'],
                'version'   => '1.0.0',
                'footer'    => false,
                'params'    => [],
            ],
            'customRatingGrifusAdmin' => [
                'name'      => 'customRatingGrifusAdmin',
                'url'       => $js . 'custom-rating-grifus-admin.js',
                'place'     => 'admin',
                'deps'      => ['jquery'],
                'version'   => '1.0.0',
                'footer'    => true,
                'params'    => [
                    'ajax_url' => admin_url('admin-ajax.php'),
                ],
            ],
        ],
        'css' => [
            'customRatingGrifus' => [
                'name'      => 'customRatingGrifus',
                'url'       => $css . 'custom-rating-grifus.css',
                'place'     => 'front',
                'deps'      => [],
                'version'   => '1.0.0',
                'media'     => '',
            ],
            'customRatingGrifusAdmin' => [
                'name'      => 'customRatingGrifusAdmin',
                'url'       => $css . 'custom-rating-grifus-admin.css',
                'place'     => 'admin',
                'deps'      => [],
                'version'   => '1.0.0',
                'media'     => '',
            ],
        ],
    ],
];
