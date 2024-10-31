<?php
namespace BZFLUENT;

define('BZFLUENT_BASE_DIR', 	dirname(__FILE__) . '/');
define('BZFLUENT_PRODUCT_ID',   'BZFF');
define('BZFLUENT_VERSION',   	'1.5');
define('BZFLUENT_DIR_PATH', plugin_dir_path( __DIR__ ));
define('BZFLUENT_PLUGIN_FILE', 'rebrand-fluentforms/rebrand-fluentforms.php');   //Main base file
define('BZFLUENT_FFPRO_PLUGIN_FILE', 'fluentformpro/fluentformpro.php');   //Main Ninja tables Pro base file

class BZRebrandFluentFormsSettings {
		
		public $pageslug 	   = 'fluent_form_rebrand';
	
		static public $rebranding = array();
		static public $redefaultData = array();
	
		public function init() { 
		
			$blog_id = get_current_blog_id();
			
			self::$redefaultData = array(
				'plugin_name'       	=> '',
				'plugin_desc'       	=> '',
				'plugin_author'     	=> '',
				'plugin_uri'        	=> '',
				
			);
        
			
			
			if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
				require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
			} 
if ( is_plugin_active( 'blitz-rebrand-fluentforms-pro/blitz-rebrand-fluentforms-pro.php' ) ) {
			
			deactivate_plugins( plugin_basename(__FILE__) );
			$error_message = '<p style="font-family:-apple-system,BlinkMacSystemFont,\'Segoe UI\',Roboto,Oxygen-Sans,Ubuntu,Cantarell,\'Helvetica Neue\',sans-serif;font-size: 13px;line-height: 1.5;color:#444;">' . esc_html__( 'Plugin could not be activated, either deactivate the Lite version or Pro version', 'simplewlv' ). '</p>';
			die($error_message); 
		 
			return;
		}
		
