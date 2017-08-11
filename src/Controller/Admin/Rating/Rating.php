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

use Eliasis\App\App,
    Eliasis\Module\Module,
    Eliasis\Controller\Controller;
    
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

        $postID = get_the_ID();

        $isActive = $this->getRatingState($postID);

        $options = $this->model->getThemeOptions();

        $params = [

            'postID'       => $postID,
            'dark'         => $options['enable-dark'],
            'imdb_button'  => __('TOTAL', 'extensions-for-grifus-rating'),
            'is_active'    => $isActive,
            'custom_nonce' => wp_create_nonce('customRatingGrifus'),
        ];

        return $params;
    }

    /**
     * Get rating state.
     * 
     * @since 1.0.1
     *
     * @param string $postID → post id
     *
     * @return boolean → movie rating state
     */
    public function getRatingState($postID) {

        return (!$this->model->getMovieVotes($postID)) ? false : true;
    }

    /**
     * Add movie rating.
     * 
     * @since 1.0.1
     *
     * @return array → rating and total votes ['rating', 'total']
     */
    public function addMovieRating() {

        $nonce = isset($_POST['custom_nonce']) ? $_POST['custom_nonce'] : '';

        $nonce = wp_verify_nonce($nonce, 'customRatingGrifus');

        if (!$nonce || !isset($_POST['postID'], $_POST['vote'])) { die; }

        $ip = $this->getIp();

        $vote = $_POST['vote'];

        $postID = $_POST['postID'];

        $this->clearCache($postID);

        $votes = $this->model->getMovieVotes($postID);

        $votes = $this->model->setUserVote($postID, $votes, $vote, $ip);

        $response = $this->setRatingAndVotes($postID, $votes);

        echo json_encode($response, true);

        die();
    }
    
    /**
     * Get Ip.
     * 
     * @since 1.0.1
     *
     * @return string → ip
     */
    public function getIp() {

        return getenv('HTTP_CLIENT_IP')?:
        getenv('HTTP_X_FORWARDED_FOR')?:
        getenv('HTTP_X_FORWARDED')?:
        getenv('HTTP_FORWARDED_FOR')?:
        getenv('HTTP_FORWARDED')?:
        getenv('REMOTE_ADDR');
    }

    /**
     * Clear cache when updating rating.
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
     * Calculate rating.
     * 
     * @since 1.0.1
     *
     * @param array $votes → votes number
     *
     * @return int|float|string → rating
     */
    public function getMovieRating($votes) {

        $votations = [];
        
        foreach ($votes as $key => $value) {
            
            for ($i=0; $i < $value; $i++) {

               $votations[] = $key;
            }
        }

        if (count($votations)) {

            $rating = array_sum($votations) / count($votations);

            return round($rating, 1);
        }

        return 'N/A';
    }

    /**
     * Get total votes.
     * 
     * @since 1.0.1
     *
     * @param array $votes → votes
     *
     * @return int|string → total votes
     */
    public function getTotalVotes($votes = null) {

        return (array_sum(array_values($votes)));
    }

    /**
     * Restart rating when added or edited post if not done previously.
     * 
     * @since 1.0.0
     *
     * @param int $postID     → post ID
     * @param object $post    → (WP_Post) post object
     * @param boolean $update → true if update post
     *
     * @return void
     */
    public function restartRating($postID, $post, $update) {

        App::id('ExtensionsForGrifus');

        if (Module::CustomRatingGrifus()->get('restart-when-add')) { 

            # Prevent overwriting the rating when inserting or updating post
            unset($_POST['imdbRating'], $_POST['imdbVotes']);

            if (App::main()->isAfterInsertPost($post, $update)) {
                
                $votes = $this->model->getMovieVotes($postID);

                if (!$votes) {

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

                    $this->setRatingAndVotes($postID, $votes);

                    return true;
                }
            }
        }

        return false;
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

        $response['ratings_restarted'] = 0;

        $posts = $this->model->getPosts();

        foreach ($posts as $post) {

            if (isset($post->ID)) {

                if ($this->restartRating($post->ID)) {

                    $response['ratings_restarted']++;
                }
            }
        }

        echo json_encode($response);

        die();
    }

    /**
     * Update rating if the movie editing page is updated.
     * 
     * @since 1.0.1
     *
     * @param int $postID     → post ID
     * @param object $post    → (WP_Post) post object
     * @param boolean $update → true if update post
     *
     * @return boolean
     */
    public function updateRating($postID, $post, $update) {

        App::id('ExtensionsForGrifus');

        if (App::main()->isAfterUpdatePost($post, $update)) {

            if (isset($_POST['efg-update-rating'])) {

                for ($i=1; $i <= 10; $i++) {

                    if (!isset($_POST["efg-rating-$i"])) {

                        return false;
                    }
                    
                    $votes["$i"] = (int) $_POST["efg-rating-$i"];
                }

                $this->setRatingAndVotes($postID, $votes);
            }
        }

        return true;
    }

    /**
     * Restart when added a movie.
     * 
     * @since 1.0.1
     *
     * @return void
     */
    public function restartWhenAdd() {

        $state = isset($_POST['state']) ? $_POST['state'] : null;

        $nonce = wp_verify_nonce(

            isset($_POST['custom_nonce']) ? $_POST['custom_nonce'] : false, 
            'customRatingGrifusAdmin'
        );

        if (!$nonce || is_null($state)) { die; }

        App::id('ExtensionsForGrifus');

        $slug = Module::CustomRatingGrifus()->get('slug');

        $this->model->setRestartWhenAdd($slug, $state);

        $response = ['restart-when-add' => $state];

        echo json_encode($response);

        die();
    }

    /**
     * Add movie rating.
     * 
     * @since 1.0.1
     *
     * @param string $postID → post id
     * @param array  $votes  → votes
     *
     * @return array → rating and total votes
     */
    public function setRatingAndVotes($postID, $votes) {

        $totalVotes = $this->getTotalVotes($votes);

        $this->model->setMovieVotes($postID, $totalVotes);

        $this->model->setTotalVotes($postID, $votes);

        $rating = $this->getMovieRating($votes);

        $this->model->setMovieRating($postID, $rating);

        return [

            'rating' => $rating,
            'total'  => $totalVotes,
        ];
    }

    /**
     * Add meta boxes.
     * 
     * @since 1.0.1
     *
     * @param string $postType → post type
     * @param object $post     → (WP_Post) post object
     *
     * @return void
     */
    public function addMetaBoxes($postType, $post) {

        App::id('ExtensionsForGrifus');
        
        $isActive = $this->getRatingState($post->ID);

        if (App::main()->isPublishPost($post) && $isActive) {

            add_meta_box(
                'info_movie-rating-movie',
                __('Extensions For Grifus - Custom rating', 
                   'extensions-for-grifus-rating'),
                [$this, 'renderMetaBoxes'],
                $postType,
                'advanced',
                'default'
            );
        }
    }

    /**
     * Renderizate post meta boxes.
     *
     * @since 1.0.1
     *
     * @param object $post → (WP_Post) post object
     *
     * @return void
     */
    public function renderMetaBoxes($post) {

        App::id('ExtensionsForGrifus');

        wp_nonce_field('_rating_movie_nonce', 'rating_movie_nonce');

        $metaBoxes = Module::CustomRatingGrifus()->get('path','meta-boxes');
        
        $data = ['votes' => $this->model->getMovieVotes($post->ID)];

        $this->view->renderizate($metaBoxes, 'wp-insert-post', $data);  
    }
}
