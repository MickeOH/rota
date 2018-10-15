<?php

require_once(get_template_directory() . '/inc/cpt/article.php');

function url_add_querystring($url, $key, $value) {

	$url = preg_replace('/(.*)(?|&)'. $key .'=[^&]+?(&)(.*)/i', '$1$2$4', $url .'&');
	$url = substr($url, 0, -1);
	
	if (strpos($url, '?') === false) {
		return ($url .'?'. $key .'='. $value);
	} else {
		return ($url .'&'. $key .'='. $value);
	}
}

function url_remove_querystring($url, $key) {
	$url = preg_replace('/(.*)(?|&)'. $key .'=[^&]+?(&)(.*)/i', '$1$2$4', $url .'&');
	$url = substr($url, 0, -1);
	return ($url);
}


remove_action( 'try_gutenberg_panel', 'wp_try_gutenberg_panel' );