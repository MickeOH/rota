<article class="blog_excerpt">
	<div class="row">
		<div class="col-md-4">
			<?php if(has_post_thumbnail()) : ?>
				<figure>
					<a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail( 'blog_excerpt' ); ?>
					</a>
				</figure>
			<?php endif; ?>
		</div>
		<div class="col-md-8">
			<h2>
				<a href="<?php the_permalink(); ?>">
					<?php the_title(); ?>
				</a>
			</h2>
			<p class="date"><?php the_time('j F Y'); ?></p>

			<p>
				<?php echo excerpt(55); ?>
			</p>
		</div>
	</div>
	
</article>