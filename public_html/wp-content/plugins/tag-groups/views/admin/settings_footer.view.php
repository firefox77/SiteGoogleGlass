</div>
<script>
jQuery(document).ready(function(){
  jQuery(".chatty-mango-help-icon").click(function(){
    jQuery(".chatty-mango-help-container-" + jQuery(this).attr("data-topic")).slideToggle();
  });
});
</script>
