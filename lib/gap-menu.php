<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/* Plugin Menu Creation Starts Here */
	add_action('admin_menu', 'gap_menus');
	
	// Menu creation under General Settings with name "Simple Featured Video"
	function gap_menus(){
			add_submenu_page('options-general.php','Guest Author Settings', 'Guest author Settings', 'administrator', 'gap_menu_page','gap_menu_page_function','', '');
	}
	// Menu page code loading
	function gap_menu_page_function(){
		include('gap-main-settings.php');
	}
/* Plugin Menu Creation Ends Here */