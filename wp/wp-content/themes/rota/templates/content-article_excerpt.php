<article class="article_excerpt col-md-4">
	<?php if(has_post_thumbnail()) : ?>
		<a href="<?php the_permalink(); ?>">
			<?php the_post_thumbnail( 'article_excerpt' ); ?>
		</a>
	<?php endif; ?>
	
	<h2>
		<a href="<?php the_permalink(); ?>">
			<?php the_title(); ?>
		</a>
	</h2>
	<p class="postmeta">
		<?php
		$article_tags = wp_get_post_terms( get_the_ID(), 'article_tag' );
		$article_tags_array = array();
		if($article_tags) :
			foreach($article_tags as $tag) :
				$article_tags_array[] = $tag->name;
			endforeach;
		endif;

		if($article_tags_array) :
			echo implode(', ', $article_tags_array) . '<br />';
		endif;

		echo get_the_time( 'd F Y' );
		?>
	</p>
</article>