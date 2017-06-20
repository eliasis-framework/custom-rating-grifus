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

use Eliasis\App\App;

$namespace = App::ExtensionsForGrifus()->get('namespaces', 'modules');

$module = 'CustomRatingGrifus';

return [

    'namespaces' => [

        'controller' => $namespace . $module . '\\Controller\\',
        'admin-controller' => $namespace . $module . '\\Controller\\Admin\\',
        'admin-page' => $namespace . $module . '\\Controller\\Admin\\Page\\',
    ],
];
