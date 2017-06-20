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
     * Set movie params to use on Ajax.
     * 
     * @since 1.0.0
     *
     * @return array
     */
    public function setMovieParams() {

        $postID = get_the_ID();

        $isActive = true;

        if (empty(get_post_meta($postID, 'imdbTotalVotes',  true))) {

            $isActive = false;
        }

        $params = [

            'postID'       => $postID,
            'dark'         => get_option('activar-dark'),
            'imdb_button'  => __('TOTAL', 'grifus-copy-movie'),
            'is_active'    => $isActive,
            'custom_nonce' => wp_create_nonce('customRatingGrifus'),
        ];

        return $params;
    }
    
    /**
     * Set movie rating
     * 
     * @since 1.0.0
     *
     * @param string $postID → post id
     * @param string $postID → votes number
     *
     * @return array
     */
    public function setMovieRating($postID, $vote) {

        $ip = getenv('HTTP_CLIENT_IP')?:
        getenv('HTTP_X_FORWARDED_FOR')?:
        getenv('HTTP_X_FORWARDED')?:
        getenv('HTTP_FORWARDED_FOR')?:
        getenv('HTTP_FORWARDED')?:
        getenv('REMOTE_ADDR');

        /** Get total votes */

        $totalVotes = get_post_meta($postID, 'imdbVotes',  true );

        $totalVotes = ($totalVotes && $totalVotes !== 'N/B') ? $totalVotes : 0;

        $totalVotes = str_replace(',','', $totalVotes);

        /** Get votes by rating */

        $votes = get_post_meta($postID, 'imdbTotalVotes',  true);

        $votes = json_decode($votes, true);

        $totalVotes++;

        /** Add or update vote */
        
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

            $totalVotes--;
        }

        $votations = [];
        
        foreach ($votes as $key => $value) {
            
            for ($i=0; $i < $value; $i++) { 
               $votations[] = $key;
            }
        }

        $rating = array_sum($votations) / count($votations);

        $rating = round($rating, 1);

        $votes = json_encode($votes, true);

        $this->_updateRating($postID, $votes, $rating, $totalVotes);

        return $response = [

            'rating' => $rating,
            'total'  => $totalVotes,
        ];
    }

    /**
     * Restart all ratings.
     * 
     * @since 1.0.0
     *
     * @return int
     */
    public function restartAllRatings() {

        $response['ratings_restarted'] = 0;

        $totalPosts = wp_count_posts();

        $totalPosts = isset($totalPosts->publish) ? $totalPosts->publish : 0;

        $posts = get_posts([

            'post_type'   => 'post', 
            'numberposts' => $totalPosts,
            'post_status' => 'publish'
        ]);

        foreach ($posts as $post) {

            if (isset($post->ID)) {

                if ($this->restartRating($post->ID)) {

                    $response['ratings_restarted']++;
                }
            }
        }

        return $response;
    }

    /**
     * Restart rating.
     * 
     * @since 1.0.0
     *
     * @param string $postID → post id
     *
     * @return boolean
     */
    public function restartRating($postID = false) {

        global $post;

        $postID = ($postID) ? $postID : $post->ID;

        if (!$postID || is_null($postID)) { return false; }

        $votes = get_post_meta($postID, 'imdbTotalVotes',  true);

        if (!$votes || empty($votes) || is_null($votes)) {

            $votes = [
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

            $votes = json_encode($votes, true);

            $this->_updateRating($postID, $votes);

            return true;
        }

        return false;
    }

    /**
     * Update rating.
     * 
     * @since 1.0.0
     *
     * @param string $postID     → post id
     * @param string $votes      → votes
     * @param string $rating     → actual rating
     * @param string $totalVotes → total votes
     *
     * @return boolean
     */
    private function _updateRating($postID, $votes, $rating = 'N/A', $totalVotes = 'N/B') {

        if (!(add_post_meta($postID, 'imdbRating', $rating, true))) {

            update_post_meta($postID, 'imdbRating', $rating);
        }

        if (!(add_post_meta($postID, 'imdbTotalVotes', $votes, true))) {

            update_post_meta($postID, 'imdbTotalVotes', $votes);
        }

        if (!(add_post_meta($postID, 'imdbVotes', $totalVotes, true))) {

            update_post_meta($postID, 'imdbVotes', $totalVotes);
        }
    }
}
