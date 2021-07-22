<?php

/**
 * Fired during plugin activation
 *
 * @link       httsp://ranked.do
 * @since      1.0.0
 *
 * @package    Mumbles_Maps
 * @subpackage Mumbles_Maps/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Mumbles_Maps
 * @subpackage Mumbles_Maps/includes
 * @author     Mumbles Ginebra <miltonjginebra@gmail.com>
 */
class Mumbles_Maps_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

	  global $wpdb;

   	  $table_name = $wpdb->prefix . "mumbles_maps"; 

	  $charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		  name tinytext NOT NULL,
		  text text NOT NULL,
		  url varchar(55) DEFAULT '' NOT NULL,
		  PRIMARY KEY  (id)
		) $charset_collate;";
		 
		 require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		 dbDelta( $sql );

	  $mapbox_db_name = 'mapbox';
	  $mapbox_db_text = '';

	  $wpdb->insert( 
	    $table_name, 
	    array( 
		  'time' => current_time( 'mysql' ), 
		  'name' => $mapbox_db_name, 
		  'text' => $mapbox_db_text, 
	    ) 
      );
	}

}