			$this->bzfluent_activation_hooks();	
		}
		
	
		
		/**
		 * Init Hooks
		*/
		public function bzfluent_activation_hooks() {
		
			global $blog_id;
			
			$rebranding = $this->bzfluent_get_rebranding();
			$bzfluent_name = isset( $rebranding['plugin_name'] ) && ! empty( $rebranding['plugin_name'] ) ? $rebranding['plugin_name'] : '';
			
			if ( ! empty( $bzfluent_name ) ) {
				add_filter( 'gettext', 					array($this, 'bzfluent_update_label'), 20, 3 );
			}
			
			add_filter( 'all_plugins', 				array($this, 'bzfluent_plugin_branding'), 10, 1 );
			add_action( 'admin_menu',				array($this, 'bzfluent_menu'), 100 );
			add_action( 'admin_enqueue_scripts', 	array($this, 'bzfluent_adminloadStyles'));
			add_action( 'admin_init',				array($this, 'bzfluent_save_settings'));			
	        add_action( 'admin_head', 				array($this, 'bzfluent_branding_scripts_styles') );
	        if(is_multisite()){
				if( $blog_id == 1 ) {
					switch_to_blog($blog_id);
						add_filter('screen_settings',			array($this, 'bzfluent_hide_rebrand_from_menu'), 20, 2);	
					restore_current_blog();
				}
			} else {
				add_filter('screen_settings',			array($this, 'bzfluent_hide_rebrand_from_menu'), 20, 2);
			}
			
			if(is_plugin_active(BZFLUENT_FFPRO_PLUGIN_FILE)){
				add_filter( 'admin_title', array($this, 'bzfluent_fluentformpage_title'),10,2);
			}
		}
		
	
	
	
			
		/**
		 * Add screen option to hide/show rebrand options
		*/
		public function bzfluent_hide_rebrand_from_menu($fluentcurrent, $screen) {

			$rebranding = $this->bzfluent_get_rebranding();

			$fluentcurrent .= '<fieldset class="admin_ui_menu"> <legend> Rebrand - '.$rebranding['plugin_name'].' </legend><p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>';
			
			$redirectUrl = $_SERVER['REQUEST_URI'];
			

			if($this->bzfluent_getOption( 'rebrand_fluent_screen_option','' )){
				
				$cartflows_screen_option = $this->bzfluent_getOption( 'rebrand_fluent_screen_option',''); 
				
				if($cartflows_screen_option=='show'){

					$fluentcurrent .= __('Hide the "','bzfluent').$rebranding['plugin_name'].__(' - Rebrand" menu item?','bzfluent') .$hide;
					$fluentcurrent .= '<style>#adminmenu .toplevel_page_fluent_forms a[href="admin.php?page='.$this->pageslug.'"]{display:block;}</style>';
				} else {
					$fluentcurrent .= __('Show the "','bzfluent').$rebranding['plugin_name'].__(' - Rebrand" menu item?','bzfluent') .$show;
					$fluentcurrent .= '<style>#adminmenu .toplevel_page_fluent_forms a[href="admin.php?page='.$this->pageslug.'"]{display:none;}</style>';
				}		
				
			} else {
					$fluentcurrent .= __('Hide the "','bzfluent').$rebranding['plugin_name'].__(' - Rebrand" menu item?','bzfluent') .$hide;
					$fluentcurrent .= '<style>#adminmenu .toplevel_page_fluent_forms a[href="admin.php?page='.$this->pageslug.'"]{display:block;}</style>';
			}	

			$fluentcurrent .=' <br/><br/> </fieldset>' ;
			
			return $fluentcurrent;
		}
		
		
		
				
		
		/**
		* Loads admin styles & scripts
		*/
		public function bzfluent_adminloadStyles(){
			
			if(isset($_REQUEST['page'])){
				
				if($_REQUEST['page'] == $this->pageslug){
				
				    wp_register_style( 'bzfluent_css', plugins_url('assets/css/bzfluent-main.css', __FILE__) );
					wp_enqueue_style( 'bzfluent_css' );
					
					wp_register_script( 'bzfluent_js', plugins_url('assets/js/bzfluent-main-settings.js', __FILE__ ), '', '', true );
					wp_enqueue_script( 'bzfluent_js' );
				
					
					
				}
			}
		}	
		
		
		
		
	   public function bzfluent_get_rebranding() {
			
			if ( ! is_array( self::$rebranding ) || empty( self::$rebranding ) ) {
				if(is_multisite()){
					switch_to_blog(1);
						self::$rebranding = get_option( 'fluentforms_rebrand');
					restore_current_blog();
				} else {
					self::$rebranding = get_option( 'fluentforms_rebrand');	
				}
			}
			return self::$rebranding;
		}
		
		
		
	    /**
		 * Render branding fields.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function bzfluent_render_fields() {
			
			$branding = get_option( 'fluentforms_rebrand');
			include BZFLUENT_BASE_DIR . 'admin/bzfluent-settings-rebranding.php';
		}
		
		
		
		/**
		 * Admin Menu
		*/
		public function bzfluent_menu() {
			
			global $menu, $blog_id;
			global $submenu;	
			
		    $admin_label = __('Rebrand', 'bzfluent');
			$rebranding = $this->bzfluent_get_rebranding();
			
			if ( current_user_can( 'manage_options' ) ) {

				$title = $admin_label;
				$cap   = 'manage_options';
				$slug  = $this->pageslug;
				$func  = array($this, 'bzfluent_render');

				if( is_multisite() ) {
					if( $blog_id == 1 ) { 
						add_submenu_page( 'fluent_forms', $title, $title, $cap, $slug, $func );
					}
				} else {
					add_submenu_page( 'fluent_forms', $title, $title, $cap, $slug, $func );
				}
			}	

				
			foreach($menu as $custommenusK => $custommenusv ) {
				if( $custommenusK == '25.24644' ) {
					if( isset($rebranding['plugin_name']) && $rebranding['plugin_name'] != '' ) {
						$menu[$custommenusK][0] = $rebranding['plugin_name']; //change menu Label
					}
						
				}
			}
			return $menu;
		}
		
			
		
		/**
		 * Renders to fields
		*/
		public function bzfluent_render() {
			
			/*update admin ui menu show/hide*/ 	
			if (isset($_REQUEST['rebrandfluent_screen_option'])) {
				$this->bzfluent_updateOption('rebrand_fluent_screen_option', $_REQUEST['rebrandfluent_screen_option']);
				$redirectUrl=$_REQUEST['redirectUrl'];
				echo '<script>window.location = "'.$redirectUrl.'";</script>';
				die;
			}
			
			$this->bzfluent_render_fields();
		}
		
	
		
		/**
		 * Save the field settings
		*/
		public function bzfluent_save_settings() {
			
			if ( ! isset( $_POST['fluent_wl_nonce'] ) || ! wp_verify_nonce( $_POST['fluent_wl_nonce'], 'fluent_wl_nonce' ) ) {
				return;
			}

			if ( ! isset( $_POST['fluent_submit'] ) ) {
				return;
			}
			$this->bzfluent_update_branding();
		}
		
		
		
		
		/**
		 * Include scripts & styles
		*/
		public function bzfluent_branding_scripts_styles() {
			
			global $blog_id;
			
			if ( ! is_user_logged_in() ) {
				return; 
			}
			$rebranding = $this->bzfluent_get_rebranding();
			
			//~ echo '<pre/>';
			//~ print_r($rebranding);
			
			
			echo '<style id="fluent-wl-admin-style">';
			include BZFLUENT_BASE_DIR . 'admin/bzfluent-style.css.php';
			echo '</style>';
			
			echo '<script id="fluent-wl-admin-script">';
			include BZFLUENT_BASE_DIR . 'admin/bzfluent-script.js.php';
			echo '</script>';
			
		}	  
	
	

		/**
		 * Update branding
		*/
	    public function bzfluent_update_branding() {
			
			if ( ! isset($_POST['fluent_wl_nonce']) ) {
				return;
			}  
			

			$data = array(
				'plugin_name'       => isset( $_POST['fluent_wl_plugin_name'] ) ? sanitize_text_field( $_POST['fluent_wl_plugin_name'] ) : '',
				
				'plugin_desc'       => isset( $_POST['fluent_wl_plugin_desc'] ) ? sanitize_text_field( $_POST['fluent_wl_plugin_desc'] ) : '',
				
				'plugin_author'     => isset( $_POST['fluent_wl_plugin_author'] ) ? sanitize_text_field( $_POST['fluent_wl_plugin_author'] ) : '',
				
				'plugin_uri'        => isset( $_POST['fluent_wl_plugin_uri'] ) ? esc_url( $_POST['fluent_wl_plugin_uri'] ) : '',
				
			);
				
			update_option( 'fluentforms_rebrand', $data );
		}
    
    
     
  
  
		
		/**
		 * change plugin meta
		*/  
        public function bzfluent_plugin_branding( $all_plugins ) {
			
			
			if (  ! isset( $all_plugins['fluentform/fluentform.php'] ) ) {
				return $all_plugins;
			}
		
			$rebranding = $this->bzfluent_get_rebranding();
			
			$all_plugins['fluentform/fluentform.php']['Name']           = ! empty( $rebranding['plugin_name'] )     ? $rebranding['plugin_name']      : $all_plugins['fluentform/fluentform.php']['Name'];
			
			$all_plugins['fluentform/fluentform.php']['PluginURI']      = ! empty( $rebranding['plugin_uri'] )      ? $rebranding['plugin_uri']       : $all_plugins['fluentform/fluentform.php']['PluginURI'];
			
			$all_plugins['fluentform/fluentform.php']['Description']    = ! empty( $rebranding['plugin_desc'] )     ? $rebranding['plugin_desc']      : $all_plugins['fluentform/fluentform.php']['Description'];
			
			$all_plugins['fluentform/fluentform.php']['Author']         = ! empty( $rebranding['plugin_author'] )   ? $rebranding['plugin_author']    : $all_plugins['fluentform/fluentform.php']['Author'];
			
			$all_plugins['fluentform/fluentform.php']['AuthorURI']      = ! empty( $rebranding['plugin_uri'] )      ? $rebranding['plugin_uri']       : $all_plugins['fluentform/fluentform.php']['AuthorURI'];
			
			$all_plugins['fluentform/fluentform.php']['Title']          = ! empty( $rebranding['plugin_name'] )     ? $rebranding['plugin_name']      : $all_plugins['fluentform/fluentform.php']['Title'];
			
			$all_plugins['fluentform/fluentform.php']['AuthorName']     = ! empty( $rebranding['plugin_author'] )   ? $rebranding['plugin_author']    : $all_plugins['fluentform/fluentform.php']['AuthorName'];
			
			
			if(is_plugin_active(BZFLUENT_FFPRO_PLUGIN_FILE)){
				
				$all_plugins['fluentformpro/fluentformpro.php']['Name']           = ! empty( $rebranding['plugin_name'] )     ? $rebranding['plugin_name']      : $all_plugins['fluentformpro/fluentformpro.php']['Name'];
				
				$all_plugins['fluentformpro/fluentformpro.php']['PluginURI']      = ! empty( $rebranding['plugin_uri'] )      ? $rebranding['plugin_uri']       : $all_plugins['fluentformpro/fluentformpro.php']['PluginURI'];
				
				$all_plugins['fluentformpro/fluentformpro.php']['Description']    = ! empty( $rebranding['plugin_desc'] )     ? $rebranding['plugin_desc']      : $all_plugins['fluentformpro/fluentformpro.php']['Description'];
				
				$all_plugins['fluentformpro/fluentformpro.php']['Author']         = ! empty( $rebranding['plugin_author'] )   ? $rebranding['plugin_author']    : $all_plugins['fluentformpro/fluentformpro.php']['Author'];
				
				$all_plugins['fluentformpro/fluentformpro.php']['AuthorURI']      = ! empty( $rebranding['plugin_uri'] )      ? $rebranding['plugin_uri']       : $all_plugins['fluentformpro/fluentformpro.php']['AuthorURI'];
				
				$all_plugins['fluentformpro/fluentformpro.php']['Title']          = ! empty( $rebranding['plugin_name'] )     ? $rebranding['plugin_name']      : $all_plugins['fluentformpro/fluentformpro.php']['Title'];
				
				$all_plugins['fluentformpro/fluentformpro.php']['AuthorName']     = ! empty( $rebranding['plugin_author'] )   ? $rebranding['plugin_author']    : $all_plugins['fluentformpro/fluentformpro.php']['AuthorName'];
								
			}
			
			return $all_plugins;
			
		}
	
    	
	
		   
		/**
		 * update plugin label
		*/
		public function bzfluent_update_label( $translated_text, $untranslated_text, $domain ) {
			
			$rebranding = $this->bzfluent_get_rebranding();
			
			$bzfluent_new_text = $translated_text;
			$bzfluent_name = isset( $rebranding['plugin_name'] ) && ! empty( $rebranding['plugin_name'] ) ? $rebranding['plugin_name'] : '';
			
			if ( ! empty( $bzfluent_name ) ) {
				
				//~ $bzfluent_new_text = str_replace( 'Fluent Forms', $bzfluent_name, $bzfluent_new_text );
				//~ $bzfluent_new_text = str_replace( 'FluentForm', $bzfluent_name, $bzfluent_new_text );
				
				if( is_plugin_active(BZFLUENT_FFPRO_PLUGIN_FILE) ) {
					
					$bzfluent_new_text = str_replace( array( 'Fluent Forms Pro','Fluent Forms Pro', 'WP Fluent Forms', 'FluentForm','Fluent Forms','FluentFrom' ), $bzfluent_name, $bzfluent_new_text );
					
				} else {
					
					$bzfluent_new_text = str_replace( array('Fluent Forms','FluentForm','FluentFrom'), $bzfluent_name, $bzfluent_new_text );
				}
				
			}
			
			return $bzfluent_new_text;
		}
	
	
	
		
		   
		/**
		 * update options
		*/
		public function bzfluent_updateOption($key,$value) {
			if(is_multisite()){
				return  update_site_option($key,$value);
			}else{
				return update_option($key,$value);
			}
		}
		
		
	
		
		   
		/**
		 * get options
		*/	
		public function bzfluent_getOption($key,$default=False) {
			if(is_multisite()){
				switch_to_blog(1);
				$value = get_site_option($key,$default);
				restore_current_blog();
			}else{
				$value = get_option($key,$default);
			}
			return $value;
		}
		
		
		
		   
		/**
		 * get options
		*/	
		public function bzfluent_fluentformpage_title($admin_title, $title) {
			
			$rebranding = $this->bzfluent_get_rebranding();
			$new_title = str_replace( array( 'Fluent Forms','Fluent Forms Pro','FluentForms','FluentFrom' ), $rebranding['plugin_name'], $title );
			return $new_title;
			
		}
		
	
} //end Class
