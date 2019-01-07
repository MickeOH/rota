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

function check_if_static_page() {
	$show_static_page = get_field('show_static_page', 'option');

	if($show_static_page && !is_user_logged_in() && $GLOBALS['pagenow'] !== 'wp-login.php') :
		$static_page = get_field('static_page', 'option');
		if($static_page) :
			$current_page_id = $static_page->ID;
			$static_page_url = get_permalink($current_page_id);
			if($current_page_id !== get_the_ID()) :
				wp_redirect($static_page_url);
				exit();
			endif;
		endif;
	endif;
}

function hide_editor() {
	if(isset($_REQUEST['post'])){
		$post_id = $_REQUEST['post'];
		$template_file = get_post_meta($post_id, '_wp_page_template', true);
		if($template_file == 'template-static_page.php'){ 
			remove_post_type_support('page', 'editor');
		}
	}
}

function excerpt($limit) {
	$excerpt = explode(' ', get_the_excerpt(), $limit);

	if (count($excerpt) >= $limit) {
		array_pop($excerpt);
		$excerpt = implode(" ", $excerpt) . '...';
	} else {
		$excerpt = implode(" ", $excerpt);
	}

	$excerpt = preg_replace('`\[[^\]]*\]`', '', $excerpt);

	return $excerpt;
}

function excerpt_article($limit) {
	global $post;
	$text = get_field('content'); 
	if ( '' != $text ) {
		$text = strip_shortcodes( $text );
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]&gt;', ']]&gt;', $text);
		$excerpt_length = $limit; // 20 words
		$excerpt_more = apply_filters('excerpt_more', ' ' . '...');
		$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
	}
	return apply_filters('the_excerpt', $text);
}


add_action( 'load-post.php', 'hide_editor' );
add_action( 'wp', 'check_if_static_page' );

remove_action( 'try_gutenberg_panel', 'wp_try_gutenberg_panel' );

function rota_search_where($where, $q){
	global $wpdb;
	if( ! is_admin() && $q->is_main_query() && $q->is_search()) :
		$where .= "OR (t.name LIKE '%".get_search_query()."%' AND {$wpdb->posts}.post_status = 'publish')";
	endif;
	return $where;
}

function rota_search_join($join, $q){
	global $wpdb;
	if( ! is_admin() && $q->is_main_query() && $q->is_search()) :
		$join .= "LEFT JOIN {$wpdb->term_relationships} tr ON {$wpdb->posts}.ID = tr.object_id INNER JOIN {$wpdb->term_taxonomy} tt ON tt.term_taxonomy_id=tr.term_taxonomy_id INNER JOIN {$wpdb->terms} t ON t.term_id = tt.term_id";
	endif;
	return $join;
}

function rota_search_groupby($groupby){
	global $wpdb;

	// we need to group on post ID
	$groupby_id = "{$wpdb->posts}.ID";
	if(!is_search() || strpos($groupby, $groupby_id) !== false) return $groupby;

	// groupby was empty, use ours
	if(!strlen(trim($groupby))) return $groupby_id;

	// wasn't empty, append ours
	return $groupby.", ".$groupby_id;
}

add_filter('posts_where','rota_search_where', 10, 2);
add_filter('posts_join', 'rota_search_join', 10, 2);
add_filter('posts_groupby', 'rota_search_groupby');