<?php
$header = get_sub_field('header');
$header_tag = get_sub_field('header_tag');

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

$args = array(
	'post_type'              => array( 'post' ),
	'posts_per_page'         => '10',
	'paged'					 => $paged
);

parse_str($_SERVER["QUERY_STRING"], $query_array);
$active_cat = '';
if (array_key_exists(__('kategori'),$query_array)) :
	$active_cat = $query_array[__('kategori')];
endif;

if($active_cat) :
	$args_cat = array(
		array(
			'taxonomy' => 'category',
			'field'    => 'slug',
			'terms'    => $active_cat,
		)
	);

	$args['tax_query'] = $args_cat;
	
endif;

$blog_posts = new WP_Query( $args );

$cat_args = array(
	'taxonomy' => 'category',
	'hide_empty' => true,
);

$categories = get_terms($cat_args);

$url = get_permalink();

?>

<section class="component component_blogposts">
	<div class="container-fluid">

		<?php if($header) : ?>
			<<?php echo $header_tag; ?> class="h1">
				<?php echo $header; ?>
			</<?php echo $header_tag; ?>>
		<?php endif; ?>


		<div class="row">
			<div class="col-md-10">
				<?php
				if ( $blog_posts->have_posts() ) :
					$i = 0;
					while ( $blog_posts->have_posts() ) :
						$blog_posts->the_post();

						get_template_part('templates/content', 'blog_excerpt');

					endwhile;
				endif;

				echo paginate_links( array(
					'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
					'total'        => $blog_posts->max_num_pages,
					'current'      => max( 1, get_query_var( 'paged' ) ),
					'format'       => '?paged=%#%',
					'show_all'     => false,
					'type'         => 'plain',
					'end_size'     => 2,
					'mid_size'     => 1,
					'prev_next'    => true,
					'prev_text'    => sprintf( '<i></i> %1$s', __( 'Nyare artiklar', 'rota' ) ),
					'next_text'    => sprintf( '%1$s <i></i>', __( 'Äldre artiklar', 'rota' ) ),
					'add_args'     => false,
					'add_fragment' => '',
				) );

				wp_reset_postdata();
				?>
			</div>
			<div class="col-md-2">
				<?php 
				if($categories): 
					?>
					<h3><?php _e('Kategorier', 'rota'); ?></h3>
					<ul class="categories">
						<li>
							<a href="<?php echo $url; ?>">
								<?php _e('Visa alla', 'rota'); ?>
							</a>
						</li>
						<?php
						foreach($categories as $category) :
							$cat_url = $url . '?' . __('kategori', 'rota') . '=' . $category->slug;
							?>
							<li>
								
								<a href="<?php echo $cat_url; ?>">
									<?php echo $category->name; ?>
								</a>
							</li>
							<?php
						endforeach;
					?></ul><?php
				endif;
				?>
			</div>
		</div>
	</div>
</section>