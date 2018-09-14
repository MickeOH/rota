<?php

// WooCommerce
//add_theme_support( 'woocommerce' );

add_action( 'admin_notices', 'my_theme_dependencies' );

function my_theme_dependencies() {

	$plugin_messages = array();
	$required_plugins = array();

	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

	$required_plugins = array(
		array(
			'name'=>'Advanced Custom Fields', 
			'download'=>'https://www.advancedcustomfields.com/', 
			'path'=>'advanced-custom-fields-pro/acf.php'
		),
	);

	foreach($required_plugins as $plugin) :
		if(!is_plugin_active( $plugin['path'] )) :
			$plugin_messages[] = sprintf( esc_html__( 'Detta tema kräver att du installerar %s. Du kan ladda ner den här: %s', 'rota' ), $plugin['name'], $plugin['download'] );
		endif;
	endforeach;

	if(count($plugin_messages) > 0) :
		echo '<div class="error">';
			foreach($plugin_messages as $message) :
				echo '<p>' . $message . '</p>';
			endforeach;
		echo '</div>';
	endif;
	
}

// Language support
load_theme_textdomain('rota', get_template_directory() . '/languages');

// All of the base theme functions
require_once(get_template_directory() . '/inc/base-functions.php');

// Theme specific functions
require_once(get_template_directory() . '/inc/custom-functions.php');

// Scripts and styles
function enqueue_scripts() {
    // JS
    wp_enqueue_script('jquery');
    wp_enqueue_script( 'app', get_template_directory_uri() . '/dist/js/app.min.js', array("jquery"), '1.0.0', true );
    // Styles
    wp_enqueue_style( 'screen', get_template_directory_uri() . '/dist/css/app.min.css', array(),'1.0.0', 'screen' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_scripts',1 );
