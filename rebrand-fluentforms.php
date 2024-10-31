<?php
/**
 * Plugin Name: 	Rebrand Fluent Forms 
 * Plugin URI: 	    https://rebrandpress.com/
 * Description: 	The Fluent Forms WordPress form builder lets you create sales and marketing forms without coding. Rebrand Fluent Forms removes all mention of Fluent Forms, allowing you to replace it with your own brand name and colors. Furthermore, you can change the description on both the navigation menu and the site’s plugin page and replace the developer’s link with a custom one of your own.

 * Version:     	1.0
 * Author:      	RebrandPress
 * Author URI:  	https://rebrandpress.com/
 * License:     	GPL2 etc
 * Network:         Active
*/

if (!defined('ABSPATH')) { exit; }

if ( !class_exists('Rebrand_FluentForms_Pro') ) {
	
	class Rebrand_FluentForms_Pro {
		
		public function bzfluent_load()
		{
			global $bzfluent_load;
			load_plugin_textdomain( 'bzfluent', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

			if ( !isset($bzfluent_load) )
			{
			  require_once(__DIR__ . '/fluentforms-settings.php');
			  $PluginFluent = new BZFLUENT\BZRebrandFluentFormsSettings;
			  $PluginFluent->init();
			}
			return $bzfluent_load;
		}
		
	}
}
$PluginRebrandFluentForms = new Rebrand_FluentForms_Pro;
$PluginRebrandFluentForms->bzfluent_load();
