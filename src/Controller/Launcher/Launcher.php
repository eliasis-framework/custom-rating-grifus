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

namespace ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Launcher;

use Josantonius\WP_Register\WP_Register,
    Eliasis\Module\Module,
    Eliasis\Controller\Controller,
    Eliasis\App\App;
    
/**
 * Module main controller.
 *
 * @since 1.0.0
 */
class Launcher extends Controller {

    /**
     * Instance of Rating class.
     *
     * @since 1.0.0
     *
     * @var object
     */
    public $Rating;
    
    /**
     * Class initializer method.
     * 
     * @since 1.0.0
     *
     * @return boolean
     */
    public function init() {

        if (Module::CustomRatingGrifus()->get('state') === 'active') {

            App::id('ExtensionsForGrifus');

            $this->Rating = Module::CustomRatingGrifus()->instance('Rating');

            add_action('init', [$this, 'setLanguage']);

            $this->runAjax(); 

            if (is_admin()) {

                return $this->admin();
            } 

            $this->front();
        }
    }

    /**
     * Module activation hook. Executed when module is activated.
     * 
     * @since 1.0.0
     */
    public function activation() {

        $this->model->createTables();
    }

    /**
     * Module uninstallation hook. Executed when module is uninstalled.
     * 
     * @since 1.0.0
     */
    public function uninstallation() {

        $this->model->deletePostMeta();

        $this->model->removeTables();
    }

    /**
     * Set plugin textdomain.
     * 
     * @since 1.0.0
     */
    public function setLanguage() {

        $DS = App::DS;

        $pSlug = App::ExtensionsForGrifus()->get('slug');

        $mSlug = Module::CustomRatingGrifus()->get('slug');

        $path = $pSlug . $DS .'modules' .$DS. $mSlug .$DS. 'languages' . $DS;

        load_plugin_textdomain($pSlug . '-rating', false, $path);
    }

    /**
     * Run ajax when change the rating.
     * 
     * @since 1.0.0
     */
    public function runAjax() {

        $method = [$this->Rating, 'setMovieRating'];

        add_action('wp_ajax_setMovieRating',        $method);
        add_action('wp_ajax_nopriv_setMovieRating', $method);
    }
    
    /**
     * Admin initializer method.
     * 
     * @since 1.0.0
     * 
     * @uses add_action() → hooks a function on to a specific action
     */
    public function admin() {

        $namespace = Module::CustomRatingGrifus()->get('namespaces');

        $modulePages = Module::CustomRatingGrifus()->get('pages');

        App::main()->setMenus($modulePages ,$namespace['admin-page']);

        $this->restartRating();
    }

    /**
     * Restart rating when added or edited post if not done previously.
     * 
     * @since 1.0.0
     */
    public function restartRating() {

        add_action('wp_insert_post', function() {

            App::id('ExtensionsForGrifus');

            if (App::main()->isAfterInsertPost()) {

                $this->Rating->restartRating();
            }
        });
    }

    /**
     * Front initializer method.
     * 
     * @since 1.0.0
     */
    public function front() {
   
        add_action('wp', function() {

            App::id('ExtensionsForGrifus');

            if (App::main()->isSingle()) {

                $this->addScripts('customRatingGrifus');

                $this->addStyles();
            
            } else if (is_home() || is_category()) {

                $this->addScripts('customRatingGrifusHome');
            }
        }); 
    }

    /**
     * Add scripts.
     * 
     * @since 1.0.0
     *
     * @param string $name → script name
     */
    protected function addScripts($name) {

        $params = Module::CustomRatingGrifus()->instance('Rating')
                                              ->setMovieParams();
        
        $settings = Module::CustomRatingGrifus()->get('assets', 'js',$name);

        $settings['params'] = array_merge($settings['params'], $params);

        WP_Register::add('script', $settings);
    }

    /**
     * Add styles.
     * 
     * @since 1.0.0
     */
    protected function addStyles() {

        $css = Module::CustomRatingGrifus()->get('assets', 'css');

        WP_Register::add(
            'style',  
            $css['customRatingGrifus']
        );
    }
}
