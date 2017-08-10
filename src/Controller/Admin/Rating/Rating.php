<?php
/**
 * Custom Rating Grifus · Extensions For Grifus
 * 
 * @author     Josantonius - hello@josantonius.com
 * @copyright  Copyright (c) 2017
 * @license    GPL-2.0+
 * @link       https://github.com/Josantonius/Custom-Rating-Grifus.git
 * @since      1.0.0
 */

namespace ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Admin\Rating;

use Eliasis\Controller\Controller;
    
/**
 * Rating controller
 *
 * @since 1.0.0
 */
class Rating extends Controller {

    /**
     * Set movie params to use on Ajax.
     * 
     * @since 1.0.0
     *
     * @return array
     */
    public function setMovieParams() {

        return $this->model->setMovieParams();
    }
    
    /**
     * Set movie rating
     * 
     * @since 1.0.0
     *
     * @return void
     */
    public function setMovieRating() {

        $nonce = isset($_POST['custom_nonce']) ? $_POST['custom_nonce'] : '';

        if (!wp_verify_nonce($nonce, 'customRatingGrifus')) {
            
            die('Busted!');
        }

        if (!isset($_POST['postID']) || !isset($_POST['vote'])) { die; }

        $postID = $_POST['postID'];
        $vote   = $_POST['vote'];

        $this->clearCache($postID);

        $response = $this->model->setMovieRating($postID, $vote);

        echo json_encode($response, true);

        die();
    }
    
    /**
     * Set movie rating
     * 
     * @since 1.0.1
     *
     * @param string $postID → post id
     *
     * @return void
     */
    public function clearCache($postID) {

        /**
         * WP Super Cache
         */
        if (function_exists('wp_cache_post_change')) {

            wp_cache_post_change($postID);
        }
    }

    /**
     * Restart all ratings.
     * 
     * @since 1.0.0
     *
     * @return void
     */
    public function restartAllRatings() {

        $nonce = isset($_POST['custom_nonce']) ? $_POST['custom_nonce'] : '';

        if (!wp_verify_nonce( $nonce, 'customRatingGrifusAdmin')) {
            
            die('Busted!');
        }

        $response = $this->model->restartAllRatings();

        echo json_encode($response);

        die();
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
    public function restartRating($postID = 0) {

        return $this->model->restartRating($postID); 
    }
}
