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

use Eliasis\Complement\Type\Module;

$css = Module::CustomRatingGrifus()->getOption( 'url' )['css'];
$js  = Module::CustomRatingGrifus()->getOption( 'url' )['js'];

return [

	'assets' => [

		'js' => [
			'customRatingGrifus' => [
				'name'      => 'customRatingGrifus',
				'url'       => $js . 'custom-rating-grifus.min.js',
				'place'     => 'front',
				'deps'      => [ 'jquery' ],
				'version'   => '1.0.0',
				'footer'    => false,
				'params'    => [
					'ajax_url' => admin_url( 'admin-ajax.php' ),
				],
			],
			'customRatingGrifusHome' => [
				'name'      => 'customRatingGrifusHome',
				'url'       => $js . 'custom-rating-grifus-home.min.js',
				'place'     => 'front',
				'deps'      => [ 'jquery' ],
				'version'   => '1.0.0',
				'footer'    => false,
				'params'    => [],
			],
			'customRatingGrifusAdmin' => [
				'name'      => 'customRatingGrifusAdmin',
				'url'       => $js . 'custom-rating-grifus-admin.min.js',
				'place'     => 'admin',
				'deps'      => [ 'jquery' ],
				'version'   => '1.0.0',
				'footer'    => true,
				'params'    => [
					'ajax_url' => admin_url( 'admin-ajax.php' ),
				],
			],
			'customRatingGrifusEditPost' => [
				'name'      => 'customRatingGrifusEditPost',
				'url'       => $js . 'custom-rating-grifus-edit-post.min.js',
				'place'     => 'admin',
				'deps'      => [ 'jquery' ],
				'version'   => '1.0.0',
				'footer'    => true,
				'params'    => [
					'ajax_url' => admin_url( 'admin-ajax.php' ),
				],
			],
		],
		'css' => [
			'customRatingGrifus' => [
				'name'      => 'customRatingGrifus',
				'url'       => $css . 'custom-rating-grifus.min.css',
				'place'     => 'front',
				'deps'      => [],
				'version'   => '1.0.0',
				'media'     => '',
			],
			'customRatingGrifusAdmin' => [
				'name'      => 'customRatingGrifusAdmin',
				'url'       => $css . 'custom-rating-grifus-admin.min.css',
				'place'     => 'admin',
				'deps'      => [],
				'version'   => '1.0.0',
				'media'     => '',
			],
			'customRatingGrifusEditPost' => [
				'name'      => 'customRatingGrifusEditPost',
				'url'       => $css . 'custom-rating-grifus-edit-post.min.css',
				'place'     => 'admin',
				'deps'      => [],
				'version'   => '1.0.0',
				'media'     => '',
			],
		],
	],
];
