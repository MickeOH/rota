<section class="editor_content">
	<h1><?php the_title(); ?></h1>
	<?php the_content(); ?>
	<p class="postmeta">
		<?php
		echo get_the_time( 'd F Y' );
		?>
	</p>
</section>