<?php get_header(); ?>
<?php if(have_posts()) : ?>
<main id="blog-roll" role="main">
	<article class="container-fluid">
		<div class="row">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part('templates/post'); ?>
			<?php endwhile; ?>
		</div>
		<nav class="pagination">
			<?php
				global $wp_query;
				$big = 999999999; // need an unlikely integer
				echo paginate_links( array(
					'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format' => '?paged=%#%',
					'current' => max( 1, get_query_var('paged') ),
					'total' => $wp_query->max_num_pages
				) );
			?>
		</nav>
	</article>
</main><!-- /#main -->
<?php endif; ?>
<?php get_footer(); ?>
