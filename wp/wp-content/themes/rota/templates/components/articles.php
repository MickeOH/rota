<?php
$header = get_sub_field('header');
$header_tag = get_sub_field('header_tag');

$args = array(
	'taxonomy' => 'article_category',
	'hide_empty' => false,
);

parse_str($_SERVER["QUERY_STRING"], $query_array);
$active_cat = '';
if (array_key_exists(__('kategori'),$query_array)) :
	$active_cat = $query_array[__('kategori')];
endif;


if($active_cat) :
	$active_cat_info = get_term_by( 'slug', $active_cat, 'article_category' );
	$active_cat_id = $active_cat_info->term_id;
	$active_cat_title = $active_cat_info->name;
	$args['parent'] = $active_cat_id;
else:
	$args['parent'] = 0;
endif;

//$article_cats = get_terms($args);

$args = array(
	'post_type'              => array( 'article' ),
	'posts_per_page'         => '5',
);
if($active_cat) :
	$args['tax_query'] = array(
		array(
			'taxonomy' => 'article_category',
			'field'    => 'term_id',
			'terms'    => $active_cat_id,
		)
	);
endif;

$articles = new WP_Query( $args );

$url = get_permalink();

?>

<section class="component component-articles">
	<div class="container-fluid">

		<?php if($active_cat) : ?>
			<?php $back_url = url_remove_querystring($url, _('kategori') ); ?>
			<p class="goback">
				<a href="<?php echo $back_url; ?>">
					<?php _e('Tillbaka'); ?>
				</a>
			</p>

			<<?php echo $header_tag; ?> class="h1">
				<?php echo $active_cat_title; ?>
			</<?php echo $header_tag; ?>>
		<?php else: ?>
			<?php if($header) : ?>
				<<?php echo $header_tag; ?> class="h1">
					<?php echo $header; ?>
				</<?php echo $header_tag; ?>>
				<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
					<label>
						<span class="screen-reader-text"><?php echo _x( 'Sök efter:', 'label' ) ?></span>
						<input	type="search" class="search-field"
								placeholder="<?php echo esc_attr_x( 'Skriv t.ex. namn på en kreatör, en plats, ett livsmedel osv...', 'placeholder' ) ?>"
								value="<?php echo get_search_query() ?>" name="s"
								title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />
					</label>
						<input 	type="submit" class="search-submit"
								value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>" />
				</form>
			<?php endif; ?>
		<?php endif; ?>

		<?php

		if ( ! empty( $article_cats ) && ! is_wp_error( $article_cats ) ) :
			echo '<ul class="article-categories">';
                foreach ( $article_cats as $term ) :
                	$term_url = url_add_querystring($url, _('kategori'), $term->slug );
                	$term_name = $term->name;
                	?>
                	<li>
                		<a href="<?php echo $term_url; ?>">
                			<?php echo $term_name; ?>
                		</a>
                	</li>
                	<?php
                    //echo '<li><a href="#">' . $term->name . '</li>';
                endforeach;
			echo '</ul>';
		endif;
		
		$counter = 0;
		$max = 3;
		if ( $articles->have_posts() ) :
			?><section class="articles_container row justify-content-center"><?php
			while ( $articles->have_posts() and ($counter < $max) ) :
				$articles->the_post();
				get_template_part('templates/content', 'article_excerpt');
				   $counter++;
			endwhile;
			?></section><?php
		else:
			
		endif;

		wp_reset_postdata();

		?>


	</div>
</section>