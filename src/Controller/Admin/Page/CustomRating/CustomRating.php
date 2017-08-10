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

namespace ExtensionsForGrifus\Modules\CustomRatingGrifus\Controller\Admin\Page\CustomRating;

use Josantonius\WP_Register\WP_Register,
    Josantonius\WP_Menu\WP_Menu,
    Eliasis\App\App,
    Eliasis\Module\Module,
    Eliasis\Controller\Controller;

/**
 * Handler Custom Rating Grifus page.
 *
 * @since 1.0.0
 */
class CustomRating extends Controller {

    /**
     * Slug for this administration page.
     *
     * @since 1.0.0
     */
    public $slug = 'custom-rating-grifus';

    /**
     * Class initializer method.
     *
     * @since 1.0.0
     */
    public function init() {

        $this->runAjax(); 
    }

    /**
     * Add submenu for this page.
     *
     * @since 1.0.0
     *
     * @uses add_submenu_page() → add a submenu page
     */
    public function setSubmenu() {

        $submenu = Module::CustomRatingGrifus()->get('submenu');

        WP_Menu::add(
            'submenu', 
            $submenu['custom-rating-grifus'], 
            [$this, 'render']
        );
    }

    /**
     * Load scripts.
     *
     * @since 1.0.0
     */
    public function addScripts() {

        $js = App::ExtensionsForGrifus()->get('assets', 'js');

        WP_Register::add(
            'script', 
            $js['eliasisMaterial']
        );

        WP_Register::add(
            'script', 
            $js['extensionsForGrifusAdmin']
        );

        $js = Module::CustomRatingGrifus()->get('assets', 'js');

        $settings = $js['customRatingGrifusAdmin'];

        $params = [
            'revised_text' => __(
                'Films were reviewed', 
                'extensions-for-grifus-rating'
            ),
            'custom_nonce' => wp_create_nonce('customRatingGrifusAdmin'),
        ];

        $settings['params'] = array_merge($settings['params'], $params);

        WP_Register::add('script', $settings);
    }

    /**
     * Load styles.
     *
     * @since 1.0.0
     */
    public function addStyles() {

        $css = App::ExtensionsForGrifus()->get('assets', 'css');

        WP_Register::add(
            'style',  
            $css['extensionsForGrifusAdmin']
        );

        WP_Register::add(
            'style',  
            Module::CustomRatingGrifus()->get(
                'assets', 'css', 'customRatingGrifusAdmin'
            )
        );
    }

    /**
     * Renderizate admin page.
     *
     * @since 1.0.0
     */
    public function render() {

        $layout = App::ExtensionsForGrifus()->get('path', 'layout');

        $page = Module::CustomRatingGrifus()->get('path','page');

        $restart = Module::CustomRatingGrifus()->get('restart-when-add');

        $data = ['restart-when-add' => $restart];

        $this->view->renderizate($layout, 'header');
        $this->view->renderizate($page,   'custom-rating', $data);
        $this->view->renderizate($layout, 'footer');       
    }

    /**
     * Run ajax when change the rating.
     * 
     * @since 1.0.0
     */
    public function runAjax() {

        $Rating = Module::CustomRatingGrifus()->instance('Rating');

        add_action('wp_ajax_restartAllRatings',[$Rating, 'restartAllRatings']);
        add_action('wp_ajax_restartWhenAdd',[$Rating, 'restartWhenAdd']);
    }
}
