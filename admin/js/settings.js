//Settings
function update_settings(name, text) {
  let data = {
    keys: [
      {
        name: name,
        text: text,
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
        if (result["status"] == "success") {
          jQuery("#settings_updated_modal_header").text("Success");
          jQuery(".modal-body").text(result["data"]["message"]);
          jQuery("#settings_updated_modal").modal("show");
        } else {
          if (result["data"]["error"] == "woocommerce_error") {
            jQuery("#woocommerce_enabled").prop("checked", false);
          }
          jQuery("#settings_updated_modal_header").text("Error");
          jQuery(".modal-body").text(result["data"]["message"]);
          jQuery("#settings_updated_modal").modal("show");
        }
      },
      error: function (error) {
        console.log(error);
      },
    })
    .done(function () {});
}

jQuery("#update_settings").click(function () {
  jQuery("[name='setting']").each(function () {
    update_settings(
      jQuery(this).attr("id"),
      jQuery(this).is(":checked") ? "checked" : ""
    );
  });
});

const is_woocommerce_active = (event, status) => {
  if (jQuery("#woocommerce_enabled").is(":checked")) {
    if (!status) {
      //jQuery("#woocommerce_enabled").prop("checked", false);
      alert(
        "You must first install and activate woocommerce. If it's already installed and avtivated, try refreshing the page."
      );
    }
  } else {
  }
};
