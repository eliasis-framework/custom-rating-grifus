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

namespace EFG\Modules\CustomRatingGrifus\Controller\Admin;

use Eliasis\Framework\App;
use Eliasis\Complement\Type\Module;
use Eliasis\Framework\Controller;
use Josantonius\WP_Register\WP_Register;

/**
 * Rating controller
 */
class Rating extends Controller {

	/**
	 * Set movie params to use on Ajax.
	 *
	 * @return array
	 */
	public function set_movie_params() {

		$post_id = get_the_ID();
		$is_active = $this->get_rating_state( $post_id );
		$options = $this->model->get_theme_options();

		$params = [
			'postID'       => $post_id,
			'dark'         => $options['enable-dark'],
			'imdb_button'  => __( 'TOTAL', 'extensions-for-grifus-rating' ),
			'is_active'    => $is_active,
		];

		return $params;
	}

	/**
	 * Get rating state.
	 *
	 * @since 1.0.1
	 *
	 * @param string $post_id → post id.
	 *
	 * @return boolean → movie rating state
	 */
	public function get_rating_state( $post_id ) {

		return ( ! $this->model->get_movie_votes( $post_id ) ) ? false : true;
	}

	/**
	 * Add movie rating.
	 *
	 * @since 1.0.1
	 */
	public function add_movie_rating() {

		$nonce = isset( $_POST['nonce'] ) ? $_POST['nonce'] : '';

		if ( ! wp_verify_nonce( $nonce, 'eliasis' ) && ! wp_verify_nonce( $nonce, 'customRatingGrifus' ) ) {
			die( 'Busted!' );
		}

		$ip = $this->get_ip();
		$vote = $_POST['vote'];
		$post_id = $_POST['postID'];

		$this->clear_cache( $post_id );

		$votes = $this->model->get_movie_votes( $post_id );
		$votes = $this->model->set_user_vote( $post_id, $votes, $vote, $ip );
		$response = $this->set_rating_and_votes( $post_id, $votes );

		echo json_encode( $response, true );

		die();
	}

	/**
	 * Get Ip.
	 *
	 * @since 1.0.1
	 *
	 * @return string → ip
	 */
	public function get_ip() {

		return getenv( 'HTTP_CLIENT_IP' ) ?:
		getenv( 'HTTP_X_FORWARDED_FOR' ) ?:
		getenv( 'HTTP_X_FORWARDED' ) ?:
		getenv( 'HTTP_FORWARDED_FOR' ) ?:
		getenv( 'HTTP_FORWARDED' ) ?:
		getenv( 'REMOTE_ADDR' );
	}

	/**
	 * Clear cache (WP Super Cache) when updating rating.
	 *
	 * @since 1.0.1
	 *
	 * @param string $post_id → post id.
	 */
	public function clear_cache( $post_id ) {

		if ( function_exists( 'wp_cache_post_change' ) ) {
			wp_cache_post_change( $post_id );
		}
	}

	/**
	 * Calculate rating.
	 *
	 * @since 1.0.1
	 *
	 * @param array $votes → votes number.
	 *
	 * @return int|float|string → rating
	 */
	public function get_movie_rating( $votes ) {

		$votations = [];

		foreach ( $votes as $key => $value ) {
			for ( $i = 0; $i < $value; $i++ ) {
				$votations[] = $key;
			}
		}

		if ( count( $votations ) ) {
			$rating = array_sum( $votations ) / count( $votations );
			return round( $rating, 1 );
		}

		return 'N/A';
	}

	/**
	 * Get total votes.
	 *
	 * @since 1.0.1
	 *
	 * @param array $votes → votes.
	 *
	 * @return int|string → total votes
	 */
	public function get_total_votes( $votes = null ) {

		return ( array_sum( array_values( $votes ) ) );
	}

