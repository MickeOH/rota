<?php
	
?>

<section class="component component-articles">
	<div class="container-fluid">

		<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
			<label>
				<span class="screen-reader-text"><?php echo _x( 'Sök efter:', 'label' ) ?></span>
				<input type="search" class="search-field"
				placeholder="<?php echo esc_attr_x( 'Skriv t.ex. namn på en kreatör, en plats, ett livsmedel osv...', 'placeholder' ) ?>"
				value="<?php echo get_search_query() ?>" name="s"
				title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />
			</label>
			<input type="submit" class="search-submit"
		value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>" />
		</form>

		<?php

		$args = array(
			'taxonomy' => 'article_category',
			'hide_empty' => false,
		);

		$article_cats = get_terms($args);

		if ( ! empty( $article_cats ) && ! is_wp_error( $article_cats ) ) :
			echo '<ul>';
                foreach ( $article_cats as $term ) :
                    echo '<li>' . $term->name . '</li>';
                endforeach;
			echo '</ul>';
		endif;

		?>


	</div>
</section>