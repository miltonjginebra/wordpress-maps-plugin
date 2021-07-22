<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       httsp://ranked.do
 * @since      1.0.0
 *
 * @package    Mumbles_Maps
 * @subpackage Mumbles_Maps/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mumbles_Maps
 * @subpackage Mumbles_Maps/admin
 * @author     Mumbles Ginebra <miltonjginebra@gmail.com>
 */
class Mumbles_Maps_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mumbles_Maps_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mumbles_Maps_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mumbles-maps-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mumbles_Maps_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mumbles_Maps_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mumbles-maps-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function mumbles_maps_admin_menu()
	{
		// add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
		add_menu_page('Mumbles Maps', 'Maps', 'manage_options', $this->plugin_name . '-settings', array($this, 'mumbles_maps_settings_page'), 'data:image/svg+xml;base64,' . base64_encode('<svg width="20" height="20" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path fill="black" d="M1152 640q0-106-75-181t-181-75-181 75-75 181 75 181 181 75 181-75 75-181zm256 0q0 109-33 179l-364 774q-16 33-47.5 52t-67.5 19-67.5-19-46.5-52l-365-774q-33-70-33-179 0-212 150-362t362-150 362 150 150 362z"/></svg>'), 2);
		add_submenu_page($this->plugin_name . '-settings', 'Settings', 'Settings', 'manage_options', $this->plugin_name . '-settings');
		add_submenu_page($this->plugin_name . '-settings', 'Integrations', 'Integrations', 'manage_options', $this->plugin_name . '-integrations', array($this, 'mumbles_maps_integrations_page'));
	}

	public function mumbles_maps_settings_page()
	{
		include(plugin_dir_path(__FILE__) . 'pages/settings.php');
	}

	public function mumbles_maps_integrations_page()
	{
		include(plugin_dir_path(__FILE__) . 'pages/integrations.php');
	}

	

	public function add_map_shortcode() {

		function add_mapbox_map_shortcode() {
			global $wpdb;
			$table_name = $wpdb->prefix . "mumbles_maps";
			$mapbox_enabled = $wpdb->get_var("SELECT text FROM $table_name WHERE name = 'mapbox_enabled'");
			$mapbox_db_key = $wpdb->get_var("SELECT text FROM $table_name WHERE name = 'mapbox'");
																										
			if ($mapbox_enabled == 'checked') { 

			?>
			<script src='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js'></script>
			<link href='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.css' rel='stylesheet' />
			<p><?php //echo $mapbox_db_key ?></p>

			<h3>Mapbox</h3>
			<p><?php echo 'Mapbox: ' . $mapbox_enabled ?></p>
			<br>
			<div id='map' style='width: 400px; height: 300px;'></div>

			<script>

			  //Mapbox
			  var bounds = [
				[-71.76469226881964, 17.523862538039353], // southwest coordinates
				[-68.18559555859032, 20.02478182486753] // northeast coordinates
			  ];
			  mapboxgl.accessToken = "<?php echo $mapbox_db_key ?>";
			  var map = new mapboxgl.Map({
			  container: 'map', // container id
			  style: 'mapbox://styles/mapbox/streets-v11', // style URL
			  center: [-69.94072463371127, 18.484209440075816], // starting position [lng, lat]
			  zoom: 7, // starting zoom
			  maxBounds: bounds // set the map's geographical bounds
			  });
			  map.addControl(new mapboxgl.GeolocateControl({
				positionOptions: {
				enableHighAccuracy: true
				},
				trackUserLocation: true
			  }));
			</script>
			<?php 

			} else {
			?>
			  <p>Mapbox map is disabled in settings</p>
			<?php
			  return;
			}

		}
		
		add_shortcode( 'mumbles_mapbox_map', 'add_mapbox_map_shortcode' );

		function add_google_map_shortcode() {
			global $wpdb;
			$table_name = $wpdb->prefix . "mumbles_maps";
			$google_enabled = $wpdb->get_var("SELECT text FROM $table_name WHERE name = 'google_enabled'");
			$google_db_key = $wpdb->get_var("SELECT text FROM $table_name WHERE name = 'google'");
																										
			if ($google_enabled == 'checked') { 

			?>

			<script>
			  	function initMap() {
				// The location of Uluru
				const santoDomingo = { lat: 18.484209440075816, lng: -69.94072463371127 };
				// The map, centered at Uluru
				const map = new google.maps.Map(document.getElementById("google_map"), {
				  zoom: 7,
				  center: santoDomingo,
				});
				// The marker, positioned at Uluru
				const marker = new google.maps.Marker({
				  position: santoDomingo,
				  map: map,
				});
			  }

			</script>


			<h3>Google Maps</h3>
    		<!--The div element for the map -->
			<p><?php echo 'Google Maps: ' . $google_enabled ?></p>
			<br>
    		<div id="google_map" style='width: 400px; height: 300px;'></div>


			<script
      		src= "https://maps.googleapis.com/maps/api/js?key=<?php echo $google_db_key ?>&callback=initMap&libraries=&v=weekly"
      		async
    		></script>
			
			<?php 

			} else {
			?>
			  <p>Google Maps is disabled in settings</p>
			<?php
			  return;
			}

		}
		
		add_shortcode( 'mumbles_google_map', 'add_google_map_shortcode' );
	}

}
