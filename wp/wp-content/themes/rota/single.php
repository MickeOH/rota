<?php get_header(); ?>
<?php if ( have_posts() ) : ?>
	<main id="main" role="main">
		<article class="container-fluid">
			<div class="row">
				<?php while ( have_posts() ) : the_post(); ?>
					<section class="col-12 editor_content">
						<h1><?php the_title(); ?></h1>
						<?php the_content(); ?>
					</section>
				<?php endwhile; ?>
			</div>
		</article>
	</main><!-- /#main -->
<?php endif; ?> <!-- End if post -->
<?php get_footer(); ?>
