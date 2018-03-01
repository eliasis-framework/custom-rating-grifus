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

namespace EFG\Modules\CustomRatingGrifus\Controller;

use Josantonius\WP_Register\WP_Register;
use Eliasis\Complement\Type\Module;
use Eliasis\Framework\Controller;
use Eliasis\Framework\App;

/**
 * Module main controller.
 */
class Launcher extends Controller {

	/**
	 * Instance of Rating class.
	 *
	 * @var object
	 */
	public $rating;

	/**
	 * Class initializer method.
	 *
	 * @return boolean
	 */
	public function init() {

		$state = Module::CustomRatingGrifus()->getOption( 'state' );

		if ( 'active' === $state || 'outdated' === $state ) {
			App::setCurrentID( 'EFG' );
			$this->rating = Module::CustomRatingGrifus()->getControllerInstance( 'Rating' );

			add_action( 'init', [ $this, 'set_language' ] );
			$this->run_ajax();
			if ( is_admin() ) {
				return $this->admin();
			}

			$this->front();
		}
	}

	/**
	 * Module activation hook. Executed when module is activated.
	 */
	public function activation() {

		$this->model->add_options();
		$this->model->create_tables();
	}

	/**
	 * Module uninstallation hook. Executed when module is uninstalled.
	 */
	public function uninstallation() {

		$this->model->delete_post_meta();
		$this->model->delete_options();
		$this->model->remove_tables();
	}

	/**
	 * Set plugin textdomain.
	 */
	public function set_language() {

		$plugin_slug = App::EFG()->getOption( 'slug' );
		$module_slug = Module::CustomRatingGrifus()->getOption( 'slug' );
		$path = $plugin_slug . '/modules/' . $module_slug . '/languages/';

		load_plugin_textdomain( $plugin_slug . '-rating', false, $path );
	}

	/**
	 * Run ajax when change the rating.
	 */
	public function run_ajax() {

		$methods = [ 'add_movie_rating' ];

		foreach ( $methods as $method ) {
			add_action( 'wp_ajax_' . $method, [ $this->rating, $method ] );
			add_action( 'wp_ajax_nopriv_' . $method, [ $this->rating, $method ] );
		}
	}

	/**
	 * Admin initializer method.
	 *
	 * @uses add_action() → hooks a function on to a specific action
	 */
	public function admin() {

		$this->set_options();

		$namespace = Module::CustomRatingGrifus()->getOption( 'namespaces' );
		$module_pages = Module::CustomRatingGrifus()->getOption( 'pages' );

		App::main()->set_menus( $module_pages, $namespace['admin-page'] );

		add_action( 'add_meta_boxes', [ $this->rating, 'add_meta_boxes' ], 10, 2 );
		add_action( 'save_post', [ $this->rating, 'restart_rating' ], 1, 3 );
		add_action( 'save_post', [ $this->rating, 'update_rating' ], 10, 3 );
	}

	/**
	 * Set database module options.
	 *
	 * @since 1.0.1
	 */
	public function set_options() {

		$slug = Module::CustomRatingGrifus()->getOption( 'slug' );
		$options = $this->model->get_options();

		foreach ( $options as $option => $value ) {
			Module::CustomRatingGrifus()->setOption( $option, $value );
		}
	}

	/**
	 * Front initializer method.
	 */
	public function front() {

		add_action(
			'wp', function() {
				App::setCurrentID( 'EFG' );
				if ( App::main()->is_single() && ! is_preview() ) {
					$this->add_scripts( 'customRatingGrifus' );
					$this->add_styles();
				} else if ( is_home() || is_category() || is_archive() || is_search() ) {
					$this->add_scripts( 'customRatingGrifusHome' );
				}
			}
		);
	}

	/**
	 * Add scripts.
	 *
	 * @param string $name → script name.
	 */
	protected function add_scripts( $name ) {

		$params = $this->rating->set_movie_params();
		$settings = Module::CustomRatingGrifus()->getOption( 'assets', 'js', $name );
		$settings['params'] = array_merge( $settings['params'], $params );

		WP_Register::add( 'script', $settings );
	}

	/**
	 * Add styles.
	 */
	protected function add_styles() {

		$css = Module::CustomRatingGrifus()->getOption( 'assets', 'css' );

		WP_Register::add(
			'style',
			$css['customRatingGrifus']
		);
	}
}
