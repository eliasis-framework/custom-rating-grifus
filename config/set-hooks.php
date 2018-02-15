<?php
/**
 * Custom Rating Grifus · Extensions For Grifus
 *
 * @author    Josantonius <hello@josantonius.com>
 * @package   Josantonius/Custom-Rating-Grifus
 * @copyright 2017 - 2018 (c) Josantonius - Custom Rating Grifus
 * @license   GPL-2.0+
 * @link      https://github.com/Josantonius/Custom-Rating-Grifus.git
 * @since     1.0.0
 */

use Eliasis\Complement\Type\Module;

$namespace = Module::CustomRatingGrifus()->getOption( 'namespaces', 'controller' );

return [

	'hooks' => [

		[ 'launch-modules', [ $namespace . 'Launcher', 'init' ], 8, 0 ],
	],
];
