<div class="tg_settings_tabs_content">

  <h2><?php _e( 'Newsletter', 'tag-groups' ) ?></h2>
  <p>
    <?php printf( __( '<a %s>Sign up for our newsletter</a> to receive updates about new versions and related tipps and news.', 'tag-groups' ), 'href="http://eepurl.com/c6AeK1" target="_blank"' ) ?>
  </p>
  <p>&nbsp;</p>

  <h2><?php _e( 'Latest Posts', 'tag-groups' ) ?></h2>
  <table class="widefat fixed" cellspacing="0">
    <thead>
      <tr>
        <th style="min-width: 200px; width: 30%;"></th>
        <th></th>
      </tr>
    </thead>
    <tbody id="tg_feed_container">
      <tr>
        <td colspan="2" style="text-align: center;">
          <?php _e( 'Loading...', 'tag-groups') ?>
        </td>
      </tr>
    </tbody>
  </table>
</div>

<script>
jQuery(document).ready(function(){
  var tg_feed_amount = jQuery("#tg_feed_amount").val();
  var data = {
    action: "tg_ajax_get_feed",
    url: "<?php echo TAG_GROUPS_UPDATES_RSS_URL ?>",
    amount: 5
  };

  jQuery.post("<?php echo $admin_url ?>", data, function (data) {
    var status = jQuery(data).find("response_data").text();
    if (status == "success") {
      var output = jQuery(data).find("output").text();
      jQuery("#tg_feed_container").html(output);
    }
  });
});
</script>
