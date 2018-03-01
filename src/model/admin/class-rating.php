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

namespace EFG\Modules\CustomRatingGrifus\Model\Admin;

use Eliasis\Framework\Model;

/**
 * Rating model.
 */
class Rating extends Model {

	/**
	 * Get theme options.
	 *
	 * @since 1.0.1
	 *
	 * @return array
	 */
	public function get_theme_options() {

		return [
			'enable-dark' => get_option( 'activar-dark' ),
		];
	}

	/**
	 * Get movie votes.
	 *
	 * @since 1.0.1
	 *
	 * @param string $post_id → post id.
	 *
	 * @return array|false → votes
	 */
	public function get_movie_votes( $post_id ) {

		$votes = get_post_meta( $post_id, 'imdbTotalVotes', true );

		if ( ! empty( $votes ) ) {
			return json_decode( $votes, true );
		}

		return false;
	}

	/**
	 * Set movie votes.
	 *
	 * @since 1.0.1
	 *
	 * @param string $post_id     → post id.
	 * @param int    $total_votes → number of total votes.
	 */
	public function set_movie_votes( $post_id, $total_votes ) {

		$total_votes = $total_votes ?: 'N/B';

		if ( ! add_post_meta( $post_id, 'imdbVotes', $total_votes, true ) ) {
			update_post_meta( $post_id, 'imdbVotes', $total_votes );
		}
	}

	/**
	 * Set total votes.
	 *
	 * @since 1.0.1
	 *
	 * @param string $post_id → post id.
	 * @param array  $votes  → votes.
	 */
	public function set_total_votes( $post_id, $votes ) {

		$votes = json_encode( $votes, true );

		if ( ! add_post_meta( $post_id, 'imdbTotalVotes', $votes, true ) ) {
			update_post_meta( $post_id, 'imdbTotalVotes', $votes );
		}
	}

	/**
	 * Set movie rating.
	 *
	 * @param string    $post_id  → post id.
	 * @param int|float $rating  → movie rating.
	 */
	public function set_movie_rating( $post_id, $rating ) {

		if ( ! add_post_meta( $post_id, 'imdbRating', $rating, true ) ) {
			update_post_meta( $post_id, 'imdbRating', $rating );
		}
	}

	/**
	 * Add or update vote and associate to an IP address.
	 *
	 * @since 1.0.1
	 *
	 * @param string $post_id → post id.
	 * @param array  $votes  → votes.
	 * @param array  $vote   → vote.
	 * @param array  $ip     → ip.
	 *
	 * @return array → movie votes
	 */
	public function set_user_vote( $post_id, $votes, $vote, $ip ) {

		global $wpdb;

		$table_name = $wpdb->prefix . 'efg_custom_rating';

		$result = $wpdb->get_row(
			"
            SELECT id, vote 
            FROM   $table_name 
            WHERE  ip      = '$ip'
            AND    post_id = $post_id
        "
		);

		if ( ! isset( $result->id ) && ! isset( $result->vote ) ) {

			$wpdb->insert(
				$table_name,
				[
					'post_id' => $post_id,
					'ip' => $ip,
					'vote' => $vote,
				],
				[ '%d', '%s', '%d' ]
			);

			$votes[ $vote ]++;

		} else {

			if ( $result->vote != $vote ) {

				$wpdb->update(
					$table_name,
					[
						'post_id' => $post_id,
						'ip' => $ip,
						'vote' => $vote,
					],
					[ 'id' => $result->id ],
					[ '%d', '%s', '%d' ],
					[ '%d' ]
				);

				$votes[ $result->vote ]--;
				$votes[ $vote ]++;
			}
		}

		return $votes;
	}

	/**
	 * Get publish posts.
	 *
	 * @since 1.0.1
	 *
	 * @return array → posts
	 */
	public function get_posts() {

		$total_posts = wp_count_posts();
		$total_posts = isset( $total_posts->publish ) ? $total_posts->publish : 0;

		return get_posts(
			[
				'post_type'   => 'post',
				'numberposts' => $total_posts,
				'post_status' => 'publish',
			]
		);
	}

	/**
	 * Set state for restart when added a movie.
	 *
	 * @since 1.0.1
	 *
	 * @param string  $slug  → module slug.
	 * @param boolean $state → restart when added a movie.
	 */
	public function set_restart_when_add( $slug, $state ) {

		update_option( $slug . '-restart-when-add', $state );
	}
}
