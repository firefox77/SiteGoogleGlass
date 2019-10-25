<?php
    echo $args['before_widget'];
    if(array_key_exists('show_title',$settings) && $settings['show_title']) { 
        echo $args['before_title'];
        echo $settings['form_title'];
        echo $args['after_title'];
    }

?>
<form method='<?php echo $method?>' action='<?php echo htmlspecialchars($results_page)?>' class='wpcfs-search-form flex' style="display: flex; flex-direction: column" id='<?php echo htmlspecialchars($form_id)?>'>
	<?php foreach($components as $config) { ?>
        <div class='wpcfs-input-wrapper wpcfs-input-input'>
            <label for="<?php echo htmlspecialchars($config['html_id'])?>" class='wpcfs-label'>
                <?php echo $config['label']; ?>
            </label>
            <div class='wpcfs-input'>
    	    	<?php echo $config['class']->render($config,$query); ?>
            </div>
        </div>
	<?php } ?>

<div class='wpcfs-input-wrapper wpcfs-input-submit'>
    <input type='submit' value='<?php echo __("Search","wp_custom_fields_search")?>'>
</div>
<?php echo $hidden; ?>
</form>
<?php echo $args['after_widget']?>