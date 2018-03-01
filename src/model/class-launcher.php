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

namespace EFG\Modules\CustomRatingGrifus\Model;

use Eliasis\Framework\Model;
use Eliasis\Complement\Type\Module;

/**
 * Module main model.
 */
class Launcher extends Model {

	/**
	 * Create database tables.
	 */
	public function create_tables() {

		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();

		$table_name = $wpdb->prefix . 'efg_custom_rating';

		if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) != $table_name ) {
			$sql = "CREATE TABLE $table_name (
	          id      mediumint(9) NOT NULL AUTO_INCREMENT,
	          post_id mediumint(9) NOT NULL,
	          ip      varchar(45)  NOT NULL,
	          vote    int(2)       NOT NULL,
	          PRIMARY KEY  (id)
	        ) $charset_collate;";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

			dbDelta( $sql );
		}
	}

	/**
	 * Set database module options.
	 *
	 * @since 1.0.1
	 */
	public function add_options() {

		$slug = Module::CustomRatingGrifus()->getOption( 'slug' );

		if ( ! get_option( $slug . '-restart-when-add' ) ) {
			add_option( $slug . '-restart-when-add', 1 );
		}
	}

	/**
	 * Get database module options.
	 *
	 * @since 1.0.1
	 *
	 * @uses get_option()
	 *
	 * @return array
	 */
	public function get_options() {

		$slug = Module::CustomRatingGrifus()->getOption( 'slug' );

		return [
			'restart-when-add' => get_option( $slug . '-restart-when-add' ),
		];
	}

	/**
	 * Delete database module options.
	 *
	 * @since 1.0.1
	 */
	public function delete_options() {

		$slug = Module::CustomRatingGrifus()->getOption( 'slug' );

		delete_option( $slug . '-restart-when-add', true );
	}

	/**
	 * Remove database tables.
	 */
	public function remove_tables() {

		global $wpdb;

		$table_name = $wpdb->prefix . 'efg_custom_rating';
		$wpdb->query( "DROP TABLE IF EXISTS $table_name" );
	}

	/**
	 * Delete post meta by key.
	 */
	public function delete_post_meta() {

		delete_post_meta_by_key( 'imdbTotalVotes' );
	}
}
