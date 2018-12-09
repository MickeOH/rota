<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,700" rel="stylesheet">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php the_field('tracking_code_header', 'option') ?>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php the_field('tracking_code_body', 'option') ?>
	
	<?php get_template_part( 'templates/nav' );  ?>
