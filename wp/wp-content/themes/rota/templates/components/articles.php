<?php
$header = get_sub_field('header');
$header_tag = get_sub_field('header_tag');
$show_featured_articles = get_sub_field('show_featured_articles');
$featured_articles = get_sub_field('featured_articles');
$hide_articles = get_sub_field('hide_articles');

$args = array(
	'taxonomy' => 'article_category',
	'hide_empty' => true,
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

$article_cats = get_terms($args);

$args = array(
	'post_type'              => array( 'article' ),
	'posts_per_page'         => '3',
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

if($show_featured_articles && !$active_cat) :
	//print_r($featured_articles);
	$articles_to_show = array();
	foreach($featured_articles as $article) :
		$articles_to_show[] = $article->ID;
	endforeach;
	$args['posts_per_page'] = -1;
	$args['post__in'] = $articles_to_show;
endif;

$articles = new WP_Query( $args );

$url = get_permalink();

?>

<section class="component component-articles">
		<?php if($active_cat) : ?>
            <div class="container-fluid">
                <?php $back_url = url_remove_querystring($url, _('kategori') ); ?>
                <p class="goback">
                    <a href="<?php echo $back_url; ?>">
                        <?php _e('Tillbaka'); ?>
                    </a>
                </p>

                <<?php echo $header_tag; ?> class="h1">
                    <?php echo $active_cat_title; ?>
                </<?php echo $header_tag; ?>>
            </div>
		<?php else: ?>
			<?php if($header) : ?>
			<div class="search-form--startpage">
				<div class="container-fluid">
				<<?php echo $header_tag; ?> class="h1">
					<?php echo $header; ?>
				</<?php echo $header_tag; ?>>
					<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
						<div class="search-form-wrapper">
							<label>
								<span class="screen-reader-text"><?php echo _x( 'Sök efter:', 'label' ) ?></span>
								<input	type="search" class="search-field"
										placeholder="<?php echo esc_attr_x( 'Skriv t.ex. namn på en kreatör, en plats, ett livsmedel osv...', 'placeholder' ) ?>"
										value="<?php echo get_search_query() ?>" name="s"
										title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />
                                <span class="search-form-icon">
                                    <input 	type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>" >
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 58.6 58.6" style="enable-background:new 0 0 58.6 58.6;" xml:space="preserve"><style type="text/css">.search-glass-path{fill:#305547;}</style><path class="search-glass-path" d="M48.5,10.2c-8.3-8.3-21.7-8.3-30,0c-4,4-6.2,9.3-6.2,15c0,5.2,1.9,10.2,5.4,14.1L4.4,52.5
	c-0.5,0.5-0.5,1.3,0,1.8c0.2,0.2,0.6,0.4,0.9,0.4s0.6-0.1,0.9-0.4L19.4,41c3.9,3.5,8.8,5.4,14.1,5.4c5.7,0,11-2.2,15-6.2
	C56.7,31.9,56.7,18.5,48.5,10.2z M46.7,38.4c-3.5,3.5-8.2,5.5-13.2,5.5c-5,0-9.7-1.9-13.2-5.5s-5.5-8.2-5.5-13.2
	c0-5,1.9-9.7,5.5-13.2c3.6-3.6,8.4-5.5,13.2-5.5c4.8,0,9.6,1.8,13.2,5.5C54,19.3,54,31.1,46.7,38.4z"/></svg>
                                </span>
										</label>
						</div>
					</form>
					</div>
				</div>
			<?php endif; ?>
		<?php endif; ?>
	<div class="container-fluid">

		<?php

		if ( ! empty( $article_cats ) && ! is_wp_error( $article_cats ) ) :
			echo '<ul class="article-categories">';
                foreach ( $article_cats as $term ) :
                	$term_url = url_add_querystring($url, _('kategori'), $term->slug );
                	$term_name = $term->name;

                	$image = get_field('image', $term);

                	?>
                	<li>
                		<a href="<?php echo $term_url; ?>">
                			<?php if($image) : ?>
                				<?php echo wp_get_attachment_image( $image['ID'], '', false, array('class' => 'category_image') ); ?>
                			<?php endif; ?>

                			<?php echo $term_name; ?>
                		</a>
                	</li>
                	<?php
                endforeach;
			echo '</ul>';
		endif;

		if($active_cat) :

			if ( $articles->have_posts() ) :
				?><section class="articles_container row justify-content-center"><?php
				while ( $articles->have_posts() ) :
					$articles->the_post();
					get_template_part('templates/content', 'article_excerpt');
				endwhile;
				?></section><?php
			else:
				
			endif;

			wp_reset_postdata();

		endif;

		?>


	</div>
</section>