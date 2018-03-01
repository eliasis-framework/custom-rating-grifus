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

namespace EFG\Modules\CustomRatingGrifus\Controller\Admin\Page;

use Josantonius\WP_Register\WP_Register;
use Josantonius\WP_Menu\WP_Menu;
use Eliasis\Framework\App;
use Eliasis\Complement\Type\Module;
use Eliasis\Framework\Controller;

/**
 * Handler Custom Rating Grifus page.
 */
class CustomRating extends Controller {

	/**
	 * Slug for this administration page.
	 *
	 * @var string
	 */
	public $slug = 'custom-rating-grifus';

	/**
	 * Class initializer method.
	 */
	public function init() {

		$this->run_ajax();
	}

	/**
	 * Add submenu for this page.
	 *
	 * @uses add_submenu_page() → add a submenu page
	 */
	public function set_submenu() {

		$submenu = Module::CustomRatingGrifus()->getOption( 'submenu' );

		WP_Menu::add(
			'submenu',
			$submenu['custom-rating-grifus'],
			[ $this, 'render' ],
			[ $this, 'add_scripts' ],
			[ $this, 'add_styles' ]
		);
	}

	/**
	 * Load scripts.
	 */
	public function add_scripts() {

		$js = App::EFG()->getOption( 'assets', 'js' );

		WP_Register::add(
			'script',
			$js['eliasisMaterial']
		);

		WP_Register::add(
			'script',
			$js['extensionsForGrifusAdmin']
		);

		$js = Module::CustomRatingGrifus()->getOption( 'assets', 'js' );

		$settings = $js['customRatingGrifusAdmin'];

		$params = [
			'revised_text' => __(
				'Films were reviewed',
				'extensions-for-grifus-rating'
			),
		];

		$settings['params'] = array_merge( $settings['params'], $params );

		WP_Register::add( 'script', $settings );
	}

	/**
	 * Load styles.
	 */
	public function add_styles() {

		$css = App::EFG()->getOption( 'assets', 'css' );

		WP_Register::add(
			'style',
			$css['extensionsForGrifusAdmin']
		);

		WP_Register::add(
			'style',
			Module::CustomRatingGrifus()->getOption(
				'assets', 'css', 'customRatingGrifusAdmin'
			)
		);
	}

	/**
	 * Renderizate admin page.
	 */
	public function render() {

		$layout = App::EFG()->getOption( 'path', 'layout' );
		$page = Module::CustomRatingGrifus()->getOption( 'path', 'page' );
		$restart = Module::CustomRatingGrifus()->getOption( 'restart-when-add' );
		$data = [ 'restart-when-add' => $restart ];

		$this->view->renderizate( $layout, 'header' );
		$this->view->renderizate( $page, 'custom-rating', $data );
		$this->view->renderizate( $layout, 'footer' );
	}

	/**
	 * Run ajax when change the rating.
	 *
	 * @since 1.0.0
	 */
	public function run_ajax() {

		$rating = Module::CustomRatingGrifus()->getControllerInstance( 'Rating' );

		add_action( 'wp_ajax_restart_all_ratings', [ $rating, 'restart_all_ratings' ] );
		add_action( 'wp_ajax_restart_when_add', [ $rating, 'restart_when_add' ] );
	}
}
