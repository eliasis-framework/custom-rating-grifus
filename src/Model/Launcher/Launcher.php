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

namespace ExtensionsForGrifus\Modules\CustomRatingGrifus\Model\Launcher;

use Eliasis\Model\Model;
    
/**
 * Module main model.
 *
 * @since 1.0.0
 */
class Launcher extends Model {

    /**
     * Create database tables.
     * 
     * @since 1.0.0
     */
    public function createTables() {

        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $tableName = $wpdb->prefix . 'efg_custom_rating';

        $sql = "CREATE TABLE IF NOT EXISTS $tableName (
          id      mediumint(9) NOT NULL AUTO_INCREMENT,
          post_id mediumint(9) NOT NULL,
          ip      varchar(15)  NOT NULL,
          vote    int(2)       NOT NULL,
          PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta($sql);
    }

    /**
     * Remove database tables.
     * 
     * @since 1.0.0
     */
    public function removeTables() {
        
        global $wpdb;
        
        $tableName = $wpdb->prefix . 'efg_custom_rating';
        
        $wpdb->query("DROP TABLE IF EXISTS $tableName");
    }

    /**
     * Delete post meta by key.
     * 
     * @since 1.0.0
     */
    public function deletePostMeta() {

        delete_post_meta_by_key('imdbTotalVotes');
    }
}
