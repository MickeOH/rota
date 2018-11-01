<?php

function create_article_cpt() {

	$labels = array(
		'name'                  => _x( 'Artiklar', 'Post Type General Name', 'rota' ),
		'singular_name'         => _x( 'Artikel', 'Post Type Singular Name', 'rota' ),
		'menu_name'             => __( 'Artiklar', 'rota' ),
		'name_admin_bar'        => __( 'Artiklar', 'rota' ),
		'all_items'             => __( 'Alla Artiklar', 'rota' ),
		'add_new_item'          => __( 'Lägg till ny artikel', 'rota' ),
		'add_new'               => __( 'Skapa ny', 'rota' ),
		'new_item'              => __( 'Ny Artikel', 'rota' ),
		'edit_item'             => __( 'Redigera Artikel', 'rota' ),
		'update_item'           => __( 'Uppdatera Artikel', 'rota' ),
		'view_item'             => __( 'Se Artikel', 'rota' ),
		'view_items'            => __( 'Se Artiklar', 'rota' ),
	);

	$slug_args = array(
		'slug'					=> __('artikel', 'rota'),
		'with_front'			=> false
	);

	$args = array(
		'label'                 => __( 'Artikel', 'rota' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'thumbnail', 'editor' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-welcome-learn-more',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'rewrite'				=> $slug_args
	);
	register_post_type( 'article', $args );

}
add_action( 'init', 'create_article_cpt', 0 );

function create_article_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Kategorier', 'Taxonomy General Name', 'rota' ),
		'singular_name'              => _x( 'Kategori', 'Taxonomy Singular Name', 'rota' ),
		'menu_name'                  => __( 'Kategorier', 'rota' ),
		'all_items'                  => __( 'Alla kategorier', 'rota' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => true,
		'rewrite'                    => false,
		'meta_box_cb'				 => false,
	);
	register_taxonomy( 'article_category', array( 'article' ), $args );

	$labels = array(
		'name'                       => _x( 'Taggar', 'Taxonomy General Name', 'rota' ),
		'singular_name'              => _x( 'Tagg', 'Taxonomy Singular Name', 'rota' ),
		'menu_name'                  => __( 'Taggar', 'rota' ),
		'all_items'                  => __( 'Alla taggar', 'rota' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => true,
		'rewrite'                    => false,
		'meta_box_cb'				 => false,
	);
	register_taxonomy( 'article_tag', array( 'article' ), $args );

}
add_action( 'init', 'create_article_taxonomy', 0 );