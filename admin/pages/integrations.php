<?php

$path = preg_replace('/wp-content(?!.*wp-content).*/', '', __DIR__);

if (file_exists($path . 'wp-load.php')) {
  require_once($path . 'wp-load.php');
} else {
  require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/wp-load.php');
}

echo "<h1>Integrations</h1><br>";

global $wpdb;
$table_name = $wpdb->prefix . "mumbles_maps";
$db_settings = $wpdb->get_results("SELECT * FROM $table_name");
$settings = array();

foreach($db_settings as $db_setting) {
  $settings[$db_setting->name] = $db_setting->text;
}

?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="<?php echo plugin_dir_url(__DIR__) . 'css/integrations.css' ?>">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script defer src="<?php echo plugin_dir_url(__DIR__) . 'js/integrations.js' ?>"></script>

<section>
 <div class="w-50">
  <form>
  <div class="mb-3 bg-light p-3">
    <label for="mapbox_token" class="form-label">Mapbox</label>
    <input type="text" class="form-control" id="mapbox_token" aria-describedby="mapbox_help" value="<?php if (array_key_exists("mapbox",$settings)) { echo $settings['mapbox']; } ?>">
    <div id="mapbox_help" class="form-text">Mapbox API Token. &nbsp; <a target="_blank" href="https://account.mapbox.com/access-tokens/">Create Token</a> &nbsp; <a target="_blank" href="https://docs.mapbox.com/api/accounts/tokens/">Documentation</a></div>
  </div>
  <div class="mb-3 bg-light p-3">
    <label for="google_token" class="form-label">Google Maps</label>
    <input type="text" class="form-control" id="google_token" aria-describedby="google_help" value="<?php if (array_key_exists("google",$settings)) { echo $settings['google']; } ?>">
    <div id="google_help" class="form-text">Google Maps API Key. &nbsp; <a target="_blank" href="https://console.cloud.google.com/project/_/google/maps-apis/credentials">Create Key</a> &nbsp; <a target="_blank" href="https://developers.google.com/maps/documentation/javascript/get-api-key">Documentation</a></div>
  </div>
  <button type="button" class="btn btn-primary mt-3" id="update_integrations">Update</button>
  </form>
 </div>

</section>