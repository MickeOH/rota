<?php


/* Theme setup - nav_menus, support thumbnails, sidebars */
function theme_setup() {

    // Navigation menu
    register_nav_menus( array(
        'primary' => __( 'Huvudmeny', 'rota' ),
    ));

    // Theme support
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'automatic-feed-links' );
    add_editor_style();

    // Filters
    add_filter('the_generator', '__return_false');

    // Remove
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );

    // ACF Options page
    if( function_exists('acf_add_options_page') ) {
        $theme_options = acf_add_options_page( array(
            'page_title'    => __('Temainställningar', 'rota'),
            'menu_title'    => __('Temainställningar', 'rota'),
            'menu_slug'     => 'theme-settings',
            'capability'    => 'edit_posts',
            'redirect'  => false
        ));

        $theme_options_footer = acf_add_options_page( array(
            'page_title'    => __('Tracking-koder', 'rota'),
            'parent_slug'   => $theme_options['menu_slug'],
        ));
    }

    add_image_size( 'article_excerpt', 360, 99999, false );

}
add_action( 'after_setup_theme', 'theme_setup' );


// WYSIWYG Functions
function embed_container( $html ) {
    return '<div class="embed-container">' . $html . '</div>';
}

// Output SVG
function load_svg( $path ) {
    if  ( strpos( $path , 'http' ) !== FALSE ) {
        $path = parse_url($path, PHP_URL_PATH);
        $filename = ABSPATH . $path;
    } else {
        $filename = get_template_directory() . $path;
    }

    $handle = fopen( $filename, 'r' );
    return fread( $handle, filesize( $filename ) );
}

/**
* Add SVG capabilities
*/
function wpcontent_svg_mime_type( $mimes = array() ) {
    $mimes['svg'] = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';

    return $mimes;
}
add_filter( 'upload_mimes', 'wpcontent_svg_mime_type' );

add_filter( 'embed_oembed_html', 'embed_container', 10, 3 );
add_filter( 'video_embed_html', 'embed_container' );