	/**
	 * Restart rating when added or edited post if not done previously.
	 *
	 * @param int     $post_id → post ID.
	 * @param object  $post    → (WP_Post) post object.
	 * @param boolean $update  → true if update post.
	 */
	public function restart_rating( $post_id, $post, $update ) {

		App::setCurrentID( 'EFG' );

		if ( Module::CustomRatingGrifus()->getOption( 'restart-when-add' ) ) {
			unset( $_POST['imdbRating'], $_POST['imdbVotes'] );
			if ( App::main()->is_after_insert_post( $post, $update ) ) {
				if ( ! $this->model->get_movie_votes( $post_id ) ) {
					$votes = $this->get_default_votes( $post_id );
					$this->set_rating_and_votes( $post_id, $votes );
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * Restart all ratings.
	 */
	public function restart_all_ratings() {

		$nonce = isset( $_POST['nonce'] ) ? $_POST['nonce'] : '';

		if ( ! wp_verify_nonce( $nonce, 'eliasis' ) && ! wp_verify_nonce( $nonce, 'customRatingGrifusAdmin' ) ) {
			die( 'Busted!' );
		}

		$response['ratings_restarted'] = 0;
		$posts = $this->model->get_posts();

		foreach ( $posts as $post ) {
			if ( isset( $post->ID ) && ! $this->model->get_movie_votes( $post->ID ) ) {
				$this->set_rating_and_votes(
					$post->ID,
					$this->get_default_votes( $post->ID )
				);
				$response['ratings_restarted']++;
			}
		}

		echo json_encode( $response );

		die();
	}

	/**
	 * Update rating if the movie editing page is updated.
	 *
	 * @since 1.0.1
	 *
	 * @param int     $post_id → post ID.
	 * @param object  $post    → (WP_Post) post object.
	 * @param boolean $update  → true if update post.
	 *
	 * @return boolean
	 */
	public function update_rating( $post_id, $post, $update ) {

		App::setCurrentID( 'EFG' );

		if ( App::main()->is_after_update_post( $post, $update ) ) {
			if ( isset( $_POST['efg-update-rating'] ) ) {
				for ( $i = 1; $i <= 10; $i++ ) {
					if ( ! isset( $_POST[ "efg-rating-$i" ] ) ) {
						return false;
					}
					$votes[ "$i" ] = (int) $_POST[ "efg-rating-$i" ];
				}
				$this->set_rating_and_votes( $post_id, $votes );
			}
		}

		return true;
	}

	/**
	 * Restart when added a movie.
	 *
	 * @since 1.0.1
	 */
	public function restart_when_add() {

		$state = isset( $_POST['state'] ) ? $_POST['state'] : null;
		$nonce = isset( $_POST['nonce'] ) ? $_POST['nonce'] : '';

		if ( ! wp_verify_nonce( $nonce, 'eliasis' ) && ! wp_verify_nonce( $nonce, 'customRatingGrifusAdmin' ) ) {
			die( 'Busted!' );
		}

		App::setCurrentID( 'EFG' );
		$slug = Module::CustomRatingGrifus()->getOption( 'slug' );
		$this->model->set_restart_when_add( $slug, $state );
		$response = [ 'restart-when-add' => $state ];

		echo json_encode( $response );

		die();
	}

	/**
	 * Get default votes.
	 *
	 * @since 1.0.1
	 *
	 * @param int $post_id → post ID
	 *
	 * @return array → default votes
	 */
	public function get_default_votes( $post_id ) {

		return [
			'1'  => 0,
			'2'  => 0,
			'3'  => 0,
			'4'  => 0,
			'5'  => 0,
			'6'  => 0,
			'7'  => 0,
			'8'  => 0,
			'9'  => 0,
			'10' => 0,
		];
	}

	/**
	 * Add movie rating.
	 *
	 * @since 1.0.1
	 *
	 * @param string $post_id → post id.
	 * @param array  $votes  → votes.
	 *
	 * @return array → rating and total votes
	 */
	public function set_rating_and_votes( $post_id, $votes ) {

		$total_votes = $this->get_total_votes( $votes );

		$this->model->set_movie_votes( $post_id, $total_votes );
		$this->model->set_total_votes( $post_id, $votes );

		$rating = $this->get_movie_rating( $votes );

		$this->model->set_movie_rating( $post_id, $rating );

		return [
			'rating' => $rating,
			'total'  => $total_votes,
		];
	}

	/**
	 * Add meta boxes.
	 *
	 * @since 1.0.1
	 *
	 * @param string $post_type → post type.
	 * @param object $post     → (WP_Post) post object.
	 */
	public function add_meta_boxes( $post_type, $post ) {

		App::setCurrentID( 'EFG' );

		$is_active = $this->get_rating_state( $post->ID );

		if ( App::main()->is_publish_post( $post ) && $is_active ) {

			$this->add_styles();
			$this->add_scripts();

			add_meta_box(
				'info_movie-rating-movie',
				__(
					'Extensions For Grifus - Custom rating',
					'extensions-for-grifus-rating'
				),
				[ $this, 'render_meta_boxes' ],
				$post_type,
				'normal',
				'high'
			);
		}
	}

	/**
	 * Renderizate post meta boxes.
	 *
	 * @since 1.0.1
	 *
	 * @param object $post → (WP_Post) post object.
	 */
	public function render_meta_boxes( $post ) {

		App::setCurrentID( 'EFG' );

		wp_nonce_field( '_rating_movie_nonce', 'rating_movie_nonce' );

		$meta_boxes = Module::CustomRatingGrifus()->getOption( 'path', 'meta-boxes' );
		$data = [ 'votes' => $this->model->get_movie_votes( $post->ID ) ];

		$this->view->renderizate( $meta_boxes, 'wp-insert-post', $data );
	}

	/**
	 * Add scripts.
	 *
	 * @since 1.0.2
	 */
	protected function add_scripts() {

		$script = 'customRatingGrifusEditPost';

		$params = [

			'votes'  => __( 'votes', 'extensions-for-grifus-rating' ),
			'rating' => __( 'Rating', 'extensions-for-grifus-rating' ),
		];

		$settings = Module::CustomRatingGrifus()->getOption( 'assets', 'js', $script );
		$settings['params'] = array_merge( $settings['params'], $params );

		WP_Register::add( 'script', $settings );
	}

	/**
	 * Add styles.
	 *
	 * @since 1.0.2
	 */
	protected function add_styles() {

		$css = 'customRatingGrifusEditPost';

		WP_Register::add(
			'style',
			Module::CustomRatingGrifus()->getOption( 'assets', 'css', $css )
		);
	}
}
