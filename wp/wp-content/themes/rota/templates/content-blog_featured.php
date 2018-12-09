<article class="blog_featured">

	<?php if(has_post_thumbnail()) : ?>
		<figure>
			<a href="<?php the_permalink(); ?>">
                <div class="blog_featured_thumbnail">
    				<?php the_post_thumbnail( 'blog_featured' ); ?>
                </div>
            </a>
		</figure>
	<?php endif; ?>

	<h2>
		<a href="<?php the_permalink(); ?>">
			<?php the_title(); ?>
		</a>
	</h2>
	
	<p class="date"><?php the_time('j F Y'); ?></p>

	<p>
		<?php echo excerpt(55); ?> &raquo;
	</p>

</article>