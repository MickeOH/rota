<article class="blog_excerpt">
	<div class="row">
		<div class="col-md-5">
			<?php if(has_post_thumbnail()) : ?>
				<figure>
					<a href="<?php the_permalink(); ?>">
                        <div class="blog_excerpt_thumbnail">
                            <?php the_post_thumbnail( 'blog_excerpt' ); ?>
                        </div>
                    </a>
				</figure>
			<?php endif; ?>
		</div>
		<div class="col-md-7">
            <a href="<?php the_permalink(); ?>">
                <h2>
                    <?php the_title(); ?>
                </h2>
                <p class="date"><?php the_time('j F Y'); ?></p>

                <p>
                    <?php echo excerpt(55); ?> &raquo;
                </p>
            </a>
        </div>
	</div>
	
</article>