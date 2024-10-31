<div class="fluent-wl-settings-header">
	<h3>
		<?php 
		if( is_plugin_active(BZFLUENT_FFPRO_PLUGIN_FILE) ) {
			_e('Rebrand Fluent Forms Pro', 'bzfluent');
		} else {
			_e('Rebrand Fluent Forms', 'bzfluent');	
		}
	
		?>
	</h3>
</div>
<div class="fluent-wl-settings-wlms">

	<div class="fluent-wl-settings">
		<form method="post" id="form" enctype="multipart/form-data">

			<?php wp_nonce_field( 'fluent_wl_nonce', 'fluent_wl_nonce' ); ?>

			<div class="fluent-wl-setting-tabs-content">

				<div id="fluent-wl-branding" class="fluent-wl-setting-tab-content active">
					<h3 class="bzfluent-section-title"><?php esc_html_e('Branding', 'bzfluent'); ?></h3>
					<p><?php esc_html_e('You can white label the plugin as per your requirement.', 'bzfluent'); ?></p>
					<table class="form-table fluent-wl-fields">
						<tbody>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="fluent_wl_plugin_name"><?php esc_html_e('Plugin Name', 'bzfluent'); ?></label>
								</th>
								<td>
									<input id="fluent_wl_plugin_name" name="fluent_wl_plugin_name" type="text" class="regular-text" value="<?php echo $branding['plugin_name']; ?>" placeholder="" />
								</td>
							</tr>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="fluent_wl_plugin_desc"><?php esc_html_e('Plugin Description', 'bzfluent'); ?></label>
								</th>
								<td>
									<input id="fluent_wl_plugin_desc" name="fluent_wl_plugin_desc" type="text" class="regular-text" value="<?php echo $branding['plugin_desc']; ?>"/>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="fluent_wl_plugin_author"><?php esc_html_e('Developer / Agency', 'bzfluent'); ?></label>
								</th>
								<td>
									<input id="fluent_wl_plugin_author" name="fluent_wl_plugin_author" type="text" class="regular-text" value="<?php echo $branding['plugin_author']; ?>"/>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="fluent_wl_plugin_uri"><?php esc_html_e('Website URL', 'bzfluent'); ?></label>
								</th>
								<td>
									<input id="fluent_wl_plugin_uri" name="fluent_wl_plugin_uri" type="text" class="regular-text" value="<?php echo $branding['plugin_uri']; ?>"/>
								</td>
							</tr>

							<tr valign="top">
								<th scope="row" valign="top">
									<label for="fluent_wl_primary_color"><?php esc_html_e('Primary Color', 'bzfluent'); ?></label>
								</th>
								<td>
									<input id="fluent_wl_primary_color" name="fluent_wl_primary_color" type="text" class="fluent-wl-color-picker" value="<?php echo $branding['primary_color']; ?>" />
									<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
								</td>
							</tr>
							
														
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="fluent_menu_icon"><?php esc_html_e('Menu Icon', 'bzfluent'); ?></label>
								</th>
								<td>
									<input class="regular-text" name="fluent_menu_icon" id="fluent_menu_icon" type="text" value="" disabled />
									<input class="button dashicons-picker" type="button" value="Choose Icon" data-target="#fluent_menu_icon" disabled />
									<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
								</td>
							</tr>
									
							 <tr valign="top">
									<th scope="row" valign="top">
										<label for="fluent_wl_hide_sign_tab"><?php echo esc_html_e('Hide Signature Addon Tab', 'bzfluent'); ?></label>
									</th>
									<td>
										<input id="fluent_wl_hide_sign_tab" name="fluent_wl_hide_sign_tab" type="checkbox" class="" value="on" disabled />
										<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
									</td>
							 </tr>
									
							 <tr valign="top">
									<th scope="row" valign="top">
										<label for="fluent_wl_hide_license_tab"><?php echo esc_html_e('Hide License Tab', 'bzfluent'); ?></label>
									</th>
									<td>
										<input id="fluent_wl_hide_license_tab" name="fluent_wl_hide_license_tab" type="checkbox" class="" value="on" disabled />
										<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
									</td>
							 </tr>
									
							 <tr valign="top">
									<th scope="row" valign="top">
										<label for="fluent_wl_hide_help_menu"><?php echo esc_html_e('Hide Get Help Menu', 'bzfluent'); ?></label>
									</th>
									<td>
										<input id="fluent_wl_hide_help_menu" name="fluent_wl_hide_help_menu" type="checkbox" class="" value="on" disabled />
										<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
									</td>
							 </tr>
									
							 <tr valign="top">
									<th scope="row" valign="top">
										<label for="fluent_wl_hide_modules_menu"><?php echo esc_html_e('Hide Modules Menu', 'bzfluent'); ?></label>
									</th>
									<td>
										<input id="fluent_wl_hide_modules_menu" name="fluent_wl_hide_modules_menu" type="checkbox" class="" value="on" disabled />
										<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
									</td>
							 </tr>
									
							 <tr valign="top">
									<th scope="row" valign="top">
										<label for="fluent_wl_hide_tools_menu"><?php echo esc_html_e('Hide Tools Menu', 'bzfluent'); ?></label>
									</th>
									<td>
										<input id="fluent_wl_hide_tools_menu" name="fluent_wl_hide_tools_menu" type="checkbox" class="" value="on" disabled />
										<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
									</td>
							 </tr>
									
		
							<?php 
								if( is_plugin_active(BZFLUENT_FFPRO_PLUGIN_FILE) ) {
								} else { ?>
								
								<tr valign="top">
									<th scope="row" valign="top">
										<label for="fluent_wl_hide_pro_menu"><?php echo esc_html_e('Hide Go Pro Menu', 'bzfluent'); ?></label>
									</th>
									<td>
										<input id="fluent_wl_hide_pro_menu" name="fluent_wl_hide_pro_menu" type="checkbox" class="" value="on" disabled />
										<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
									</td>
								</tr>
								
							<?php }	?>
							
						</tbody>
					</table>
				</div>
				
				<div class="fluent-wl-setting-footer">
					<p class="submit">
						<input type="submit" name="fluent_submit" id="fluent_save_branding" class="button button-primary bzfluent-save-button" value="<?php esc_html_e('Save Settings', 'bzfluent'); ?>" />
					</p>
				</div>
			</div>
		</form>
	</div>
</div>
