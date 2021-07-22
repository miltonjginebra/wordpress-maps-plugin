<?php

$path = preg_replace('/wp-content(?!.*wp-content).*/', '', __DIR__);

if (file_exists($path . 'wp-load.php')) {
    require_once($path . 'wp-load.php');
} else {
    require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/wp-load.php');
}

function mumbles_maps_update_db($name, $text)
{
    global $wpdb;
    $table_name = $wpdb->prefix . "mumbles_maps";
    $db_record = $wpdb->get_results("SELECT * FROM $table_name WHERE name = '$name'");
    $db_api_key = $wpdb->get_var("SELECT text FROM $table_name WHERE name = '$name'");

    if ($db_record == null && $db_api_key == null) {
        $wpdb->insert(
            $table_name,
            array(
                'time' => current_time('mysql'),
                'name' => $name,
                'text' => $text,
            )
        );
    } else {
        $where = array('name' => $name);
        $new_value = array('text' => $text);
        $wpdb->update($table_name, $new_value, $where);
    }
}

header('Content-type: application/json');

$woocommerce_is_active = class_exists( 'woocommerce' ) ? $woocommerce_is_active = true : $woocommerce_is_active = false;

$response_array = [
    'status' => '',
    'data' => [
        'error' => '',
        'message' => ''
    ]
];

foreach($_POST['keys'] as $key) {
  if (isset($key['name']) && isset($key['text'])) {
    if ($key['name'] === 'woocommerce_enabled' && $key['text'] === "checked" &&  $woocommerce_is_active == false) {     
        $response_array['status'] = 'error';
        $response_array['data']['error'] = 'woocommerce_error'; 
        $response_array['data']['message'] = 'woocommerce is not active, this setting has been ignored.'; 
        continue;
    } else {
        mumbles_maps_update_db($key['name'], $key['text']);  
    }    
  }
}

if($response_array['data']['error'] != 'woocommerce_error') {
    $response_array['status'] = 'success';
    $response_array['data']['message'] = 'Settings Updated';
}  

echo json_encode($response_array);
return;
