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

return [

	'submenu' => [
		'custom-rating-grifus' => [
			'parent'     => 'extensions-for-grifus',
			'title'      => __( 'Custom Rating', 'extensions-for-grifus-rating' ),
			'name'       => __( 'Custom Rating', 'extensions-for-grifus-rating' ),
			'capability' => 'manage_options',
			'slug'       => 'extensions-for-grifus-rating',
			'function'   => '',
		],
	],
];
