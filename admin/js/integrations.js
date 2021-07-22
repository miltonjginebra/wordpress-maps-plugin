// Integrations
jQuery("#update_integrations").click(function () {
  let data = {
    keys: [
      {
        name: "mapbox",
        text: jQuery("#mapbox_token").val(),
      },
      {
        name: "google",
        text: jQuery("#google_token").val(),
      },
    ],
  };
  jQuery
    .ajax({
      type: "POST",
      url: "http://localhost/wordpress/wp-content/plugins/mumbles-maps/admin/functions/mumbles_maps_update_db.php",
      contentType: "application/x-www-form-urlencoded; charset=UTF-8",
      enctype: "multipart/form-data",
      data: data,
      success: function (result) {
        alert("Integrations Updated");
      },
      error: function (error) {
        console.log(error);
      },
    })
    .done(function () {});
});

jQuery("[name='setting']").change(function () {
  //alert(this.checked);
});
