<section class="editor_content">
	<h1><?php the_title(); ?></h1>
    <p class="postmeta">
        <?php
        echo get_the_time( 'd F Y' );
        ?>
    </p>
	<?php the_content(); ?>
</section>