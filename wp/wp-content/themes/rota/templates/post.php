<article class="col-12 post editor_content" id="<?php echo $post->ID; ?>">
    <h2><?php the_title(); ?></h2>
    <?php the_excerpt(); ?>
    <?php echo excerpt_article(20); ?>
    <a href="<?php the_permalink(); ?>"><?php _e('Läs mer &raquo;','rota'); ?></a>
</article>
