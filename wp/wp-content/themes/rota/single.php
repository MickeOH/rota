<?php get_header(); ?>
<?php $prev_url = $_SERVER['HTTP_REFERER']; ?>
<?php if ( have_posts() ) : ?>
	<main id="main" role="main">
		<article class="container-fluid">
			<p class="goback">
				<a href="<?php echo $prev_url; ?>">
					<?php _e('Tillbaka', 'rota'); ?>
				</a>
			</p>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part('templates/content', 'blog'); ?>
			<?php endwhile; ?>
		</article>
	</main><!-- /#main -->
<?php endif; ?> <!-- End if post -->
<?php get_footer(); ?>
