<?php $prev_url = $_SERVER['HTTP_REFERER']; ?>
<?php get_header() ?>
<main id="main" role="main">
	<article class="container-fluid">
			<?php if ( have_posts() ) : ?>
                <p class="goback">
                    <a href="<?php echo $prev_url; ?>"> Tillbaka</a>
                </p>
                <h1>Dina sökresultat</h1>
                <div class="row">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php get_template_part('templates/post'); ?>
    		    	<?php endwhile;?>
                </div>
		    <?php else : ?>
                <div class="row justify-content-center">
                    <h2>Tyvärr, vi kunde inte hitta några resultat baserat på din sökning. :(</h2>
                </div>
                <div class="row justify-content-center">
                    <p>Vad vill du göra?</p>
                </div>
                <div class="row justify-content-center">
                    <a href="<?php echo $prev_url; ?>" class="button--primary button--backwards">Gå tillbaka</a>
                    <a href="/tipsa-oss/" class="button--primary">Tipsa oss om aktörer!</a>
                </div>
            <?php endif; ?>
	</article>

    <section class="container-fluid">
        <div class="row justify-content-center">
            <nav class="pagination">
                <?php
                    global $wp_query;
                    $big = 999999999; // need an unlikely integer
                    echo paginate_links( array(
                        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                        'format' => '?paged=%#%',
                        'current' => max( 1, get_query_var('paged') ),
                        'total' => $wp_query->max_num_pages
                    ) );
                ?>
            </nav>
        </div>
    </section>

</main><!-- /#main -->
<?php get_footer(); ?>