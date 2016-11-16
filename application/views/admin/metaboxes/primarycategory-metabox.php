<label for="<?php echo PrimaryCategory_Constants::PLUGIN_SLUG; ?>_category">Select which category should be primary</label>
<br />
<?php
				wp_dropdown_categories(array(
								'hide_empty' => false,
								'name' => PrimaryCategory_Constants::PLUGIN_SLUG.'_category',
								'id' => PrimaryCategory_Constants::PLUGIN_SLUG.'_category',
								'hierarchical' => true,
								'selected' => get_post_meta($post_id, PrimaryCategory_Constants::PLUGIN_SLUG.'_category')
				));
?>