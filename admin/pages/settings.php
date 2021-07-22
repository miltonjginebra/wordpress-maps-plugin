<?php

global $wpdb;
$table_name = $wpdb->prefix . "mumbles_maps";
$db_settings = $wpdb->get_results("SELECT * FROM $table_name");
$settings = array();

foreach($db_settings as $db_setting) {
  $settings[$db_setting->name] = $db_setting->text;
}

$woocommerce_is_active = class_exists( 'woocommerce' ) ? $woocommerce_is_active = true : $woocommerce_is_active = false;

?>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo plugin_dir_url(__DIR__) . 'css/settings.css' ?>">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script defer src="<?php echo plugin_dir_url(__DIR__) . 'js/settings.js' ?>"></script>

<section>

  <h1 class="mb-3">Settings</h1>

  <!-- Modal -->
    <div class="modal fade" id="settings_updated_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="settings_updated_modal_header"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
         
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>
 
  <form>
  <div class="container m-0">
      
    <div class="row justify-content-md-start mt-3 bg-light p-3">    
        <div class="col-12">
        <h4 class="form-label">Mapbox</h4>     
        <div class="form-check form-switch ps-0">
        <input class="form-check-input" type="checkbox" name="setting" id="mapbox_enabled" <?php if (array_key_exists("mapbox_enabled",$settings)) { echo $settings['mapbox_enabled']; } ?> />
        <label class="form-check-label ps-1" for="mapbox_enabled">Enable Mapbox</label>   
        </div>
        </div> 
        
    </div>
    
    <div class="row justify-content-md-start mt-3 bg-light p-3">
        <div class="col-12">
        <h4 class="form-label">Google Maps</h4>
        <div class="form-check form-switch ps-0">
        <input class="form-check-input ps-1" type="checkbox" name="setting" id="google_enabled" <?php if (array_key_exists("google_enabled",$settings)) { echo $settings['google_enabled']; } ?> />
        <label class="form-check-label ps-1" for="google_enabled">Enable Google Maps</label>    
        </div> 
        </div>
    </div>

    <div class="row justify-content-md-start mt-3 bg-light p-3">
      <div class="col-12">
        <h4 class="form-label">Woocommerce</h4>
        <div class="form-check form-switch ps-0">
        <input class="form-check-input ps-1" type="checkbox" name="setting" woocommerce_active="<?php echo $woocommerce_is_active ?>" id="woocommerce_enabled" onchange="is_woocommerce_active(event, <?php echo $woocommerce_is_active ?>)" <?php if (array_key_exists("woocommerce_enabled",$settings)) { echo $settings['woocommerce_enabled']; } ?> />
        <label class="form-check-label ps-1" for="woocommerce_enabled">Enable Woocommerce Integration</label>    
        </div> 
      </div>
    </div>

    <div class="row justify-content-md-start mt-3">
    <div class="col">
    <button type="button" class="btn btn-primary" id="update_settings">Update</button>
    </div>
    </div>

  </div>
  </form>
</section>

<?php
return;
?>
