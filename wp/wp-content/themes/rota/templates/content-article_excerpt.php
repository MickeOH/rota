<article class="article_excerpt col-md-4">
    <a href="<?php the_permalink(); ?>">
        <div class="article_thumbnail">
            <?php if(has_post_thumbnail()) : ?>
                <?php the_post_thumbnail( 'article_excerpt' ); ?>
            <?php endif; ?>
        </div>

        <h2>
            <?php the_title(); ?>
        </h2>
        <p class="postmeta_tags">
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
            ?>
        </p>
        <p class="postmeta_time">
            <?php
            echo get_the_time( 'd F Y' );
            ?>
        </p>
    </a>
</article>