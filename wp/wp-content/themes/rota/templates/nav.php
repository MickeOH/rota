<?php 

$logotype = get_field('logotype', 'option');

$args = array(
	'theme_location'	=> 'primary',
	'menu_class'		=> 'navbar-nav',
	'container'			=> false,
); 

$show_static_page = get_field('show_static_page', 'option');



if($show_static_page) :
	$home_url = 'http://rota.nu/hem/';
else:
	$home_url = get_bloginfo('url');
endif;




?>
<header class="site-header container-fluid">

	<div class="row">

		<div class="col-md-3">
			<a href="<?php echo $home_url; ?>">
				<?php if($logotype) : ?>
					<?php echo wp_get_attachment_image( $logotype['ID'], $size = 'full' ); ?>
				<?php else: ?>
					<?php echo get_bloginfo('name'); ?>
				<?php endif; ?>
			</a>
		</div>

		<div class="col-md-9">
			<nav class="navbar">
				<?php wp_nav_menu( $args ); ?>
			</nav>
		</div>

	</div>
</header>
