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

use Eliasis\Framework\App;
use Eliasis\Complement\Type\Module;

$root_path = Module::CustomRatingGrifus()->getOption( 'path', 'root' );

return [

	'path' => [

		'page'       => $root_path . 'src/template/page/',
		'languages'  => $root_path . 'languages/',
		'meta-boxes' => $root_path . 'src/template/meta-boxes/',
	],
];
