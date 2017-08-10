<?php
/**
 * Extensions For Grifus · Custom Rating Grifus
 * 
 * @author     Josantonius - hello@josantonius.com
 * @copyright  Copyright (c) 2017
 * @license    GPL-2.0+
 * @link       https://github.com/Josantonius/Custom-Rating-Grifus.git
 * @since      1.0.0
 */

namespace ExtensionsForGrifus\Modules\CustomRatingGrifus\Model\Admin\Rating;

use Eliasis\Model\Model;

/**
 * Rating model.
 *
 * @since 1.0.0
 */
class Rating extends Model {

    /**
     * Get theme options.
     * 
     * @since 1.0.1
     *
     * @return array
     */
    public function getThemeOptions() {

        return [

            'enable-dark' => get_option('activar-dark'),
        ];
    }

    /**
     * Get movie votes.
     * 
     * @since 1.0.1
     *
     * @param string $postID → post id
     *
     * @return array|false → votes
     */
    public function getMovieVotes($postID) {

        $votes = get_post_meta($postID, 'imdbTotalVotes', true);

        if (!empty($votes)) {

            return json_decode($votes, true);
        }

        return false;
    }

    /**
     * Set movie votes.
     * 
     * @since 1.0.1
     *
     * @param string $postID     → post id
     * @param int    $totalVotes → number of total votes
     *
     * @return void
     */
    public function setMovieVotes($postID, $totalVotes) {

        $totalVotes = $totalVotes ?: 'N/B';

        if (!add_post_meta($postID, 'imdbVotes', $totalVotes, true)) {

            update_post_meta($postID, 'imdbVotes', $totalVotes);
        }
    }

    /**
     * Set total votes.
     * 
     * @since 1.0.1
     *
     * @param string $postID → post id
     * @param array  $votes  → votes
     *
     * @return void
     */
    public function setTotalVotes($postID, $votes) {

        $votes = json_encode($votes, true);

        if (!add_post_meta($postID, 'imdbTotalVotes', $votes, true)) {

            update_post_meta($postID, 'imdbTotalVotes', $votes);
        }
    }

    /**
     * Set movie rating.
     * 
     * @since 1.0.0
     *
     * @param string    $postID  → post id
     * @param int|float $rating  → movie rating
     *
     * @return void
     */
    public function setMovieRating($postID, $rating) {

        if (!add_post_meta($postID, 'imdbRating', $rating, true)) {

            update_post_meta($postID, 'imdbRating', $rating);
        }
    }

    /**
     * Add or update vote and associate to an IP address.
     * 
     * @since 1.0.1
     *
     * @param string $postID → post id
     * @param array  $votes  → votes
     * @param array  $vote   → vote
     * @param array  $ip     → ip
     *
     * @return array → movie votes
     */
    public function setUserVote($postID, $votes, $vote, $ip) {
        
        global $wpdb;

        $tableName = $wpdb->prefix . 'efg_custom_rating';

        $result = $wpdb->get_row("
            SELECT id, vote 
            FROM   $tableName 
            WHERE  ip      = '$ip'
            AND    post_id = $postID
        ");

        if (!isset($result->id) && !isset($result->vote)) {

            $wpdb->insert( 
                $tableName, 
                ['post_id' => $postID, 'ip' => $ip, 'vote' => $vote],
                ['%d', '%s', '%d']
            );

            $votes[$vote]++;
        
        } else {

            if ($result->vote != $vote) {

                $wpdb->update( 
                    $tableName, 
                    ['post_id' => $postID, 'ip' => $ip, 'vote' => $vote],
                    ['id' => $result->id],
                    ['%d', '%s', '%d'],
                    ['%d']
                );
                
                $votes[$result->vote]--;

                $votes[$vote]++;
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
    public function getPosts() {

        $totalPosts = wp_count_posts();

        $totalPosts = isset($totalPosts->publish) ? $totalPosts->publish : 0;

        return get_posts([

            'post_type'   => 'post', 
            'numberposts' => $totalPosts,
            'post_status' => 'publish'
        ]);
    }

    /**
     * Set state for restart when added a movie.
     * 
     * @since 1.0.1
     *
     * @param string  $slug  → module slug
     * @param boolean $state → restart when added a movie
     *
     * @return void
     */
    public function setRestartWhenAdd($slug, $state) {

        update_option($slug . '-restart-when-add', $state);
    }
}
