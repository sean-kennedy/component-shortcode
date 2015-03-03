<?php
/**
 * Plugin Name: Component Shortcode
 * Plugin URI: https://github.com/sean-kennedy/component-shortcode
 * Description: A simple Wordpress shortcode to load decoupled template-parts outside of a theme folder, load template code within the_content() area and pass in variables. Perfect for use with the Advanced Custom Fields plugin.
 * Version: 1.0.0
 * Author: Sean Kennedy
 * Author URI: http://seankennedy.com.au/
 */
	
add_shortcode('component', 'sk_the_component_shortcode');
	 
function sk_the_component_shortcode($attr) {
	
	if (!empty($attr['template'])) {
		
		$template = WP_CONTENT_DIR . '/components/' . $attr['template'] . '.php';
		
		$cs_vars = $attr;
		
		if (file_exists($template)) {
			ob_start();
			include($template);
			return ob_get_clean();
		}
	
	}
	
}
	
?>