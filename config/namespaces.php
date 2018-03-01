<?php
/**
 * Custom Rating Grifus · Extensions For Grifus
 *
 * @author    Josantonius <hello@josantonius.com>
 * @package   Josantonius/Custom-Rating-Grifus
 * @copyright 2017 - 2018 (c) Josantonius - Custom Rating Grifus
 * @license   GPL-2.0+
 * @link      https://github.com/eliasis-framework/custom-rating-grifus.git
 * @since     1.0.0
 */

use Eliasis\Framework\App;

$namespace = App::EFG()->getOption( 'namespaces', 'modules' );

return [

	'namespaces' => [

		'controller' => $namespace . 'CustomRatingGrifus\\Controller\\',
		'admin-controller' => $namespace . 'CustomRatingGrifus\\Controller\\Admin\\',
		'admin-page' => $namespace . 'CustomRatingGrifus\\Controller\\Admin\\Page\\',
	],
];
